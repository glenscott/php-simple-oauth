<?php

require_once dirname(__FILE__) . '/../library/OAuth/OAuth.php';
 
// this is sent with each request, and doesn't matter if it is public
$consumer_key = 'thisisakey';
 
// this should never be sent directly over the wire
$private_key  = 'thisisasecret';
 
// API endpoint
$url = 'https://example.com/v1/oauth';
 
// the custom paramters you want to send to the endpoint
$params = array( 'foo' => 'bar',
                 'bar' => 'foo',
                 );
 
$consumer = new OAuthConsumer($consumer_key, $private_key);
$request  = OAuthRequest::from_consumer_and_token($consumer, NULL, 'GET', $url, $params);
 
$sig = new OAuthSignatureMethod_HMAC_SHA1();
 
$request->sign_request($sig, $consumer, null);
 
$opts = array(
    'http' => array(
        'header' => $request->to_header()
    )
);
 
$context = stream_context_create($opts);
 
$url = $url . '?' . http_build_query($params);
 
echo "Making request: " . $url . PHP_EOL;
echo "Authorization HTTP Header: " . $request->to_header() . PHP_EOL;
echo "Response: " . file_get_contents($url, false, $context) . PHP_EOL;
