<?php
//output list of visit reports to HTML
function detailedVisitReport()
{
  global $detailedvisitreports;

  echo '<table>
      <tr>
          <th>Report ID</th>
          <th>Visit Date</th>
          <th>Services Provided</th>
          <th>Nurse:First Name</th>
          <th>Nurse:Last Name</th>
          <th>Client:First Name</th>
          <th>Client:Last Name</th>
      </tr>';

  //check if the $detailedvisitreports array is empty or not set
  if (empty($detailedvisitreports)) {
    //display a message the table is empty
    echo '<tr><td colspan="7">No detailed visit reports available.</td></tr>';
  } else {
    //loop through the detailedvisitreports array and display the data
    foreach ($detailedvisitreports as $row) {
      echo '<tr>
              <td>' . $row['ReportID'] . '</td>
              <td>' . $row['VisitDate'] . '</td>
              <td>' . $row['ServicesProvided'] . '</td>
              <td>' . $row['NurseName'] . '</td>
              <td>' . $row['NurseLastName'] . '</td>
              <td>' . $row['ClientName'] . '</td>
              <td>' . $row['ClientLastName'] . '</td>
          </tr>';
    }
  }

  echo '</table>';
}

//display a table of clients who have no scheduled visits
function noScheduledVisit()
{
  global $client;

  echo '<table>
      <tr>
          <th>Client ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>DOB</th>
          <th>Street</th>
          <th>City</th>
          <th>Postal</th>
          <th>Phone#</th>
          <th>Client Type</th>
          <th>Contract ID</th>
      </tr>';

  if (empty($client)) {
    echo '<tr><td colspan="10">No clients w/o scheduled visit.</td></tr>';
  } else {
    foreach ($client as $row) {
      echo '<tr>
              <td>' . $row['ClientID'] . '</td>
              <td>' . $row['fName'] . '</td>
              <td>' . $row['lName'] . '</td>
              <td>' . $row['DOB'] . '</td>
              <td>' . $row['Street'] . '</td>
              <td>' . $row['City'] . '</td>
              <td>' . $row['Postal'] . '</td>
              <td>' . $row['PhoneNr'] . '</td>
              <td>' . $row['ClientType'] . '</td>
              <td>' . $row['ContractID'] . '</td>
          </tr>';
    }
  }

  echo '</table>';
}

//display a form for creating a contract for clients who do not have one 
function addContract()
{
  global $contract;

  echo '<form action="company.php" method="post">
    <h3>Create Contract</h3>
    <fieldset>
      <legend> Choose Day of Week </legend>
        <select id="DayOfWeek" name="DayOfWeek"required>
          <option value="">Choose day</option>
          <option value="Monday">Monday</option>
          <option value="Tuesday">Tuesday</option>
          <option value="Wednesday">Wednesday</option>
          <option value="Thursday">Thursday</option>
          <option value="Friday">Friday</option>
          <option value="Saturday">Saturday</option>   
          <option value="Sunday">Sunday</option>                                                                     
        </select>
    </fieldset>                            

    <label for="StartTime">  Start Time:
    <input type="time" name="StartTime" id="StartTime">
    </label>

    <label for="EndTime">  End Time:
    <input type="time" name="EndTime" id="EndTime">
    </label>

    <label for="Street">  Street:
    <input type="text" name="Street" id="Street">
    </label>

    <label for="City">  City:
    <input type="text" name="City" id="City">
    </label>

    <label for="Postal">  Postal:
    <input type="text" name="Postal" id="Postal">
    </label>

    <label for="PhoneNr">  Phone number:
    <input type="text" name="PhoneNr" id="PhoneNr">
    </label>

    <label for="Diagnose">  Diagnose:
    <input type="text" name="Diagnose" id="Diagnose">
    </label>

    <label for="ClientID">  Client ID:
    <input type="number" name="ClientID" id="ClientID">
    </label>

    <div class="sticker"><input type="reset" value="Reset Form"></div>
    <div class="sticker"><input type="submit" value="Submit Form"></div>

  </form>';

}

//form for deleting clients - duplicate clients, error entries entered by website visitors trying to sign up
function deleteClient()
{
  global $client;

  echo '<form action="company.php" method="post">
  <h3>Delete Invalid Client Entry</h3>

  <label for="ClientID">  Client ID:
  <input type="number" name="ClientID" id="ClientID" required>
  </label>
  <input type="hidden" name="delete_client" value="1">
  <div class="sticker"><input type="reset" value="Reset Form"></div>
  <div class="sticker"><input type="submit" value="Submit Form"></div>

</form>';

}

//display full visit report table 
function displayVisitReport()
{
  global $visitreport;

  echo '<table>
      <tr>
          <th>Report ID</th>
          <th>Nurse ID</th>
          <th>Client ID</th>
          <th>Contract ID</th>
          <th>Health Condition</th>
          <th>Visit Date</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Services Provided</th>
          <th>Met As Scheduled</th>
      </tr>';

  if (empty($visitreport)) {
    echo '<tr  ><td colspan="10">No visit reports available.</td></tr>';
  } else {
    foreach ($visitreport as $row) {
      echo '<tr>
              <td>' . $row['ReportID'] . '</td>
              <td>' . $row['NurseID'] . '</td>
              <td>' . $row['ClientID'] . '</td>
              <td>' . $row['ContractID'] . '</td>
              <td>' . $row['HealthCondition'] . '</td>
              <td>' . $row['VisitDate'] . '</td>
              <td>' . $row['StartTime'] . '</td>
              <td>' . $row['EndTime'] . '</td>
              <td>' . $row['ServicesProvided'] . '</td>
              <td>' . $row['MetAsScheduled'] . '</td>
          </tr>';
    }
  }

  echo '</table>';
}

//form for updating visit report fields, not all though, just selected to avoid errors 
function updateVisitReport()
{
  global $visitreport;

  echo '<form action="company.php" method="post">
    <label style="font-size:1.5rem;"  for="ReportID">Report ID:</label>
    <input type="number" id="ReportID" name="ReportID" required>
    
    <label style="font-size:1.5rem;"  for="column">Select Column to Update:</label>
    <select id="column" name="column" style="font-size:1rem;" required>
        <option value="HealthCondition">Health Condition</option>
        <option value="VisitDate">Visit Date</option>
        <option value="StartTime">Start Time</option>
        <option value="EndTime">End Time</option>
        <option value="ServicesProvided">Services Provided</option>
        <option value="MetAsScheduled">Met As Scheduled</option>
    </select>

    <label style="font-size:1.5rem;" for="newValue">Enter New Value:</label>
    <input type="text" id="newValue" name="newValue" required>
    <input type="hidden" name="update_report" value="1">
    <div class="sticker"><input type="reset" value="Reset Form"></div>
    <div class="sticker"><input type="submit" value="Submit Form"></div>
</form>';
}

//remove visit reports form 
function removeVisitReport()
{
  global $visitreport;

  echo '<form action="company.php" method="post">
  <h3>Delete Visit Report</h3>

  <label for="ReportID">  Report ID:
  <input type="number" name="ReportID" id="ReportID">
  </label>
  <input type="hidden" name="remove_report" value="1">
  <div class="sticker"><input type="reset" value="Reset Form"></div>
  <div class="sticker"><input type="submit" value="Submit Form"></div>

</form>';
}

//displays a table of all nurses with their substitution periods
function nurseSub()
{
  global $nurse;

  echo '<table>
      <tr>
          <th>Nurse ID</th>
          <th>Nurse Name</th>
          <th>Nurse Last Name</th>
          <th>Start Date</th>
          <th>End Date</th>
      </tr>';

  if (empty($nurse)) {
    echo '<tr><td colspan="5">No nurse substitutions available.</td></tr>';
  } else {
    foreach ($nurse as $row) {
      echo '<tr>
              <td>' . $row['NurseID'] . '</td>
              <td>' . $row['NurseName'] . '</td>
              <td>' . $row['NurseLastName'] . '</td>
              <td>' . $row['StartDate'] . '</td>
              <td>' . $row['EndDate'] . '</td>
          </tr>';
    }
  }

  echo '</table>';
}

//form for filtering nurses by their ID
function nurseForm()
{
  global $nurse;

  echo '<form method="POST" action="">
    <label for="nurseID">Nurse ID:</label>
    <input type="number" id="nurseID" name="nurseID" required>

    <input type="submit" value="Filter">
  </form>';
}