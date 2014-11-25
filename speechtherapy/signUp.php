<?php
include "top.php";
/* the purpose of this page is to display a form to allow a person to register
 * the form will be sticky meaning if there is a mistake the data previously 
 * entered will be displayed again. Once a form is submitted (to this same page)
 * we first sanitize our data by replacing html codes with the html character.
 * then we check to see if the data is valid. if data is valid enter the data 
 * into the table and we send and dispplay a confirmation email message. 
 * 
 * if the data is incorrect we flag the errors.
 * 
 * Written By: Robert Erickson robert.erickson@uvm.edu
 * Last updated on: October 17, 2014
 * 
 * 
  -- --------------------------------------------------------
  --
  -- Table structure for table `tblRegister`
  --

  CREATE TABLE IF NOT EXISTS `tblRegister` (
  `pmkRegisterId` int(11) NOT NULL AUTO_INCREMENT,
  `fldEmail` varchar(65) DEFAULT NULL,
  `fldDateJoined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fldConfirmed` tinyint(1) NOT NULL DEFAULT '0',
  `fldApproved` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pmkRegisterId`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

 * I am using a surrogate key for demonstration, 
 * email would make a good primary key as well which would prevent someone
 * from entering an email address in more than one record.
 */


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
//
// SECTION: 1b Security
//
// define security variable to be used in SECTION 2a.
$yourURL = $domain . $phpSelf;

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
//
// Initialize variables one for each form element
// in the order they appear on the form
$email = "";
$username = "";
$fName = "";
$lName = "";
$match =false;
$bingo = true;
$both=false;
$grade="none";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$emailERROR = false;
$usernameERROR = false;
$lNameERROR = false;
$fNameERROR = false;
$gradeERROR = false;
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();

// used for building email message to be sent and displayed
$mailed = false;
$messageA = "";
$messageB = "";
$messageC = "";

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2a Security
//
    if (!securityCheck(true)) {
        $msg = "<p>Sorry you cannot access this page. ";
        $msg.= "Security breach detected and reported</p>";
        die($msg);
    }

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2b Sanitize (clean) data
// remove any potential JavaScript or html code from users input on the
// form. Note it is best to follow the same order as declared in section 1c.

    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $username = htmlentities($_POST["txtUsername"], ENT_QUOTES, "UTF-8");
    $fName = htmlentities($_POST["txtFName"], ENT_QUOTES, "UTF-8");
    $lName = htmlentities($_POST["txtLName"], ENT_QUOTES, "UTF-8");
    $bingo = htmlentities($_POST["chkBingo"],ENT_QUOTES,"UTF-8");
    $match = htmlentities($_POST["chkMatch"],ENT_QUOTES,"UTF-8");
    $both = htmlentities($_POST["chkBoth"],ENT_QUOTES,"UTF-8");
    $gender = htmlentities($_POST["radGender"],ENT_QUOTES,"UTF-8");
    $grade = htmlentities($_POST["lstGrade"],ENT_QUOTES,"UTF-8");

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2c Validation
//
// Validation section. Check each value for possible errors, empty or
// not what we expect. You will need an IF block for each element you will
// check (see above section 1c and 1d). The if blocks should also be in the
// order that the elements appear on your form so that the error messages
// will be in the order they appear. errorMsg will be displayed on the form
// see section 3b. The error flag ($emailERROR) will be used in section 3c.


    if ($username == "") {
        $errorMsg[] = "Please enter last name";
        $usernameERROR = true;
    } elseif (!verifyAlphaNum($username)) {
        $errorMsg[] = "Your last name address appears to be incorrect.";
        $usernameERROR = true;
    }
    if ($fName == "") {
        $errorMsg[] = "Please enter first name";
        $fNameERROR = true;
    } elseif (!verifyAlphaNum($fName)) {
        $errorMsg[] = "Your first name address appears to be incorrect.";
        $fNameERROR = true;
    }
    if ($lName == "") {
        $errorMsg[] = "Please enter username";
        $lNameERROR = true;
    } elseif (!verifyAlphaNum($lName)) {
        $errorMsg[] = "Your username address appears to be incorrect.";
        $lNameERROR = true;
    }
    if ($email == "") {
        $errorMsg[] = "Please enter your email address";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = "Your email address appears to be incorrect.";
        $emailERROR = true;
    }
    
    if(isset($_POST["chkBingo"])) {
        $bingo  = true;
    }else{
        $bingo  = false;
    }

    if(isset($_POST["chkMatch"])) {
        $match  = true;
    }else{
        $match  = false;
    }
    if(isset($_POST["chkBoth"])){
        $both=true;
    }else{
        $both=false;
    }
    
    if($grade=="NONE"){
        $errorMsg[]="Please select a valid grade level";
        $gradeERROR=true;
    } 
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2d Process Form - Passed Validation
//
// Process for when the form passes validation (the errorMsg array is empty)
//
    if (!$errorMsg) {
        if ($debug)
            print "<p>Form is valid</p>";

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2e Save Data
        //

        $primaryKey = "";
        $dataEntered = false;
        try {
            $thisDatabase->db->beginTransaction();
            $query = 'INSERT INTO tblRegister SET fldEmail = ?, fldUserName = ?';
            $data = array($email, $userName);
            if ($debug) {
                print "<p>sql " . $query;
                print"<p><pre>";
                print_r($data);
                print"</pre></p>";
            }
            $results = $thisDatabase->insert($query, $data);

            $primaryKey = $thisDatabase->lastInsert();
            if ($debug)
                print "<p>pmk= " . $primaryKey;

// all sql statements are done so lets commit to our changes
            $dataEntered = $thisDatabase->db->commit();
            $dataEntered = true;
            if ($debug)
                print "<p>transaction complete ";
        } catch (PDOExecption $e) {
            $thisDatabase->db->rollback();
            if ($debug)
                print "Error!: " . $e->getMessage() . "</br>";
            $errorMsg[] = "There was a problem with accpeting your data please contact us directly.";
        }
        // If the transaction was successful, give success message
        if ($dataEntered) {
            if ($debug)
                print "<p>data entered now prepare keys ";
            //#################################################################
            // create a key value for confirmation

            $query = "SELECT fldDateJoined FROM tblRegister WHERE pmkRegisterId=" . $primaryKey;
            $results = $thisDatabase->select($query);

            $dateSubmitted = $results[0]["fldDateJoined"];

            $key1 = sha1($dateSubmitted);
            $key2 = $primaryKey;

            if ($debug)
                print "<p>key 1: " . $key1;
            if ($debug)
                print "<p>key 2: " . $key2;


            //#################################################################
            //
            //Put forms information into a variable to print on the screen
            //

            $messageA = '<h2>Thank you for registering.</h2>';

            $messageB = "<p>Click this link to confirm your registration: ";
            $messageB .= '<a href="' . $domain . $path_parts["dirname"] . '/confirmation.php?q=' . $key1 . '&amp;w=' . $key2 . '">Confirm Registration</a></p>';
            $messageB .= "<p>or copy and paste this url into a web browser: ";
            $messageB .= $domain . $path_parts["dirname"] . '/confirmation.php?q=' . $key1 . '&amp;w=' . $key2 . "</p>";

            $messageC .= "<p><b>Email Address:</b><i>   " . $email . "</i></p>";

            //##############################################################
            //
            // email the form's information
            //
            $to = $email; // the person who filled out the form
            $cc = "";
            $bcc = "";
            $from = " Crud";
            $subject = "CS 148 registration";

            $mailed = sendMail($to, $cc, $bcc, $from, $subject, $messageA . $messageB . $messageC);
        } //data entered  
    } // end form is valid
} // ends if form was submitted.
//#############################################################################
//
// SECTION 3 Display Form
//
?>
<article id="main">
    <?php
//####################################
//
// SECTION 3a.
//
//
//
//
// If its the first time coming to the form or there are errors we are going
// to display the form.
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
        print "<h1>Your Request has ";
        if (!$mailed) {
            print "not ";
        }
        print "been processed</h1>";
        print "<p>A copy of this message has ";
        if (!$mailed) {
            print "not ";
        }
        print "been sent</p>";
        print "<p>To: " . $email . "</p>";
        print "<p>Mail Message:</p>";
        print $messageA . $messageC;
    } else {
//####################################
//
// SECTION 3b Error Messages
//
// display any error messages before we print out the form
        if ($errorMsg) {
            print '<div id="errors">';
            print "<ol>\n";
            foreach ($errorMsg as $err) {
                print "<li>" . $err . "</li>\n";
            }
            print "</ol>\n";
            print '</div>';
        }
//####################################
//
// SECTION 3c html Form
//
        /* Display the HTML form. note that the action is to this same page. $phpSelf
          is defined in top.php
          NOTE the line:
          value="<?php print $email; ?>
          this makes the form sticky by displaying either the initial default value (line 35)
          or the value they typed in (line 84)
          NOTE this line:
          <?php if($emailERROR) print 'class="mistake"'; ?>
          this prints out a css class so that we can highlight the background etc. to
          make it stand out that a mistake happened here.
         */
        ?>
        <form action="<?php print $phpSelf; ?>"
              method="post"
              id="frmRegister">
            <fieldset class="wrapper">
                <legend>Register Today</legend>
                <p>You will find Peace ...</p>
                <fieldset class="wrapperTwo">
                    <legend>Please complete the following form</legend>
                    <fieldset class="contact">
                        <legend>Contact Information</legend>

                        <label for="txtEmail" class="required">Email
                            <input type="text" id="txtEmail" name="txtEmail"
                                   value="<?php print $email; ?>"
                                   maxlength="45" placeholder="Enter a valid email address"
                                   <?php if ($emailERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()" 
                                   autofocus>
                        </label>
                        <label for="txtUsername" class="required">Username
                            <input type="text" id="txtUsername" name="txtUsername"
                                   value="<?php print $username; ?>"
                                   maxlength="45" placeholder="Enter a valid username address"
                                   <?php if ($usernameERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()" 
                                   autofocus>
                        </label>
                        <label for="txtFName" class="required">First Name
                            <input type="text" id="txtFName" name="txtFName"
                                   value="<?php print $fName; ?>"
                                   maxlength="45" placeholder="Enter a valid First name"
                                   <?php if ($fNameERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()" 
                                   autofocus>
                        </label>
                        <label for="txtLName" class="required">Last Name
                            <input type="text" id="txtLName" name="txtLName"
                                   value="<?php print $lName; ?>"
                                   maxlength="45" placeholder="Enter a valid Last name"
                                   <?php if ($lNameERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()" 
                                   autofocus>
                        </label>
                    </fieldset> <!-- ends contact -->
                    <fieldset>
                        <label for="lstGrade" >Grade
                            <select <?php if ($gradeERROR) print 'class="mistake"'; ?>
                                id="lstGrade"
                                    name="lstGrade"
                                    tabindex="600" onfocus="this.select()" autofocus >
                                <option value="NONE"> - </option>
                                <option value="KIND">Kindergarten</option>
                                <option value="FIRST">1st</option>
                                <option value="SECOND">2nd</option>
                                <option value="THIRD">3rd</option>
                                <option value="FOURTH">4th</option>
                                <option value="FIFTH">5th</option>
                                <option value="SIXTH">6th</option>
                            </select></label>
                    </fieldset> 
                    <fieldset>
                        <fieldset class="radio">
                            <legend>What is your gender?</legend>
                            <div id="radio">
                                <label><input type="radio" id="radGenderMale" name="radGender" value="Male" tabindex="231"
                                              checked="checked" >Male</label>

                                <label><input type="radio" id="radGenderFemale" name="radGender" value="Female" tabindex="233"
                                              >Female</label>
                                <label><input type="radio" id="radGenderOther" name="radGender" value="Other" tabindex="233"
                                              >Other</label>
                            </div>
                        </fieldset>
                        <fieldset class="checkbox">
                            <legend>Favorite Game:</legend>
                            <div id="checkbox">
                                <label><input type="checkbox" id="chkBingo" name="chkBingo" value="Bingo" tabindex="221"
                                              checked="checked">Bingo</label>

                                <label><input type="checkbox" id="chkMatch" name="chkMatch" value="Match" tabindex="223"
                                              >Match</label>
                                <label><input type="checkbox" id="chkBoth" name="chkBoth" value="Both" tabindex="223"
                                              >Both</label>
                            </div>
                        </fieldset>
                        
                    </fieldset>
                </fieldset><!-- ends wrapper Two -->
                <fieldset class="buttons">
                    <legend></legend>
                    <input type="submit" id="btnSubmit" name="btnSubmit" value="Register" tabindex="900" class="button">
                </fieldset> <!-- ends buttons -->
            </fieldset> <!-- Ends Wrapper -->
        </form>
        <?php
    } // end body submit
    ?>
</article>



<?php
if ($debug)
    print "<p>END OF PROCESSING</p>";
include "footer.php";
?>