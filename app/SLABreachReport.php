<?php

namespace App;

use App\Order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SLABreachReport implements FromCollection, WithMapping, WithHeadings
{
	protected $date,$delivery_status;
	private $sla_charge ,$sla_charge_type;
	function __construct($date,$delivery_status) {
		$this->date	   		= $date;
		$this->delivery_status	= $delivery_status;	
		$this->sla_charge= get_setting('sla_charge',0);
		$this->sla_charge_type= get_setting('sla_charge_type','flat');

	}
	
	public function collection()
    {
		$orders = Order::orderBy('id', 'asc')->where('sla_breach',1);
		if ($this->date) {			
			$date_from = date('Y-m-d', strtotime(explode(" to ", $this->date)[0]));
			$date_to   = date('Y-m-d', strtotime(explode(" to ", $this->date)[1]));			
			$orders = $orders->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
		}		
		// if ($this->delivery_status) {
		// 	$orders = $orders->where('delivery_status', $this->delivery_status);           
		// }		
        return $orders->get();
    }

    public function headings(): array
    {
        return [
			'Date',
            'Order ID',            
            'Customer Name',
			'Customer Phone',
			'Seller Name',
			'Seller Number',
			'Amount',
			'SLA Breach Amount',
			'Delivery Status',
        ];
    }

    /**
    * @var Orders $orders
    */
    public function map($orders): array
    {   
		$shipping_address = json_decode($orders->shipping_address);	
		// $charge =0;
		// if($this->sla_charge_type == 'per') {
		// 	$charge = ($orders->grand_total*$this->sla_charge)/100;
		// }
		// else $charge = $this->sla_charge;
		
        return [
			$orders->created_at,
            $orders->code,           
			!empty($shipping_address->name ) ? $shipping_address->name  : '',
			!empty($shipping_address->phone ) ? $shipping_address->phone : '',
			!empty($orders->seller->name) ? $orders->seller->name : '',
			!empty($orders->seller->phone) ? $orders->seller->phone : '',
			single_price($orders->grand_total),
			single_price($orders->slaBreach->sla_amount), 
			!empty($orders->delivery_status) ? $orders->delivery_status : '',		
        ];
    }
}