<?php
//v.6

$host = 'api.twitter.com';
$method = 'GET';
$path = '/1.1/lists/statuses.json'; // api call path

$query = array( // query parameters
    'owner_screen_name' => $owner,
    'slug' => $list,
    'count' => $cnt,
    'include_rts' => 'false'
);

$oauth = array(
    'oauth_consumer_key' => $consumer_key,
    'oauth_token' => $token,
    'oauth_nonce' => (string)mt_rand(), // a stronger nonce is recommended
    'oauth_timestamp' => time(),
    'oauth_signature_method' => 'HMAC-SHA1',
    'oauth_version' => '1.0'
);

$oauth = array_map("rawurlencode", $oauth); // must be encoded before sorting
$query = array_map("rawurlencode", $query);

$arr = array_merge($oauth, $query); // combine the values THEN sort

asort($arr); // secondary sort (value)
ksort($arr); // primary sort (key)

// http_build_query automatically encodes, but our parameters
// are already encoded, and must be by this point, so we undo
// the encoding step
$querystring = urldecode(http_build_query($arr, '', '&'));

$url = "https://$host$path";

// mash everything together for the text to hash
$base_string = $method."&".rawurlencode($url)."&".rawurlencode($querystring);

// same with the key
$key = rawurlencode($consumer_secret)."&".rawurlencode($token_secret);

// generate the hash
$signature = rawurlencode(base64_encode(hash_hmac('sha1', $base_string, $key, true)));

// this time we're using a normal GET query, and we're only encoding the query params
// (without the oauth params)
$url .= "?".http_build_query($query);
$url=str_replace("&amp;","&",$url); //Patch by @Frewuill

$oauth['oauth_signature'] = $signature; // don't want to abandon all that work!
ksort($oauth); // probably not necessary, but twitter's demo does it

// also not necessary, but twitter's demo does this too
function add_quotes($str) { return '"'.$str.'"'; }
$oauth = array_map("add_quotes", $oauth);

// this is the full value of the Authorization line
$auth = "OAuth " . urldecode(http_build_query($oauth, '', ', '));

// if you're doing post, you need to skip the GET building above
// and instead supply query parameters to CURLOPT_POSTFIELDS
$options = array( CURLOPT_HTTPHEADER => array("Authorization: $auth"),
                  //CURLOPT_POSTFIELDS => $postfields,
                  CURLOPT_HEADER => false,
                  CURLOPT_URL => $url,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_SSL_VERIFYPEER => false);

// do our business
$feed = curl_init();
curl_setopt_array($feed, $options);
$json = curl_exec($feed);
curl_close($feed);


$twitter_data = json_decode($json, true);

function processString($s) {
    return preg_replace('/https?:\/\/[\w\-\.!~#?&=+\*\'"(),\/]+/','<a href="$0">$0</a>',$s);
}

if (isset( $_GET["test"] )){	
	if ($_GET["test"] == 'json')
		$test = $json;
	else
		$test = $twitter_data;
	
	print("<pre>");
	print_r($test);
	print("</pre>". PHP_EOL);
}

print('<?xml version="1.0" encoding="utf-8"?>'. PHP_EOL);
print('<?xml-stylesheet type="text/xsl" href="atom-to-html.xsl"?>'. PHP_EOL);

print('<feed xmlns="http://www.w3.org/2005/Atom">'. PHP_EOL);
print('<title>'.$list. ' ('.$owner.')</title>'. PHP_EOL);

$arrLen = count($twitter_data);
for ($i=0; $i<$arrLen; $i++) {
	print(PHP_EOL. '	<entry>'. PHP_EOL);
		print('		<id>https://twitter.com/'.$twitter_data[$i]['user']['screen_name'].'/statuses/'. $twitter_data[$i]['id_str'] .'</id>'. PHP_EOL);
		print('		<link href="https://twitter.com/'.$twitter_data[$i]['user']['screen_name'].'/statuses/'. $twitter_data[$i]['id_str'] .'" rel="alternate" type="text/html"/>'. PHP_EOL);
		print('		<title>'.$twitter_data[$i]['user']['screen_name'].': '.htmlspecialchars($twitter_data[$i]['text']).'</title>'. PHP_EOL);
		print('		<summary type="html"><![CDATA['.$twitter_data[$i]['user']['screen_name'].': '.$twitter_data[$i]['text'].']]></summary>'. PHP_EOL);
		
		$feedContent = '		<content type="html"><![CDATA[<p>'.$twitter_data[$i]['text'].'</p>]]></content>';
		$text = processString($feedContent);
		
		print($text . PHP_EOL);
		print('		<updated>'.$twitter_data[$i]['created_at'].'</updated>'. PHP_EOL);
		print('		<author><name></name></author>'. PHP_EOL);
		
		$hashLen = count($twitter_data[$i]['entities']['hashtags']);
		if ($hashLen > 0){
			for ($j=0; $j<$hashLen; $j++){
				print('		<category term="'.$twitter_data[$i]['entities']['hashtags'][$j]['text'].'"/>'. PHP_EOL);
			}
		}
	print('	</entry>'. PHP_EOL);
}

print('</feed>'. PHP_EOL);
print('<!-- vim:ft=xml -->');

?>