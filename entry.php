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

// Provjera je li korisnik prijavljen
if(isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    
    if (isset($_GET['competition_id'])) {
        $competition_id = $_GET['competition_id'];
    }
    else{
        $competition_id="0";
    }
    $sql = "SELECT * FROM ardf_competition WHERE competition_id = $competition_id";
    $result = mysqli_query($mysqli, $sql);
     // Provjeri jesu li podaci pronađeni
     if (mysqli_num_rows($result) > 0) {
        // Prolazi kroz svaki red rezultata
        while ($row = mysqli_fetch_assoc($result)) {
            $competition_name = $row['competition_name']; 
        }}

    // Provjera korisničkih ovlasti za administraciju kluba
    $club_query = "SELECT * FROM ardf_club_members WHERE member_user_id = $user_id AND member_admin = true";
    $club_result = $mysqli->query($club_query);
    $is_admin = false;

    if ($club_result && $club_result->num_rows > 0) {
        $is_admin = true;
        // Prikaži opciju za odabir između pojedinačne prijave i grupnog unosa
        echo '<div class="container mt-3">';
        echo '<h3>Prijava na natjecanje: ' . $competition_name . '!</h3>';
        echo '<p>Odaberite način prijave:</p>';
        echo '<a class="mt-3 btn btn-primary" href="individual_entry.php?user_id=' . $user_id . '&competition_id=' . $competition_id . '">Pojedinačna prijava</a>';
        echo '</br><a class="mt-3 btn btn-primary" href="group_entry.php?competition_id=' . $competition_id . '" >Grupni unos</a>'; //neka nasljedi competition_id
        echo '</div>';
    } else {
        echo '<div class="container mt-3">';
        echo '<h3>Prijava na natjecanje: ' . $competition_name . '!</h3>';
        echo '<a class="mt-3 btn btn-primary" href="individual_entry.php?user_id=' . $user_id . '&competition_id=' . $competition_id . '">Pojedinačna prijava</a>';
        echo '</div>';
    }
    
} else {
    // Korisnik nije prijavljen
    echo '<div class="container mt-3">';
    echo '<h3>Niste prijavljeni.</h3>';
    echo '</div>';
}
?>







</body>
</html>