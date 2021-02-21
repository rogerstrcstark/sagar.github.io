<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\SendBuyLaterCardMail;

class CronController extends Controller
{
    public function sendBuyLaterEmail(){
		$enquiries=\App\StoreEnquiry::whereDate('purchase_date','=',date('Y-m-d'))->get();
		$flag=0;
		if(!$enquiries->isEmpty()){
			foreach ($enquiries as $enquiry){
				$store=\App\Stores::where('id',$enquiry->store_id)->where('status',1)->where('trash',0)->first();
				
				if($store){
					$flag=1;
					//Send Email
					
					$data['store_name']=$store->name;
					$data['store_slug']=$store->slug;
					Mail::to($enquiry->email_address)->send(new SendBuyLaterCardMail($data));
							
				}
			}
			
			if($flag==1){
				echo 'Mail sent';
			}else{
				echo 'Mail not sent';
			}
		}else{
			echo 'No more enquiries available.';
		}
	}
	
	public function endCampaignOnDate(){
		$campaigns=\App\Charity::whereDate('end_date','=',date('Y-m-d'))->where('is_completed',0)->get();
		
		$flag=0;
		if(!$campaigns->isEmpty()){
			foreach ($campaigns as $campaign){
				\App\Charity::where('id',$campaign->id)->update(['is_completed'=>1]);
				$flag=1;
			}
			
			if($flag==1){
				echo 'Campaign end';
			}else{
				echo 'Campaign not end';
			}
		}else{
			echo 'No more campaigns available.';
		}
	}
}
