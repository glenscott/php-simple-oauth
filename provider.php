<?php

$server = new OAuthServer(new DataApi_OAuthDataStore());
$server->add_signature_method( new OAuthSignatureMethod_HMAC_SHA1() );
 
$request = OAuthRequest::from_request();
 
try {
    if ( $server->verify_request($request) ) {
        echo json_encode(true);
    }
}
catch (Exception $e) {
    echo json_encode("Exception: " . $e->getMessage());
}
 
class DataApi_OAuthDataStore extends OAuthDataStore {
    function lookup_consumer($consumer_key) {
        $consumer_secrets = array( 'thisisakey'     => 'thisisasecret',
                                   'anotherkey'     => 'f3ac5b093f3eab260520d8e3049561e6',
                                 );
 
        if ( isset($consumer_secrets[$consumer_key])) {
            return new OAuthConsumer($consumer_key, $consumer_secrets[$consumer_key], NULL);
        }
        else {
            return false;
        }
    }
 
    function lookup_token($consumer, $token_type, $token) {
        // we are not using tokens, so return empty token
        return new OAuthToken("", "");
    }
 
    function lookup_nonce($consumer, $token, $nonce, $timestamp) {
        // @todo lookup nonce and make sure it hasn't been used before (perhaps in combination with timestamp?)
        return NULL;
    }
 
    function new_request_token($consumer, $callback = null) {
 
    }
 
    function new_access_token($token, $consumer, $verifier = null) {
 
    }
}
