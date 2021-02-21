<?php 
function getUserDetails($user_id){
	$user=\App\User::with('UserRole.Role')->where('id',$user_id)->first();
	return $user;
}
function getDomain($url){
    $pieces = parse_url($url);
    $domain = isset($pieces['host']) ? $pieces['host'] : '';
    if(preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)){
        return $regs['domain'];
    }
    return FALSE;
}
function createSlug($text){
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicated - symbols
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
      return 'n-a';
    }

    return $text;
}

function getStoreCategoryNameByStoreId($store_id){
	$store=\App\Stores::with('StoreCategory')->where('id',$store_id)->first();
	if($store){
		if(!empty($store->StoreCategory)){
			return $store->StoreCategory->name;
		}else{
			return 'N.A.';
		}
	}else{
		return 'N.A.';
	}
}

function getSiteSettings($key){
	$siteSettings=\App\SiteSettings::where('_key',$key)->first();
	return $siteSettings;
}

function getUserRole($user_id)
{
	$roles=\App\UserRole::where('user_id',$user_id)->first();
	if(!empty($roles))
		$role_id=$roles->role_id;
	else
		$role_id=0;
	
	return $role_id;
}

function getBlogsForFooter(){
	$blogs=\App\Blogs::where('status',1)->where('trash',0)->orderBy('id','DESC')->limit(1)->get();
	
	return $blogs;
}

function removeInlineStyleFromContent($content){
		
	$content=preg_replace('/style=\\"[^\\"]*\\"/', '', $content);
	return $content;
}

function getStoreNameByID($id){
	$store=\App\Stores::find($id);
	if($store){
		return $store->name;
	}else{
		return '';
	}
}

function getStoresByStoreCategoryID($store_cat_id){
	$stores=\App\Stores::where('store_cat_id',$store_cat_id)->where('status',1)->where('trash',0)->orderBy('id','ASC')->get();
	
	return $stores;
}

function getImpactProductsByStoreCategoryID($store_cat_id){
	$products=\App\ImpactProducts::where('store_cat_id',$store_cat_id)->where('status',1)->where('trash',0)->orderBy('id','DESC')->get();
	
	return $products;
}

function getStorIDBySlug($slug){
	$store=\App\Stores::where('slug','=',$slug)->where('status',1)->where('trash',0)->first();
	if($store){
		return $store->id;
	}else{
		return '';
	}
}

function getTwoDatesDifferenceInDays($date1,$date2=null){
	if($date2==null)
		$date2=date('Y-m-d');
	
	/* echo $date1.'</br>';
	echo $date2.'</br>';
	$date11 = strtotime($date2);  
	$date21 = strtotime($date1);

	
	$diff = abs($date21 - $date11); 
	echo $diff.'</br>';
	$years = floor($diff / (365*60*60*24)); 
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
	$days = floor(($diff - $years * 365*60*60*24 -  
	$months*30*60*60*24)/ (60*60*24)); 	
	echo $years.'</br>';
	echo $months.'</br>';
	echo $days.'</br>';
	die; */
	
	$diff = strtotime($date1) - strtotime($date2);
	$days =abs(round($diff / 86400));
	return $days;
}

function getRunningCampaignsByCauseCategoryID($cause_cat_id){
	$campaigns=\App\Charity::with(['CauseCategory','Campaigner'])->where('cause_cat_id',$cause_cat_id)->where('status',1)->where('trash',0)->where('is_completed',0)->whereDate('end_date','>=',date('Y-m-d'))->orderBy('name','ASC')->get();
	
	return $campaigns;
}

function getCompletedCampaignsByCauseCategoryID($cause_cat_id){
	//$campaigns=\App\Charity::with(['CauseCategory','Campaigner'])->where('cause_cat_id',$cause_cat_id)->where('status',1)->where('trash',0)->whereDate('end_date','<',date('Y-m-d'))->orWhere('is_completed',1)->orderBy('name','ASC')->get();
	$campaigns=\App\Charity::with(['CauseCategory','Campaigner'])->where('cause_cat_id',$cause_cat_id)->where('status',1)->where('trash',0)->where('is_completed',1)->orderBy('name','ASC')->get();
	
	return $campaigns;
}

function getCampaignIDBySlug($slug){
	$campaign=\App\Charity::where('slug','=',$slug)->first();
	if($campaign){
		return $campaign->id;
	}else{
		return '';
	}
}

function getImpactProductIDBySlug($slug){
	$product=\App\ImpactProducts::where('slug','=',$slug)->first();
	if($product){
		return $product->id;
	}else{
		return '';
	}
}

function getAllStores(){
	$stores=\App\Stores::where('status',1)->where('trash',0)->orderBy('name','ASC')->get();
	
	$arr=array();
	if(!empty($stores)){
		foreach ($stores as $key=>$store){
			if($store->name!=''){
				$arr[$key]['value']=$store->name;
				$arr[$key]['label']=$store->slug;
			}
		}
	}
	
	return $arr;
}

function getCauseCategoryNameByID($id){
	$cat=\App\CauseCategory::find($id);
	if($cat){
		return $cat->name;
	}else{
		return '';
	}
}

function checkUserAddedStoreInFavourite($user_id,$store_id){
	$favourite=\App\UserFavouriteStores::where('user_id',$user_id)->where('store_id',$store_id)->get()->count();
	
	if($favourite)
		return $favourite;
	else
		return 0;
}

function checkUserAddedImpactProductInFavourite($user_id,$product_id){
	$favourite=\App\UserFavouriteImpactProducts::where('user_id',$user_id)->where('impact_product_id',$product_id)->get()->count();
	
	if($favourite)
		return $favourite;
	else
		return 0;
}

function getCauseCategoryDetailsByID($id){
	$cat=\App\CauseCategory::find($id);
	if($cat)
		return $cat;
	else
		return array();
}

function getStoreCategoryNameByID($id){
	$cat=\App\StoreCategory::find($id);
	if($cat){
		return $cat->name;
	}else{
		return '';
	}
}

function getUserCauseRunningCampaignByCauseCategoryID($cause_cat_id){
	$campaign=\App\Charity::where('cause_cat_id',$cause_cat_id)->where('status',1)->where('trash',0)->where('is_completed',0)->first();
	
	return $campaign;
}

function getStoreCategoryIconPathByCategoryID($id){
	$cat=\App\StoreCategory::find($id);
	if($cat){
		if(!empty($cat->icon)){
			return url('/').'/'.$cat->icon;
		}else{
			return url('/public/front/images/icon/all.png');
		}
	}else{
		return url('/public/front/images/icon/all.png');
	}
}

function getCauseCategoryIconPathByCategoryID($id){
	$cat=\App\CauseCategory::find($id);
	if($cat){
		if(!empty($cat->icon)){
			return url('/').'/'.$cat->icon;
		}else{
			return url('/public/front/images/icon/all.png');
		}
	}else{
		return url('/public/front/images/icon/all.png');
	}
}

function getUserFavouriteStoresCount($user_id){
	$favStores=\App\UserFavouriteStores::where('user_id',$user_id)->get()->count();
	if($favStores)
		return $favStores;
	else
		return 0;
}

function getMonthlyReports(){
	$reports=\App\MonthlyReports::where('status',1)->where('trash',0)->orderBy('id','DESC')->limit(2)->get();
	return $reports;
}

function checkCampaignsCompleted(){
	//$campaigns=\App\Charity::where('end_date','<=',date('Y-m-d'))->orWhere('is_completed','=',1)->where('status',1)->where('trash',0)->get()->count();
	$campaigns=\App\Charity::where('is_completed','=',1)->where('status',1)->where('trash',0)->get()->count();
	if($campaigns)
		return $campaigns;
	else
		return 0;
}

function getIPAddress(){
	
	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
	
    return $ip;
}

function getImpactProductViewCount($impact_product_id){
	
	$viewCount=\App\ImpactProductViews::where('impact_product_id',$impact_product_id)->sum('view_count');
	if($viewCount)
		return $viewCount;
	else
		return 0;
}

function addImpactProductViewCount($impact_product_id){
	$ipAddress=getIPAddress();
	$checkIPViewCount=\App\ImpactProductViews::where('impact_product_id',$impact_product_id)->where('ip_address',$ipAddress)->first();
	if(empty($checkIPViewCount)){
		\App\ImpactProductViews::create(['impact_product_id'=>$impact_product_id,'ip_address'=>$ipAddress,'view_count'=>1]);
		return true;
	}
}

function getUserTotalDonationCount($user_id){
	$donation=\App\UserDonations::where('user_id',$user_id)->get()->count();
	if($donation)
		return $donation;
	else
		return 0;
}

function getUserTotalRaisedDonationAmount($user_id){
	$total=0;
	$donations=\App\UserDonations::where('user_id',$user_id)->get();
	if(!$donations->isEmpty()){
		foreach ($donations as $donation){
			$amount=$donation->amount;
			$tAmount=$donation->amount*0.6;
			
			$total+=$tAmount;
		}
	}
	
	return number_format($total,2);
	/* $donation=\App\UserDonations::where('user_id',$user_id)->sum('amount');
	if($donation)
		return $donation;
	else
		return 0; */
}

function getCampaignTotalSupporters($campaign_id){
	$campaign=\App\Charity::where('id',$campaign_id)->first();
	if($campaign){
		$cause_id=$campaign->cause_cat_id;
		$donation=\App\UserDonations::where('cause_id',$cause_id)->get()->count();
		if($donation)
			return $donation;
		else
			return 0;
	}else{
		return 0;
	}
}

function getCampaignTotalAmountRaised($campaign_id){
	$campaign=\App\Charity::where('id',$campaign_id)->first();
	if($campaign){
		$cause_id=$campaign->cause_cat_id;
		$donation=\App\UserDonations::where('cause_id',$cause_id)->sum('amount');
		
		if($donation){
			$d=$donation*0.6;
			//return number_format($d,2);
			return $d;
		}else{
			return 0;
		} 
	}else{
		return 0;
	}
}

function getAllCauseCategories(){
	$causeCats=\App\CauseCategory::where('status',1)->where('trash',0)->orderBy('name','ASC')->get();
	return $causeCats;
}

function getCampaignDetailByCauseID($cause_cat_id=null){
	if($cause_cat_id==null){
		return array();
	}
	
	$campaign=\App\Charity::where('cause_cat_id',$cause_cat_id)->where('status',1)->where('trash',0)->where('is_completed',0)->first();
	return $campaign;
}

function getStoreDealsByStoreCategoryID($store_cat_id){
	$storeDeals=\App\StoreDealsAndSales::where('store_cat_id',$store_cat_id)->where('status',1)->where('trash',0)->orderBy('id','DESC')->get();
	
	return $storeDeals;
}

function getAllFaqs(){
	$faqs=\App\Faq::where('status',1)->where('trash',0)->get();
	return $faqs;
}

function getHomePageContentByType($type){
	$content=\App\HomePage::where('type','=',$type)->first();
	return $content;
}