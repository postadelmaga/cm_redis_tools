<?php
require_once 'abstract.php';

class Rediscli extends Mage_Shell_Abstract
{
    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
        Usage: php -f rediscli.php [options]

            -s <server> - server address
            -p <port> - server port
            -d <database list> - list of the databases, comma separated
            -m <mode> [all|old] old is default mode
            -v show status messages
        Example: php -f rediscli.php -s 127.0.0.1 -p 6379 -d 0,1

USAGE;
    }

    public function run()
    {
        if ($this->getArg('s') !== false && $this->getArg('p') !== false && $this->getArg('d') !== false) {

            $port = $this->getArg('p');
            $server = $this->getArg('s');
            $verbose = ($this->getArg('v') !== false);
            $mode = $this->getArg('m') == 'all' ? $this->getArg('m') : 'old';

            /* parsing command line options */
            $databases = preg_split('/,/', $this->getArg('d'));

            foreach ($databases as $db) {
                $db = (int)$db;
                if ($verbose)
                    echo "Cleaning $mode entry for database $db:";

                try {
                    $cache = new Cm_Cache_Backend_Redis(array('server' => $server, 'port' => $port, 'database' => $db));
                } catch (CredisException $e) {
                    echo "\nError: " . $e->getMessage() . "\n";
                    exit(1);
                }

                if ($cache === false) {
                    echo "\nERROR: Unable to clean database $db\n";
                }
                try {
                    if ($mode == 'all') {
                        $cache->clean(Zend_Cache::CLEANING_MODE_ALL);
                    } else {
                        $cache->clean(Zend_Cache::CLEANING_MODE_OLD);
                    }
                } catch (CredisException $e) {
                    echo "\nError: " . $e->getMessage() . "\n";
                    exit(1);
                }

                if ($verbose)
                    echo " [done]\n";
                unset($cache);
            }
        } else {
            echo $this->usageHelp();
        }
    }
}

$shell = new Rediscli();
$shell->run();