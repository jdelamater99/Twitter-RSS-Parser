<?php
$host = 'api.twitter.com';
$method = 'GET';
$path = '/1.1/statuses/home_timeline.json'; // api call path

$query = array( // query parameters
	'count' => $count,
	'trim_user' => 'false',
	'exclude_replies' => !$home_include_replies,
	'include_entities' => 'true',
	'include_rts' => $home_include_rts,
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

print('<id>tag:twitter.com,2006:/home/'. $screen_name .'</id>'. PHP_EOL);
print('<title>Home Timeline of @'. $screen_name . '</title>'. PHP_EOL);
print('<updated>'.date('c', strtotime($twitter_data[0]['created_at'])).'</updated>'. PHP_EOL);

print('<link href="https://twitter.com/"/>'. PHP_EOL);
print('<link href="'.$protocol.$_SERVER['SERVER_NAME'].str_replace("&", "&amp;", $_SERVER['REQUEST_URI']).'" rel="self" type="application/atom+xml" />'. PHP_EOL);

include "feed.php";

?>
