<?php
//v.9

$host = 'api.twitter.com';
$method = 'GET';
$path = '/1.1/statuses/home_timeline.json'; // api call path

$query = array( // query parameters
    'count' => $cnt,
    'trim_user' => $home_trim_user,
	'exclude_replies' => $home_exclude_replies,
	'contributor_details' => $home_contributor_details,
	'include_rts' => $home_include_rts,
);

include "functions.php";

print('<?xml version="1.0" encoding="utf-8"?>'. PHP_EOL);
print('<?xml-stylesheet type="text/xsl" href="atom-to-html.xsl"?>'. PHP_EOL);

print('<feed xmlns="http://www.w3.org/2005/Atom">'. PHP_EOL);
print('<title>Home Timeline of @'. $sn . '</title>'. PHP_EOL);

$arrLen = count($twitter_data);
for ($i=0; $i<$arrLen; $i++) {
	print(PHP_EOL. '	<entry>'. PHP_EOL);
		print('		<id>https://twitter.com/'.$twitter_data[$i]['user']['screen_name'].'/statuses/'. $twitter_data[$i]['id_str'] .'</id>'. PHP_EOL);
		print('		<link href="https://twitter.com/'.$twitter_data[$i]['user']['screen_name'].'/statuses/'. $twitter_data[$i]['id_str'] .'" rel="alternate" type="text/html"/>'. PHP_EOL);
		print('		<title>'.$twitter_data[$i]['user']['screen_name'].': '.htmlspecialchars($twitter_data[$i]['text']).'</title>'. PHP_EOL);
		print('		<summary type="html"><![CDATA['.$twitter_data[$i]['user']['screen_name'].': '.$twitter_data[$i]['text'].']]></summary>'. PHP_EOL);
		
		$feedContent = '		<content type="html"><![CDATA[<html><body><p></p><p>'.$twitter_data[$i]['text'].'</p></body></html>]]></content>';
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