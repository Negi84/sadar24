<?php

namespace App;

use App\Customer;
use App\Address;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersRegExport implements FromCollection, WithMapping, WithHeadings
{
	protected $date,$search;
	
	function __construct($date,$search) {
		$this->date	    = $date;
		$this->search	= $search;		
	}
	
     public function collection()
    {
        $customers = Customer::orderBy('created_at', 'desc');
			
		if ($this->date) {			
			$date_from = date('Y-m-d', strtotime(explode(" to ", $this->date)[0]));
			$date_to   = date('Y-m-d', strtotime(explode(" to ", $this->date)[1]));			
			$customers = $customers->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
		}
		
		if ($this->search) {
			$sort_search = $this->search;
			$user_ids = User::where('user_type', 'customer')->where(function($user) use ($sort_search){
					$user->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%');
			})->pluck('id')->toArray();
			
			$customers = $customers->where(function($customer) use ($user_ids){
				$customers->whereIn('user_id', $user_ids);
			});
		}
		
        return $customers->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
			'Address',
			'City',
			'State',
			'Registration Date',
        ];
    }

    /**
    * @var Customer $customers
    */
    public function map($customers): array
    {     
		$user_phone = "";
		$user_add = "";
		$user_city = "";
		$user_state = "";
		
		$user_id = !empty($customers->user->id) ? $customers->user->id:'' ;
		
		$user_details = Address::where('user_id', $user_id)->first();								
		if($user_details){
			$user_phone = $user_details->phone;
			$user_add = $user_details->address;
			$user_city = $user_details->city;
			$user_state = $user_details->state;	
		}		
	
		
        return [
            !empty($customers->user->name) ? $customers->user->name:'',
			!empty($customers->user->email) ? $customers->user->email:'',
			!empty($customers->user->phone) ? $customers->user->phone:$user_phone,
			!empty($customers->user->address) ? $customers->user->address:$user_add,
			!empty($customers->user->city) ? $customers->user->city:$user_city,
			!empty($customers->user->state) ? $customers->user->state:$user_state,
			!empty($customers->user->created_at) ? $customers->user->created_at:'',
        ]; 
    }
}
