<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class CampaignController extends Controller
{
    public function getAllCampaigns($causecat=null){
		$causeCats=\App\CauseCategory::where('status',1)->where('trash',0)->orderBy('id','ASC')->get();
		$campaigns=\App\Charity::with(['CauseCategory','Campaigner'])->where('status',1)->where('trash',0)->where('is_completed',0)->whereDate('end_date','>=',date('Y-m-d'))->orderBy('id','DESC')->get();
		
		$causeCatId='';
		/* if($causecat!=''){
			$cause=\App\CauseCategory::where('slug',$causecat)->first();
			$causeCatId=$cause->id;
		} */
		//$completedCampaigns=\App\Charity::with(['CauseCategory','Campaigner'])->where('status',1)->where('trash',0)->whereDate('end_date','<',date('Y-m-d'))->orWhere('is_completed',1)->orderBy('id','DESC')->get();
		$completedCampaigns=\App\Charity::with(['CauseCategory','Campaigner'])->where('status',1)->where('trash',0)->where('is_completed',1)->orderBy('id','DESC')->get();
		
		
		return view('pages.campaigns',compact('causeCats','campaigns','completedCampaigns','causeCatId'));
	}
	
	public function getCampaignDetail($slug){
		$campaignID=getCampaignIDBySlug($slug);
		if($campaignID!=''){
			$campaign=\App\Charity::with(['CauseCategory','Campaigner','Beneficiary'])->where('id',$campaignID)->first();
			
			$featuredImpactProduct=\App\ImpactProducts::where('status',1)->where('trash',0)->where('is_featured',1)->first();
			$stores=\App\Stores::where('status',1)->where('trash',0)->orderBy('name','ASC')->get();
			$user_id='';
			if(Auth::check()){
				$user_id=Auth::id();
			}
			$favStore=\App\UserFavouriteStores::with('stores')->where('user_id',$user_id)->whereHas('stores',function($query) {
					$query->where('status', '1');
			})->whereHas('stores',function($query) {
					$query->where('trash', '0');
			})->orderBy('id','DESC')->first();
			
			return view('pages.detail-pages.campaign-detail',compact('campaign','featuredImpactProduct','stores','favStore'));
		}else{
			return redirect()->back();
		}
	}
	
	public function getCampaignsByCauseCat($slug){
		$causeCats=\App\CauseCategory::where('status',1)->where('trash',0)->orderBy('id','ASC')->get();
		$campaigns=\App\Charity::with(['CauseCategory','Campaigner'])->where('status',1)->where('trash',0)->where('is_completed',0)->whereDate('end_date','>=',date('Y-m-d'))->orderBy('id','DESC')->get();
		
		$causeCatId='';
		if($slug!=''){
			$cause=\App\CauseCategory::where('slug',$slug)->where('status',1)->where('trash',0)->first();
			$causeCatId=$cause->id;
		}
		$completedCampaigns=\App\Charity::with(['CauseCategory','Campaigner'])->where('status',1)->where('trash',0)->where('is_completed',1)->whereDate('end_date','<',date('Y-m-d'))->orderBy('id','DESC')->get();
		
		
		return view('pages.campaigns',compact('causeCats','campaigns','completedCampaigns','causeCatId'));
	}
}
