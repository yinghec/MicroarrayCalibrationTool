<?php
        session_start();
        if (!isset($_SESSION['ID'])) {
            echo "no ID";
            $serial = $_SESSION['name'];
        }else{
            $serial = $_SESSION['ID'];
        }
        if (isset($_POST["info"])) {
            $id = $_POST["info"];
            $db = new PDO('mysql:host=ovid01.u.washington.edu;port=3302;dbname=CalibratedMicroarrays', 'root', 'kikos2014');
            $out1 = "/nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/".$serial."_out1.txt";
            $statement = $db->query("SELECT ProbeID, a, b, R2, CurveType From ProbeCharacteristics 
                where Projects_ProjectID = '$serial' into outfile '$out1'");
            chmod($out1, 0777);
            $aveSample = "/nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/".$serial."AVG_Sample.txt";
            if ($id != "All of Above") {
                $query = "SELECT Hybridizations_HybridizationID, ProbeID_rep, AVG(Intensity) AS AVG_Intensities, STDDEV(Intensity)/ SQRT(COUNT(*))/AVG(Intensity) AS SEM FROM CalibratedMicroarrays.Intensities_experiments WHERE Project_ID = "."'$serial'"." and Hybridizations_HybridizationID = "."'$id'"." GROUP BY ProbeID_rep, Hybridizations_HybridizationID into outfile '$aveSample'";
                $sets = $db->query($query);
            }else {
                $query = "SELECT Hybridizations_HybridizationID, ProbeID_rep, AVG(Intensity) AS AVG_Intensities, STDDEV(Intensity)/ SQRT(COUNT(*))/AVG(Intensity) AS SEM FROM CalibratedMicroarrays.Intensities_experiments WHERE Project_ID = "."'$serial'"." GROUP BY ProbeID_rep, Hybridizations_HybridizationID into outfile '$aveSample'";
                $sets = $db->query($query);
            }
            chmod($aveSample, 0777);
    	    $out2 = "/nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/".$serial."_out2.txt";
            $LoadIntoDatabase = fopen($out2, "w");
            chmod($out2, 0777);
            #file_put_contents($out2, "HybridizationID\tProbeID\tConc\tErr\n");
            exec("./concentration  <${out1} -freund F -linear LN -langmuir LG  -intens ${aveSample} >> /nfs/bronfs/uwfs/hw00/d37/ohirl/tmp/${serial}_out2.txt", $output);
            $file_data = "HybridizationID\tProbeID\tConc\tErr\n";
            $file_data .= file_get_contents($out2);
            file_put_contents($out2, $file_data);
            header("Content-type: text/plain");
            header("Content-Disposition: attachment; filename=conc_".$serial.".txt");
            readfile($out2);
    	    unlink($out1);
            unlink($out2);
            unlink($aveSample);
        }
        ?>      
