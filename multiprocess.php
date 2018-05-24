<?php
//Be careful with fork() process. You  have to manually kill (pkill) php processes.
//Processes are growing exponetially by 2^n
//Do not set n>10 since 2^10 - 1 = 1023 processes
$n = 3;

if (
    isset($argv[1]) && 
    !is_null($argv[1]) && 
    !empty($argv[1]) && 
    is_int((int)$argv[1])
) {
    $n = $argv[1];
    print '$n = '.$n;
}

//Truck or Equipment

$siteForTesting = $argv[2];

//print_r(isset($argv[1]) . PHP_EOL);
//print_r(!is_null($argv[1]) . PHP_EOL);
//print_r(!empty($argv[1]) . PHP_EOL);
//print_r(is_int((int)$argv[1]) . PHP_EOL);
//print_r($n);exit;

if (! function_exists('pcntl_fork')) die('PCNTL functions not available on this PHP installation');

for ($x = 1; $x < $n; $x++) {
   switch ($pid = pcntl_fork()) {
      case -1:
         // @fail
         die('Fork failed');
         break;

      case 0:
         // @child: Include() misbehaving code here
         print "FORK: Child #{$x} preparing to nuke...\n";
         shell_exec("php load-access-log.php  {$siteForTesting}> /dev/null 2>&1 &");

         break;

      default:
         // @parent
         print "FORK: Parent, letting the child run amok...\n";

         shell_exec("php load-access-log.php {$siteForTesting}> /dev/null 2>&1 &");
         pcntl_waitpid($pid, $status);

         break;
   }
}

print "Done! :^)\n\n";
?>

