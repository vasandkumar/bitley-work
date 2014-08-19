<?php 

class bitly_plugin {
	var $username = 'leadingtowin';
		var $api_key = 'R_20b7ecb64a0490594de13f3ea08ba69b';

	function __construct() {
		$username = 'leadingtowin';
		$api_key = 'R_20b7ecb64a0490594de13f3ea08ba69b';
	}
	
		function shorten($url, $service='bit.ly', $qr=false)	{
	
			$url = "http://api.$service/v3/shorten?login=$this->username&apiKey=$this->api_key&longUrl=".urlencode($url)."&format=json";
	
			if (function_exists('curl_init')) {
				$ch = curl_init();
				curl_setopt($ch,CURLOPT_URL,$url);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10);
				$response = curl_exec($ch);
				curl_close($ch);
			} else {
				$response = file_get_contents($url);
			}
	
			$short = json_decode($response,true);
			$status = $short['status_txt'];
			$status_code = $short['status_code'];
	
			if($status == 'OK') {
	
				$short = $short['data']['url'];
	
				if ($qr==false) {
					return $short;
				} else {
					return '<img src="'.$short.'.qrcode" alt="QR Code" />';
				}
	
			} else {
				return "Error $status_code ($status)";
			}
	
	} // End bitly_shorten()
	
	
	
	// Expand Short Url
		function expand($url) {
	
			$url = "http://api.bit.ly/v3/expand?login=$this->username&apiKey=$this->api_key&shortUrl=".$url."&format=json";
	
			if (function_exists('curl_init')) {
				$curl = curl_init();
				curl_setopt($curl,CURLOPT_URL,$url);
				curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,10);
				$response = curl_exec($curl);
				curl_close($curl);
			} else {
				$response = file_get_contents($url);
			}
	
			$long = json_decode($response,true);
			$status = $long['status_txt'];
			$status_code = $long['status_code'];
	
			if($status == 'OK') {
				return $long['data']['expand'][0]['long_url'];
			} else {
				return "Error $status_code ($status)";
			}
	
	} // End expand()
	
	
	// Expand Short Url
		function stats($url,$type='user')	{
	
			$url = "http://api.bit.ly/v3/clicks?login=$this->username&apiKey=$this->api_key&shortUrl=".urlencode($url)."&format=json";
	
			if (function_exists('curl_init')) {
				$curl = curl_init();
				curl_setopt($curl,CURLOPT_URL,$url);
				curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,10);
				$response = curl_exec($curl);
				curl_close($curl);
			} else {
				$response = file_get_contents($url);
			}
	
			$clicks = json_decode($response,true);
			$status = $clicks['status_txt'];
			$status_code = $clicks['status_code'];
	
			if($status == 'OK') {
	
				if ($type=='global') {
					return $clicks['data']['clicks'][0]['global_clicks'];
				} else if ($type=='both') {
					$stats['global'] = $clicks['data']['clicks'][0]['global_clicks'];
					$stats['user'] = $clicks['data']['clicks'][0]['user_clicks'];
					return $stats;
				} else {
					return $clicks['data']['clicks'][0]['user_clicks'];
				}
	
			} else {
				return "Error $status_code ($status)";
			}
	
	} // End bitly_stats()

}

$bitly = new bitly_plugin;