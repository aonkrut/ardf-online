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
    <div class="container mt-2">
<?php 


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
                    $competition_id = $row['competition_id']; // Postavljanje competition_id na vrijednost iz trenutnog retka
                    
                    ?>
                    <!-- Kartica za natjecanje -->
                    <div class="card mb-4">
                    <div class="card-header py-3">
                    <h4>Natjecanje <b><?php echo $row['competition_name']; ?></h4>
                    
                </div>
                        <div class="card-body">
                        
                        <?php 
                        $sql2 = "SELECT * FROM ardf_type";
                        $result2 = mysqli_query($mysqli, $sql2);

                        if ($result2) {
                            $selected_id = isset($row['competition_type_id']) ? $row['competition_type_id'] : '';
                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                if ($selected_id == $row2['type_id']) {
                                    echo '<h5>Vrsta natjecanja: <b>' . $row2['type_name'] . '</b></h5>';
                                    break;
                                }
                            }
                            mysqli_free_result($result2);
                        } else {
                            echo "Error: " . $sql2 . "<br>" . mysqli_error($mysqli);
                        }

                        if (!empty($row['competition_start_date'])) {
                            echo '<h5>Datum održavanja: <b>' . $row['competition_start_date'] . '</b></h5>';
                        }

                       
?>
                      <h5 >
                    Prijave u razdoblju:  <b>
                  <?php 
                     $start_date = strtotime($row['competition_start_entry_date']);
                     $end_date = strtotime($row['competition_end_entry_date']);
                     
                     $start_day = date('d', $start_date);
                     $start_month = date('m', $start_date);
                     $start_year = date('Y', $start_date);
                     
                     $end_day = date('d', $end_date);
                     $end_month = date('m', $end_date);
                     $end_year = date('Y', $end_date);
                     
                     if (($start_month === $end_month)&&($start_year===$end_year)) {
                         echo "" . $start_day . "-" . $end_day . "." . $start_month . "." . $start_year . "";
                     } else if ($start_year===$end_year){
                         echo "" . $start_day . "." . $start_month . " - " . $end_day . "." . $end_month . "." . $end_year . "";
                     }
                     else{
                       echo "" . $start_day . "." . $start_month . ".". $start_year ." - " . $end_day . "." . $end_month . "." . $end_year . "";
                     }
                     ?></b>
                </h5>
                    </br>
<?php
                         if (!empty($row['competition_description'])) {
                            echo '<h5>Opis: <b>' . $row['competition_description'] . '</b></h5></br>';
                        }

                        if (!empty($row['competition_location'])) {
                            echo '<h5>Lokacija: <b>' . $row['competition_location'] . '</b></h5>';
                        }

                        if (!empty($row['competition_coordinates'])) {
                            echo '<h5>Koordinate: <b>' . $row['competition_coordinates'] . '</b></h5> </br>';
                        }

                        if (!empty($row['competition_start_time'])) {
                            echo '<h5>Prvi start: <b>' . $row['competition_start_time'] . '</b></h5>';
                        }

                        if (!empty($row['gathering_time'])) {
                            echo '<h5>Okupljanje: <b>' . $row['gathering_time'] . '</b></h5>';
                        }

                        if (!empty($row['departure_to_start'])) {
                            echo '<h5>Polazak na start: <b>' . $row['departure_to_start'] . '</b></h5>';
                        }

                        if (!empty($row['goniometer_delay'])) {
                            echo '<h5>Odlaganje goniometara: <b>' . $row['goniometer_delay'] . '</b></h5>';
                        }
                        ?>
                        <?php
                            echo "<a href='entry.php?competition_id=" . $row['competition_id'] . "' class='btn btn-success mt-2' style='width: 90px; margin-right: 5px;'>Prijavi se</a>";
                            ?>
                        <?php
                             echo "<a href='competition_entires.php?competition_id=" . $row['competition_id'] . "' class='btn btn-info mt-2' style='width: 150px; margin-right: 5px;'>Popis prijavljenih</a>";
                            ?>
                        </div>

                            </div>
                            
                        </div>
                    <?php
                }
            }
            
            else{
                echo "Nema natjecanja";
            }
            
?>
</div>
    
</body>
</html>