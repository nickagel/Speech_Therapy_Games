<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <?php
    $adminStatus = false;
    $loggedIn = false;
    $user="username";
    
    
    include ('head.php');
    $debug = false;

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// PATH SETUP
//
//  $domain = "https://www.uvm.edu" or http://www.uvm.edu;

    $domain = "http://";
    if (isset($_SERVER['HTTPS'])) {
        if ($_SERVER['HTTPS']) {
            $domain = "https://";
        }
    }

    $server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");

    $domain .= $server;

    $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");

    $path_parts = pathinfo($phpSelf);

    if ($debug) {
        print "<p>Domain" . $domain;
        print "<p>php Self" . $phpSelf;
        print "<p>Path Parts<pre>";
        print_r($path_parts);
        print "</pre>";
    }

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// inlcude all libraries
//

    require_once('lib/security.php');

    if ($path_parts['filename'] == "crud" or $path_parts['filename'] == "confirmation" or $path_parts['filename'] == "approve") {
        include "lib/validation-functions.php";
        include "lib/mail-message.php";
    }
    ?>	
    <!-- ################ body section ######################### -->

    <?php
    print '<body id="' . $path_parts['filename'] . '">';
    require_once('bin/myDatabase.php');
    $dbUserName = get_current_user() . '_writer';
    $whichPass = "w"; //flag for which one to use.
    $dbName = strtoupper(get_current_user()) . '_speech';
    $thisDatabase = new myDatabase($dbUserName, $whichPass, $dbName);
    include "nav.php";
    ?>
