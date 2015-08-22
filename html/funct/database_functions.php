<?php

    require 'config_functions.php';
    GLOBAL $config_file;

    $db_server = get_config_value($config_file, "dbserver");
    $db_username = get_config_value($config_file, "dbusername");
    $db_password = get_config_value($config_file, "dbpassword");
    $db_name = get_config_value($config_file, "dbname");

    function connect_to_database()
    {
        GLOBAL $db_server, $db_username, $db_password, $db_name;
        $connection = new PDO("mysql:host=$db_server;dbname=$db_name", $db_username, $db_password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    }

?>