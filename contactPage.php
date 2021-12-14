<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="Author" content="Noah Clark">
    <title>Reach out to me</title>

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
    <header>
        <h1>Dungeons and Dragons Fifth Edition Character Generator</h2>
        <ul>
            <li><a href="5eCharGen.php">Home</a></li>
            <li class="active"><a href="contactPage.php">Contact</a></li>
            <li><a href="adminLogin.php">Admin Login</a></li>
        </ul>
    </header>

    <section>
        <h3>Contact Page</h3>
        <?php if ($_SERVER['REQUEST_METHOD'] !== 'POST') { ?>
            <p>Please enter your full name and email to contact me!</p>
            <form id="contactForm" name="contactForm" method="post" action="contactPage.php">
                <p>
                    <label for="name">Full Name:</label>
                    <input type="text" name="name" id="name" required>
                </p>
                <p>
                    <label for="email">Email: </label>
                    <input type="email" name="email" id="email" required>
                </p>
                <p>
                    <label for="message">Message:</label> <br>
                    <textarea id="message" name="message" rows=6 col=200 required> </textarea>
                </p>
                <p>
                    <input type="submit" class="button" name="button" id="button" value="Submit">
                </p>

                <input type="text" name="phone" id="phone" style="display:none !important" tableindex="-1" autocomplete="off" value="0" required>
            </form>
        <?php } else if(!empty($_POST['phone'])) { ?>
            <h4 style="text-color:red">Access Denied</h4>
            <button onClick="window.location.reload();">Refresh Page</button>
        <?php } else {
            echo "<p>", $_POST['name'], ", thank you for reaching out to me!<br>";
            echo "A copy of the generated message has been sent to your email at ", $_POST['email'], ".<br>";
            echo "If you are having trouble finding it, be sure to check your spam folder.<br>";
            echo "Thank you again for sending me a message!<br>";
            echo "Your message: ", $_POST['message'], "</p>";

            $emailMessage = "
                <p>Contact: ". $_POST['name']. "<br>
                Email: ". $_POST['email']. "<br>
                Message: ". $_POST['message']. "<br>
                Date Sent: ". date("m/d/Y"). "</p>";

            $header =  'MIME-Version: 1.0' . "\r\n"; 
            $header .= "Content-type:text/html;charset=UTF-8\r\n";
            $header .= 'From: admin@npclarkdmacc.com';

            mail("admin@npclarkdmacc.com", "Contact Message", $emailMessage, $header);
            mail($_POST['email'], "Contact Message", $emailMessage, $header);
        } ?>
    </section>

    <footer>
        <h4><i>© <?php echo date("Y"); ?> </i></h4>
    </footer>
</body>
</html>