<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Seller;
use App\Customer;
use App\User;
use App\Shop;
use App\Product;
use App\CommissionHistory;
use App\Wallet;
use App\Search;
use App\Order;
use App\OrderDetail;
use App\CouponUsage;
use App\SellerRegExport;
use App\CustomersRegExport;
use App\SalesReportExport;
use App\BestSellingProductsExport;
use App\LedgerExport;
use App\SellerSalesReportExport;
use Auth;
use Cache;
use Excel;
use DB; 
use App\SLABreachReport;
use App\Models\RecentlyViewedItem;

class ReportController extends Controller
{	
	public function seller_registration_report(Request $request){		
		
		if($request->submit_type == 'export') {				
			return Excel::download(new SellerRegExport($request->date,$request->search), 'saller_reg_data.xlsx');
		}
		else{
		
			$date = $request->date;
			$sort_search = null;			
			$sellers = Seller::orderBy('user_id', 'desc');			
			if ($date != null) {			
				$date_from = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
				$date_to   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));			
				$sellers = $sellers->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
			}
			
			if ($request->has('search')) {
				$sort_search = $request->search;
				$user_ids = User::where('user_type', 'seller')->where(function ($user) use ($sort_search) {
					$user->where('name', 'like', '%' . $sort_search . '%')->orWhere('email', 'like', '%' . $sort_search . '%');
				})->pluck('id')->toArray();
				$sellers = $sellers->where(function ($seller) use ($user_ids) {
					$seller->whereIn('user_id', $user_ids);
				});
			}
			
			$sellers = $sellers->paginate(10);      
			return view('backend.reports.seller_registration_report', compact('sellers', 'date'));	
		}
    }
	
	public function customer_registration_report(Request $request){		
		
		if($request->submit_type == 'export') {				
			return Excel::download(new CustomersRegExport($request->date,$request->search), 'customer_reg_data.xlsx');
		}
		else{
		
			$date = $request->date;
			$sort_search = null;
			$customers = Customer::orderBy('created_at', 'DESC');
			
			if ($date != null) {			
				$date_from = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
				$date_to   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));			
				$customers = $customers->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
			}
			
			if ($request->has('search')){
				$sort_search = $request->search;
				$user_ids = User::where('user_type', 'customer')->where(function($user) use ($sort_search){
						$user->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%')->orWhere('phone', 'like', '%'.$sort_search.'%');
				})->pluck('id')->toArray();
				$customers = $customers->where(function($customer) use ($user_ids){
					$customer->whereIn('user_id', $user_ids);
				});
			}
			
			$customers = $customers->paginate(10);      
			return view('backend.reports.customer_registration_report', compact('customers', 'date'));		
		}
    }

	public function registered_customer_report(Request $request){		
		
		if($request->submit_type == 'export') {				
			return Excel::download(new CustomersRegExport($request->date,$request->search), 'customer_reg_data.xlsx');
		}
		else{
		
			$date = $request->date;
			$sort_search = null;
			$customers = Customer::orderBy('created_at', 'DESC');
			
			if ($date != null) {			
				$date_from = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
				$date_to   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));			
				$customers = $customers->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
			}
			$user_ids = User::where('user_type', 'customer')->where('phone','!=',null)->pluck('id')->toArray();
			$customers = $customers->where(function($customer) use ($user_ids){
				$customer->whereIn('user_id', $user_ids);
			});
			if ($request->has('search')){
				$sort_search = $request->search;
				$user_ids = User::where('user_type', 'customer')->where('phone','!=',null)->where(function($user) use ($sort_search){
						$user->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%');
				})->pluck('id')->toArray();
				$customers = $customers->where(function($customer) use ($user_ids){
					$customer->whereIn('user_id', $user_ids);
				});
			}
			
			$customers = $customers->paginate(10);  
			return view('backend.reports.registered_customer_report', compact('customers', 'date'));		
		}
    }

	public function guest_customer_report(Request $request){		
		
		if($request->submit_type == 'export') {				
			return Excel::download(new CustomersRegExport($request->date,$request->search), 'customer_reg_data.xlsx');
		}
		else{
		
			$date = $request->date;
			$sort_search = null;
			$customers = Customer::orderBy('created_at', 'DESC');
			
			if ($date != null) {			
				$date_from = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
				$date_to   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));			
				$customers = $customers->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
			}
				$user_ids = User::where('user_type', 'customer')->where('phone','=',null)->pluck('id')->toArray();
			$customers = $customers->where(function($customer) use ($user_ids){
				$customer->whereIn('user_id', $user_ids);
			});
			if ($request->has('search')){
				$sort_search = $request->search;
				$user_ids = User::where('user_type', 'customer')->where('phone','=',null)->where(function($user) use ($sort_search){
						$user->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%');
				})->pluck('id')->toArray();
				$customers = $customers->where(function($customer) use ($user_ids){
					$customer->whereIn('user_id', $user_ids);
				});
			}
			
			$customers = $customers->paginate(10); 
			return view('backend.reports.guest_customer_report', compact('customers', 'date'));		
		}
    }
		
	public function sales_reports(Request $request)
	{	
		if($request->submit_type == 'export') {				
			return Excel::download(new SalesReportExport($request->seller_id,$request->delivery_status,$request->date), 'sales_reports_data.xlsx');
		}
		else{
			
			$seller_id   = $request->seller_id;
			$delivery_status = $request->delivery_status;
			$date = $request->date;
			
			$sales = OrderDetail::orderBy('id', 'desc');					
			
			if ($seller_id) {
				$sales = $sales->where('seller_id', $seller_id);
			}			
			if ($delivery_status) {
				$sales = $sales->where('delivery_status', $request->delivery_status);           
			}			
			if ($date != null) {			
				$date_from = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
				$date_to   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));			
				$sales = $sales->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
			}			
			$sales = $sales->paginate(10);			
			return view('backend.reports.sales_reports', compact('sales','seller_id','delivery_status','date'));
		}
    }
	
	public function best_selling_products_report(Request $request)
	{	
		if($request->submit_type == 'export') {				
			return Excel::download(new BestSellingProductsExport($request->date,$request->seller_id), 'best_selling_products_report.xlsx');
		}
		else{
			
			$seller_id = $request->seller_id;
			$date = $request->date;			
			$sort_search = null;
			
			$best_selling_items = OrderDetail::select('product_id','seller_id',DB::raw('COUNT(product_id) as number_of_sale'))->groupBy('product_id')->orderBy('number_of_sale','desc');
			
			if ($date != null) {			
				$date_from = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
				$date_to   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));			
				$best_selling_items = $best_selling_items->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
			}
			
			if ($seller_id) {
				$best_selling_items = $best_selling_items->where('seller_id', $seller_id);
			}
			
			$best_selling_items = $best_selling_items->paginate(10); 
			
			return view('backend.reports.best_selling_products_report', compact('best_selling_items','seller_id','date','sort_search'));
		}
    }
	
	public function coupon_code_utilization_report(Request $request){		
		$date = null;  
        $couponUsage = CouponUsage::orderBy('id', 'desc');
        		
		if ($request->$date != null) {			
			$date_from = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
			$date_to   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));			
			$couponUsage = $couponUsage->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
		}
		
        $couponUsage = $couponUsage->paginate(10);      
        return view('backend.reports.coupon_code_utilization_report', compact('couponUsage', 'date'));		
    }	
		
	public function seller_sale_report(Request $request)
	{	
		if($request->submit_type == 'export') {				
			return Excel::download(new SellerSalesReportExport($request->date,$request->seller_id), 'saller_sales_report.xlsx');
		}
		else{			
			$seller_id = $request->seller_id;
			$date = $request->date;
			$sort_by =null;	
			
			$sellers = OrderDetail::select('seller_id',DB::raw('COUNT(product_id) as number_of_sale,SUM(price) as total_sale'))->groupBy('seller_id')->orderBy('number_of_sale','desc');
			
			if ($date != null) {			
				$date_from = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
				$date_to   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));			
				$sellers = $sellers->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
			}
			
			if ($seller_id) {
				$sellers = $sellers->where('seller_id', $seller_id);
			}
			$sellers = $sellers->paginate(10);
			return view('backend.reports.seller_sale_report', compact('sellers','seller_id','date','sort_by'));
		}
    }
   
    public function stock_report(Request $request)
    {
        $sort_by =null;
        $products = Product::orderBy('created_at', 'desc');
        if ($request->has('category_id')){
            $sort_by = $request->category_id;
            $products = $products->where('category_id', $sort_by);
        }
        $products = $products->paginate(15);
        return view('backend.reports.stock_report', compact('products','sort_by'));
    }
	
	public function wish_report(Request $request)
    {
        $sort_by =null;
        $products = Product::orderBy('created_at', 'desc');
        if ($request->has('category_id')){
            $sort_by = $request->category_id;
            $products = $products->where('category_id', $sort_by);
        }
        $products = $products->paginate(10);
        return view('backend.reports.wish_report', compact('products','sort_by'));
    }

    public function user_search_report(Request $request){
        $searches = Search::orderBy('count', 'desc')->paginate(10);
        return view('backend.reports.user_search_report', compact('searches'));
    }
    
    public function commission_history(Request $request) 
	{		
		if($request->submit_type == 'export') {	
			
			return Excel::download(new LedgerExport($request->seller_id,$request->date,$request->delivery_status,$request->search), 'ledger.xlsx');
		}
		else{
			
			$seller_id = null;
			$date = null;
			$delivery_status = null;
			$sort_search = null;
		
			if(Auth::user()->user_type == 'seller') {
				$seller_id = Auth::user()->id;
			} if($request->seller_id) {
				$seller_id = $request->seller_id;
			}
					
			$commission_history = CommissionHistory::orderBy('id', 'desc');
			
			if ($date != null) {			
				$date_from = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
				$date_to   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));			
				$commission_history = $commission_history->whereBetween('delivered_date', [$date_from." 00:00:00",$date_to." 23:59:59"]);
			}
			
			if ($seller_id){            
				$commission_history = $commission_history->where('seller_id', '=', $seller_id);
			}
			
			if ($request->delivery_status) {
				$delivery_status = $request->delivery_status;
				$commission_history = $commission_history->where('delivery_status', $request->delivery_status);           
			}
			
			if ($request->has('search')) {
				$sort_search = $request->search;
				$commission_history = $commission_history->where('code', 'like', '%' . $sort_search . '%');
			}
			
			
			$commission_history = $commission_history->paginate(10);
			if(Auth::user()->user_type == 'seller') {
				return view('frontend.user.seller.reports.commission_history_report', compact('commission_history', 'date', 'date_range', 'delivery_status','sort_search'));
			}
			return view('backend.reports.commission_history_report', compact('commission_history', 'seller_id', 'date','delivery_status','sort_search'));
					
		}   
	}
    
    public function in_house_sale_report(Request $request)
    {
        $sort_by =null;
        $products = Product::orderBy('num_of_sale', 'desc')->where('added_by', 'admin');
        if ($request->has('category_id')){
            $sort_by = $request->category_id;
            $products = $products->where('category_id', $sort_by);
        }
        $products = $products->paginate(15);
        return view('backend.reports.in_house_sale_report', compact('products','sort_by'));
    }  
	
    public function wallet_transaction_history(Request $request) {
        $user_id = null;
        $date_range = null;
        
        if($request->user_id) {
            $user_id = $request->user_id;
        }
        
        $users_with_wallet = User::whereIn('id', function($query) {
            $query->select('user_id')->from(with(new Wallet)->getTable());
        })->get();

        $wallet_history = Wallet::orderBy('created_at', 'desc');
        
        if ($request->date_range) {
            $date_range = $request->date_range;
            $date_range1 = explode(" / ", $request->date_range);
            $wallet_history = $wallet_history->where('created_at', '>=', $date_range1[0]);
            $wallet_history = $wallet_history->where('created_at', '<=', $date_range1[1]);
        }
        if ($user_id){
            $wallet_history = $wallet_history->where('user_id', '=', $user_id);
        }
        
        $wallets = $wallet_history->paginate(10);

        return view('backend.reports.wallet_history_report', compact('wallets', 'users_with_wallet', 'user_id', 'date_range'));
    }
	
	/**
	* method to load the report for the sla breach
	*/	
	public function sla_breach_report(Request $request)
	{
		if($request->submit_type == 'export') {	
			$excel = new SLABreachReport($request->date,$request->delivery_status);	
			return Excel::download($excel, 'sla_breach.xlsx');
		}
		else{

			$date = $request->date;
			$sort_search = null;
			$delivery_status = null;
			//TODO: can we update the sla in case the vendor is not updating the status and it has breached the time 
			$orders = Order::orderBy('id', 'desc')->where('sla_breach',1);
			if ($request->has('search')) {
				$sort_search = $request->search;
				$orders = $orders->where('code', 'like', '%' . $sort_search . '%');
			}
		
			if ($date != null) {	
				$date_from = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
				$date_to   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));			
				$orders = $orders->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
			}	
			$orders = $orders->paginate(15);
			return view('backend.reports.sla_breach_report', compact('orders', 'sort_search', 'delivery_status', 'date'));
		}
	}
	
	/**
	* method to load the report for the sla breach
	*/	
	public function recently_viewed_report(Request $request)
	{
		if($request->submit_type == 'export') {	
			$excel = new RecentlyViewedReport($request->date);	
			return Excel::download($excel, 'recently_viewed.xlsx');
		}
		else{

			$date = $request->date;
			//TODO: can we update the sla in case the vendor is not updating the status and it has breached the time 
			$recently = RecentlyViewedItem::orderBy('id', 'desc');			
			if ($date != null) {	
				$date_from = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
				$date_to   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));			
				$recently = $recently->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
			}	
			$recently = $recently->paginate(15);
			return view('backend.reports.recently_viewed_items', compact('recently', 'date'));
		}
	}
		
}
