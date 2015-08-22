<?php

    GLOBAL $config_file;
    require 'database_functions.php';
    $db_prefix = trim(get_config_value($config_file, 'tblprefix'));
    $db_table = $db_prefix . '_users';

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

        try {
            $db_connection = connect_to_database();
            $query = $db_connection->prepare("select * from " . $db_table . " where name = :username");
            $query->bindParam(':username',$user_name);
            $query->execute();

        }
        catch(PDOException $error)
        {
            die($error->getMessage());
        }

        $row = $query->fetchObject();
        return $row->$data_to_collect;
    }

    function check_if_user_exists($user_name)
    {
        GLOBAL $db_table;

        try {
            $db_connection = connect_to_database();
            $query = $db_connection->prepare("select count(name) from " . $db_table . " where name = :username");
            $query->bindParam(':username',$user_name);
            $query->execute();

        }
        catch(PDOException $error)
        {
            die($error->getMessage());
        }

        return ($query->rowCount() > 0) ? true : false;

    }

?>