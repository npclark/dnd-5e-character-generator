<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="Author" content="Noah Clark">
    <title>Add Data</title>

    <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #dddddd;
        }

        li {
            float: left;
        }

        li a {
            display: block;
            padding: 8px;
        }
        table {
            border: solid 1px black;
        }
    </style>

    <?php
        include "database/dbConnect.php";

        $stmtRace = $conn->prepare("SELECT * FROM races");
        $stmtRace->execute();
        $resultRace = $stmtRace->setFetchMode(PDO::FETCH_ASSOC);
        $stmtClass = $conn->prepare("SELECT * FROM classes");
        $stmtClass->execute();
        $resultClass = $stmtClass->setFetchMode(PDO::FETCH_ASSOC);
        $stmtBack = $conn->prepare("SELECT * FROM backgrounds");
        $stmtBack->execute();
        $resultBack = $stmtBack->setFetchMode(PDO::FETCH_ASSOC);

        // Creates table output
        class TableRows extends RecursiveIteratorIterator {
            function _construct($it) {
                parent::_construct($it, self::LEAVES_ONLY);
            }

            function current() {
                return "<td>" . parent::current(). "</td>";
            }

            function beginChildren(){
                echo "<tr>";
            }

            function endChildren(){
                echo '</tr>' . "\n";
            }
        }
    ?>
</head>
<body>
    <header>
        <h1>Dungeons and Dragons Fifth Edition Character Generator</h1>
        <ul>
            <li><a href="5eCharGen.php">Home</a></li>
            <li><a href="contactPage.php">Contact</a></li>
            <li><a href="adminLogin.php">Admin Login</a></li>
        </ul>
    </header>

    <form action="" method="post">
    <?php 

        // Outputs Race table
        echo "<table>";
        echo "<tr><th>ID</th><th>Race Name</th><th>Stat Bonus</th></tr>";
        foreach(new TableRows(new RecursiveArrayIterator($stmtRace->fetchAll())) as $k=>$v){
            echo $v;
        }
        echo "</table>";
        
        // Outputs Class table
        echo "<table>";
        echo "<tr><th>ID</th><th>Class Name</th><th>Class Description</th><th>Hit Die</th><th>Primary Ability</th><th>Saving Throws</th></tr>";
        foreach(new TableRows(new RecursiveArrayIterator($stmtClass->fetchAll())) as $k=>$v){
            echo $v;
        }
        echo "</table>";

        // Outputs Background table
        echo "<table>";
        echo "<tr><th>ID</th><th>Background Name</th><th>Background Feature</th></tr>";
        foreach(new TableRows(new RecursiveArrayIterator($stmtBack->fetchAll())) as $k=>$v){
            echo $v;
        }
        echo "</table>";
    ?>
    </form>

    <footer>
        <h4><i>© <?php echo date("Y"); ?> </i></h4>
    </footer>
</body>
</html>