<?php

// http://www.tonymarston.net/php-mysql/3-tier-architecture.html

class myDatabase {

    var $db;

    public function __construct($dbUserName,$whichPass,$dbName) {
        $this->db = null;
        $this->connect($dbUserName,$whichPass,$dbName);
    }

    function connect($dbUserName,$whichPass,$dbName) {
        require_once("bin/pass.php");

        $debugMe = false;

        switch ($whichPass){
        case "a":
            $dbUserPass = $dbAdmin;
            break;
        case "r":
            $dbUserPass = $dbReader;
            break;
        case "w":
            $dbUserPass = $dbWriter;
            break;
        }
        $query = NULL;

        $dsn = 'mysql:host=webdb.uvm.edu;dbname=';

        if ($debugMe) {
            print "<p>Username: " . $dbUserName;
            print "<p>DSN: " . $dsn . $dbName;
        }

        try {
            if (!$this->db)
                $this->db = new PDO($dsn . $dbName, $dbUserName, $dbUserPass);
            if (!$this->db) {
                return 0;
            } else {
                return $this->db;
            }

            if ($debugMe)
                echo '<p>A You are connected to the database!</p>';
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            if ($debugMe)
                echo "<p>A An error occurred while connecting to the database: $error_message </p>";
        }
        return $this->db;
    }

    /* ############################################################################
     * returns the number of records that matched the query */
    function numRows($query, $values = "") {

        $debugMe = false;

        if ($debugMe) {
            print "<p>myDatabase.php->numRows " . $query . "values= ";
            print_r($values);
            print "</pre></p>";
        }

        $statement = $this->db->prepare($query);

        if (is_array($values)) {
            $statement->execute($values);
        } else {
            $statement->execute();
        }

        $recordSet = $statement->fetchAll();

        if ($debugMe) {
            print "<p>database.php->numRows<p><pre> ";
            print_r($recordSet);
            print "</pre></p>";
        }

        $statement->closeCursor();

        return count($recordSet);
    }

    /* ############################################################################
     *  performs a select query and returns the array */
    function select($query, $values = "") {

        $debugMe = false;

        if ($debugMe) {
            print "<p>myDatabase.php->select " . $query . "values= ";
            print_r($values);
            print "</pre></p>";
        }

        $statement = $this->db->prepare($query);

        if (is_array($values)) {
            $statement->execute($values);
        } else {
            $statement->execute();
        }

        $recordSet = $statement->fetchAll();

        if ($debugMe) {
            print "<p>database.php->select<p><pre> ";
            print_r($recordSet);
            print "</pre></p>";
        }

        $statement->closeCursor();

        return $recordSet;
    }

//############################################################################
    function insert($query, $values = "") {

        $debugMe = false;
        $success = false;
        
        if ($debugMe) {
            print "<p>myDatabase.php->insert " . $query . "values= ";
            print_r($values);
            print "</p>";
        }

        $statement = $this->db->prepare($query);

        if (is_array($values)) {
            $success = $statement->execute($values);
        } else {
            $success = $statement->execute();
        }

        if ($debugMe) {
            print "<p>database.php->insert<p>" . $success . "</p>";
        }

        $statement->closeCursor();

        return $success;
    }

    /* ############################################################################
     */

    function lastInsert() {

        $debugMe = false;

        $query = "SELECT LAST_INSERT_ID()";

        if ($debugMe)
            print "<p>database.php->lastInsert " . $query;

        $statement = $this->db->prepare($query);

        $statement->execute();

        $recordSet = $statement->fetchAll();

        if ($debugMe) {
            print "<p>database.php->last insert<p><pre> ";
            print_r($recordSet);
            print "</p>";
        }

        $statement->closeCursor();

        if ($recordSet)
            return $recordSet[0]["LAST_INSERT_ID()"];
        
        return -1;
    }

    /* ############################################################################
     */
    function update($query, $values = "") {

        $debugMe = false;
        $success = false;

        if ($debugMe) {
            print "<p>myDatabase.php->update " . $query . "values= ";
            print_r($values);
            print "</p>";
        }
            $statement = $this->db->prepare($query);

            if (is_array($values)) {
                $success = $statement->execute($values);
            } else {
                $success = $statement->execute();
            }

            if ($debugMe) {
                print "<p>database.php->update<p>" . $success . "</p>";
            }

            $statement->closeCursor();

            return $success;
        
    }

    /* ############################################################################
     */
    function delete($query, $values = "") {

        $debugMe = false;
        $success = false;
        if ($debugMe)
            print "<p>database.php->delete " . $query;

        $statement = $this->db->prepare($query);

        if (is_array($values)) {
            $success = $statement->execute($values);
        } else {
            $success = $statement->execute();
        }

        if ($debugMe) {
            print "<p>database.php->delete<p>" . $success . "</p>";
        }

        $statement->closeCursor();

        return $success;
    }

} // end class
?>
