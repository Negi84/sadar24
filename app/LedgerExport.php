<?php

namespace App;

use App\Order;
use App\CommissionHistory;
use App\OrderDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LedgerExport implements FromCollection, WithMapping, WithHeadings
{
	protected $seller_id,$order_date,$delivered_date,$delivery_status,$search;
	
	function __construct($seller_id,$order_date,$delivered_date,$delivery_status,$search) {
		$this->seller_id	    = $seller_id;
		$this->order_date	   	= $order_date;
		$this->delivered_date	= $delivered_date;
		$this->delivery_status	= $delivery_status;
		$this->search	    	= $search;		
	}
		
    public function collection()
    {
		$commission_history = CommissionHistory::orderBy('id', 'desc');			
		
		if ($this->seller_id){            
			$commission_history = $commission_history->where('seller_id', '=', $this->seller_id);
		}
		
		if ($this->order_date) {			
			$date_from = date('Y-m-d', strtotime(explode(" to ", $this->order_date)[0]));
			$date_to   = date('Y-m-d', strtotime(explode(" to ", $this->order_date)[1]));			
			$commission_history = $commission_history->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
		}
		
		if ($this->delivered_date) {			
			$date_from = date('Y-m-d', strtotime(explode(" to ", $this->delivered_date)[0]));
			$date_to   = date('Y-m-d', strtotime(explode(" to ", $this->delivered_date)[1]));			
			$commission_history = $commission_history->whereBetween('delivered_date', [$date_from." 00:00:00",$date_to." 23:59:59"]);
		}		
		
		if ($this->delivery_status) {
			$commission_history = $commission_history->where('delivery_status', $this->delivery_status);           
		}
				
		if ($this->search) {
			$commission_history = $commission_history->where('code', 'like', '%' . $this->search . '%');
		}
		
        return $commission_history->get();
    }

    public function headings(): array
    {
        return [
            'VENDOR',
			'ORDER ID',
			'ORDER DATE',
			'CUSTOMER',
			'WAYBILL',
			'DELIVERY STATUS',
			'DELIVERY DATE',
			'PAYMENT TYPE',
			'TAXABLE PRICE',
			'GST ON TAXABLE PRICE',
			'GST ON TAXABLE AMOUNT',
			'SUBTOTAL',
			'DISCOUNT',
			'SHIPPING',
			'INVOICE AMOUNT',
			'ROUND OF INVOICE AMOUNT',
			'AMOUNT RECEIVED',
			'AMOUNT RECEIVED DATE',
			'TOTAL QTY',
			'PLATFORM CHARGES',
			'GST ON PLATFORM CHARGES 18%',
			'GST TYPE ON PLATFORM CHARGES',
			'SHIPPING',
			'GST ON SHIPPING CHARGES',
			'GST TYPE ON SHIPPING CHARGES',
			'TDS',
			'TCS',
			'GST TYPE ON TCS',
			'DISCOUNT AMOUNT',
			'NET PAYABLE AMOUNT',
			'ROUND OF NET PAYABLE AMOUNT',
			'PAID AMOUNT',
			'PAID DATE',			
        ];
    }

    /**
    * @var History $history
    */
    public function map($history): array
    {   
		
		if(isset($history->order->seller)){
			$seller_name = $history->order->seller->name ;
			if(strtoupper($history->order->seller->state) == 'DELHI'){										
				$platform_gst_type = 'CGST,SGST';
				$shipping_gst_type = 'CGST,SGST';
			}else{
				$platform_gst_type = 'IGST';
				$shipping_gst_type = 'IGST';
			}
			
		}else{
			$seller_name = 'Seller Deleted';
			$platform_gst_type = 'Not Available';
			$shipping_gst_type = 'Not Available';
		}
		
		if(isset($history->order)){
			$order_id = $history->order->code;
		}else{
			$order_id = 'Order Deleted';
		}	
		
		if(isset($history->order->shipping_address)){			
			if(isset(json_decode($history->order->shipping_address)->state)){			
				if(strtoupper($history->order->seller->state) == strtoupper(json_decode($history->order->shipping_address)->state)){									
					$tcs_gst_type = 'CGST,SGST';
				}else{
					$tcs_gst_type = 'IGST';
				}
			}else{
				$tcs_gst_type = 'Not Available';
			}
		}else{
			$tcs_gst_type = 'Not Available';
			
		}
		
        return [
			!empty($seller_name) ? $seller_name : '',
			!empty($order_id) ? $order_id : '',
			$history->created_at,
			!empty($history->order->user->name) ? $history->order->user->name : '',
			!empty($history->order->waybill) ? $history->order->waybill : '',
			$history->delivery_status,
			$history->delivered_date,
			!empty($history->order->payment_type) ? $history->order->payment_type : '',
			$history->product_price,
			$history->gst_on_product."%",
			$history->gst_on_product_amount,
			$history->subtotal,
            $history->coupon_discount,
			($history->shipping + $history->shipping_with_gst),
			$history->invoice_amount,
			round($history->invoice_amount),
			$history->amount_received,
			$history->delivered_date,
			!empty($history->orderDetails->quantity) ? $history->orderDetails->quantity : '',
			$history->platform_charges,
			$history->platform_charges_with_gst,
			$platform_gst_type,
			$history->shipping,
			$history->shipping_with_gst,
			$shipping_gst_type,
			$history->tds,
			$history->tcs,
			$tcs_gst_type,
			$history->coupon_discount,
			$history->seller_earning,
			round($history->seller_earning),
			$history->paid_amount,
			$history->paid_date,
        ];
    }
}
