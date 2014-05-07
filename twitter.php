<?php
include_once 'config.inc.php';
require_once('vendor/j7mbo/twitter-api-php/TwitterAPIExchange.php');

$settings = array(
    'oauth_access_token' => $_CONFIG['twitter_OAUTH_ACCESS_TOKEN'],
    'oauth_access_token_secret' => $_CONFIG['twitter_OAUTH_ACCESS_TOKEN_SECRET'],
    'consumer_key' => $_CONFIG['twitter_CONSUMER_KEY'],
    'consumer_secret' => $_CONFIG['twitter_CONSUMER_SECRET']
);

$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q=%23PicassoUTC&result_type=recent&count=10';
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
echo $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();