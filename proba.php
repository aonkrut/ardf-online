<!DOCTYPE html>
<html lang="hr">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARDF online</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script defer src="js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Funkcija koja omogućuje uređivanje polja nakon što se pritisne gumb za uređivanje
            function enableEditing() {
                var inputs = document.querySelectorAll("input, select");
                inputs.forEach(function(input) {
                    input.removeAttribute("readonly");
                    
                });
                document.getElementById("editEvent").style.display = "none";
                document.getElementById("saveButton").style.display = "block";
            }

            document.getElementById("editEvent").addEventListener("click", function() {
                enableEditing();
            });
        });
    </script>
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
    echo "Event ID: " . $event_id;
}
else{
    $event_id="0";
}

$sql = "SELECT * FROM ardf_event WHERE event_id = '$event_id'";
$result = $mysqli->query($sql);

if($result->num_rows > 0){
    // Prikazivanje forme za uređivanje informacija
    while($row = $result->fetch_assoc()){
?>

<div class="container mt-2">
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h4 class="mt-3 mb-2 d-inline">Događaj</h4>
                    <a href="#" id="editEvent">uredi</a>
                </div>
                <div class="card-body">

                <form action="action.php" method="post" id="eventForm">
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-outline">
                                <label for="event_name" class="form-label">Event Name:</label>
                                <input type="text" class="form-control" id="event_name" name="event_name" value="<?php echo $row['event_name']; ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-outline">
                                <label for="event_club_id" class="form-label">Klub ID:</label>
                                <input type="text" class="form-control" id="event_club_id" name="event_club_id" value="<?php echo $row['event_club_id']; ?>" readonly disabled> 
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline">
                                <label for="event_organizer_id" class="form-label">Event Organizator:</label>
                                <input type="text" class="form-control" id="event_organizer_id" name="event_organizer_id" value="<?php $username = $_SESSION['username'];echo "$username  ";?>" readonly disabled>
                            </div>
                        </div>
                    </div>

                    <div class="form-outline mb-4">
                        <label for="country" class="form-label">Država:</label>
                        <?php
                        include 'config.php';
                        $event_country_id=$row['event_country_id'];
                        $sql_countries = "SELECT * FROM ardf_country";
                        $result_countries = $mysqli->query($sql_countries);
                        if ($result_countries->num_rows > 0) {
                            echo '<select class="form-control" id="country" name="country" required>';
                            echo '<option value="">Odaberite državu</option>';
                            while ($row_country = $result_countries->fetch_assoc()) {
                                $selected = ($row_country['country_id'] == $event_country_id) ? "selected" : ""; // Provjerava je li trenutna zemlja jednaka odabranoj iz baze
                                echo '<option value="' . $row_country['country_id'] . '" ' . $selected . '>' . $row_country['country_name'] . '</option>';
                            }
                            echo '</select>';
                        } else {
                            echo 'Nema dostupnih država.';
                        }
                        ?>
                    </div>

                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-outline">
                                <label for="event_location" class="form-label">Lokacija:</label>
                                <input type="text" class="form-control" id="event_location" name="event_location" value="<?php echo $row['event_location']; ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="form-outline">
                                <label for="event_coordinates" class="form-label"> Koordinate:</label>
                                <input type="text" class="form-control" id="event_coordinates" name="event_coordinates" value="<?php echo $row['event_cordinates']; ?>" readonly>
                            </div>
                        </div>
                    
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-outline">
                                <label for="event_start_date" class="form-label">Start Date:</label>
                                <input type="date" class="form-control" id="event_start_date" name="event_start_date" value="<?php echo $row['event_start_date']; ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="form-outline">
                                <label for="event_end_date" class="form-label">End Date:</label>
                                <input type="date" class="form-control" id="event_end_date" name="event_end_date" value="<?php echo $row['event_end_date']; ?>" readonly>
                            </div>
                        </div>
                    
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-outline">
                                <label for="event_competition_web" class="form-label">Event Competition Web:</label>
                                <input type="text" class="form-control" id="event_competition_web" name="event_competition_web" value="<?php echo $row['event_competition_web']; ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="form-outline">
                                <label for="event_email" class="form-label">Email:</label>
                                <input type="text" class="form-control" id="event_email" name="event_email" value="<?php echo $row['event_email']; ?>" readonly>
                            </div>
                        </div>
                    
                    </div>
                    
                    <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                    <input type="hidden" name="update_event_submit" value="1">
                    <button id="saveButton" type="submit" class="btn btn-success" style="display:none;">Spremi</button>
                </form>

                </div>
            </div>
        </div>
        <?php
    }}
    ?>
        <div class="col-md-4 mb-4">
        <?php
            $sql = "SELECT * FROM ardf_competition WHERE event_id = $event_id";
            $result = mysqli_query($mysqli, $sql);
            
            // Provjeri jesu li podaci pronađeni
            if (mysqli_num_rows($result) > 0) {
                // Prolazi kroz svaki red rezultata
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <!-- Kartica za natjecanje -->
                        <div class="card mb-4">
                            <div class="card-header py-3">
                            <h5 class="mb-0">Natjecanje <b><?php echo $row['competition_name']; ?></b></h5>
                            </div>
                            <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                Datum održavanja
                                <span><?php echo date("d.m.Y", strtotime($row['competition_start_date'])); ?></span>
                                </li>
                                <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                Okupljanje
                                <span><?php echo date("H:i", strtotime($row['gathering_time'])); ?></span>
                                </li>
                                <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                Start
                                <span><?php echo date("H:i", strtotime($row['competition_start_time'])); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                    <div>
                                        <strong>Kotizacija</strong>
                                    </div>
                                    <span><strong><?php echo $row['competition_fee']; ?></strong></span>
                                </li>

                            </ul>
                    
                            <button type="button" class="btn btn-primary btn-lg btn-block" onclick="editCompetition(<?php echo $row['competition_id']; ?>)">
                                Uredi
                            </button>
                            

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
        
    </div>
  
  </div>
  <script>
    function editCompetition(competitionId) {
        window.location.href = "competition.php?competition_id=" + competitionId;
    }
  </script>
</body>
</html>
