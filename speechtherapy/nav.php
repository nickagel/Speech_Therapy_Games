<nav>
    <ol>
        <li id="logo"><a  id='header' href='index.php'><img alt="logo" src="logo/transparent.png">
                <strong>Speech</strong><span> Therapy</span></a></li>
        <?php
        if ($path_parts['filename'] == "index") {
            print '<li class="activePage">About</li>';
        } else {
            print '<li><a href="index.php">About</a></li>';
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
        if (!empty($_SESSION['logStatus']) and $_SESSION["logStatus"]) {
            if ($path_parts['filename'] == "Homework") {
                print '<li class="activePage">Homework</li>';
            } else {
                print '<li><a href="homework.php">Homework</a></li>';
            }
            print "<li>USER: " . $_SESSION['user'] . "</li>\n";
            print '<li><a href="logIn.php">Log out</a></li>';
        } else {
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
            
        }
        if ($adminStatus) {
            if ($path_parts['filename'] == "update") {
                print '<li class="activePage">Update</li>';
            } else {
                print '<li><a href="update.php">Update</a></li>';
            }
            if ($path_parts['filename'] == "students") {
                print '<li class="activePage">Students</li>';
            } else {
                print '<li><a href="students.php">Students</a></li>';
            }
        }
        ?>
    </ol>
</nav>