<?php

function check_live($url)
{
		 $handles = curl_init($url);
		 curl_setopt($handles, CURLOPT_NOBODY, true);
		 curl_exec($handles);
		 $result = curl_getinfo($handles, CURLINFO_HTTP_CODE);
		 return $result;
}

function filter_bdt($bdt)
{
	$bdt = trim($bdt);
	$bdt = str_replace(",","",$bdt);
	$arr = explode(".",$bdt);
	$bdt = $arr[0];
	
	return $bdt;
}

function make_bdt($bdt)
{ 
	//echo "bdt: " . strlen($bdt);
	if((strlen($bdt)>3) and (strlen($bdt)<6))
	 {
		 $bdt = strrev($bdt);
		 $bdt = substr($bdt,0,3) . "," . substr($bdt,3);
		 $new_bdt = strrev($bdt);
	 }
	else if((strlen($bdt)>5) and (strlen($bdt)<8))
	 {
		 $bdt = strrev($bdt);
		 $bdt = substr($bdt,0,3) . "," . substr($bdt,3,2) . "," . substr($bdt,5);
		 $new_bdt = strrev($bdt);
	 }
	else
	{
		$new_bdt = $bdt;
	}

	$new_bdt .= "/-";
	return $new_bdt;
}


function odesk_message($user_name)
{
	include("includes/config.php");
    
	
	$url   = 'https://www.odesk.com/api/mc/v1/trays/' . $user_name . '.json';
    
	/* 
	 OAuth it's a PHP oAuth extension
	 Location: I:\xampp\php\ext\php_oauth.dll
	 Download: http://pecl.php.net/package/oauth/1.2.3/windows
	 Php.Ini: extension=php_oauth.dll
	*/
    /*
    $oauth = new OAuth($api_key,$secret);
	$oauth->enableDebug();
    $oauth->setToken($_SESSION['saved_token_id'],$_SESSION['saved_oauth_secret']);
    $oauth->fetch($url);
    $json = json_decode($oauth->getLastResponse());
    */
	
	$api = new oDeskAPI($secret, $api_key);
	$api->option('amode','headers');
	$api->option('mode', 'nonweb'); 
	$api->option('api_token', $_SESSION['saved_token_id']); 
	$api->option('api_secret', $_SESSION['saved_oauth_secret']);
	$params = array();
	$response = $api->get_request($url, $params);
    $json = json_decode($response);
	
	$trays = $json->trays;

	$text = "";
	$i =1;
	$count = 0;
	
	foreach($trays as $key=>$value)
	{
		if($value->unread)
		{
		 $text .= "($i) " . $value->type . "<br />";
		 $i++;
		 if($value->type!='notifications') $count++;
		}
		//$message .= "Status: " . $value->unread . "<br /><br />";
	}
   if(!$text) $text = "No new messages.";
   
   $message['user'] = $user_name;
   $message['text'] = $text;
   $message['count'] = $count; 
    
	return $message;
}

function odesk_update($user_link)
{
	include("includes/config.php");

	$url   = 'https://www.odesk.com/api/profiles/v1/providers/' . $user_link . '/brief.json';
    /* 
	$oauth = new OAuth($api_key,$secret);
    $oauth->enableDebug();
    $oauth->setToken($_SESSION['saved_token_id'],$_SESSION['saved_oauth_secret']);
    $oauth->fetch($url);
    $json = json_decode($oauth->getLastResponse());
    */
	$api = new oDeskAPI($secret, $api_key);
	$api->option('amode','headers');
	$api->option('mode', 'nonweb'); 
	$api->option('api_token', $_SESSION['saved_token_id']); 
	$api->option('api_secret', $_SESSION['saved_oauth_secret']);
	$params = array();
	$response = $api->get_request($url, $params);
    $json = json_decode($response);
	
	$user_info['hours'] = floor((float)$json->profile->dev_total_hours+0.5);
	$user_info['scores'] = round((float)$json->profile->dev_adj_score,2);

	//print_r($user_info); exit();
    return $user_info;
}

?>