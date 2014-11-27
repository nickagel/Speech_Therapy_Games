<?php
/* the purpose of this page is to accept the hashed date joined and primary key  
 * as passed into this page in the GET format.
 * 
 * I retrieve the date joined from the table for this person and verify that 
 * they are the same. After which i update the confirmed field and acknowlege 
 * to the user they were successful. Then i send an email to the system admin 
 * to approve their membership 
 * 
 * Written By: Robert Erickson robert.erickson@uvm.edu
 * Last updated on: October 17, 2014
 * 
 * 
 */

include "bin/top.php";

print '<article id="main">';

print '<h1>Approve Confirmation</h1>';

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// variables for the classroom purposes to help find errors.
$debug = false;
if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
    $debug = true;
}
if ($debug)
    print "<p>DEBUG MODE IS ON</p>";
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%

$adminEmail = "nagel@uvm.edu";
$message = "<p>I am sorry but this project cannot be confrimed at this time. Please call (802) 656-1234 for help in resolving this matter.</p>";


//##############################################################
//
// SECTION: 2 
// 
// process request

if (isset($_GET["q"])) {
    $key1 = htmlentities($_GET["q"], ENT_QUOTES, "UTF-8");

    $data = array($key1);
    //##############################################################
    // get the membership record 

    $query = "SELECT fldDateJoined, fldEmail FROM tblUser WHERE fldCrypt = ? ";
    $results = $thisDatabase->select($query, $data);

    $dateSubmitted = $results[0]["fldDateJoined"];
    $email = $results[0]["fldEmail"];

    $k1 = sha1($dateSubmitted);

    if ($debug) {
        print "<p>Date: " . $dateSubmitted;
        print "<p>email: " . $email;
        print "<p><pre>";
        print_r($results);
        print "</pre></p>";
        print "<p>k1: " . $k1;
        print "<p>q : " . $key1;
    }
    //##############################################################
    // update confirmed
    
        if ($debug)
            print "<h1>Confirmed</h1>";

        $query = "UPDATE tblUser set fldApproved=1 WHERE fldCrypt = ? ";
        $results = $thisDatabase->update($query, $data);

        if ($debug) {
            print "<p>Query: " . $query;
            print "<p><pre>";
            print_r($results);
            print_r($data);
            print "</pre></p>";
        }
        $message = '<h2>The following Registration has been Approved. You may now log in and enjoy Speech Therapy</h2>';

        if ($debug)
            print "<p>" . $message;

        $to = $email;
        $cc = "";
        $bcc = "";
        $from = "Speech Therapy";
        $subject = "Account Approved";

        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);

        if ($debug) {
            print "<p>";
            if (!$mailed) {
                print "NOT ";
            }
            print "mailed to admin ". $to . ".</p>";
        }
        $message = '<h2>Succesfully confirmed '. $email.'</h2>'
                . '<p>If you did not confirm this user please contact IT ASAP</p>';

        if ($debug)
            print "<p>" . $message;

        $to = $adminEmail;
        $cc = "";
        $bcc = "";
        $from = "Speech Therapy";
        $subject = "New Membership Confirmed: Approved!";

        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);

        if ($debug) {
            print "<p>";
            if (!$mailed) {
                print "NOT ";
            }
            print "mailed to admin ". $to . ".</p>";
        }

        
   
    
    
} // ends isset get q
?>



<?php
include "bin/footer.php";
if ($debug)
    print "<p>END OF PROCESSING</p>";
?>
</article>
</body>
</html>

