<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;


class StoreController extends Controller
{
    public function getAllStores($storecat=null){
		$stores=\App\Stores::with('StoreCategory')->where('status',1)->where('trash',0)->orderBy('id','ASC')->get();
		
		/* $cats=\App\StoreCategory::with(['stores','ImpactProducts'])->where('status',1)->where('trash',0)->orderBy('name','ASC')->get(); */
		
		$cats=\App\StoreCategory::where('status',1)->where('trash',0)->orderBy('id','ASC')->get();
		
		$impactProducts=\App\ImpactProducts::with(['Stores','StoreCategory'])->where('status',1)->where('trash',0)->orderBy('id','DESC')->get();
		
		$user_id='';
		if(Auth::check()){
			$user_id=Auth::id();
		}
		
		$favouriteStores=\App\UserFavouriteStores::with('stores')->where('user_id',$user_id)->whereHas('stores',function($query) {
				$query->where('status', '1');
		})->whereHas('stores',function($query) {
				$query->where('trash', '0');
		})->orderBy('id','DESC')->get();
		
		$favouriteImpactProducts=\App\UserFavouriteImpactProducts::with('ImpactProducts')->where('user_id',$user_id)->whereHas('ImpactProducts',function($query) {
				$query->where('status', '1');
		})->whereHas('ImpactProducts',function($query) {
				$query->where('trash', '0');
		})->orderBy('id','DESC')->get();
		
		$storeDeals=\App\StoreDealsAndSales::where('status',1)->where('trash',0)->orderBy('id','DESC')->get();
		
		$storeCatId='';
		/* if($storecat!=''){
			$storeCat=\App\StoreCategory::where('slug',$storecat)->first();
			if($storeCat){
				$storeCatId=$storeCat->id;
			}
		} */
		
		return view('pages.stores',compact('stores','cats','impactProducts','favouriteStores','favouriteImpactProducts','storeCatId','storeDeals'));
	}
	
	public function getStoreDetail(Request $request, $slug){
		$storeID=getStorIDBySlug($slug);
		if(!empty($storeID)){
			
			$store=\App\Stores::with(['StoreCategory','donations','impactproducts'])->where('trash',0)->where('id',$storeID)->first();
			
			$storeDonations=\App\DonationRates::where('store_id',$storeID)->paginate(9);
			
			$storeImpactProducts=\App\ImpactProducts::with(['Stores','StoreCategory'])->where('store_id',$storeID)->where('status',1)->where('trash',0)->orderBy('id','DESC')->paginate(2);
			
			$allStoreImpactProductCount=\App\ImpactProducts::with(['Stores','StoreCategory'])->where('store_id',$storeID)->where('status',1)->where('trash',0)->orderBy('name','ASC')->get()->count();
			
			$storeDeals=\App\StoreDealsAndSales::where('store_id',$storeID)->where('status',1)->where('trash',0)->orderBy('id','DESC')->get();
			
			if ($request->ajax()) {
				if($request->type=='donation'){
					if(!$storeDonations->isEmpty()){
						$html='';
						foreach ($storeDonations as $storeDonation){
							$html.='<div class="rates-list"><div class="left">'.$storeDonation->donation_rate.'</div><div class="right">'.$storeDonation->title.'</div></div>';
						}
						return response()->json(['html'=>$html,'next_page_url'=>$storeDonations->nextPageUrl()]);	
					}
				}
				
				if($request->type=='products'){
					if(!$storeImpactProducts->isEmpty()){
						$html1='';
						foreach ($storeImpactProducts as $storeImpactProduct){
							$html1.='<div class="store-box bg-white bx-shadow"><div class="img">';
							if(!empty($storeImpactProduct->logo)){
								$html1.='<img src="'.url('/').'/'.$storeImpactProduct->logo.'" class="width100">';
							}else{
								$html1.='<img src="'.asset('public/front/images/box-img.jpg').'" class="width100">';
							}
		
							$html1.='</div><div class="content"><div class="titl"><h3>'.$storeImpactProduct->name.'</h3></div><ul><li><span class="d-flex align-items-center">Price :<img src="'.asset('public/front/images/icon/purple-repee.png').'" alt="" width="8px;" class="icon-rupees"/> '.$storeImpactProduct->price.'</span></li><li>Donation : '.$storeImpactProduct->impact.'/sale</li></ul><div class="vedio-box mb-20">';
							if(!empty($storeImpactProduct->image)){
							   $html1.='<div class="vedio-bg" style="background-image:url('.url('/').'/'.$storeImpactProduct->image.')"></div>';
							}else{
								$html1.='<div class="vedio-bg" style="background-image:url('.asset('public/front/images/75023.jpg').')"></div>';
							}
			
							if(!empty($storeImpactProduct->video_url)){
							   $html1.='<div class="video-btn">
								  <a href="#" class="button">
								  <i class="far fa-play-circle"></i>watch video</a>
							   </div>';
							}
							$html1.='</div><div class="rngs mb-15"><div class="rngs-list"><i class="icons"><img src="'.getStoreCategoryIconPathByCategoryID($storeImpactProduct->store_cat_id).'" alt=""/></i><span class="text">'.$storeImpactProduct->StoreCategory->name.' </span></div><div class="rngs-list"><i class="icons"><img src="'.asset('public/front/images/icon/stores.png').'" alt=""/></i><span class="text">'.$storeImpactProduct->Stores->name.'</span></div>';
							if($storeImpactProduct->is_verified==1){
							   $html1.='<div class="rngs-list green">
								  <span class="icon"></span>
								  <span class="text">
								  Verified
								  </span>
							   </div>';
							}
							$html1.='</div>
							<div class="text">';
							$description=removeInlineStyleFromContent($storeImpactProduct->description);
							$html1.='<div>'.str_limit($description,200).'</div>
							</div>
							<div class="btn-row">';
							if(Auth::check()){
							   $html1.='<a href="'.$storeImpactProduct->shop_link.'" class="button">Buy Now</a>';
							}
							
							$html1.='<a href="'.url('impact-products',$storeImpactProduct->slug).'" class="button secondary">Read Review</a>
							</div>
						 </div>
						</div>';
						}
						return response()->json(['html'=>$html1,'next_page_url'=>$storeImpactProducts->nextPageUrl()]);	
					}
				}
			}

			$similarStores=\App\Stores::with('StoreCategory')->where('id','!=',$storeID)->where('store_cat_id',$store->store_cat_id)->where('status',1)->where('trash',0)->orderBy('id','ASC')->get();
			
			return view('pages.detail-pages.store-detail',compact('store','storeDonations','storeImpactProducts','similarStores','storeDeals','allStoreImpactProductCount'));
		}else{
			return redirect()->back();
		}
	}
	
	public function getImpactProductDetail($slug){
		$productID=getImpactProductIDBySlug($slug);
		if($productID!=''){
			$product=\App\ImpactProducts::with(['Stores','StoreCategory'])->where('id',$productID)->first();
			$productReviews=\App\ImpactProductReviews::with(['StoreCategory'])->where('impact_product_id',$productID)->where('status',1)->where('trash',0)->get();
			$productPros=\App\ImpactProductProsAndCons::where('impact_product_id',$productID)->where('type','pros')->where('status',1)->where('trash',0)->get();
			$productCons=\App\ImpactProductProsAndCons::where('impact_product_id',$productID)->where('type','cons')->where('status',1)->where('trash',0)->get();
			
			$similarProducts=\App\ImpactProducts::where('status',1)->where('trash',0)->where('id','!=',$productID)->where('store_cat_id',$product->store_cat_id)->orderBy('name','ASC')->get();
			
			return view('pages.detail-pages.impact-product-detail',compact('product','productReviews','productPros','similarProducts','productCons'));
		}else{
			return redirect()->back();
		}
	}
	
	public function getStoresByStoreCat($slug){
		
		$stores=\App\Stores::with('StoreCategory')->where('status',1)->where('trash',0)->orderBy('id','ASC')->get();
		
		/* $cats=\App\StoreCategory::with(['stores','ImpactProducts'])->where('status',1)->where('trash',0)->orderBy('name','ASC')->get(); */
		
		$cats=\App\StoreCategory::where('status',1)->where('trash',0)->orderBy('id','ASC')->get();
		
		$impactProducts=\App\ImpactProducts::with(['Stores','StoreCategory'])->where('status',1)->where('trash',0)->orderBy('id','DESC')->get();
		
		$user_id='';
		if(Auth::check()){
			$user_id=Auth::id();
		}
		
		$favouriteStores=\App\UserFavouriteStores::with('stores')->where('user_id',$user_id)->whereHas('stores',function($query) {
				$query->where('status', '1');
		})->whereHas('stores',function($query) {
				$query->where('trash', '0');
		})->orderBy('id','ASC')->get();
		
		$favouriteImpactProducts=\App\UserFavouriteImpactProducts::with('ImpactProducts')->where('user_id',$user_id)->whereHas('ImpactProducts',function($query) {
				$query->where('status', '1');
		})->whereHas('ImpactProducts',function($query) {
				$query->where('trash', '0');
		})->orderBy('id','ASC')->get();
		
		
		$storeCatId='';
		if($slug!=''){
			$storeCat=\App\StoreCategory::where('slug',$slug)->where('status',1)->where('trash',0)->first();
			
			if($storeCat){
				$storeCatId=$storeCat->id;
			}
		} 
		$storeDeals=\App\StoreDealsAndSales::where('status',1)->where('trash',0)->orderBy('id','DESC')->get();
		return view('pages.stores',compact('stores','cats','impactProducts','favouriteStores','favouriteImpactProducts','storeCatId','storeDeals'));
	}
	
	public function getStoreAllDeals(){
		$stores=\App\Stores::with('StoreCategory')->where('status',1)->where('trash',0)->orderBy('id','ASC')->get();
		
		$cats=\App\StoreCategory::where('status',1)->where('trash',0)->orderBy('id','ASC')->get();
		
		$impactProducts=\App\ImpactProducts::with(['Stores','StoreCategory'])->where('status',1)->where('trash',0)->orderBy('id','DESC')->get();
		
		$user_id='';
		if(Auth::check()){
			$user_id=Auth::id();
		}
		
		$favouriteStores=\App\UserFavouriteStores::with('stores')->where('user_id',$user_id)->whereHas('stores',function($query) {
				$query->where('status', '1');
		})->whereHas('stores',function($query) {
				$query->where('trash', '0');
		})->orderBy('id','DESC')->get();
		
		$favouriteImpactProducts=\App\UserFavouriteImpactProducts::with('ImpactProducts')->where('user_id',$user_id)->whereHas('ImpactProducts',function($query) {
				$query->where('status', '1');
		})->whereHas('ImpactProducts',function($query) {
				$query->where('trash', '0');
		})->orderBy('id','DESC')->get();
		
		$storeDeals=\App\StoreDealsAndSales::where('status',1)->where('trash',0)->orderBy('id','DESC')->get();
		
		$storeCatId='';
		return view('pages.store-deals',compact('stores','cats','impactProducts','favouriteStores','favouriteImpactProducts','storeCatId','storeDeals'));
	}
}
