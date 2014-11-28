<?php
include "bin/top.php";
//security variables
$yourURL = $domain . $phpSelf;
$username = "";
$password = "";

$usernameERROR = false;
$passwordERROR = false;

$errorMsg = array();

if (isset($_POST["btnSubmit"])) {

    if (!securityCheck(true)) {
        $msg = "<p>Sorry you cannot access this page. ";
        $msg.= "Security breach detected and reported</p>";
        die($msg);
    }
    $username = htmlentities($_POST["txtUsername"], ENT_QUOTES, "UTF-8");
    $password = htmlentities($_POST["txtPassword"], ENT_QUOTES, "UTF-8");
    
    if ($username!="") {
        $query = "select pmkUsername from tblUser where pmkUsername='" . $username . "'";
        if (!($thisDatabase->select($query))) {
            $usernameERROR = true;
            $errorMsg[] = "This username doesn't exist";
        }
    } else {
        $usernameERROR = true;
        $errorMsg[] = "please enter a username";
    }

    if ($password != "") {
        $query = "select fldPassword from tblUser where fldPassword='" . $password . "'";
        if (!($thisDatabase->select($query))) {
            $passwordERROR = true;
            $errorMsg[] = "This password doesn't exist";
        }
    } else {
        $usernameERROR = true;
        $errorMsg[] = "please enter a username";
    }
    if (!$passwordERROR and ! $usernameERROR) {
        $query = "select pmkUsername, fldPassword from tblUser where fldPassword='" . $password . "' and pmkUsername='".$username."'";
        if (!($thisDatabase->select($query))) {
            $usernameERROR = true;
            $passwordERROR = true;
            $errorMsg[] = "The given password and username do not match";
        }
    }
}



if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) {
    echo "Login successful";
} else {
    foreach ($errorMsg as $message) {
        echo $message;
    }
    ?>
    <form action="<?php print $phpSelf; ?>"
          method="post"
          id="frmRegister">
        <fieldset class="wrapper">

            <label  for="txtUsername">Username
                <input type="text" id="txtUsername" name="txtUsername"
                       value="<?php print $username; ?>"
                       maxlength="45" placeholder="Enter a valid username address"
                       <?php if ($usernameERROR) print 'class="mistake"'; ?>
                       onfocus="this.select()" 
                       autofocus>
            </label>
            <label for="txtPassword" >Password
                <input type="password" id="txtPassword" name="txtPassword"
                       value="<?php print $password; ?>"
                       maxlength="45" placeholder="Enter a valid username address"
                       <?php if ($passwordERROR) print 'class="mistake"'; ?>
                       onfocus="this.select()" 
                       autofocus>
            </label>
        </fieldset>
        <fieldset class="buttons">
            <legend></legend>
            <input type="submit" id="btnSubmit" name="btnSubmit" value="Sign up" tabindex="900" class="button">
        </fieldset>
    </form>
    <?php
}
?>




<?php include "bin/footer.php";
?>