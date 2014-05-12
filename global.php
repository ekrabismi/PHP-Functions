<?php

function make_pages($total_data,$page_limit,$extra_params)
{
  $total_page = ceil($total_data/$page_limit);
  
  $html="";
  $low_limit=0;
  $high_limit=0;
  
  if(isset($_GET['p']))
   $curr = $_GET['p'];
  else
   $curr = 1;
  
  $html = "Pages ($curr/$total_page): ";
  $html .= "<select onchange=\"show_page(this.value)\" >"; 
  
  for($i=1;$i<=$total_page;$i++)
  {
	  if(!$high_limit)
	  {
	   $low_limit=$i-1;
	   }
	  else
	  {
		  $low_limit=$high_limit+1;
	  }
	  
	  $high_limit=$low_limit+$page_limit-1;
	  
	  if($high_limit>=$total_data) $high_limit=$total_data-1;
      
	  if($curr==$i)
	   $html .= "<option selected='selected' value=\"?l=$low_limit&h=$page_limit&p=$i&$extra_params\">$i</option>"; 
	 else
	   $html .= "<option value=\"?l=$low_limit&h=$page_limit&p=$i&$extra_params\">$i</option>"; 
	  
  }
    $html .= "</select>";
	
 return $html;
}

function get_request_uri()
{
	$url = $_SERVER['REQUEST_URI'];
	$url = substr($url, strpos($url,"?"));
	return $url;
}

function get_str($str,$start,$end)
{
	$length = strrev($str);
	$end = strrev($end);
	$length = strlen($str)-strpos($length,$end)-strlen($end)-strpos($str,$start)-strlen($start);
	
	$str = substr($str, strpos($str,$start)+strlen($start), $length);
	return $str;
}

function filter_url($url)
{
	$url = trim($url);
	$url = str_replace("http://","",$url);
	$url = str_replace("https://","",$url);
	
	$arr = explode("/",$url); //getting first part
	$url = $arr[0];
	
	$url = str_replace("/","",$url); //replacing extra /
	
	$arr = explode(".",$url); //adding www
	if(count($arr)<3)
	 $url = "www.".$url; 
	 
	return $url;
}

function make_time($time)
{
	$arr = explode(".",$time);
	
	if(!empty($arr[1])) 
	 {
	  $part = $arr[1];
 	  $time = $arr[0];

	
	  if($time>=0) $ion="v+"; else $ion="v-";
	  
	  if($time>23) $time-=24; 
	  if($time<0) $time+=24;
	
	  if($ion=="v+" and $part==5)
	  {
		  switch($time)
		{
			case '0': return '12:30 am'; 
			case '1': return '1:30 am'; 
			case '2': return '2:30 am'; 
			case '3': return '3:30 am'; 
			case '4': return '4:30 am'; 
			case '5': return '5:30 am'; 
			case '6': return '6:30 am'; 
			case '7': return '7:30 am'; 
			case '8': return '8:30 am'; 
			case '9': return '9:30 am'; 
			case '10': return '10:30 am'; 
			case '11': return '11:30 am'; 
			case '12': return '12:30 pm';
			case '13': return '1:30 pm';
			case '14': return '2:30 pm';
			case '15': return '3:30 pm';
			case '16': return '4:30 pm';
			case '17': return '5:30 pm';
			case '18': return '6:30 pm';
			case '19': return '7:30 pm';
			case '20': return '8:30 pm';
			case '21': return '9:30 pm';
			case '22': return '10:30 pm';
			case '23': return '11:30 pm'; 
			
		}
	  }
	  else if($ion=="v+" and $part==75)
	  {
		  switch($time)
		{
			case '0': return '12:45 am'; 
			case '1': return '1:45 am'; 
			case '2': return '2:45 am'; 
			case '3': return '3:45 am'; 
			case '4': return '4:45 am'; 
			case '5': return '5:45 am'; 
			case '6': return '6:45 am'; 
			case '7': return '7:45 am'; 
			case '8': return '8:45 am'; 
			case '9': return '9:45 am'; 
			case '10': return '10:45 am'; 
			case '11': return '11:45 am'; 
			case '12': return '12:45 pm';
			case '13': return '1:45 pm';
			case '14': return '2:45 pm';
			case '15': return '3:45 pm';
			case '16': return '4:45 pm';
			case '17': return '5:45 pm';
			case '18': return '6:45 pm';
			case '19': return '7:45 pm';
			case '20': return '8:45 pm';
			case '21': return '9:45 pm';
			case '22': return '10:45 pm';
			case '23': return '11:45 pm'; 
			
		}
	  }
	  else if ($ion=="v-" and $part==5)
	  {
		switch($time)
		{
			case '0': return '11:30 pm'; 
			case '1': return '12:30 am'; 
			case '2': return '1:30 am'; 
			case '3': return '2:30 am'; 
			case '4': return '3:30 am'; 
			case '5': return '4:30 am'; 
			case '6': return '5:30 am'; 
			case '7': return '6:30 am'; 
			case '8': return '7:30 am'; 
			case '9': return '8:30 am'; 
			case '10': return '9:30 am'; 
			case '11': return '10:30 am'; 
			case '12': return '11:30 am';
			case '13': return '12:30 pm';
			case '14': return '1:30 pm';
			case '15': return '2:30 pm';
			case '16': return '3:30 pm';
			case '17': return '4:30 pm';
			case '18': return '5:30 pm';
			case '19': return '6:30 pm';
			case '20': return '7:30 pm';
			case '21': return '8:30 pm';
			case '22': return '9:30 pm';
			case '23': return '10:30 pm'; 
			
		}
	  }
	 }
	 
	else
	{
		if($time>23) $time-=24; 
	    if($time<0) $time+=24;
	
		switch($time)
		{
			case '0': return '12:00 am'; 
			case '1': return '1:00 am'; 
			case '2': return '2:00 am'; 
			case '3': return '3:00 am'; 
			case '4': return '4:00 am'; 
			case '5': return '5:00 am'; 
			case '6': return '6:00 am'; 
			case '7': return '7:00 am'; 
			case '8': return '8:00 am'; 
			case '9': return '9:00 am'; 
			case '10': return '10:00 am'; 
			case '11': return '11:00 am'; 
			case '12': return '12:00 pm';
			case '13': return '1:00 pm';
			case '14': return '2:00 pm';
			case '15': return '3:00 pm';
			case '16': return '4:00 pm';
			case '17': return '5:00 pm';
			case '18': return '6:00 pm';
			case '19': return '7:00 pm';
			case '20': return '8:00 pm';
			case '21': return '9:00 pm';
			case '22': return '10:00 pm';
			case '23': return '11:00 pm'; 
			
		}
	}
}

function mydir($dirpath)
{
	if ($handle = opendir($dirpath)) {

		/* This is the correct way to loop over the directory. */
		while (false !== ($entry = readdir($handle))) {
			//echo "$entry\n";
			$ext = substr($entry,strlen($entry)-3,3);
			//echo $ext;
			 if ($entry != '..' && $entry != '.' && $entry != 'done' && $ext!="lnk")
			  {
			    $dirname[] = $entry;
			  }
		}

		closedir($handle);
	}
	if(!empty($dirname)) return $dirname;
}



?>