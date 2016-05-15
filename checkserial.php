<?php 
    session_start();
	$i = rand(5, 25);
	move_uploaded_file($_FILES["savedID"]["tmp_name"], "/nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/"."savedID".$i.".txt");
	$file = file("/nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/"."savedID".$i.".txt");
	$code = $file[0];
	$serial = bindec($code);
    $_SESSION["name"] = $serial;
    $_SESSION["ID"] = $serial;
?>
<!DOCTYPE>
    <?php include("common.php"); ?>
        <div class="function">
            <h2>Calculated samples:</h2>
            <?php
            $db = new PDO('mysql:host=ovid01.u.washington.edu;port=3302;dbname=CalibratedMicroarrays', 'root', 'kikos2014');
            $rows = $db->query("SELECT * FROM Projects WHERE ProjectID = $serial");
            if (!isset($rows)) {
                echo "Did not find the project";
                exit;
            }else {
                $rows =  $db->query("SELECT * FROM CalibratedMicroarrays.Hybridizations WHERE Projects_ProjectID = '$serial'");
                $countR =  $db->query("SELECT count(*) FROM CalibratedMicroarrays.Hybridizations WHERE Projects_ProjectID = '$serial'");
                if ($countR == 0) {
                    echo "There is no result.";
                }else {
                    ?>
                    <form action="successSubmit3.php" enctype="multipart/form-data" method = "post">
                        <select name = "info">
                    <?php foreach ($rows as $lines) { ?>
                        <option value="<?= $lines["HybridizationID"] ?>"> <?= $lines["HybridizationID"] ?>
                <?php 
                    } ?>
                    <option value="All of Above"> All of Above
                </select>
                    <input type="submit" value="DOWNLOAD">
                </form>
                <?php }
            }
            ?>
            <a href="upload2.php"><p>Submit more samples</p></a>
            <img src="banner.jpg" alt="CalibrateIt" style="width:780px;height:30px">
        </div> 
    </BODY>

</HTML>