<?php

namespace App;

use App\Seller;
use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class BestSellingProductsExport implements FromCollection, WithMapping, WithHeadings
{
	protected $date,$seller_id;
	
	function __construct($date,$seller_id) {
		$this->date	   		= $date;
		$this->seller_id	= $seller_id;
	}
		
    public function collection() 
    {
		$best_selling_items = OrderDetail::select('product_id','seller_id',DB::raw('COUNT(product_id) as number_of_sale'))->groupBy('product_id')->orderBy('number_of_sale','desc');
		if ($this->date) {			
			$date_from = date('Y-m-d', strtotime(explode(" to ", $this->date)[0]));
			$date_to   = date('Y-m-d', strtotime(explode(" to ", $this->date)[1]));			
			$best_selling_items = $best_selling_items->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
		}
		
		if ($this->seller_id) {
			$best_selling_items = $best_selling_items->where('seller_id', $this->seller_id);
		}
		
        return $best_selling_items->get();
    }

    public function headings(): array
    {
        return [  
		
            'Name',
			'Shop Name',
			'Seller Name',			
			'Quantity',
        ];
    }

    /**
    * @var best_selling_items $best_selling_items
    */
    public function map($best_selling_items): array
    {   
		$product = Product::findOrFail($best_selling_items->product_id);
		$seller =  Seller::where('user_id', $best_selling_items->seller_id)->first();
		
		 return [
		 
			!empty($product->name) ? $product->name:'',
			!empty($seller->user->shop->name) ? $seller->user->shop->name:'',
			!empty($seller->user->name) ? $seller->user->name:'',			
			$best_selling_items->number_of_sale,	
			
        ];
    }
}
