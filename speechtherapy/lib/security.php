<?php

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//performs a few security checks
function securityCheck($form = false) {
    
    $status = true; // start off thinking everything is good until a test fails
    $debug = false; 
    
    // when it is a form page check to make sure it submitted to itself
    if ($form) {
        // globals defined in top.php
        global $yourURL;

        $fromPage = htmlentities($_SERVER['HTTP_REFERER'], ENT_QUOTES, "UTF-8");

        if ($debug)
            print "<p>From: " . $fromPage . " should match your Url: " . $yourURL;

        if ($fromPage != $yourURL) {
            $status = false;
        }
    }

    return $status;
}

?>