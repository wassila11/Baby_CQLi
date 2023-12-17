<?php

session_start();

$blacklist = [
    'UNION',    
    'DELETE',    
    'DROP',
    'cat',
    'INSERT',
    'head',
    'ls',
    'tmp',
    'echo',
    'print',
    'get',
    'curl',
    'flag',
    '--',
    '(',
    ')',
    'read'   
];

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["username"])) {
    $username = $_GET["username"];
    if (containsBlacklist($username)){
        echo "Sorry you can't see my secret!";
        exit();
    }

    // Establish SQLite database connection
    $db = new SQLite3('/var/www/html/sql/minions.db');
    
    if (!$db) {
        die("Error: Could not connect to the database.");
    }

    $sql = sprintf("SELECT score_value FROM scores WHERE username='%s';",$username);
    try {

        $dbPath = '/var/www/html/sql/minions.db';
        $result = queryLite($sql,$dbPath);
        ob_start(); 
        var_dump($result);
        $result = ob_get_clean(); 
        
        preg_match_all('/string\(\d+\) "(.*?)"/', $result, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
             if (containsBlacklist($match[1])){
                 echo "Sorry you can't see my secret!";
                 exit();
             }
            
           echo $match[1] . "\n"; 

        }


    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    $db->close();
}


function queryLite($sql,$dbPath) {
 
    $command = 'sqlite3 ' . escapeshellarg($dbPath);
    $descriptorspec = array(
        0 => array("pipe", "r"), //stdin
        1 => array("pipe", "w"), //stdout
        2 => array("pipe", "w"), //stderr
    );

    $process = proc_open($command, $descriptorspec, $pipes);

    if (is_resource($process)) {
        fwrite($pipes[0], $sql);
        fclose($pipes[0]);

        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $errorOutput = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        $returnValue = proc_close($process);

        if ($returnValue !== 0) {
            throw new Exception("Error executing SQLite command: $errorOutput");
        }

        $result = [];
        $rows = explode("\n", trim($output));
        foreach ($rows as $row) {
            if ($row === '') {
                break;
            }
            $result[] = explode('|', $row);
        }

        return $result;
    }

    throw new Exception("Failed to open process.");
}


function containsBlacklist($output) {
    global $blacklist;
    foreach ($blacklist as $item) {
        if (stripos($output, $item) !== false) {
            return true;
        }
    }
    return false;
}


?>
