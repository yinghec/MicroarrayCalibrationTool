<?php
        session_start();
        if (!isset($_SESSION['name'])) {
            echo "no ID";
            $serial = 00000;
        }else{
            (float)$serial = $_SESSION['name'];
        }
        $file = "/nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/key".$serial;
        $LoadIntoDatabase = fopen($file, "w");
        chmod($file, 0777);
        file_put_contents($file, decbin($serial)."\n");
        file_put_contents($file, "You have save your current projects successfully, and this txt file is the password to access current project", FILE_APPEND);
        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename= project_$serial");
        readfile($file);
	    unlink($file);
        ?>      