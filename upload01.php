<?php session_start();

 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <?php 
        include("common.php"); 
    ?>     
     <script src="./nfs/bronfs/uwfs/hw00/d37/ohirl/calibarray/dropzone.js"></script>   
        <div class="function">
           <!--<form action="successSubmit01.php" class="dropzone"id="my-awesome-dropzone">
                <input type="file" name="file" />
                <input type="submit" name="submit" value="Submit" id="finish"><br/>
            </form>-->
            <form action="successSubmit01.php" enctype="multipart/form-data" method = "post">
                <div id = "FileUploadContainer">
                    <label for="file">Filename:</label>
                    <input type="file" name="file1">
                </div>

                <p id="color">Suggest calibration curves. At least one must be selected.</p>
                <input type="checkbox" name="choice1" checked>Freundlich 
                <input type="checkbox" name="choice2">Linear
                <input type="checkbox" name="choice3">Langmuir<br>
                 <p class="txtColor">File format: ProbeID TAB Intensity Dilution factor</p>
                <input type="submit" name="submit" value="Submit" id="finish"><br/>
                <img src="banner.jpg" alt="CalibrateIt" style="width:780px;height:30px">
            </form>-
        </div>
    </BODY>

</HTML>