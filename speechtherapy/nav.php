<nav>
    <ol>
        <?php
        print "<li>".include('header.php')."</li>";
        if ($path_parts['filename'] == "index") {
            print '<li class="activePage">About</li>';
        } else {
            print '<li><a href="index.php">About</a></li>';
        }
        if ($path_parts['filename'] == "form") {
            print '<li class="activePage">Join</li>';
        } else {
            print '<li><a href="form.php">Join</a></li>';
        }
        if ($path_parts['filename'] == "match") {
            print '<li class="activePage">Match</li>';
        } else {
            print '<li><a href="match.php">Match</a></li>';
        }
        if ($path_parts['filename'] == "bingo") {
            print '<li class="activePage">Bingo</li>';
        } else {
            print '<li><a href="bingo.php">Bingo</a></li>';
        }
        if (!($loggedIn)) {
            if ($path_parts['filename'] == "logIn") {
                print '<li class="activePage">Log In</li>';
            } else {
                print '<li><a href="logIn.php">Log In</a></li>';
            }
            if ($path_parts['filename'] == "signUp") {
                print '<li class="activePage">Sign Up</li>';
            } else {
                print '<li><a href="signUp.php">Sign Up</a></li>';
            }
        } else {
            print "<li>" . $user . "</li>";
            print "<script>";
            print "<li><a href='javascript:history.go(0)'>Click to refresh the page</a></li>";
            print"</script>";
        }
        if ($adminStatus) {
            if ($path_parts['filename'] == "students") {
                print '<li class="activePage">Students</li>';
            } else {
                print '<li><a href="students.php">Students</a></li>';
            }
            if ($path_parts['filename'] == "update") {
                print '<li class="activePage">Update</li>';
            } else {
                print '<li><a href="update.php">Update</a></li>';
            }
        }
        ?>
    </ol>
</nav>