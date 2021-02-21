<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use URL;
use Session;
class SocialAuthController extends Controller
{
    public function redirect($service) {
		if(!empty(URL::previous())){
			Session::put('social_redirect_url',URL::previous());
		}
		
		if($service=='google'){
			return Socialite::driver ( $service )->with(['redirect'=>'https://www.charitism.com/callback/google','client_id'=>'358382154459-gsco4jllefe1ggj6lkb2ipccvbkj8gcj.apps.googleusercontent.com'])->redirect ();
		}else{
			return Socialite::driver ( $service )->with(['app_id'=>'1332843243533071'])->redirect ();
		}
    }
	
	public function callback($service) {
		
		if($service=='google'){
			$user = Socialite::driver('google')->stateless()->user();
		}else{
			$user = Socialite::driver($service)->user();
		}
		
		$authUser = $this->findOrCreateUser($user, $service);
		
		if(!empty($authUser)){ 
			
			$userDetails=\App\User::where('id',$authUser->id)->first();
			if($userDetails->cause_id==''){
				return view('pages.select-cause',compact('authUser'));
			}else{
				Auth::login($authUser, true);
				//return redirect('dashboard');
				//return redirect()->back();
				//Redirect::intended();
				if(!empty(Session::get('social_redirect_url'))){
					$redirect=Session::get('social_redirect_url');
					Session()->forget('social_redirect_url');
					return redirect($redirect);
				}else{
					return redirect('dashboard');
				}
				
			}
		}else{ 
			/* return redirect()->back()->with('login_error','Either your account is already configured or your account removed from admin.'); */
			
			return redirect('/')->with('login_error','Either your account is already configured or your account removed from admin.');
		}

    }
	
	public function findOrCreateUser($user, $service)
    {
		
		$authUser=\App\User::where('email',$user->email)->first();
		if($authUser){
			if(!empty($authUser->provider)){
				return $authUser;
			}else{
				if($authUser->status==1 && $authUser->trash==0){
					return $authUser;
				}else if($authUser->trash==1){ 
					return array();
				}else{
					return array();
				}
			}
		}else{
			$users= \App\User::create([
				'name'     => $user->name,
				'email'    => $user->email,
				'password'=>'',
				'provider' => $service,
				'provider_id' => $user->id,
				'profile_picture'=>$user->avatar,
				'status'=>1
			]);
			 
			$createRole=\App\UserRole::insert(['role_id'=>2,'user_id'=>$users->id]);
			$username=str_replace(' ','',$user->name).$users->id;
			\App\User::where('id',$users->id)->update(['username'=>$username]);
			return $users;
		}
         /* $authUser = \App\User::where('provider_id', $user->id)->first();
		
		$userDetails=\App\User::where('email',$user->email)->whereNull('provider_id')->first();
		
       if ($authUser) {
			if($authUser->status==1 && $authUser->trash==0){
				return $authUser;
			}else if($authUser->trash==0){ 
				return $authUser;
			}else{
				return array();
			}
        }else if(!empty($userDetails)){
			return array();
		}else{
			$userDetails=\App\User::where('email',$user->email)->whereNull('provider_id')->first();
			if(!empty($userDetails)){
				return array();
			}else{
				$users= \App\User::create([
					'name'     => $user->name,
					'email'    => $user->email,
					'password'=>'',
					'provider' => $service,
					'provider_id' => $user->id,
					'profile_picture'=>$user->avatar,
					'status'=>1
				]);
				 
				$createRole=\App\UserRole::insert(['role_id'=>2,'user_id'=>$users->id]);
				$username=str_replace(' ','',$user->name).$users->id;
				\App\User::where('id',$users->id)->update(['username'=>$username]);
				return $users;
			}
		} */
    }
}
