<?php
require_once(__DIR__.'/../vendor/autoload.php');
use lkdevelopment\BreadfishAPIClient;

$client = new BreadfishAPIClient(12701,"hzr0MEDI5wk4FZyCfNuj9leP3otqBLUc6Sr");
$client->setRedirectUrl("http://localhost/BreadfishApiClient/test/response.php");

$client->setScope(array(BreadfishAPIClient::SCOPE_AVATAR, BreadfishAPIClient::SCOPE_BAN));
$client->redirectToBreadfish();