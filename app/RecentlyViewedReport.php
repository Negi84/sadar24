<?php

namespace App;

use App\Models\RecentlyViewedItem;
use App\Order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class RecentlyViewedReport implements FromCollection, WithMapping, WithHeadings
{
	protected $date;
	function __construct($date) {
		$this->date	 = $date;
	}
	
	public function collection()
    {	//TODO: can we update the sla in case the vendor is not updating the status and it has breached the time 
		$recently = RecentlyViewedItem::orderBy('id', 'desc');			
		if ($this->date != null) {	
			$date_from = date('Y-m-d', strtotime(explode(" to ", $this->date)[0]));
			$date_to   = date('Y-m-d', strtotime(explode(" to ", $this->date)[1]));			
			$recently = $recently->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
		}	
        return $recently->get();
    }

    public function headings(): array
    {
        return [
			'Session',
            'Products',    
			'ProductIDs',            
            'Customer Name',	
			'IP Adress'
        ];
    }

    /**
    * @var  $orders
    */
    public function map($recent): array
    {   
	
		$prod_name = [];
		$products = \App\Product::whereIn('id', explode(',',$recent->products))->get();
			foreach ($products as $k => $value) {
				$prod_name[] = $value->getTranslation('name');
			}
        return [
			$recent->created_at.'-'.$recent->upated_at,
			 implode(';;',$prod_name),
			$recent->products,
			 $recent->type =='guest' ?
			('Guest'.($recent->user_id!=0?'_'.$recent->user_id:'')):$recent->user->name ,
			$recent->ip_address
        ];
    }
}