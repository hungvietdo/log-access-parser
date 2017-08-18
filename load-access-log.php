<?php 
require_once __DIR__ . '/vendor/autoload.php';
$parser = new \Kassner\LogParser\LogParser();

$accesslogFile = 'www.commercialtrucktrader.com.access.log';
$base_uri = 'http://www.commercialtrucktrader.com';


$parser->setFormat('%h %v %u %a - - -  - - %t "%r" %>s %I %T "%{Referer}i" "%{User-Agent}i"');

$lines = file($accesslogFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$client = new GuzzleHttp\Client(['base_uri' => $base_uri]);

foreach ($lines as $line) {
  $entry = $parser->parse($line);
  $pagePath = explode(" ",$entry->request)[1];
  $response = $client->request('GET',$pagePath);
  $code = $response->getStatusCode();
  print_r($code." ".$pagePath."\n");
}


