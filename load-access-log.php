<?php 
require_once __DIR__ . '/vendor/autoload.php';
$parser = new \Kassner\LogParser\LogParser();


if ($argv[1] == 'truck') {
//Please copy access_log to current folder
$accesslogFile = 'www.commercialtrucktrader.com.access.log';

//Update webserver that you are going to test
$baseUri = 'https://responsive.commercialtrucktrader.com';
} else {
//Please copy access_log to current folder
$accesslogFile = 'www.equipmenttrader.com.access.log';

//Update webserver that you are going to test
$baseUri = 'https://responsive.equipmenttrader.com';

}

//Logfile Path
$resultLogFilePath = '/tmp/loadtest-access-log.log';

//-------------------------------------- Read log and run -----------------------------------------------

$parser->setFormat('%{createTime}i %h %v %u %a - - - %{version}i - - %t "%r" %>s %I %T "%{Referer}i" "%{User-Agent}i"');

$lines = file($accesslogFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$client = new GuzzleHttp\Client(['base_uri' => $baseUri, 'verify' => false]);

do {
  shuffle($lines);
  $line = array_pop($lines);

  if (strpos($line, 'POST ')) {
    continue;
  }

  $entry = $parser->parse($line);
  $pagePath = explode(" ",$entry->request)[1];
  $code = $entry->status;

  if ($code != 200) {
    continue;
  }

  if (checkToIgnore($pagePath)) {
    continue;
  }

  $entry = $parser->parse($line);
  $pagePath = explode(" ",$entry->request)[1];

  try {
    $response = $client->request('GET',$pagePath);
    $code = $response->getStatusCode();
    $log = print_r($code." ".$pagePath."\n", true);
    file_put_contents($resultLogFilePath, $log, FILE_APPEND);
  echo $log;
  } catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
  }
} while (!empty($lines));

/**
 * This function is to check if a url is valid for stress test.
 *
 * @param string $pagePath the url that being requested
 */
function checkToIgnore($pagePath) {
  $ignoreTerms = ['Gettiledata', 'favicon', '/myt/', 'fonts'];

  if(preg_match('/[a-z]{1,}\.(css|js)/', $pagePath)) {
    return true;
  }

  foreach ($ignoreTerms as $term) {
    $pos = strpos($pagePath, $term);
    if ($pos !== false) {
      return true;
    }
  }

  return false;
}

