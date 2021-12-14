<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="Author" content="Noah Clark">
    <title>View Data</title>

    <style>
        body {
            background-color: #866743;
        }
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #2c988d;
        }

        li {
            float: left;
            border-right:1px solid #bbb;
        }

        li a {
            display: block;
            color: black;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover:not(.active) {
            background-color: #dcd2d3;
        }

        .active {
            background-color: #fcf7f5;
        }

        .button {
            background-color: #2c988d;
            border: none;
            color: black;
            padding: 15px 32px;
            text-align: center;
            display: inline-block;
            font-size: 16px;
        }

        p {
            font-size: 18px;
        }
        
        table {
            border: solid 1px black;
        }
    </style>

    <?php
        include "database/dbConnect.php";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $sql;
            if (!empty($_POST['phone'])) {
                echo '<script>parent.window.location.reload(true);</script>';
            } else if(isset($_POST['deleteItem1']) && is_numeric($_POST['deleteItem1'])){
                $sql = "DELETE FROM `races` WHERE `raceID`='". $_POST['deleteItem1']. "'";
            } else if(isset($_POST['deleteItem2']) && is_numeric($_POST['deleteItem2'])) {
                $sql = "DELETE FROM `classes` WHERE `classID`='". $_POST['deleteItem2']. "'";
            } else if(isset($_POST['deleteItem3']) && is_numeric($_POST['deleteItem3'])) {
                $sql = "DELETE FROM `backgrounds` WHERE `backgroundID`='". $_POST['deleteItem3']. "'";
            }

            $delete = $conn->prepare($sql);
            $delete->execute();
            
        }

        $stmtRace = $conn->prepare("SELECT * FROM races");
        $stmtRace->execute();
        $resultRace = $stmtRace->setFetchMode(PDO::FETCH_ASSOC);
        $stmtClass = $conn->prepare("SELECT * FROM classes");
        $stmtClass->execute();
        $resultClass = $stmtClass->setFetchMode(PDO::FETCH_ASSOC);
        $stmtBack = $conn->prepare("SELECT * FROM backgrounds");
        $stmtBack->execute();
        $resultBack = $stmtBack->setFetchMode(PDO::FETCH_ASSOC);
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
        <input type="text" name="phone" id="phone" style="display:none !important" tableindex="-1" autocomplete="off" value="0" required>
    <?php 

        // Outputs Race table
        echo "<table>";
        echo "<tr><th>ID</th><th>Race Name</th><th>Stat Bonus</th><th>Delete?</th></tr>";
        foreach($stmtRace->fetchAll() as $x){
            echo "<tr><td>". $x['raceID']. "</td><td>". $x['raceName'] . "</td><td>". $x['statBonus']. "</td><td><button type='submit' class='button' name='deleteItem1' value='".$x['raceID']."' />Delete</button></td></tr>";
        }
        echo "</table>";

        // Outputs Class table
        echo "<table>";
        echo "<tr><th>ID</th><th>Class Name</th><th>Class Description</th><th>Hit Die</th><th>Primary Ability</th><th>Saving Throws</th><th>Delete?</th></tr>";
        foreach($stmtClass->fetchAll() as $x){
            echo "<tr><td>". $x['classID']. "</td><td>". $x['className'] . "</td><td>". $x['classDesc']. "</td><td>". $x['hitDie']. "</td><td>". $x['primaryAbility']. "</td><td>". $x['savingThrows']. "</td><td><button class='button' type='submit' name='deleteItem2' value='".$x['classID']."' />Delete</button></td></tr>";
        }
        echo "</table>";

        // Outputs Background table
        echo "<table>";
        echo "<tr><th>ID</th><th>Background</th><th>Feature</th><th>Delete?</th></tr>";
        foreach($stmtBack->fetchAll() as $x){
            echo "<tr><td>". $x['backgroundID']. "</td><td>". $x['backgroundName'] . "</td><td>". $x['backgroundFeature']. "</td><td><button type='submit' name='deleteItem3' value='".$x['backgroundID']."' />Delete</button></td></tr>";
        }
        echo "</table>";
    ?>
    </form>

    <footer>
        <h4><i>© <?php echo date("Y"); ?> </i></h4>
    </footer>
</body>
</html>