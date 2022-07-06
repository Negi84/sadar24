<?php

namespace App\Http\Controllers;

use Cache;
use App\Product;
use App\Category;
use Illuminate\Support\Str;
use App\CategoryTranslation;
use Illuminate\Http\Request;
use App\Utility\CategoryUtility;
use Illuminate\Support\Facades\DB;

class ajaxCallController extends Controller
{

    public function validatePhoneFields(Request $request){
       if(DB::table('users')->where('phone',$request->phone)->pluck('phone')->first() != null){
            $status  = [
                "for" => "Phone",
                "status" => "This ".$request->phone." Phone Is Already Exist!",
            ];
            return $status;
        }
    }
    public function validateEmailFields(Request $request){
        if(DB::table('users')->where('email',$request->email)->pluck('email')->first() != null){
            $status  = [
                "for" => "Email",
                "status" => "This ".$request->email." Email Is Already Exist!",
            ];
            return $status;
        }
    }
    public function validateGstFields(Request $request){
       if(DB::table('shops')->where('gst_number',$request->gst)->pluck('gst_number')->first() != null){
            $status  = [
                "for" => "GST",
                "status" => "This ".$request->gst." GST Number Is Already Exist!",
            ];
            return $status;
        }
    }
    
}
