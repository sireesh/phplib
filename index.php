<?php
/**
 * Created by PhpStorm.
 * User: sireesh
 * Date: 15/04/16
 *
 * BootStrap File
 *
 * 
 */

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

//getting DB Innstance 
$con = mysql_db::getInstance();

// Logging class initialization
$log = new php_logger();

// set path and name of log file
$log->lfile('/var/log/debug.log');

//Logging messages to debug log file
$log->lwrite("SUCCESS: Application started");
$log->lwrite("ERROR: Issue with DB Connection");
