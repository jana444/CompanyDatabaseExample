<?php
//include config file for database connnection
require 'config.php';

// Should return a PDO
function db_connect()
{

  try {
    // TODO
    // try to open database connection using constants set in config.php
    // return $pdo;
    $connectionString = 'mysql:host=' . DBHOST . ';dbname=' . DBNAME;
    $user = DBUSER;
    $pass = DBPASS;

    $pdo = new PDO($connectionString, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

//Add client on client tab 
function add_client($pdo)
{
  //check request method 
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //check if fields are set 
    if (
      isset($_POST['fName']) && isset($_POST['lName']) && isset($_POST['DOB']) && isset($_POST['Street']) && isset($_POST['City'])
      && isset($_POST['Postal']) && isset($_POST['PhoneNr']) && isset($_POST['ClientType'])
    ) {
      try {
        //query
        $sql = "INSERT INTO client (fName, lName, DOB, Street, City, Postal, PhoneNr, ClientType) 
                VALUES (:fName, :lName, :DOB, :Street, :City, :Postal, :PhoneNr, :ClientType)";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':fName', $_POST['fName']);
        $statement->bindValue(':lName', $_POST['lName']);
        $statement->bindValue(':DOB', $_POST['DOB']);
        $statement->bindValue(':Street', $_POST['Street']);
        $statement->bindValue(':City', $_POST['City']);
        $statement->bindValue(':Postal', $_POST['Postal']);
        $statement->bindValue(':PhoneNr', $_POST['PhoneNr']);
        $statement->bindValue(':ClientType', $_POST['ClientType']);
        $statement->execute();
      } catch (PDOException $e) {
        //display error message 
        echo "Error: " . $e->getMessage();
      }
    }
  }
}

//Displays Visit Reports on company tab
function detailed_visit_report()
{
  global $pdo;
  global $detailedvisitreports;

  $sql = "SELECT * FROM detailedvisitreports";
  $result = $pdo->query($sql);
  while ($row = $result->fetch()) {
    $detailedvisitreports[] = $row;
  }
}

//Displays Clients w/o Scheduled Visit on company tab
function no_scheduled_visit()
{
  global $pdo;
  global $client;

  $sql = "SELECT c.ClientID, c.fName, c.lName, c.DOB, c.Street, c.City, c.Postal, c.PhoneNr, c.ClientType, c.ContractID
            FROM Client c
            WHERE c.ClientID NOT IN (
                SELECT vr.ClientID
                FROM VisitReport vr
          )";
  $result = $pdo->query($sql);
  while ($row = $result->fetch()) {
    $client[] = $row;
  }
}

//Add client on client tab
function add_contract($pdo)
{
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
      isset($_POST['DayOfWeek']) && isset($_POST['StartTime']) && isset($_POST['EndTime']) && isset($_POST['Street']) && isset($_POST['City'])
      && isset($_POST['Postal']) && isset($_POST['PhoneNr']) && isset($_POST['Diagnose']) && isset($_POST['ClientID'])
    ) {
      try {
        $sql = "INSERT INTO contract (DayOfWeek, StartTime, EndTime, Street, City, Postal, PhoneNr, Diagnose, ClientID) 
              VALUES (:DayOfWeek, :StartTime, :EndTime, :Street, :City, :Postal, :PhoneNr, :Diagnose, :ClientID)";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':DayOfWeek', $_POST['DayOfWeek']);
        $statement->bindValue(':StartTime', $_POST['StartTime']);
        $statement->bindValue(':EndTime', $_POST['EndTime']);
        $statement->bindValue(':Street', $_POST['Street']);
        $statement->bindValue(':City', $_POST['City']);
        $statement->bindValue(':Postal', $_POST['Postal']);
        $statement->bindValue(':PhoneNr', $_POST['PhoneNr']);
        $statement->bindValue(':Diagnose', $_POST['Diagnose']);
        $statement->bindValue(':ClientID', $_POST['ClientID']);
        $statement->execute();
        //get the newly created ContractID
        $contractId = $pdo->lastInsertId();

        // Update Client's ContractID in client table
        $updateClientSql = "UPDATE client SET ContractID = :ContractID WHERE ClientID = :ClientID";
        $updateStatement = $pdo->prepare($updateClientSql);
        $updateStatement->bindValue(':ContractID', $contractId);
        $updateStatement->bindValue(':ClientID', $_POST['ClientID']);
        $updateStatement->execute();

        //select a nurse for the visit - selects the first available nurse
        $nurseSql = "SELECT NurseID FROM Nurse LIMIT 1";
        $nurseStatement = $pdo->query($nurseSql);
        $nurse = $nurseStatement->fetch(PDO::FETCH_ASSOC);

        if ($nurse) {
          $nurseId = $nurse['NurseID'];

          // Insert a new visit report for the created contract
          $visitReportSql = "INSERT INTO visitreport (NurseID, ClientID, ContractID, HealthCondition, VisitDate, StartTime, EndTime, ServicesProvided, MetAsScheduled) 
                                  VALUES (:NurseID, :ClientID, :ContractID, :HealthCondition, :VisitDate, :StartTime, :EndTime, :ServicesProvided, :MetAsScheduled)";

          $visitReportStat = $pdo->prepare($visitReportSql);
          $visitReportStat->bindValue(':NurseID', $nurseId);
          $visitReportStat->bindValue(':ClientID', $_POST['ClientID']);
          $visitReportStat->bindValue(':ContractID', $contractId);
          $visitReportStat->bindValue(':HealthCondition', 'Unknown'); //default value
          $visitReportStat->bindValue(':VisitDate', date('Y-m-d')); //default to today's date
          $visitReportStat->bindValue(':StartTime', $_POST['StartTime']);
          $visitReportStat->bindValue(':EndTime', $_POST['EndTime']);
          $visitReportStat->bindValue(':ServicesProvided', 'General Checkup'); //default value
          $visitReportStat->bindValue(':MetAsScheduled', false); //default value
          $visitReportStat->execute();
        } else {
          echo "Error: No nurses available to assign.";
        }
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    }
  }
}

//deletes clients on a company tab
function delete_client($pdo)
{
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_client'])) {
    // Check if ClientID is set
    if (!empty($_POST['ClientID'])) {
      $clientId = $_POST['ClientID'];

      try {
        // First delete contracts associated with the client
        $sqlContracts = "DELETE FROM contract WHERE ClientID = :ClientID";
        $statementContracts = $pdo->prepare($sqlContracts);
        $statementContracts->bindValue(':ClientID', $clientId);
        $statementContracts->execute();

        // Now delete the client
        $sqlClient = "DELETE FROM client WHERE ClientID = :ClientID";
        $statementClient = $pdo->prepare($sqlClient);
        $statementClient->bindValue(':ClientID', $clientId);
        if ($statementClient->execute()) {
          echo "Client and related contracts deleted successfully.";
        } else {
          echo "Failed to delete client.";
        }
      } catch (PDOException $e) {
        echo "Error deleting client: " . $e->getMessage();
      }
    } else {
      echo "ClientID is required.";
    }
  }
}

//updates given visit report fields on company tab
function update_visit_report($pdo)
{
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_report'])) {
    if (!empty($_POST['ReportID']) && !empty($_POST['column']) && isset($_POST['newValue'])) {
      // Sanitize input to avoid SQL injection
      $reportId = $_POST['ReportID'];
      $column = $_POST['column'];
      $newValue = $_POST['newValue'];

      //list of values that can be updated
      $validColumns = [
        'HealthCondition',
        'VisitDate',
        'StartTime',
        'EndTime',
        'ServicesProvided',
        'MetAsScheduled'
      ];

      //check if the selected column is valid
      if (in_array($column, $validColumns)) {
        $sql = "UPDATE visitreport SET $column = :newValue WHERE ReportID = :reportId";

        try {
          $statement = $pdo->prepare($sql);
          $statement->bindValue(':newValue', $newValue);
          $statement->bindValue(':reportId', $reportId);

          if ($statement->execute()) {
            echo "Visit report updated successfully.";
          } else {
            echo "Failed to update visit report.";
          }
        } catch (PDOException $e) {
          echo "Error updating visit report: " . $e->getMessage();
        }
      } else {
        echo "Invalid column selected.";
      }
    } else {
      echo "ReportID, column, and new value are required.";
    }
  }
}

//displays visit report table on company tab 
function display_visit_report()
{
  global $pdo;
  global $visitreport;

  $sql = "SELECT * FROM visitreport";
  $result = $pdo->query($sql);
  while ($row = $result->fetch()) {
    $visitreport[] = $row;
  }
}

//deletes visit report records on company tab  
function remove_report($pdo)
{
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_report'])) {
    try {
      // Delete the client record
      $sql = "DELETE FROM visitreport WHERE ReportID = :ReportID";
      $statement = $pdo->prepare($sql);
      $statement->bindValue(':ReportID', $_POST['ReportID']);
      $statement->execute();
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
}

//list all nurses with their substitution periods
function get_Nurse_Sub_Data($NurseID = null)
{
  global $pdo;
  global $nurse;

  $sql = "SELECT n.NurseID, n.fName AS NurseName, n.lName AS NurseLastName, 
          s.StartDate, s.EndDate
          FROM Nurse n
          LEFT JOIN Substitution s ON n.NurseID = s.NurseID";

  //user enters the nurse ID to get the results 
  if ($NurseID) {
    $sql .= " WHERE n.NurseID = :NurseID";//concatenate the sql statement to the first part 
  }

  $statement = $pdo->prepare($sql);

  // Bind parameter if it's provided
  if ($NurseID) {
    $statement->bindParam(':NurseID', $NurseID);
  }

  $statement->execute();
  $nurse = $statement->fetchAll();
}