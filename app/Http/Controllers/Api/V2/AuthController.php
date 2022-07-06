<?php

/** @noinspection PhpUndefinedClassInspection */

namespace App\Http\Controllers\Api\V2;

use Hash;
use App\User;
use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\OTPVerificationController;
use App\Notifications\AppEmailVerificationNotification;


class AuthController extends Controller
{
    public function signup(Request $request)
    {
        if (User::where('email', $request->email)->orWhere('phone', $request->phone)->first() != null) {
            $exist_user = User::where('email', $request->email)->orWhere('phone', $request->phone)->first();
            $message = $exist_user->email == $request->email ? $exist_user->email: ($exist_user->phone == $request->phone ? $exist_user->phone : "");
            return response()->json([
                'result' => false,
                'message' => 'User with this '.$message.' already exists. Please login!',
                'user_id' => 0
            ], 201);
        }

            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'verification_code' => rand(100000, 999999)
            ]);

        if (BusinessSetting::where('type', 'email_verification')->first()->value != 1) {
            $user->email_verified_at = date('Y-m-d H:m:s');
        } elseif ($request->register_by == 'email') {
            try {
                $user->notify(new AppEmailVerificationNotification());
            } catch (\Exception $e) {
            }
        } else {
            $otpController = new OTPVerificationController();
            $otpController->send_code($user);
        }

        $user->save();
        $customer = new Customer;
        $customer->user_id = $user->id;
        $customer->save();
        return response()->json([
            'result' => true,
            'message' => 'Registration Successful. Please verify and log in to your account.',
            'user_id' => $user->id
        ], 201);
    }

    public function resendCode(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $user->verification_code = rand(100000, 999999);

        if ($request->verify_by == 'email') {
            $user->notify(new AppEmailVerificationNotification());
        } else {
            $otpController = new OTPVerificationController();
            $otpController->send_code($user);
        }

        $user->save();

        return response()->json([
            'result' => true,
            'message' => 'Verification code is sent again',
        ], 200);
    }
    public function confirmCode(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        if ($user->verification_code == $request->verification_code) {
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->verification_code = null;
            $user->save();
            return response()->json([
                'result' => true,
                'message' => 'Your account is now verified.Please login',
            ], 200);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Code does not match, you can request for resending the code',
            ], 200);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            // 'remember_me' => 'boolean'
        ]);
        if(User::where('user_type', 'seller')->where('email', $request->email)->orWhere('phone', $request->email)->first()) {
            return response()->json(['result' => false, 'message' => 'This user is registered as a seller on sadar24. Please login with another mobile number..!!', 'user' => null, 'session_id' => null], 401);
		}
// dd($request);
        // $delivery_boy_condition = $request->has('user_type') && $request->user_type == 'delivery_boy';

        // if ($delivery_boy_condition) {
        //     $user = User::whereIn('user_type', ['delivery_boy'])->where('email', $request->email)->orWhere('phone', $request->email)->first();
        // } else {
            // dd($request);
            $user = User::where('user_type', 'customer')->where('email', $request->email)->orWhere('phone', $request->email)->first();
            // dd($user);
        // }


        if ($user != null) {
            if (Hash::check($request->password, $user->password)) {

                if ($user->email_verified_at == null) {
                    return response()->json(['message' => 'Please verify your account', 'user' => null], 401);
                }
                $tokenResult = $user->createToken('Personal Access Token');
                return $this->loginSuccess($tokenResult, $user);
            } else {
                return response()->json(['result' => false, 'message' => 'Incorrect password. Re-enter or reset your password!', 'user' => null], 401);
            }
        } else {
            return response()->json(['result' => false, 'message' => 'No user exist. Please Signup first!', 'user' => null], 401);
        }
    }

    public function sendLoginOtp(Request $request)
    {
        // Check validation
        $this->validate($request, [
            'phone' => 'required|regex:/[0-9]{10}/|digits:10',            
        ]);
		$phone = $request->get('phone');

		if(User::where('user_type', 'seller')->where('phone', $request->get('phone'))->first()) {
            return response()->json(['result' => false, 'message' => 'This number is registered as a seller on sadar24. Please login with another mobile number..!!', 'user' => null, 'session_id' => null], 401);
		}
        // Get user record
        $user = User::where('user_type', 'customer')->where('phone', $request->get('phone'))->first();
		
        // Check Condition Mobile No. Found or Not
		
        if($user == null) {
            return response()->json(['result' => false, 'message' => 'Your mobile number not match in our system..!!', 'user' => null, 'session_id' => null], 401);
		} else{
			if($phone != $user->phone) {
            return response()->json(['result' => false, 'message' => 'Your mobile number not match in our system..!!', 'user' => null, 'session_id' => null], 401);
			}
		}
		
		$api = 'c59e9994-ef4f-11ea-9fa5-0200cd936042';
		$url = "https://2factor.in/API/V1/".$api."/SMS/+91".$phone."/AUTOGEN/smsotp1";

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);
		$resp1 = json_decode($resp, true);
		$status =  $resp1['Status'];
		$session_id =  $resp1['Details'];
        // Set Auth Details
		if ($status == "Success"){
            $tokenResult = $user->createToken('Personal Access Token');
			// flash(translate('Phone Number matched.'))->success();
            return response()->json(['result' => true, 'message' => 'Phone Number matched. OTP Sent!', 'user' => $phone, 'session_id' => $session_id]);
			// return view('frontend.otp', compact('resp','session_id','phone'));
		} else{
			
            return response()->json(['result' => false, 'message' => '! OTP is wrong..!!', 'user' => null, 'session_id' => null], 401);
		}
    }


    public function mobileLogin(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|regex:/[0-9]{10}/|digits:10',            
        ]);

        // Get user record
        $user = User::where('phone', $request->get('phone'))->first();
		$otp = $request->get('otp');
		$session_id =  $request->get('session_id');
		$api = 'c59e9994-ef4f-11ea-9fa5-0200cd936042';
		$url = "https://2factor.in/API/V1/".$api."/SMS/VERIFY/".$session_id."/".$otp;
		//dd($request);
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		
		curl_close($curl);
		$resp1 = json_decode($resp, true);
		
        $status =  $resp1['Status'];
        // Set Auth Details
		if ($status == "Success"){
			\Auth::login($user);
			// if($user->user_type == 'seller'){
			// 	flash(translate('Login successfully'))->success();
			// 	return redirect()->route('orders.index');
			// }
			// elseif($user->user_type == 'customer'){
			// 	flash(translate('Login successfully'))->success();
			// 	return redirect()->route('cart');
			// }
			// Redirect home page
			// flash(translate('Login successfully'))->success();
			// return redirect()->route('cart');
            $tokenResult = $user->createToken('Personal Access Token');
                return $this->loginSuccess($tokenResult, $user);
		} else{
			// flash(translate($status.'! OTP is wrong..!!'))->error();
			return response()->json(['status' => false, 'message' => '! OTP is wrong..!!'], 401);
            // return redirect()->route('user.otplogin');
			
		}
        
        
    }


    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'result' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    public function socialLogin(Request $request)
    {
        if (User::where('email', $request->email)->first() != null) {
            $user = User::where('email', $request->email)->first();
        } else {
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'provider_id' => $request->provider,
                'email_verified_at' => Carbon::now()
            ]);
            $user->save();
            $customer = new Customer;
            $customer->user_id = $user->id;
            $customer->save();
        }
        $tokenResult = $user->createToken('Personal Access Token');
        return $this->loginSuccess($tokenResult, $user);
    }

    protected function loginSuccess($tokenResult, $user)
    {
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(100);
        $token->save();
        return response()->json([
            'result' => true,
            'message' => 'Successfully logged in',
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => [
                'id' => $user->id,
                'type' => $user->user_type,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'avatar_original' => api_asset($user->avatar_original),
                'phone' => $user->phone
            ]
        ]);
    }
}
