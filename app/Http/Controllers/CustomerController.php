<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Customer;
use App\User;
use App\Order;
use App\OrderDetail;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $customer_type = "all";
        $customers = Customer::orderBy('created_at', 'desc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $user_ids = User::where('user_type', 'customer')->where(function($user) use ($sort_search){
                $user->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%');
            })->pluck('id')->toArray();
            $customers = $customers->where(function($customer) use ($user_ids){
                $customer->whereIn('user_id', $user_ids);
            });
        }
        $customers = $customers->paginate(15);
        return view('backend.customer.customers.index', compact('customers', 'sort_search','customer_type'));
    }
	
	
	public function customer_purchase_history($id,Request $request)
    {	
		$delivery_status = null;
        $date = null;
		$sort_search = null;
		
		$purchase_history = Order::where('user_id', $id)->orderBy('created_at', 'desc');

        if ($request->delivery_status != null) {
            $purchase_history = $purchase_history->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')) {           
            $purchase_history = $purchase_history->where('code', 'like', '%' . $sort_search . '%');
			$sort_search = $request->search;
        }
		if ($date != null) {			
			$date_from = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
			$date_to   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));			
			$purchase_history = $purchase_history->whereBetween('created_at', [$date_from." 00:00:00",$date_to." 23:59:59"]);
		}

        $purchase_history = $purchase_history->paginate(15);		
        return view('backend.customer.customers.purchase_history', compact('purchase_history','delivery_status','date','sort_search'));
    }

    public function registered_index(Request $request)
    {   
        $sort_search = null;
        $customer_type = "registered";
        $customers = Customer::orderBy('created_at', 'desc');
        // ->where('phone','!=',null)
        if ($request->has('search')){
            $sort_search = $request->search;
            $user_ids = User::where('user_type', 'customer')->where('phone','!=',null)->where(function($user) use ($sort_search){
                $user->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%');
            })->pluck('id')->toArray();
            $customers = $customers->where(function($customer) use ($user_ids){
                $customer->whereIn('user_id', $user_ids);
            });
        }
        $user_ids = User::where('user_type', 'customer')->where('phone','!=',null)->pluck('id')->toArray();
        $customers = $customers->where(function($customer) use ($user_ids){
            $customer->whereIn('user_id', $user_ids);
        });
        $customers = $customers->paginate(15);
        return view('backend.customer.customers.index', compact('customers', 'sort_search','customer_type'));
    }

    public function guest_index(Request $request)
    {
        $sort_search = null;
        $customer_type = "guest";
        $customers = Customer::orderBy('created_at', 'desc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $user_ids = User::where('user_type', 'customer')->where('phone','=',null)->where(function($user) use ($sort_search){
                $user->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%');
            })->pluck('id')->toArray();
            $customers = $customers->where(function($customer) use ($user_ids){
                $customer->whereIn('user_id', $user_ids);
            });
        }
        $user_ids = User::where('user_type', 'customer')->where('phone','=',null)->pluck('id')->toArray();
        $customers = $customers->where(function($customer) use ($user_ids){
            $customer->whereIn('user_id', $user_ids);
        });
     
        $customers = $customers->paginate(15);
        return view('backend.customer.customers.index', compact('customers', 'sort_search','customer_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'email'         => 'required|unique:users|email',
            'phone'         => 'required|unique:users',
        ]);
        
        $response['status'] = 'Error';
        
        $user = User::create($request->all());
        
        $customer = new Customer;
        
        $customer->user_id = $user->id;
        $customer->save();
        
        if (isset($user->id)) {
            $html = '';
            $html .= '<option value="">
                        '. translate("Walk In Customer") .'
                    </option>';
            foreach(Customer::all() as $key => $customer){
                if ($customer->user) {
                    $html .= '<option value="'.$customer->user->id.'" data-contact="'.$customer->user->email.'">
                                '.$customer->user->name.'
                            </option>';
                }
            }
            
            $response['status'] = 'Success';
            $response['html'] = $html;
        }
        
        echo json_encode($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::where('user_id', Customer::findOrFail($id)->user->id)->delete();
        User::destroy(Customer::findOrFail($id)->user->id);
        if(Customer::destroy($id)){
            flash(translate('Customer has been deleted successfully'))->success();
            return redirect()->route('customers.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }
    
    public function bulk_customer_delete(Request $request) {
        if($request->id) {
            foreach ($request->id as $customer_id) {
                $this->destroy($customer_id);
            }
        }
        
        return 1;
    }

    public function login($id)
    {
        $customer = Customer::findOrFail(decrypt($id));

        $user  = $customer->user;

        auth()->login($user, true);

        return redirect()->route('dashboard');
    }

    public function ban($id) {
        $customer = Customer::findOrFail($id);

        if($customer->user->banned == 1) {
            $customer->user->banned = 0;
            flash(translate('Customer UnBanned Successfully'))->success();
        } else {
            $customer->user->banned = 1;
            flash(translate('Customer Banned Successfully'))->success();
        }

        $customer->user->save();

        return back();
    }
}
