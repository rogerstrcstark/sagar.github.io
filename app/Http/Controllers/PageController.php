<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function getAboutUsPageContent(){
		$content=\App\Pages::where('type','=','about-us')->first();
		return view('pages.about-us',compact('content'));
	}
	
	public function getHowItWorksPageContent(){
		return view('pages.how-it-works');
	}
	
	public function getAllBlogs(){
		$blogs=\App\Blogs::where('status',1)->where('trash',0)->orderBy('id','DESC')->get();
		return view('pages.blogs',compact('blogs'));
	}
	
	public function getBlogDetail($slug){
		$blog=\App\Blogs::where('slug',$slug)->first();
		return view('pages.detail-pages.blog-detail',compact('blog'));
	}
	
	public function getAllTeams(){
		$content=\App\Pages::where('type','=','our-team')->first();
		$teams=\App\OurTeam::where('status',1)->where('trash',0)->orderBy('id','ASC')->get();
		
		return view('pages.our-team',compact('content','teams'));
	}
	
	public function getTermsAndConditions(){
		$userContent=\App\Pages::where('type','=','user-terms-and-conditions')->first();
		$causeContent=\App\Pages::where('type','=','cause-terms-and-conditions')->first();
		
		return view('pages.terms-and-conditions',compact('userContent','causeContent'));
	}
	
	public function getPrivacyPolicyPageContent(){
		$content=\App\Pages::where('type','=','privacy-policy')->first();
		
		return view('pages.privacy-policy',compact('content'));
	}
	
	public function getCookiesPageContent(){
		$content=\App\Pages::where('type','=','cookies')->first();
		
		return view('pages.cookies',compact('content'));
	}
	
	public function getContactUsPageContent(){
		
		$content=\App\Pages::where('type','=','contact-us')->first();
		$contactEmails=\App\ContactEmails::where('status',1)->where('trash',0)->orderBy('id','DESC')->get();
		return view('pages.contact-us',compact('content','contactEmails'));
	}
	
	public function getAllReports(){
		$reports=\App\MonthlyReports::where('status',1)->where('trash',0)->orderBy('id','DESC')->get();
		
		return view('pages.reports',compact('reports'));
	}
	
	public function getStartCampaignContent(){
		$campaigns=\App\Charity::with(['CauseCategory','Campaigner'])->where('status',1)->where('trash',0)->where('is_completed',0)->whereDate('end_date','>=',date('Y-m-d'))->orderBy('id','DESC')->get();
		return view('pages.start-campaign',compact('campaigns'));
	}
	
	public function getShopThankYouPage($name=null){
		return view('pages.thank-you',compact('name'));
	}
}
