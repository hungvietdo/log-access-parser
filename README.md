
## LOADTEST-NGINX-ACCESS-LOG
- This program using the log-paresr library to parse NGINX access_log.
- Log-parser repo: https://github.com/kassner/log-parser
- There are 20000 rows in www[.]commercialtrucktrader[.]com[.]access[.]log file

#### Installation

`composer install`
`NEW_RELIC_APP_NAME="testing truck - hung" NERELIC_ENABLED=true APIGEE_ENV=prod PORT=9018 nodemon server.js`

#### How To Run
##### Script (access-log-file.php)

###### Required:
- Modify `$accesslogFile` variable for log path location
- Modify `$base_uri` variable (Facade setup of this local site must point to the API that you want to do load test)

###### Optional:
- Modify setFormat when needed (Detail Info can be found in: https://github.com/kassner/log-parser)

##### Execute script in multi-processes 
- Take a look at multithreads.sh and multiprocess.php scripts. 
- Current setup is `n=3` ~ 6 processes.
- To run: `php multiprocess.php`

##### View current log
- See the current progress: `tail -f /tmp/loadtest-access-log.log`

##### Kill processes
- view processes: `ps -ef | grep load-access-log.php`
- kill these processes: `pkill -f load-access-log.php`
