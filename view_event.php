<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARDF online</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php 
    // Uključivanje navigacije i konfiguracije baze podataka
    include 'navigation.php';
    include 'config.php';

    // Inicijalizacija varijabli za podatke forme
    $event_name = $event_start_date = $event_end_date = $event_coordinates = $event_location = $event_competition_web = $event_email = "";
    if (isset($_GET['event_id'])) {
        $event_id = $_GET['event_id'];
    } else {
        $event_id = "0";
    }
    $sql = "SELECT * FROM ardf_event WHERE event_id = '$event_id'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        // Prikazivanje forme za uređivanje informacija
        while ($row = $result->fetch_assoc()) {
            ?>

            <div class="container mt-2">
                <div class="row">
                    <div class="col-md-7 mb-4">
                        <h3>Event</h3>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h3><?php echo $row['event_name']; ?></h3>
                                <h5>Datum održavanja: <b>
                                    <?php 
                                    $start_date = strtotime($row['event_start_date']);
                                    $end_date = strtotime($row['event_end_date']);
                                    
                                    $start_day = date('d', $start_date);
                                    $start_month = date('m', $start_date);
                                    $start_year = date('Y', $start_date);
                                    
                                    $end_day = date('d', $end_date);
                                    $end_month = date('m', $end_date);
                                    $end_year = date('Y', $end_date);
                                    
                                    if (($start_month === $end_month) && ($start_year === $end_year)) {
                                        echo "" . $start_day . "-" . $end_day . "." . $start_month . "." . $start_year . "";
                                    } else if ($start_year === $end_year) {
                                        echo "" . $start_day . "." . $start_month . " - " . $end_day . "." . $end_month . "." . $end_year . "";
                                    } else {
                                        echo "" . $start_day . "." . $start_month . "." . $start_year ." - " . $end_day . "." . $end_month . "." . $end_year . "";
                                    }
                                    ?></b>
                                </h5>
                                <h5>Mjesto održavanja: <b>
                                    <?php 
                                    $event_country_id = $row['event_country_id'];
                                    $sql_country_names = "SELECT country_name FROM ardf_country WHERE country_id=$event_country_id";
                                    $country_result = mysqli_query($mysqli, $sql_country_names);
                                    $country_row = mysqli_fetch_assoc($country_result);
                                    $country_name = $country_row['country_name'];
                                    $location= $row['event_location'];
                                    echo "$country_name , $location";
                                    ?>
                                </b>
                                </h5>
                                <h5>GPS kordinate: <b>
                                    <?php 
                                    echo $row['event_cordinates'];
                                    ?>
                                </b>
                                </h5>    
                                <h5 class="d-inline">Administrator/Organizator: <b>
                                    <?php 
                                    $organizator_id = $row['event_organizer_id'];
                                    // Izvršavanje upita za dohvaćanje podataka o organizatoru
                                    $club_query = "SELECT name, surname FROM ardf_user WHERE user_id = $organizator_id";
                                    $club_result = $mysqli->query($club_query);

                                    if ($club_result->num_rows > 0) {
                                        $club_row = $club_result->fetch_assoc();
                                        $organizer_name = $club_row['name'];
                                        $organizer_surname = $club_row['surname'];
                                        // Ispisivanje imena i prezimena organizatora
                                        echo $organizer_name . " " . $organizer_surname;
                                    } else {
                                        echo "nepoznato";
                                    }
                                    ?></b>
                                </h5>
                                <h5>Organizacija: <b>
                                    <?php 
                                    $event_club_id = "0";
                                    $event_club_id = $row['event_club_id'];
                                    // Izvršavanje upita za dohvaćanje podataka o organizatoru
                                    $club_query = "SELECT * FROM ardf_club WHERE club_id = $event_club_id";
                                    $club_result = $mysqli->query($club_query);

                                    if ($club_result->num_rows > 0) {
                                        $club_row = $club_result->fetch_assoc();
                                        $club_name = $club_row['club_name'];
                                        $club_call = $club_row['club_call'];
                                        // Ispisivanje imena i prezimena organizatora
                                        echo $club_name . ", " . $club_call;
                                    } else {
                                        echo "nepoznato";
                                    }
                                    ?></b>
                                </h5>

                                <?php 
                                if (!empty($row['event_competition_web'])) {
                                    echo '<h5>WEB sjedište: <b><a href="' . $row['event_competition_web'] . '">' . $row['event_competition_web'] . '</a></b></h5>';
                                }
                                ?>

                                <h5>E-mail kontakt: <b>
                                    <?php echo $row['event_email']; ?>
                                </b>
                                </h5> 

                            </div>
                        </div>
                    </div>
                                  
                    <div class="col-md-4 mb-4">
                        <div class="mb-3 mt-2 overflow-auto" style="max-height: 70vh;">
                            <h3>Natjecanja</h3>
                            <?php
                            $sql = "SELECT * FROM ardf_competition WHERE event_id = $event_id";
                            $result = mysqli_query($mysqli, $sql);

                            // Provjeri jesu li podaci pronađeni
                            if (mysqli_num_rows($result) > 0) {
                                // Prolazi kroz svaki red rezultata
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $competition_id = $row['competition_id']; // Postavljanje competition_id na vrijednost iz trenutnog retka
                                    ?>
                                    <!-- Kartica za natjecanje -->
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h5 class="mb-0">Natjecanje <b><?php echo $row['competition_name']; ?></b></h5>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                                    Datum održavanja
                                                    <span><?php echo date("d.m.Y", strtotime($row['competition_start_date'])); ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                                    Start
                                                    <span><?php echo date("H:i", strtotime($row['competition_start_time'])); ?></span>
                                                </li>
                                            </ul>
                                            
                                            <?php
                                            echo "<a href='view_competition.php?competition_id=" . $row['competition_id'] . "' class='btn btn-secondary mt-2' style='width: 90px; margin-right: 5px;'>Pregled</a>";
                                            ?>
                                              <?php
                             echo "<a href='competition_entires.php?competition_id=" . $row['competition_id'] . "' class='btn btn-info mt-2' style='width: 150px; margin-right: 5px;'>Popis prijavljenih</a>";
                            ?>
                                            <?php
                                            // Provjerava je li današnji datum unutar raspona za prijavu
                                            $current_date = date('Y-m-d'); // Dohvati današnji datum u formatu YYYY-MM-DD

                                            $sql2 = "SELECT * FROM ardf_competition WHERE event_id = $event_id 
                                                    AND '$current_date' BETWEEN competition_start_entry_date AND competition_end_entry_date";
                                            $result2 = mysqli_query($mysqli, $sql2);

                                            // Provjeri jesu li podaci pronađeni i ispiši gumb za prijavu ako je datum u rasponu
                                            if (mysqli_num_rows($result2) > 0) {
                                                while ($row = mysqli_fetch_assoc($result2)) {
                                                    echo "<a href='entry.php?competition_id=" . $row['competition_id'] . "' class='btn btn-success mt-2' style='width: 90px; margin-right: 5px;'>Prijavi se</a>";
                                                }
                                            } else {
                                                // Ako današnji datum nije u rasponu, ne ispisujemo gumb za prijavu
                                                echo "Prijave trenutno nisu otvorene.";
                                            }
                                            ?>
                                            

                                        </div>
                                    </div>
                                <?php
                                }
                            } else {
                                echo "Nema natjecanja";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

    <?php
        }
    }
    ?>

    <script defer src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
