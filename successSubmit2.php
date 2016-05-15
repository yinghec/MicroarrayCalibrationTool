<?php session_start();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <?php
        if (!isset($_SESSION['ID'])) {
            echo "no ID";
        }else{
            (float)$serial = $_SESSION['ID'];
        }
        $_SESSION["name"] = $serial;
        $count = $_POST["count"] + 1;
        $descDataArray = array();
        $commDataArray = array();
        $pathWay = "/nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/".$serial."_sample";
        for ($i=1; $i< $count; $i++){
            $descData = $_POST["description".$i];
            $commData = $_POST["comment".$i];
            $temp = explode(".", $_FILES["file".$i]["name"]);
            if ($temp[1] != "txt") {
                echo "Only text file allowed";
                exit();
            }
            $result = move_uploaded_file($_FILES["file".$i]["tmp_name"], "$pathWay"."$i".".txt");
            array_push($descDataArray, $descData);
            array_push($commDataArray, $commData);
        }
        $previousDesc = null;
        $db = new PDO('mysql:host=ovid01.u.washington.edu;port=3302;dbname=CalibratedMicroarrays', 'root', 'kikos2014');
        for ($i=1; $i< $count; $i++) {
            //print_r("in the loop");
            $HID = $descDataArray[$i - 1];
            //print_r($HID);
            $com = $commDataArray[$i - 1];
            //print_r($com);
            $statement = $db->query("INSERT INTO CalibratedMicroarrays.Hybridizations (HybridizationID, Comment, Projects_ProjectID) VALUES ('$HID', '$com', $serial)");
            $linkpath = "/nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/".$serial."sample.txt";
            $LoadIntoDatabase = fopen($linkpath, "w");
            file_put_contents($linkpath, "");
            chmod($linkpath, 0777); 
            $currentData = "$pathWay"."$i".".txt";
            $resultopt = shell_exec("./process_20th $currentData $linkpath $HID $serial");
            $statement = $db->query("LOAD DATA LOCAL INFILE '${linkpath}' INTO TABLE CalibratedMicroarrays.Intensities_experiments");
            //unlink($linkpath);
       }
    ?>      
    <?php include("common1.php");  ?>
            <img src="banner1.jpg" alt="CalibrateIt" style="width:780px;height:30px" class="banner1">
            <img src="here.png" alt="CalibrateIt" style="width:100px;height:75px" id="current3">
        <div class = "leftExplain">
            <p id="first">Calibrate MicroArrays</p>
            <img src="arrowDown.jpg" alt="CalibrateIt" style="width:80px;height:100px" id ="four">
            <p id="sec">Upload Samples</p>
            <img src="arrowDown.jpg" alt="CalibrateIt" style="width:80px;height:100px" id="five">
            <a href="checkserial2.php" style="text-decoration:none;"><p id ="thr">Export Results</p></a>
        </div>

            <div class = "btmBanner">
                <img src="banner.jpg" alt="CalibrateIt" style="width:780px;height:30px"> <br/>
            </div>   
    </BODY>

</HTML>