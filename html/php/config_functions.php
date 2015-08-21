<?php

    global $config_file;
    $config_file = ".config";

    function get_config_value($configfile,$configvalue){
        $results = "unknown";
        if (empty($configfile)){ $results = "failed, config file name can not be blank"; return $results; exit;}
        if (empty($configvalue)){ $results = "failed, config file value can not be blank"; return $results; exit;}
        if (!file_exists($configfile)){ $results = "failed, config file does not exist"; return $results; exit;}
        $file_handle = fopen($configfile, "r");
        while (!feof($file_handle)) {
            $line = fgets($file_handle);
            if (strpos($line,$configvalue) !== false){
                $lineparts = explode("=",$line);
                if ($lineparts[0] == $configvalue){
                    if (sizeof($lineparts) < 3 && sizeof($lineparts) > 1){ $results = $lineparts[1];}
                    break;
                }
            }
        }
        fclose($file_handle);
        if ($results == "unknown"){ $results = "failed, unable to locate config value (" . $configvalue . ")";}
        return trim($results);
    }
?>