<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="Author" content="Noah Clark">
    <title>5e Character Generator</title>

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

    <?php
        // Class for the generated character
        class Character {
            public $raceName;
            public $statBonus;
            public $className;
            public $classDesc;
            public $hitDie;
            public $primaryAbility;
            public $savingThrows;
            public $backgroundName;
            public $backgroundFeature;
            public $abilityScoreArray;

            // Setters for each property
            function setRaceName($raceName) {
                $this->raceName = $raceName;
            }
            function setStatBonus($statBonus) {
                $this->statBonus = $statBonus;
            }
            function setClassName($className) {
                $this->className = $className;
            }
            function setClassDesc($classDesc) {
                $this->classDesc = $classDesc;
            }
            function setHitDie($hitDie) {
                $this->hitDie = $hitDie;
            }
            function setPrimaryAbility($primaryAbility) {
                $this->primaryAbility = $primaryAbility;
            }
            function setSavingThrows($savingThrows) {
                $this->savingThrows = $savingThrows;
            }
            function setBackgroundName($backgroundName) {
                $this->backgroundName = $backgroundName;
            }
            function setBackgroundFeature($backgroundFeature) {
                $this->backgroundFeature = $backgroundFeature;
            }
            function setAbilityScoreArray($abilityScoreArray) {
                $this->abilityScoreArray = $abilityScoreArray;
            }

            // Getters for each property
            function getRaceName() {
                return $this->raceName;
            }
            function getStatBonus() {
                return $this->statBonus;
            }
            function getClassName() {
                return $this->className;
            }
            function getClassDesc() {
                return $this->classDesc;
            }
            function getHitDie() {
                return $this->hitDie;
            }
            function getPrimaryAbility() {
                return $this->primaryAbility;
            }
            function getSavingThrows() {
                return $this->savingThrows;
            }
            function getBackgroundName() {
                return $this->backgroundName;
            }
            function getBackgroundFeature() {
                return $this->backgroundFeature;
            }
            function getAbilityScoreArray() {
                return $this->abilityScoreArray;
            }
        }
    ?>
</head>

<body>
    <?php include "database/dbConnect.php"; ?>
    <header>
        <h1>Dungeons and Dragons Fifth Edition Character Generator</h1>
        <ul>
            <li class="active"><a href="5eCharGen.php">Home</a></li>
            <li><a href="contactPage.php">Contact</a></li>
            <li><a href="adminLogin.php">Admin Login</a></li>
        </ul>
    </header>

    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Gets maximum for use in randomization
            $stmtRace = $conn->prepare("SELECT * FROM races");
            $stmtRace->execute();
            $stmtClass = $conn->prepare("SELECT * FROM classes");
            $stmtClass->execute();
            $stmtBack = $conn->prepare("SELECT * FROM backgrounds");
            $stmtBack->execute();

            // The following variables are used to select random records from the database, and is dynamic if more records are added to the tables
            $raceMax = $stmtRace->rowCount();
            $classMax = $stmtClass->rowCount();
            $backMax = $stmtBack->rowCount();

            // Selects a random record to be displayed later in the page
            $stmtRace = $conn->prepare("SELECT * FROM races WHERE raceID=". rand(1,$raceMax));
            $stmtRace->execute();
            $stmtClass = $conn->prepare("SELECT * FROM classes WHERE classID=". rand(1,$classMax));
            $stmtClass->execute();
            $stmtBack = $conn->prepare("SELECT * FROM backgrounds WHERE backgroundID=". rand(1,$backMax));
            $stmtBack->execute();

            $resultRace = $stmtRace->fetch(PDO::FETCH_ASSOC);
            $resultClass = $stmtClass->fetch(PDO::FETCH_ASSOC);
            $resultBack = $stmtBack->fetch(PDO::FETCH_ASSOC);

            // Generates ability score array
            $abilityScores = " ";
            for ($x = 0; $x < 6; $x++){
                // Rolls four d6s
                $roll = array(rand(1,6), rand(1,6), rand(1,6), rand(1,6));
                
                // Identifies lowest roll
                $lowRoll = min($roll);

                // This value will be set to true when the lowest roll is processed, in the event that a low number was rolled twice, ie the user rolled 3, 4, 3, and 5, only the first 3 will be ignored
                $dupe = true;

                for($d = 0; $d < 4; $d++){
                    if($roll[$d] == $lowRoll && $dupe){
                        $roll[$d] = 0;
                        $dupe = false;
                    }
                }
                $abilityScores .= array_sum($roll) . " | ";
            }

            // Creates the character to be sent to user
            $character = new Character();    
            $character->setRaceName($resultRace['raceName']);
            $character->setStatBonus($resultRace['statBonus']);
            $character->setClassName($resultClass['className']);
            $character->setClassDesc($resultClass['classDesc']);
            $character->setHitDie($resultClass['hitDie']);
            $character->setPrimaryAbility($resultClass['primaryAbility']);
            $character->setSavingThrows($resultClass['savingThrows']);
            $character->setBackgroundName($resultBack['backgroundName']);
            $character->setBackgroundFeature($resultBack['backgroundFeature']);
            $character->setAbilityScoreArray($abilityScores);
        }
    ?>

    <section>
        <h3>Click this button to generate a character!</h3>
        <form id="charGen" name="charGen" method="post" action="5eCharGen.php">
            <input type="submit" class="button" id="button" name="button" value="Generate Character">
        </form>
        <br>
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Outputs the randomly selected records
            echo "<p> Race: ", $character->getRaceName(), "<br>";
            echo "Stat Bonus: ", $character->getStatBonus(), "<br>";
            echo "Class: ", $character->getClassName(), "<br>";
            echo "Description: ", $character->getClassDesc(), "<br>";
            echo "Hit Dice: ", $character->getHitDie(), "<br>";
            echo "Primary Ability: ", $character->getPrimaryAbility(), "<br>";
            echo "Saving Throws: ", $character->getSavingThrows(), "<br>";
            echo "Background: ", $character->getBackgroundName(), "<br>";
            echo "Feature: ", $character->getBackgroundFeature(), "<br>";
            echo "Ability Score Array:", $character->getAbilityScoreArray(), "</p>";
        } ?>
    </section>

    <footer>
        <h4><i>© <?php echo date("Y"); ?> </i></h4>
    </footer>
</body>
</html>