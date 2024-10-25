<?php
//global array of clients to be fetched from db
$client = [];
require_once 'database/database.php';
//connect to the database
$pdo = db_connect();

//check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    add_client($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BINGO</title>
    <?php include 'templates/head.php'; ?>
</head>

<body>
    <div id="bckgdimg">
        <?php
        $pageTitle = "Clients";
        include 'templates/header.php';
        ?>
        <div class="leather">
            <nav>
                <ul>
                    <li class="nurses"><a href="nurses.php">Nurses</a></li>
                    <li class="comp"><a href="company.php">Company</a></li>
                </ul>
            </nav>
            <main class="home">
                <img class="stamp" alt="stamp" src="images/seal.png">
                <br>
                <div class="homePad">
                    <h2>Welcome to Bingo</h2>
                    <section class="homePage">
                        <p id="indexP">Please sign up, to receive service.
                            <br>
                            We provide health care assistance to seniors and disabled clients at the comfort of their
                            own home.<br>You can start by submitting your information to provide customized services.
                        </p>
                        <div id="div-id">
                            <h5>Enter your information</h5>
                            <form action="index.php" method="post">

                                <label for="fName"> First Name:
                                    <input type="text" name="fName" id="fName">
                                </label>

                                <label for="lName"> Last Name:
                                    <input type="text" name="lName" id="lName">
                                </label>

                                <label for="DOB"> Date of Birth:
                                    <input type="date" name="DOB" id="DOB">
                                </label>

                                <label for="Street"> Street:
                                    <input type="text" name="Street" id="Street">
                                </label>

                                <label for="City"> City:
                                    <input type="text" name="City" id="City">
                                </label>

                                <label for="Postal"> Postal:
                                    <input type="text" name="Postal" id="Postal">
                                </label>

                                <label for="PhoneNr"> Phone number:
                                    <input type="text" name="PhoneNr" id="PhoneNr">
                                </label>

                                <fieldset>
                                    <legend> Choose your client category </legend>
                                    <select id="ClientType" name="ClientType" required>
                                        <option value="">Choose your category</option>
                                        <option value="Senior">Senior</option>
                                        <option value="Disabled">Disabled</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </fieldset>

                                <div class="sticker"><input type="reset" value="Reset Form"></div>
                                <div class="sticker"><input type="submit" value="Submit Form"></div>

                            </form>
                        </div>
                    </section>
                </div>
                <br>
                <footer>
                    Jana Krizanova CPSC2221 Project
                </footer>
            </main>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.0/gsap.min.js"></script>
    <script src="assets/g.js"></script>
</body>

</html>