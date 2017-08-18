#!/bin/bash
# Run script: first argument is number of processes to run simultaneously
process=$1
PHP=`which php`

echo "Spawning $process processes"
for i in {1..$process}
do
    $PHP load-access-log.php &
    sleep 1
done
