<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARDF online</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script defer src="js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php 
include 'navigation.php';
include 'config.php';
?>
<div class="container mt-3">
<h3>Članovi kluba</h3>
<?php
include 'config.php';
$_SESSION['a'] = '1';
$club_id=$_SESSION['club_id'];
$username = $_SESSION['username'];
if (isset($_GET['competition_id'])) {
    $competition_id = $_GET['competition_id'];
}
else{
    $competition_id="0";
    header("Location: login.php");
    exit();
}
$user_query = "SELECT user_id FROM ardf_user WHERE username = '$username'";
$user_result = $mysqli->query($user_query);
if ($user_result->num_rows > 0) {
    $user_row = $user_result->fetch_assoc();
    $user_id = $user_row['user_id'];
    $club_query = "SELECT * FROM ardf_club_members WHERE member_user_id = $user_id AND member_admin = true";
    $club_result = $mysqli->query($club_query);
    $is_admin=false;
    if ($club_result->num_rows > 0) {
       $is_admin=true;
    }}
$sql = "SELECT u.user_id, u.name, u.surname, u.user_date_of_birth, u.user_sex, u.user_call
        FROM ardf_club_members AS m
        INNER JOIN ardf_user AS u ON m.member_user_id = u.user_id
        WHERE m.member_club_id = ?";
$stmt = $mysqli->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $club_id);
    $stmt->execute();
    $stmt->bind_result($userm_id, $name, $surname, $date_of_birth, $sex, $user_call);
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped table-bordered'>";
    echo "<thead class='thead-light'>";
    echo "<tr>";
    echo "<th width='3%'>ID</th><th>Name</th><th>Surname</th><th>Date of Birth</th><th width='5%'>Sex</th><th>User Call</th>";
    if ($is_admin==true){echo "<th width='10%'>Upravljaj</th>";}
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    while ($stmt->fetch()) {
        echo "<tr >";
        echo "<td width='3%'>$userm_id</td>";
        echo "<td>$name</td>";
        echo "<td>$surname</td>";
        echo "<td>$date_of_birth</td>";
        echo "<td width='5%'>$sex</td>";
        echo "<td>$user_call</td>";
        
        if ($is_admin==true){
             echo "<td width='10%'>";
             echo '<a class="mt-3 btn btn-primary" href="individual_entry.php?user_id=' . $userm_id . '&competition_id=' . $competition_id . '">Prijavi</a>';
            echo "</td>";}
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    $stmt->close();
} else {
    echo "Error: " . $mysqli->error;
}
$mysqli->close();
?>
</div>
</body>
</html>
