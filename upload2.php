<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
        <?php
        $serial = $_SESSION["name"];
        $_SESSION['ID'] = $serial;
        include("common1.php");?>
        <script src="checkbox2.js" type = "text/javascript"></script>
        <div class = "function">
            <form action="successSubmit2.php" enctype="multipart/form-data" method = "post">
                <div id = "FileUploadContainer">
                <label for="file">Sample intensities:</label>
                <input type="file" name="file1">Designation: <input type="text" name="description1" style="width: 120px;">
                Comment: <input type="text" name="comment1" style="width: 120px;">               
                    <!--FileUpload Controls will be added here -->
                </div>
		  <img src="add.jpg" alt="CalibrateIt" style="width:25px;height:25px" id="add">Add more files<br>
                <input name="count" value="1" id="count" style="width: 20px;" type="hidden"><br>
                <p class="txtColor">File format: ProbeID TAB Intensity. Designation is an experiment identifier</p>
                <input type="submit" name="submit" value="Submit" id="finish"><br/>
                <img src="banner.jpg" alt="CalibrateIt" style="width:780px;height:30px">
            </form>
        </div>
    </BODY>

</HTML>