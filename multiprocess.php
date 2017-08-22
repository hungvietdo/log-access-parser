<?php
//Be careful with fork() process. You  have to manually kill (pkill) php processes.
//Processes are growing exponetially by 2^n
//Do not set n>10 since 2^10 - 1 = 1023 processes
$n = 3;

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
         shell_exec("php load-access-log.php > /dev/null 2>&1 &");

         break;

      default:
         // @parent
         print "FORK: Parent, letting the child run amok...\n";

         shell_exec("php load-access-log.php > /dev/null 2>&1 &");
         pcntl_waitpid($pid, $status);

         break;
   }
}

print "Done! :^)\n\n";
?>

