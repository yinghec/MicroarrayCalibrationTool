<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <?php 
        include("common.php"); 
    ?>
            <script src="checkbox.js" type="text/javascript"></script>
        
        <div class="function">
            <a href="upload01.php" style="text-decoration:none;"><img src="circular_arrows.png" alt="CalibrateIt" style="width:25px;height:25px">Click here if you sumbit one single file that contains all dilutions.<br></a>
            <form action="successSubmit.php" enctype="multipart/form-data" method = "post">
                <div id = "FileUploadContainer">
                <label for="file">Filename:</label>
                <input type="file" name="file1">
                Dilution factor: <input type="text" name="concentration1" class="factorData" id="dilution">  <br>
                    <!--FileUpload Controls will be added here -->
                </div>
                <div><img src="add.jpg" alt="CalibrateIt" style="width:25px;height:25px" id="add"> Add more files</div>
                <input name="count" value="1" id="count" style="width: 20px;" type="hidden"><br>
                <p id="color">Suggest calibration curves. At least one must be selected.</p>
                <input type="checkbox" name="choice1" checked>Freundlich 
                <input type="checkbox" name="choice2">Linear
                <input type="checkbox" name="choice3">Langmuir<br>
                 <p class="txtColor">File format: ProbeID TAB Intensity. No header. Dilution factor is a floating point number (e.g., 0.25 or 3) </p>
                <input type="submit" name="submit" value="Submit" id="finish"><br/>
                <img src="banner.jpg" alt="CalibrateIt" style="width:780px;height:30px">
            </form>
        </div>
    </BODY>

</HTML>