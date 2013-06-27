<?php
<<<<<<< HEAD
//v1.1
=======
//v1.0
>>>>>>> 5bc7a2493926b74440733016713e66b7e257c9fa

$host = 'api.twitter.com';
$method = 'GET';
$path = '/1.1/search/tweets.json'; // api call path

<<<<<<< HEAD
$q = str_replace("+", "%20", urlencode($q));

$query = array( // query parameters
	'q' => $q,
=======
$query = array( // query parameters
  'q' => $q,
>>>>>>> 5bc7a2493926b74440733016713e66b7e257c9fa
	'include_entities' => $search_include_entities,
	'result_type' => $search_result_type
);

include "functions.php";

<<<<<<< HEAD
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    || $_SERVER['SERVER_PORT'] == 443) {

    $protocol = 'https://';
} else {
    $protocol = 'http://';
}

print('<?xml version="1.0" encoding="utf-8"?>'. PHP_EOL);
print('<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="en" xml:base="'.$_SERVER['SERVER_NAME'].'">'. PHP_EOL);

print('<id>https://twitter.com/search?q='.$q.'</id>'. PHP_EOL);
print('<title>Search: '. urldecode($q) . '</title>'. PHP_EOL);
print('<updated>'.date('c', strtotime($twitter_data['statuses'][0]['created_at'])).'</updated>'. PHP_EOL);

print('<link href="https://twitter.com/search?q='.$q.'" rel="alternate" type="application/atom+xml"/>'. PHP_EOL);
print('<link href="'.$protocol.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'" rel="self" type="application/atom+xml" />'. PHP_EOL);

include "feed.php";
?>
=======
print('<?xml version="1.0" encoding="utf-8"?>'. PHP_EOL);
print('<?xml-stylesheet type="text/xsl" href="atom-to-html.xsl"?>'. PHP_EOL);

print('<feed xmlns="http://www.w3.org/2005/Atom">'. PHP_EOL);
print('<title>Search: '. $q . '</title>'. PHP_EOL);

$arrLen = count($twitter_data['statuses']);
for ($i=0; $i<$arrLen; $i++) {
	print(PHP_EOL. '	<entry>'. PHP_EOL);
		print('		<id>https://twitter.com/'.$twitter_data['statuses'][$i]['user']['screen_name'].'/statuses/'. $twitter_data['statuses'][$i]['id_str'] .'</id>'. PHP_EOL);
		print('		<link href="https://twitter.com/'.$twitter_data['statuses'][$i]['user']['screen_name'].'/statuses/'. $twitter_data['statuses'][$i]['id_str'] .'" rel="alternate" type="text/html"/>'. PHP_EOL);
		print('		<title>'.$twitter_data['statuses'][$i]['user']['screen_name'].': '.htmlspecialchars($twitter_data['statuses'][$i]['text']).'</title>'. PHP_EOL);
		print('		<summary type="html"><![CDATA['.$twitter_data['statuses'][$i]['user']['screen_name'].': '.$twitter_data['statuses'][$i]['text'].']]></summary>'. PHP_EOL);
		
		$feedContent = '		<content type="html"><![CDATA[<html><body><p></p><p>'.$twitter_data['statuses'][$i]['text'].'</p></body></html>]]></content>';
		$text = processString($feedContent);
		
		print($text . PHP_EOL);
		print('		<updated>'.$twitter_data['statuses'][$i]['created_at'].'</updated>'. PHP_EOL);
		print('		<author><name></name></author>'. PHP_EOL);
		
		$hashLen = count($twitter_data['statuses'][$i]['entities']['hashtags']);
		if ($hashLen > 0){
			for ($j=0; $j<$hashLen; $j++){
				print('		<category term="'.$twitter_data['statuses'][$i]['entities']['hashtags'][$j]['text'].'"/>'. PHP_EOL);
			}
		}
		
	print('	</entry>'. PHP_EOL);
}

print('</feed>'. PHP_EOL);
print('<!-- vim:ft=xml -->');
?>
>>>>>>> 5bc7a2493926b74440733016713e66b7e257c9fa
