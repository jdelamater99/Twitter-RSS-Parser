<?php
$host = 'api.twitter.com';
$method = 'GET';
$path = '/1.1/search/tweets.json'; // api call path

$q = str_replace("+", "%20", urlencode($q));

$query = array( // query parameters
	'q' => $q,
	'count' => $count,
	'include_entities' => 'true',
	'result_type' => $search_result_type
);

include "functions.php";

if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    || $_SERVER['SERVER_PORT'] == 443) {

    $protocol = 'https://';
} else {
    $protocol = 'http://';
}

print('<?xml version="1.0" encoding="utf-8"?>'. PHP_EOL);
print('<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="en" xml:base="'.$_SERVER['SERVER_NAME'].'">'. PHP_EOL);

print('<id>tag:twitter.com,2006:/search/'.$q.'</id>'. PHP_EOL);
print('<title>Search: '. urldecode($q) . '</title>'. PHP_EOL);
print('<updated>'.date('c', strtotime($twitter_data['statuses'][0]['created_at'])).'</updated>'. PHP_EOL);

print('<link href="https://twitter.com/search?q='.$q.'"/>'. PHP_EOL);
print('<link href="'.$protocol.$_SERVER['SERVER_NAME'].str_replace("&", "&amp;", $_SERVER['REQUEST_URI']).'" rel="self" type="application/atom+xml" />'. PHP_EOL);

include "feed.php";
?>
