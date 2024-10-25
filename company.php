<?php
// global array of activities to be fetched from db
$contract = [];
require_once 'database/database.php';
require_once 'templates/functions/template_functions.php';
//connect to database
$pdo = db_connect();
//functions:
if (array_key_exists('button1', $_POST)) {
    detailed_visit_report();
}
if (array_key_exists('button2', $_POST)) {
    no_scheduled_visit();
}
if (array_key_exists('button3', $_POST)) {
    display_visit_report();
}
if (array_key_exists('button4', $_POST)) {
    display_visit_report();
}
//function call comes after requiring the file
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    add_contract($pdo);
    delete_client($pdo);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    update_visit_report($pdo);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    remove_report($pdo);
}
?>

<!DOCTYPE html>
<?php include 'templates/head.php'; ?>
<html lang="en">

<body>
    <div id="bckgdimg">
        <?php
        $pageTitle = "Company";
        include 'templates/header.php';
        ?>
        <div class="leather">
            <nav>
                <ul>
                    <li class="home"><a href="index.php">Clients</a></li>
                    <li class="nurses"><a href="nurses.php">Nurses</a></li>
                    <li class="comp">Company</li>
                </ul>
            </nav>
            <main class="company">
                <div id="container">
                    <h5>Choose an overview type</h5>
                    <form action="company.php" method="post">
                        <div class="button-container">
                            <input type="submit" name="button1" class="button" value="List of Detailed Visit Reports">
                            <input type="submit" name="button2" class="button" value="Clients w/o Scheduled Visit">
                            <input type="submit" name="button3" class="button" value="Update Visit Report">
                            <input type="submit" name="button4" class="button" value="Remove Report">
                        </div>
                    </form>
                </div>
                <div class="rightColumn">
                    <?php
                    //check if 'button#' was submitted in the post request
                    //then call function in the if statement
                    if (array_key_exists('button1', $_POST)) {
                        detailedVisitReport();
                    }
                    if (array_key_exists('button2', $_POST)) {
                        noScheduledVisit();
                    }
                    if (array_key_exists('button3', $_POST)) {
                        displayVisitReport();
                    }
                    if (array_key_exists('button4', $_POST)) {
                        displayVisitReport();
                    }
                    ?>
                </div>
                <div class="bottomForm">
                    <?php
                    //check if 'button#' was submitted in the post request
                    //then call function in the if statement
                    if (array_key_exists('button2', $_POST)) {
                        addContract();
                        deleteClient();
                    }
                    if (array_key_exists('button3', $_POST)) {
                        updateVisitReport();
                    }
                    if (array_key_exists('button4', $_POST)) {
                        removeVisitReport();
                    }
                    ?>
                </div>
                <footer>
                    Jana Krizanova CPSC2221 Project
                </footer>
            </main>
        </div>
        <footer>

        </footer>
    </div>
</body>

</html>