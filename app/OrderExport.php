<?php

namespace App;

use App\Order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderExport implements FromCollection, WithMapping, WithHeadings
{
	protected $date,$delivery_status;
	
	function __construct($date,$delivery_status) {
		$this->date	   		= $date;
		$this->delivery_status	= $delivery_status;	
	}
	
	public function collection()
    {
		$orders = Order::orderBy('id', 'asc');
		
		if ($this->date) {			
			$date_from = date('Y-m-d', strtotime(explode(" to ", $this->date)[0]));
			$date_to   = date('Y-m-d', strtotime(explode(" to ", $this->date)[1]));			
			$orders = $orders->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
		}		
		if ($this->delivery_status) {
			$orders = $orders->where('delivery_status', $this->delivery_status);           
		}		
        return $orders->get();
    }

    public function headings(): array
    {
        return [
			'Date',
            'Order ID',            
            'Customer Name',
			'Customer Phone',
			'Customer State',
			'Seller Name',
			'Seller Number',
			'Waybill',
			'Delivery Status',
			'Payment Method',
			'Payment Status',
			'Amount',
        ];
    }

    /**
    * @var Orders $orders
    */
    public function map($orders): array
    {   
		$shipping_address = json_decode($orders->shipping_address);	
		
        return [
			$orders->created_at,
            $orders->code,           
			!empty($shipping_address->name ) ? $shipping_address->name  : '',
			!empty($shipping_address->phone ) ? $shipping_address->phone : '',
			!empty($shipping_address->state) ? $shipping_address->state : '',
			!empty($orders->seller->name) ? $orders->seller->name : '',
			!empty($orders->seller->phone) ? $orders->seller->phone : '',
			!empty($orders->waybill) ? $orders->waybill : 'Pending for ready to ship',
			!empty($orders->delivery_status) ? $orders->delivery_status : '',
			!empty($orders->payment_type) ? $orders->payment_type : '',
			!empty($orders->payment_status) ? $orders->payment_status : '',
			$orders->grand_total,	
        ];
    }
}
