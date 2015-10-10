<?php
require_once(__DIR__.'/../vendor/autoload.php');
use lkdevelopment\BreadfishAPIClient;

$client = new BreadfishAPIClient(12701,"hzr0MEDI5wk4FZyCfNuj9leP3otqBLUc6Sr");
echo "<pre>".print_r($client->getResponseFromBreadfish())."</pre>";
