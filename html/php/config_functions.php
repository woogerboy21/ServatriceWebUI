<?php

    GLOBAL $config_file;
    $config_file = ".config";

    function get_config_value($config_file_input, $config_value)
    {
        if (empty($config_file_input))
            return "failed, config file name can not be blank";
        if (empty($config_value))
            return "failed, config file value can not be blank";
        if (!file_exists($config_file_input))
            return "failed, config file does not exist";

        $file_handle = fopen($config_file_input, "r");
        while (!feof($file_handle))
        {
            $line = fgets($file_handle);
            if (strpos($line,$config_value) !== false)
            {
                $lineparts = explode("=", $line);
                if ($lineparts[0] == $config_value)
                {
                    if (sizeof($lineparts) == 2)
                        $results = $lineparts[1];
                    break;
                }
            }
        }
        fclose($file_handle);

        if (empty($results))
            return "failed, unable to locate config value (" . $config_value . ")";

        return trim($results);
    }
?>