
## LOADTEST-NGINX-ACCESS-LOG
- This program using the log-paresr library to parse NGINX access_log.
- Log-parser repo: https://github.com/kassner/log-parser
- There are 20000 rows in www[.]commercialtrucktrader[.]com[.]access[.]log file

#### How To Run
##### Script (access-log-file.php)

######Required:
- Modify access-log-file location
- Modify $base_uri variable (Facade setup of this local site must point to the API that you want to do load test)

######Optional:
- Modify setFormat when needed (Detail Info can be found in: https://github.com/kassner/log-parser)

##### Multi processes 
- Take a look at multithreads.sh and multiprocess.php scripts

##### View current log
- tail -f /tmp/loadtest-access-log.log

##### Kill processes
- ps -ef | grep load-access-log.php
- pkill -f load-access-log.php
