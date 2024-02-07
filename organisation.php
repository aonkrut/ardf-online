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
include 'navigation.php'; // Uključivanje navigacije
include 'config.php'; // Uključivanje konfiguracijske datoteke za bazu podataka

if (isset($_SESSION['username'])) { // Provjera je li korisnik prijavljen
    
    $username = $_SESSION['username']; 
    $user_id=$_SESSION['user_id'];
    $club_id=$_SESSION['club_id'];

        // Dohvaćanje događaja koje organizira trenutni korisnik
        $events_query = "SELECT * FROM ardf_event WHERE event_organizer_id = $user_id OR event_club_id=$club_id";
        $events_result = $mysqli->query($events_query); // Izvršavanje upita za dohvaćanje događaja

        if ($events_result && $events_result->num_rows > 0) { // Provjera jesu li pronađeni događaji
            echo "<div class='container mt-5'>
            <h3 class='d-inline mb-2'>Vaši događaji</h3>
            <a href='new_event.php' class='btn btn-primary mb-2'>Kreiraj novi</a>
                    <div class='row'>
                        <div class='col'>
                            <table class='table table-bordered'>
                                <thead class='thead-dark'>
                                    <tr>
                                        <th>Naziv događaja</th>
                                        <th width='10%'>Datum</th>
                                        <th>Lokacija</th>
                                        <th width='40%'>Opcije</th>
                                    </tr>
                                </thead>
                                <tbody>";

                                while ($row = $events_result->fetch_assoc()) { // Prolazak kroz rezultate upita
                                    echo "<tr>";
                                    echo "<td>" . $row['event_name'] . "</td>"; // Ispis naziva događaja
                                
                                    $start_date = strtotime($row['event_start_date']);
                                    $end_date = strtotime($row['event_end_date']);
                                    
                                    $start_day = date('d', $start_date);
                                    $start_month = date('m', $start_date);
                                    $start_year = date('Y', $start_date);
                                    
                                    $end_day = date('d', $end_date);
                                    $end_month = date('m', $end_date);
                                    $end_year = date('Y', $end_date);
                                    
                                    if (($start_month === $end_month)&&($start_year===$end_year)) {
                                        echo "<td  width='10%'> " . $start_day . "-" . $end_day . "." . $start_month . "." . $start_year . "</td>";
                                    } else if ($start_year===$end_year){
                                        echo "<td  width='10%'>" . $start_day . "." . $start_month . " - " . $end_day . "." . $end_month . "." . $end_year . "</td>";
                                    }
                                    else{
                                        echo "<td  width='10%'>" . $start_day . "." . $start_month . ".". $start_year ." - " . $end_day . "." . $end_month . "." . $end_year . "</td>";
                                    }
                                    echo "<td>" . $row['event_location'] . "</td>";
                                    echo "<td width='40%' style='text-align: left;'>";
                                    
                                    // Gumb za objavu događaja
                                    if ($row['event_public'] === null || $row['event_public'] === "0") {
                                        echo "<a href='action.php?action=publish_event&event_id=" . $row['event_id'] . "' class='btn btn-warning' style='width: 80px; margin-right: 5px;'>Privatno</a>"; 
                                    }
                                    if ($row['event_public'] === "1" ) {
                                        echo "<a href='action.php?action=depublish_event&event_id=" . $row['event_id'] . "' class='btn btn-success' style='width: 80px; margin-right: 5px;'>Javno</a>"; 
                                    }
                                    
                                    // Gumb za pregled događaja
                                    echo "<a href='view_event.php?event_id=" . $row['event_id'] . "' class='btn btn-secondary' style='width: 80px; margin-right: 5px;'>Pregled</a>"; 
                                    
                                    // Gumb za uređivanje događaja
                                    echo "<a href='admin_event.php?event_id=" . $row['event_id'] . "' class='btn btn-primary' style='width: 80px; margin-right: 5px;'>Uredi</a>"; 
                                    
                                    // Gumb za brisanje događaja
                                    echo "<a href='action.php?action=delete_event&event_id=" . $row['event_id'] . "' class='btn btn-danger' style='width: 80px;'>Obriši</a>"; 
                                    
                                    echo "</td>";                   
                                    echo "</tr>";
                                }
                                
            echo "</tbody>
                    </table>
                </div>
            </div>
        </div>";
        } else {
            echo "<div class='container mt-5'>
                    <div class='alert alert-info' role='alert'>
                        Nema pronađenih događaja.
                    </div>
                </div>";
        }
    }
 else {
    echo "<div class='container mt-5'>
            <div class='alert alert-warning' role='alert'>
                Morate biti prijavljeni da biste organizirali događaj.
            </div>
        </div>";
}
?>


    
</body>
</html>