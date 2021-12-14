<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="Author" content="Noah Clark">
    <title>Add New Data</title>

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
    </style>
</head>
<body>
    <?php include "database/dbConnect.php"; ?>
    <header>
        <h1>Dungeons and Dragons Fifth Edition Character Generator</h2>
        <ul>
            <li><a href="5eCharGen.php">Home</a></li>
            <li><a href="contactPage.php">Contact</a></li>
            <li><a href="adminLogin.php">Admin Login</a></li>
        </ul>
    </header>

    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['phone'])) {
            echo '<script>parent.window.location.reload(true);</script>';
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Will build SQL statement to insert new data
            $sql;
            switch ($_POST['test']) {
                case "races":
                    $sql = "INSERT INTO `races` (`raceName`, `statBonus`) VALUES ('". $_POST['raceName']. "', '". $_POST['statBonus']. "')";
                    break;
                case "classes":
                    $sql = "INSERT INTO `classes` (`className`, `classDesc`, `hitDie`, `primaryAbility`, `savingThrows`) VALUES ('". $POST['className']. "', '". $_POST['classDesc']. "', '". $_POST['hitDie']. "', '". $_POST['primaryAbility']. "', '". $_POST['savingThrows']. "')";
                    break;
                case "backgrounds":
                    $sql = "INSERT INTO `backgrounds` (`backgroundName`, `backgroundFeature`) VALUES ('". $_POST['backName']. "', '". $_POST['backFeat']. "')";
                    break;
                default:
                    echo "Something went wrong";
            }
            $stmtRace = $conn->prepare($sql);
            $stmtRace->execute();
            echo "<p>Successfully added!</p>";
        }
    ?>

    <section>
        <!-- Adds record to Race Table -->
        <form id="raceForm" name="raceForm" method="post" action="addRecord.php">
            <h2>Add New Race</h2>
            <input type="text" name="test" id="test" hidden readonly value="races">
            <p>
                <label for="raceName">Race Name:</label>
                <input type="text" name="raceName" id="raceName" required>
            </p>
            <p>
                <label for="statBonus">Stat Bonus:</label>
                <input type="text" name="statBonus" id="statBonus" required>
            </p>
            <p>
                <input type="submit" class="button" name="button1" id="button1" value="Submit">
            </p>
            <input type="text" name="phone" id="phone" style="display:none !important" tableindex="-1" autocomplete="off" value="0" required>
        </form>

        <!-- Adds record to Class Table -->
        <form id="classForm" name="classForm" method="post" action="addRecord.php">
            <input type="text" name="test" id="test" hidden readonly value="classes">
            <h2>Add New Class</h2>
            <p>
                <label for="className">Class Name:</label>
                <input type="text" name="className" id="className" required>
            </p>
            <p>
                <label for="classDesc">Class Description:</label>
                <input type="text" name="classDesc" id="classDesc" required>
            </p>
            <p>
                <label for="hitDie">Hit Die:</label>
                <select name="hitDie" id="hitDie" required>
                    <option value="d6">d6</option>
                    <option value="d8">d8</option>
                    <option value="d10">d10</option>
                    <option value="d12">d12</option>
                    <option selected disabled hidden>d?</option>
                </select>
            </p>
            <p>
                <label for="primaryAbility">Primary Ability:</label>
                <input type="text" name="primaryAbility" id="primaryAbility" required>
            </p>
            <p>
                <label for="savingThrows">Saving Throws:</label>
                <input type="text" name="savingThrows" id="savingThrows" required>
            <p>
                <input type="submit" class="button" name="button2" id="button2" value="Submit">
            </p>
            <input type="text" name="phone" id="phone" style="display:none !important" tableindex="-1" autocomplete="off" value="0" required>
        </form>

        <!-- Adds record to Background Table -->
        <form id="backForm" name="backForm" method="post" action="addRecord.php">
            <input type="text" name="test" id="test" hidden readonly value="backgrounds">
            <h2>Add New Background</h2>
            <p>
                <label for="backName">Background Name:</label>
                <input type="text" name="backName" id="backName" required>
            </p>
            <p>
                <label for="backFeat">Background Feature:</label>
                <input type="text" name="backFeat" id="backFeat" required>
            </p>
            <p>
                <input type="submit" class="button" name="button3" id="button3" value="Submit">
            </p>
            <input type="text" name="phone" id="phone" style="display:none !important" tableindex="-1" autocomplete="off" value="0" required>
        </form>
    </section>

    <footer>
        <h4><i>© <?php echo date("Y"); ?> </i></h4>
    </footer>
</body>