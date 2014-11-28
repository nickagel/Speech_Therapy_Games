<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <?php
    $adminStatus = false;
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

    if ($path_parts['filename'] == "signUp" or $path_parts['filename'] == "confirmation" or $path_parts['filename'] == "approve" or $path_parts['filename'] == "logIn") {
        include "lib/validation-functions.php";
        include "lib/mail-message.php";
    }
    //if this page is loaded it unsets any session variable and sets log in as false
    if ($path_parts['filename']=='logIn'){
        session_unset();
        $logOutMessage="Log out Successful!";
    }
    ?>	
    <!-- ################ body section ######################### -->
    <?php
    require_once('bin/myDatabase.php');
    $dbUserName = get_current_user() . '_writer';
    $whichPass = "w"; //flag for which one to use.
    $dbName = strtoupper(get_current_user()) . '_speech';
    $thisDatabase = new myDatabase($dbUserName, $whichPass, $dbName);
    if ($path_parts['filename'] == 'match') {
        try {
            require_once('bin/array.php');
            require_once('bin/matchGame.php');
        } catch (Exception $ex) {
            echo "error with game loading please contact admin";
        }
    }
    print '<body class="' . $path_parts['filename'] . '">';
    include "nav.php";
    print '<section class="content">';
    ?>
