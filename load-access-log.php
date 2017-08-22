<?php 
require_once __DIR__ . '/vendor/autoload.php';
$parser = new \Kassner\LogParser\LogParser();

$accesslogFile = 'www.equipmenttrader.com.access.log.1';
$base_uri = 'http://cloud.equip.local';


$parser->setFormat('%h %v %u %a - - -  - - %t "%r" %>s %I %T "%{Referer}i" "%{User-Agent}i"');

$lines = file($accesslogFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$client = new GuzzleHttp\Client(['base_uri' => $base_uri]);

foreach ($lines as $line) {
  $entry = $parser->parse($line);
  $pagePath = explode(" ",$entry->request)[1];
  try {
  $response = $client->request('GET',$pagePath);
  $code = $response->getStatusCode();
  $log = print_r($code." ".$pagePath."\n", true);
  file_put_contents('/tmp/loadtest-access-log.log', $log, FILE_APPEND);
  echo $log;
  } catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
  }
}


