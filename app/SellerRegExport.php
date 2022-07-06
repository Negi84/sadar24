<?php

namespace App;

use App\Seller;
use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SellerRegExport implements FromCollection, WithMapping, WithHeadings
{
	protected $date,$search;
	
	function __construct($date,$search) {
		$this->date	    = $date;
		$this->search	= $search;		
	}
		
    public function collection()
    {
		$sellers = Seller::orderBy('user_id', 'desc');			
		if ($this->date) {			
			$date_from = date('Y-m-d', strtotime(explode(" to ", $this->date)[0]));
			$date_to   = date('Y-m-d', strtotime(explode(" to ", $this->date)[1]));			
			$sellers = $sellers->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
		}
		
		if ($this->search) {
			$sort_search = $this->search;
			$user_ids = User::where('user_type', 'seller')->where(function ($user) use ($sort_search) {
				$user->where('name', 'like', '%' . $sort_search . '%')->orWhere('email', 'like', '%' . $sort_search . '%');
			})->pluck('id')->toArray();
			
			$sellers = $sellers->where(function ($seller) use ($user_ids) {
				$seller->whereIn('user_id', $user_ids);
			});
		}	
		
        return $sellers->get();
    }

    public function headings(): array
    {
        return [
            'Seller ID',
            'Company',
            'Name',
			'Email',
			'Verification',
			'Phone',
			'Address',
			'City',
			'State',
			'Pincode',
			'GST Number',
			'PAN Number',
			'Beneficiary Name',
			'Bank Name',
			'Account Number',
			'Account Type',
			'IFSC',
			'Branch',
			'Total Products',
			'Published',
			'Unpublished',
			'Registration Date',
        ];
    }

    /**
    * @var Seller $seller
    */
    public function map($seller): array
    {   
		$total_products = Product::where('user_id', $seller->user_id)->count();	
		$published = Product::where('user_id', $seller->user_id)->where('published', '=', '1')->count();	
		$unpublished = Product::where('user_id', $seller->user_id)->where('published', '=', '0')->count();	
	
        return [
            $seller->user_id,
			!empty($seller->user->shop->name) ? $seller->user->shop->name:'',
			!empty($seller->user->name) ? $seller->user->name:'',
			!empty($seller->user->email) ? $seller->user->email:'',
			($seller->verification_status == '1') ? 'Yes':'No',
			!empty($seller->user->shop->phone) ? $seller->user->shop->phone:'',
			!empty($seller->user->shop->address) ? $seller->user->shop->address:'',
			!empty($seller->user->shop->city) ? $seller->user->shop->city:'',
			!empty($seller->user->shop->state) ? $seller->user->shop->state:'',
			!empty($seller->user->shop->postal_code) ? $seller->user->shop->postal_code:'',
			!empty($seller->user->shop->gst_number) ? $seller->user->shop->gst_number:'',
			!empty($seller->user->shop->pan_number) ? $seller->user->shop->pan_number:'',
			$seller->bank_acc_name,
			$seller->bank_name,
			$seller->bank_acc_no,
			$seller->account_type,
			$seller->ifsc_code,
			$seller->branch,
			$total_products,
			$published,
			$unpublished,
			!empty($seller->user->shop->created_at) ? $seller->user->shop->created_at:'',
        ];
    }
}
