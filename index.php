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
       
    ?>

<?php
    if(isset($_SESSION['username'])) { 
?>
        
        <h2>Pozdrav 
        <?php echo $_SESSION['name']; ?></h2>
<?php 
    } 
?>
 
    
    
  
  <?php
        // Dohvaćanje događaja koje organizira trenutni korisnik
        $events_query = "SELECT * FROM ardf_event WHERE event_public='1' AND event_start_date > CURDATE() ORDER BY event_start_date ASC LIMIT 3";
        $events_result = $mysqli->query($events_query); // Izvršavanje upita za dohvaćanje događaja

        if ($events_result && $events_result->num_rows > 0) { // Provjera jesu li pronađeni događaji
            echo "<div class='container mt-5'>
                <h3 class='mb-3'>ARDF događaji</h3>
                    <div class='row'>
                        <div class='col'>
                            <table class='table table-bordered'>
                                <thead class='thead-dark'>
                                    <tr>
                                        <th>Naziv događaja</th>
                                        <th width='10%'>Datum</th>
                                        <th>Lokacija</th>
                                        <th width='10%'>Opcije</th>
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
                                    echo "<td width='10%' style='text-align: left;'>";
                                    // Gumb za pregled događaja
                                    echo "<a href='view_event.php?event_id=" . $row['event_id'] . "' class='btn btn-primary' style='width: 80px; margin-right: 5px;'>Pregled</a>"; 
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
    

    ?>
    </div></div>



    </body>
</html>