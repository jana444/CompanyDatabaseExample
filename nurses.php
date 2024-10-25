<?php
$nurse = [];
require_once 'database/database.php';
require_once 'templates/functions/template_functions.php';
//connect to database 
$pdo = db_connect();
//check if form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nurseID = $_POST['nurseID'] ?? null;
    get_Nurse_Sub_Data($nurseID);
} else {
    get_Nurse_Sub_Data();
}
?>

<!DOCTYPE html>
<?php include 'templates/head.php'; ?>
<html lang="en">

<body>
    <div id="bckgdimg">
        <?php
        $pageTitle = "Nurses";
        include 'templates/header.php';
        ?>
        <div class="leather">
            <nav>
                <ul>
                    <li class="home"><a href="index.php">Clients</a></li>
                    <li class="nurses">Nurses</li>
                    <li class="comp"><a href="company.php">Company</a></li>
                </ul>
            </nav>
            <main class="nurses">
                <div id="container">
                    <h5>List of all nurses with their substitution periods.</h5>
                    <?php nurseForm(); ?>
                    <?php nurseSub(); ?>
                </div>
                <br>
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