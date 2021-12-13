<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="Author" content="Noah Clark">
    <title>Admin Login</title>

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
        $stmt = $conn->prepare("SELECT * FROM admin WHERE adminID='1'");
        $stmt->execute();
        $login = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>

    <section>
        <form id="login" name="login" method="post" action="adminLogin.php">
            <?php if ($_SERVER['REQUEST_METHOD'] !== 'POST') { ?>
                <h3>Admin Login</h3>
                <p>
                    <label for="username">Username: </label>
                    <input type="text" name="username" id="username" required>
                </p>
                <p>
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" required>
                </p>
                <p>
                    <input type="submit" name="button" id="button" value="Submit">
                </p>
                <input type="text" name="phone" id="phone" style="display:none !important" tableindex="-1" autocomplete="off" value="0" required>
            <?php } else if (!empty($_POST['phone'])) { ?>
                <h4 style="text-color:red">Access Denied</h4>
                <button onClick="window.location.reload();">Refresh Page</button>
            <?php } else {
                if ($_POST['username'] == $login['username'] && $_POST['password'] == $login['password']) { ?>
                    <h3>Welcome Admin!</h3>
                    <p>- <a href="addRecord.php">Add Data</a></p>
                    <p>- <a href="viewData.php">View Data</a></p>
                <?php } else { ?>
                    <h4 style="text-color:red">Access Denied</h4>
                    <button onClick="window.location.reload();">Refresh Page</button>
                <?php }
            } 
            ?>
        </form>
    </section>

    <footer>
        <h4><i>© <?php echo date("Y"); ?> </i></h4>
    </footer>
</body>