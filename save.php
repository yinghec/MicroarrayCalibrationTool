<?php
    session_start();
    $serial = $_SESSION["name"];
    if (!isset($serial)) {
        print_r("expression");
    }
    $db = new PDO('mysql:host=ovid01.u.washington.edu;port=3302;dbname=CalibratedMicroarrays', 'root', 'kikos2014');
    $statement = $db->query("UPDATE CalibratedMicroarrays.Projects SET Keep='1' WHERE ProjectID='$serial'");
    $url = preg_replace('/\?.*/', '',  $_SERVER['HTTP_REFERER']); //To remove query string
    header('Location: successSubmit5.php');
    ?>