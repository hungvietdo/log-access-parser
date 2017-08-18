
## LOADTEST-NGINX-ACCESS-LOG
- This program is using the log-paresr library to parse NGINX access_log.
- Log-parser repo: https://github.com/kassner/log-parser
- There are 20000 rows in www[.]commercialtrucktrader[.]com[.]access[.]log file

#### How To Run
##### Script
- Modify access-log-file location
- Modify $base_uri variable
- Mofify setFormat when needed (Detail Info can be found in: https://github.com/kassner/log-parser)
##### Multi processes 
- Take a look at multithreads.sh and multiprocess.php scripts
