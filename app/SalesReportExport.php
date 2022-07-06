<?php

namespace App;

use App\Seller;
use App\Product;
use App\Order;
use App\OrderDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesReportExport implements FromCollection, WithMapping, WithHeadings
{
	protected $seller_id,$delivery_status,$date;
	
	function __construct($seller_id,$delivery_status,$date) {		
		$this->seller_id		= $seller_id;
		$this->delivery_status	= $delivery_status;
		$this->date	   	    	= $date;
	}
		
    public function collection() 
    {
		$orders = OrderDetail::orderBy('id', 'desc');	
		
		if ($this->seller_id) {
			$orders = $orders->where('seller_id', $this->seller_id);
		}
		
		if ($this->delivery_status) {
			$orders = $orders->where('delivery_status', $this->delivery_status);           
		}
		
		if ($this->date) {			
			$date_from = date('Y-m-d', strtotime(explode(" to ", $this->date)[0]));
			$date_to   = date('Y-m-d', strtotime(explode(" to ", $this->date)[1]));			
			$orders = $orders->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
		}
        return $orders->get();
    }

    public function headings(): array
    {
        return [  
		
            'Order Date',
			'Order ID',
			'Customer Name',
			'Product Name',			
			'Product Price',
			'Category',
			'Customer State',
			'Customer City',
			'Customer Phone',
			'Delivery Status',
			'Payment Status',
			'Payment Method',
			'Seller Name',
			'Seller Phone',
        ];
    }

    /**
    * @var OrderDetail $orderDetail
    */
    public function map($orderDetail): array
    {   
		ini_set('max_execution_time',60000);
		ini_set('memory_limit', '-1');
	
		$shipping_address = json_decode($orderDetail->order->shipping_address);	
		
		if(empty($shipping_address)){
			$shipping_address->state = '';
			$shipping_address->city = '';
			$shipping_address->phone = '';
		}
		
		 return [			
			$orderDetail->created_at,
			!empty($orderDetail->order->code) ? $orderDetail->order->code:'Not available',
			!empty($orderDetail->order->user->name) ? $orderDetail->order->user->name:'Not available',
			!empty($orderDetail->product->name) ? $orderDetail->product->name:'Not available',			
			$orderDetail->price,
			!empty($orderDetail->product->category->name) ? $orderDetail->product->category->name:'Not available',	
			!empty($shipping_address->state) ? $shipping_address->state :'Not available',
			!empty($shipping_address->city)  ? $shipping_address->city :'Not available',
			!empty($shipping_address->phone) ? $shipping_address->phone :'Not available',
			$orderDetail->delivery_status,
			$orderDetail->payment_status,
			$orderDetail->order->payment_type ,
			!empty($orderDetail->seller->name) ? $orderDetail->seller->name:'Not available',
			!empty($orderDetail->seller->phone) ? $orderDetail->seller->phone:'Not available',			
        ];
    }
}
