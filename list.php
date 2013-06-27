<?php
//v1.1

$host = 'api.twitter.com';
$method = 'GET';
$path = '/1.1/lists/statuses.json'; // api call path

$query = array( // query parameters
    'owner_screen_name' => $owner,
    'slug' => $list,
    'count' => $cnt,
    'include_rts' => $list_include_rts,
    'include_entities' => $list_include_entities,
    'trim_user' => $list_trim_user
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

print('<id>https://twitter.com/'.$twitter_data[0]['user']['screen_name'].'/statuses/'. $twitter_data[0]['id_str'] .'</id>'. PHP_EOL);
print('<title>'.$list. ' ('.$owner.')</title>'. PHP_EOL);
print('<updated>'.date('c', strtotime($twitter_data[0]['created_at'])).'</updated>'. PHP_EOL);

print('<link href="https://twitter.com/'.$twitter_data[0]['user']['screen_name'].'/'. $list .'" rel="alternate" type="application/atom+xml"/>'. PHP_EOL);
print('<link href="'.$protocol.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'" rel="self" type="application/atom+xml" />'. PHP_EOL);

include "feed.php";
?>