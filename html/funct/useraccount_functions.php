<?php

    GLOBAL $config_file;
    require 'database_functions.php';
    $db_table = trim(get_config_value($config_file, 'dbusertable'));

    function crypt_password($password, $salt = '')
    {
        if ($salt == '')
        {
            $salt_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            for ($i = 0; $i < 16; ++$i)
                $salt .= $salt_chars[rand(0, strlen($salt_chars) - 1)];
        }

        $key = $salt . $password;
        for ($i = 0; $i < 1000; ++$i)
            $key = hash('sha512', $key, true);

        return $salt . base64_encode($key);
    }

    function get_user_data($user_name, $data_to_collect)
    {
        GLOBAL $db_table;
        
        $query_string = "SELECT * FROM " . $db_table . " WHERE LOWER(name)='" . $user_name . "'";
        $data = query_database($query_string);
        $row = mysql_fetch_array($data);
        $data_to_collect = strtolower(trim($data_to_collect));

        return $row[$data_to_collect];
    }

    function check_if_user_exists($user_name)
    {
        GLOBAL $db_table;

        $query_string = "SELECT count(name) FROM " . $db_table . " where name='" . $user_name . "'";
        $data = query_database($query_string);

        if ($row = mysql_fetch_array($data))
            return ($row['count(name)'] > 0) ? true : false;
    }
?>