
Magento Shell Script - Redis Clean Up
====================================

Forked from `samm-git/cm_redis_tools`:  
- Fixed include problems
- Removed un-necessery lib files
- Converted to Magento Shell Script
- Added Clean Mode


Installation
------------
Just copy `rediscli.php` in your Magento installation root inside `/shell/` dir

**Note:**  
It requires `Credis` extension (https://github.com/colinmollenhour/Cm_Cache_Backend_Redis).  


rediscli.php
------------
Cleaning tags using Redis cache backend 
  
        Usage: php -f rediscli.php [options]

            -s <server> - server address
            -p <port> - server port
            -d <database list> - list of the databases, comma separated
            -m <mode> [all|old] old is default mode
            -v show status messages
            
        Example: php -f rediscli.php -s 127.0.0.1 -p 6379 -d 0,1
