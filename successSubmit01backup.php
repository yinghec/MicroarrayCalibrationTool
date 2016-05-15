<?php session_start();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
    <?php

// ----------------------------------------------------------------------------------------------------
// - Display Errors
// ----------------------------------------------------------------------------------------------------
ini_set('display_errors', 'On');
ini_set('html_errors', 0);
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
if ($_SERVER['HTTP_HOST']==='some.domain.name.here') {
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
}

// ----------------------------------------------------------------------------------------------------
// - Error Reporting
// ----------------------------------------------------------------------------------------------------
error_reporting(-1);

// ----------------------------------------------------------------------------------------------------
// - Shutdown Handler
// ----------------------------------------------------------------------------------------------------
function ShutdownHandler()
{
    if(@is_array($error = @error_get_last()))
    {
        return(@call_user_func_array('ErrorHandler', $error));
    };

    return(TRUE);
};

register_shutdown_function('ShutdownHandler');

// ----------------------------------------------------------------------------------------------------
// - Error Handler
// ----------------------------------------------------------------------------------------------------
function ErrorHandler($type, $message, $file, $line)
{
    $_ERRORS = Array(
        0x0001 => 'E_ERROR',
        0x0002 => 'E_WARNING',
        0x0004 => 'E_PARSE',
        0x0008 => 'E_NOTICE',
        0x0010 => 'E_CORE_ERROR',
        0x0020 => 'E_CORE_WARNING',
        0x0040 => 'E_COMPILE_ERROR',
        0x0080 => 'E_COMPILE_WARNING',
        0x0100 => 'E_USER_ERROR',
        0x0200 => 'E_USER_WARNING',
        0x0400 => 'E_USER_NOTICE',
        0x0800 => 'E_STRICT',
        0x1000 => 'E_RECOVERABLE_ERROR',
        0x2000 => 'E_DEPRECATED',
        0x4000 => 'E_USER_DEPRECATED'
    );

    if(!@is_string($name = @array_search($type, @array_flip($_ERRORS))))
    {
        $name = 'E_UNKNOWN';
    };

    return(print(@sprintf("%s Error in file \xBB%s\xAB at line %d: %s\n", $name, @basename($file), $line, $message)));
};

$old_error_handler = set_error_handler("ErrorHandler");

// other php code

?>
    <?php
        /*if (!isset($_POST["choice1"]) && !isset($_POST["choice2"]) && !isset($_POST["choice3"])) {
            echo "<script>
            alert('You MUST select at least one option to calibrate');
            window.location.href='upload.php';
            </script>";
        }*/
        //upload_max_filesize "2M" PHP_INI_PERDIR;
        error_reporting(-1);
        ini_set('mysql.connect_timeout', 3000);
        ini_set('default_socket_timeout', 3000);
        ini_set('set_time_limit', 3000);
        $num = 0;
        function GenerateSerial($digits) {
        $min = pow(10, $digits - 1);
        $max = pow(10, $digits) - 1;
        return mt_rand($min, $max);
        }
        $serial =  GenerateSerial(5);
        function checkifSerialexist ($serial) {
            $db = new PDO('mysql:host=ovid01.u.washington.edu;port=3302;dbname=CalibratedMicroarrays', 'root', 'kikos2014');
            $statement = $db->prepare("SELECT 'ProjectID' FROM 'Projects' WHERE 'ProjectID' = $serial");
                if (!is_null($statement)) {
                    return true;
                }else{
                    return false;
                }
            }
        while (!checkifSerialexist($serial)) {
            $serial = GenerateSerial(5);

        }
        $_SESSION["name"] = $serial;       
        $pathWay = "/nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/".$serial."_calibration";
        if ($_FILES["file1"]["error"] != 0) {
            exit($_FILES["file1"]["error"]);
        }
        if (empty($_FILES["file1"]["tmp_name"])) {
            exit("empty");
        }
        $moveResult = move_uploaded_file($_FILES["file1"]["tmp_name"], "$pathWay".".txt");
        if ($moveResult == true) {
            //echo "File has been moved from " . $fileTmpLoc . " to" . $pathAndName;
        } else {
            //echo "ERROR: File not moved correctly";
        }
        #$temp = explode(".", $_FILES["file"]["file1"]);
        #if ($temp[1] != "txt") {
        #    echo "Only text file allowed";
        #    exit();
        #}
        $db = new PDO('mysql:host=ovid01.u.washington.edu;port=3302;dbname=CalibratedMicroarrays', 'root', 'kikos2014');
        date_default_timezone_set("America/Los_Angeles");
        header("Location:/nfs/bronfs/uwfs/hw00/d37/ohirl/calibarray/save.php");
        $today = date("Y-m-d H:i:s"); 
        //print("$today");
        $statement = $db->query("INSERT INTO Projects (ProjectID, Note, DateCreated, Keep) 
                    VALUES ($serial, 'hello' , '$today', $num)");
        $linkpath = "/nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/"."$serial"."_intoData.txt";
        $LoadIntoDatabase = fopen($linkpath, "w");
        file_put_contents($linkpath, "");
        chmod($linkpath, 0777); 
        $currentData = "$pathWay".".txt";
            #exec("./process ${currentData}  ${serial}  ${factor} >> /nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/${serial}_out1.txt", $output);
        $resultopt = shell_exec("./processw $currentData $linkpath $serial");
        $db = new PDO('mysql:host=ovid01.u.washington.edu;port=3302;dbname=CalibratedMicroarrays', 'root', 'kikos2014');
        $statement = $db->query("LOAD DATA INFILE '${linkpath}' INTO TABLE CalibratedMicroarrays.Intensities_calibration");
        #unlink($linkpath);
        $db = new PDO('mysql:host=ovid01.u.washington.edu;port=3302;dbname=CalibratedMicroarrays', 'root', 'kikos2014');
        $test = "/nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/"."$serial"."temp.txt"; 
        #$rows = $db->query(" SELECT Calib_Concentration, ProbeID_rep, cast(AVG(Intensity) as DECIMAL(10,7)), cast(STDDEV(Intensity)/ SQRT(COUNT(*))/AVG(Intensity) AS DECIMAL(10,7)) FROM Intensities_calibration WHERE ProjectID = '$serial'  GROUP BY ProbeID_rep, Calib_Concentration
        #    INTO OUTFILE '$test'; ");
        $rows = $db->query(" SELECT Calib_Concentration, ProbeID_rep, AVG(Intensity), STDDEV(Intensity)/ SQRT(COUNT(*))/AVG(Intensity) FROM CalibratedMicroarrays.Intensities_calibration WHERE ProjectID = '$serial'  GROUP BY ProbeID_rep, Calib_Concentration
            INTO OUTFILE '$test'; ");
        #$rows = $db->query(" SELECT Calib_Concentration, ProbeID_rep, AVG(Intensity), STDDEV(Intensity)/ SQRT(COUNT(*))/AVG(Intensity)) FROM Intensities_calibration WHERE ProjectID = '$serial'  GROUP BY ProbeID_rep, Calib_Concentration
        #    INTO OUTFILE '$test'; ");
        if (!$rows) {
            print_r("false");
        }
        if (isset($_POST["choice1"]) && !isset($_POST["choice2"]) && !isset($_POST["choice3"])) {
            exec("./calibrate < $test -R2 0.9 -freund F  > /nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/${serial}_out1.txt", $output);
        }
        if (!isset($_POST["choice1"]) && isset($_POST["choice2"]) && !isset($_POST["choice3"])) {
            exec("./calibrate < $test -R2 0.9  -linear LN  > /nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/${serial}_out1.txt", $output);
        }
        if (!isset($_POST["choice1"]) && !isset($_POST["choice2"]) && isset($_POST["choice3"])) {
            exec("./calibrate < $test -R2 0.9  -langmuir LG  > /nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/${serial}_out1.txt", $output);
        }
        if (isset($_POST["choice1"]) && isset($_POST["choice2"]) && !isset($_POST["choice3"])) {
            exec("./calibrate < $test -R2 0.9 -freund F -linear LN > /nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/${serial}_out1.txt", $output);
        }
        if (isset($_POST["choice1"]) && !isset($_POST["choice2"]) && isset($_POST["choice3"])) {
            exec("./calibrate < $test -R2 0.9 -freund F -langmuir LG > /nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/${serial}_out1.txt", $output);
        }
        if (isset($_POST["choice1"]) && isset($_POST["choice2"]) && isset($_POST["choice3"])) {
            exec("./calibrate < $test -R2 0.9 -freund F -langmuir LG -linear LN > /nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/${serial}_out1.txt", $output);
        }
        if (!isset($_POST["choice1"]) && isset($_POST["choice2"]) && isset($_POST["choice3"])) {
            exec("./calibrate < $test -R2 0.9  -linear LN -langmuir LG  > /nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/${serial}_out1.txt", $output);
        }
        #unlink($test);
        $CalibrateOutput = "/nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/".$serial."_out1.txt";
        chmod($CalibrateOutput, 0777);
        $probeFile = file($CalibrateOutput, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $intoProbeFile = "/nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/".$serial."_intoFile.txt"; 
        file_put_contents($intoProbeFile, "");
        chmod($intoProbeFile, 0777);
        $resultadd = shell_exec("./processlast $CalibrateOutput $intoProbeFile $serial");
        $statement = $db->query("LOAD DATA LOCAL INFILE '${intoProbeFile}' INTO TABLE CalibratedMicroarrays.ProbeCharacteristics");
        unlink($CalibrateOutput);
        unlink($intoProbeFile);
     ?>     
    <?php include("common1.php");  ?>
        <img src="banner1.jpg" alt="CalibrateIt" style="width:780px;height:30px" class="banner1">
            <img src="here.png" alt="CalibrateIt" style="width:100px;height:75px" id="current2">
        <div class = "leftExplain">
            <p id="first">Calibrate MicroArrays</p>
            <img src="arrowDown.jpg" alt="CalibrateIt" style="width:80px;height:100px" id="four">
            <a href="upload2.php" style="text-decoration:none;"><p id="sec">Upload Samples</p></a>
            <img src="arrowDown.jpg" alt="CalibrateIt" style="width:80px;height:100px" id="five">
            <p id ="thr">Export Results</p>
        </div>

            <div class="btmBanner">
                <img src="banner.jpg" alt="CalibrateIt" style="width:780px;height:30px">
            </div>  
    </BODY>

</HTML>  