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

        $connection = mysql_connect($db_server, $db_username, $db_password) or die(mysql_error());
        $database = mysql_select_db($db_name, $connection) or die(mysql_error());

        return $connection;
    }

    function query_database($query_string)
    {
        echo 'query string: ' . $query_string . '<br />'; // Why?

        $db_connection = connect_to_database();
        $query = mysql_query($query_string) or die(mysql_error());
        mysql_close($db_connection);

        return $query;
    }
?>