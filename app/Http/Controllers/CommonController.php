<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Mail;
use Hash;
use App\Mail\SendSignUpMail;
class CommonController extends Controller
{
    public function searchStores(Request $request){
		
		$searchItem='';
		
		$search_store=$request->search_store;
		if(isset($search_store) && $search_store!=''){
			$redirectURL=url('/').'/stores/'.$search_store;
			return redirect($redirectURL);
		}else{
			return view('errors.404');
		}
	}
	
	public function getRegistartionForm(){
		if(Auth::check()){
			if(getUserRole(Auth::id())==1){
				return redirect()->route('dashboard.index');
			}else{
				return redirect('dashboard');
			}
		}else{
			$causeCats=\App\CauseCategory::where('status',1)->where('trash',0)->orderBy('name','ASC')->get();
			return view('pages.register',compact('causeCats'));
		}
	}
	
	public function checkEmailExists(Request $request){
		$email=$request->email;
		
		$checkEmailExists=\App\User::where('email',$email)->get()->count();
		if(empty($email)){
			return response()->json(['status'=>false,'message'=>'Please enter email address.']);
		}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			return response()->json(['status'=>false,'message'=>'Please enter valid email address']);
		}else if($checkEmailExists>0){
			return response()->json(['status'=>false,'message'=>'Email already exists, Please try new one.']);
		}else{
			return response()->json(['status'=>true,'message'=>'Success']);
		}
	}
	
	public function checkContactNumberExists(Request $request){
		$contact_number=$request->contact_number;
		
		if(empty($contact_number)){
			return response()->json(['status'=>false,'message'=>'Please enter contact number.']);
		}else{
			$user=\App\User::where('contact_number',$contact_number)->get()->count();
			if($user>0){
				return response()->json(['status'=>false,'message'=>'Contact number already exists, Please try new one.']);
			}else{
				return response()->json(['status'=>true,'message'=>'Success']);
			}
		}
	}
	
	public function registerUser(Request $request){
		
		$rules = [
			'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
		//	'contact_number' => 'required|unique:users',
			'password' => 'required',
			'cause_id' => 'required',
		];
		$this->validate($request, $rules);
		
		$data['name']=$request->name;
		$data['email']=$request->email;
		//$data['contact_number']=$request->contact_number;
		$data['password']=bcrypt($request->password);
		$data['cause_id']=$request->cause_id;
		
		$user=\App\User::create($data);
		
		if($user){
			$createRole=\App\UserRole::insert(['role_id'=>2,'user_id'=>$user->id,'created_at'=>date('Y-m-d h:i:s')]);
			$username=str_replace(' ','',$request->name).''.$user->id;
			\App\User::where('id',$user->id)->update(['username'=>$username]);

			Mail::to($user->email)->send(new SendSignUpMail($user));
			
			Auth::attempt(['email'=>$request->email,'password'=>$request->password]);
			
			//Send EmailTo User
				
		//	Mail::to($request->email)->send(new SendSignUpMail($user));
			return response()->json(['status'=>true,'message'=>'Success']);
		}else{
			return response()->json(['status'=>false,'message'=>'Something went wrong!!!, Please try again']);
		}
	}
	
	public function logoutUser(Request $request){
		if(Auth::check()){
			Auth::logout();
			return redirect('/');
		}
	}
	
	public function submitSupportEnquiry(Request $request){
		$data['support_type']=$request->bug_type;
		$data['name']=$request->name;
		$data['email_address']=$request->email_address;
		$data['comments']=$request->comments;
		
		$saveEnquiry=\App\SupportEnquiry::create($data);
		if($saveEnquiry)
			return response()->json(['status'=>true,'message'=>'Thank you for contact us.']);
		else
			return response()->json(['status'=>false,'message'=>'Something went wrong!!!, Please try again.']);
	}
	
	public function submitStoreEnquiry(Request $request){

		$data['email_address']=$request->email_address;
		$data['purchase_date']=date('Y-m-d',strtotime(str_replace('/','-',$request->purchase_date)));
		$data['store_id']=$request->store_id;
		
		$saveEnquiry=\App\StoreEnquiry::create($data);
		if($saveEnquiry)
			return redirect()->back()->with('store_success','Thank you for contact us.');
		else
			return redirect()->back()->with('store_error','Something went wrong!!!, Please try again.');
	}
	
	public function forgotPassword(Request $request){
		Validator::make($request->all(), [			
			'email' => 'required|email',
		])->validate();
		
		$email=$request->email;
		
		$user=\App\User::where('email','=',$email)->first();
		if($user){
			$token = md5($email . microtime(true));
			$updateToken=\App\User::where('id',$user->id)->update(['password'=>$token]);
			$url_with_token = url('/').'/reset-password/' . $token;
			
			$message='Hello '.$user->name.'<br/><br/>';
			$message.='Your passwrod have reset.<br/><br/>';
			$message.='To complete the process please go through following link.<br/><br/>';
			$message.='Please click <a href="'.$url_with_token.'"><strong>here</strong></a> to set your new password.<br/><br/><br/>';
			$message.='Thank you<br/>';
			$message.='Charitism<br/>';
			
			$subject='Charitism - Reset Password';
			$data2=['email'=>$email,'subject'=>$subject,'message'=>$message];
			
			Mail::send([], [], function($message) use ($data2) {
				$message->from('info@charitism.com','Charitism');
				$message->to($data2['email']);
				$message->subject($data2['subject']);
				$message->setBody('<html>'.$data2['message'].'</html>','text/html');
			});
			
			return redirect()->back()->with('fp_success','Please check your inbox and reset your password.');
			
		}else{
			return redirect()->back()->with('fp_error','Email address does not exists in our system.');
		}
	}
	
	public function resetPassword($token){
		$user=\App\User::where('password',$token)->first();
		return view('pages.reset-password',compact('user','token'));
	}
	
	public function updateNewPassword(Request $request){
		
		Validator::make($request->all(), [			
			'token' => 'required',
			'password' => 'required',
			'confirm_password' => 'required|same:password',
		])->validate();
		
		$token=$request->token;
		$password=$request->password;
		$confirm_password=$request->confirm_password;
		
		$user=\App\User::where('password',$token)->first();
		if($user){
			$updateNewPassword=\App\User::where('id',$user->id)->update(['password'=>bcrypt($password)]);
			if($updateNewPassword){
				Auth::attempt(['email'=>$user->email,'password'=>$password]);
				return redirect('dashboard');
			}else{
				return redirect()->back()->with('error','Password not reset, Please try again.');
			}
			
		}else{
			return redirect()->back()->with('error','Token invalid.');
		}
	}
	
	public function loginUser(Request $request){
		Validator::make($request->all(), [			
			'email' => 'required',
			'password' => 'required',
		])->validate();
		
		$user=\App\User::with(['UserRole.Role'])->where('email',$request->email)->first();
		
		if(empty($user)){
			return redirect()->back()->with('login_error','Your credentails does not exists.');
		}else if(!empty($user)){
			$hasRoles=\App\UserRole::where('user_id',$user->id)->get()->count();
			$checkPassword = Hash::check($request->password,$user->password);
			if($checkPassword==true && $user->status==0){
				return redirect()->back()->with('login_error','Your account is suspended, Please contact to admin.');
			}else if($checkPassword==true && $user->trash==1){
				return redirect()->back()->with('login_error','Your credentails does not exists.');
			}else if($checkPassword==true && $user->status==0 && $hasRoles>0){
				return redirect()->back()->with('login_error','Your account is suspended, Please contact to admin.');
			}else if($checkPassword==true && $user->status==1 && $user->trash==0 && $hasRoles>0){
				if(isset($request->remember)){
					$remember=true;
				}else{
					$remember=false;
				}
				
				Auth::attempt(['email'=>$request->email,'password'=>$request->password],$remember);
				if(getUserRole($user->id)==1){
					return redirect()->route('dashboard.index');
				}else{
					return redirect()->back();
				}	
			}else{
				return redirect()->back()->with('login_error','Your credentails does not exists.');
			}
		}
	}
	
	public function selectCauseOnSocialRegister(Request $request){
		$user_id=$request->user_id;
		$cause_id=$request->cause_id;
		
		$selectCause=\App\User::where('id',$user_id)->update(['cause_id'=>$cause_id]);
		if($selectCause){
			$user=\App\User::where('id',$user_id)->first();
			//$authUser=array('email'=>$us)
			
			Mail::to($user->email)->send(new SendSignUpMail($user));
			Auth::login($user, true);
			return response()->json(['status'=>true]);
		}else{
			return response()->json(['status'=>false,'message'=>'Something went wrong!!!, Please try again.']);
		}
	}
}