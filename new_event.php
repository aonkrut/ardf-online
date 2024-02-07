<?php
include 'navigation.php';
include 'config.php';

// Inicijalizacija varijabli za default vrijednosti
$event_name = $event_start_date = $event_end_date = $event_coordinates = $event_location = $event_competition_web = $event_email = "";

// Provjera da li je forma submitana
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obrada podataka forme
    $event_name = $_POST["event_name"];
    $event_start_date = $_POST["event_start_date"];
    $event_end_date = $_POST["event_end_date"];
    $event_location = $_POST["event_location"];
    $event_coordinates = $_POST["event_coordinates"];
    $event_competition_web = $_POST["event_competition_web"];
    $event_email = $_POST["event_email"];
    $event_club_id = $_SESSION['club_id'];
    $event_organizer_id = $_SESSION['user_id'];
    $event_country_id = $_POST["country"];

    // Unos novog događaja
    $sql_insert_event = "INSERT INTO ardf_event (event_name, event_start_date, event_end_date, event_club_id, event_country_id, event_location, event_competition_web, event_email, event_organizer_id, event_cordinates) VALUES ('$event_name', '$event_start_date', '$event_end_date', '$event_club_id', '$event_country_id', '$event_location', '$event_competition_web', '$event_email', '$event_organizer_id', '$event_coordinates')";
    
    if ($mysqli->query($sql_insert_event) === TRUE) {
        // Dohvaćanje event_id-a
        $event_id = $mysqli->insert_id;
        // Proslijediti event_id na sljedeći korak
        header("Location: admin_event.php?event_id=$event_id");
        exit;
    } else {
        echo "Error inserting event: " . $mysqli->error;
    }
}

?>

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
    
<div class="container mt-2">
        
   <h3 class="mt-3 mb-2">Događaj</h3>
   <hr>
  
   <div class="row mt-2">
       <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
           <div class="row">
               <div class="col-md-2 mb-3">
                   <label for="event_club_id" class="form-label">Klub ID:</label>
                   <input type="text" class="form-control" id="event_club_id" name="event_club_id" value="<?php $club_id=$_SESSION['club_id'];echo "$club_id";?>" readonly disabled>
               </div>
               <div class="col-md-2 mb-3">
                   <label for="event_organizer_id" class="form-label">Event Organizer ID:</label>
                   <input type="text" class="form-control" id="event_organizer_id" name="event_organizer_id" value="<?php $username = $_SESSION['username'];echo "$username  ";?>" readonly disabled>
               </div>
               <div class="form-group col-md-2 mb-3">
                   <label for="country" class="form-label">Država:</label>
                   <?php
                       include 'config.php';
                       $sql_countries = "SELECT * FROM ardf_country";
                       $result_countries = $mysqli->query($sql_countries);
                       if ($result_countries->num_rows > 0) {
                           echo '<select class="form-control" id="country" name="country" required>';
                           echo '<option value="">Odaberite državu</option>';
                           while ($row_country = $result_countries->fetch_assoc()) {
                               echo '<option value="' . $row_country['country_id'] . '">' . $row_country['country_name'] . '</option>';
                           }
                           echo '</select>';
                       } else {
                           echo 'Nema dostupnih država.';
                       }
                       $mysqli->close();
                   ?>
               </div>
           </div>
           <div class="row">
               <div class="col-md-6 mb-3">
                   <label for="event_name" class="form-label">Event Name:</label>
                   <input type="text" class="form-control" id="event_name" name="event_name" value="<?php echo $event_name; ?>">
               </div>
               
               
           </div>
           
           <div class="row"> 
               <div class="col-md-3 mb-3">
                   <label for="event_start_date" class="form-label">Start Date:</label>
                   <input type="date" class="form-control" id="event_start_date" name="event_start_date" value="<?php echo $event_start_date; ?>">
               </div>
               <div class="col-md-3 mb-3">
                   <label for="event_end_date" class="form-label">End Date:</label>
                   <input type="date" class="form-control" id="event_end_date" name="event_end_date" value="<?php echo $event_end_date; ?>">
               </div>
           </div>
           <div class="row">
               <div class="mb-3 col-md-3">
                   <label for="event_location" class="form-label">Lokacija:</label>
                   <input type="text" class="form-control" id="event_location" name="event_location" value="<?php echo $event_location; ?>">
               </div>
               <div class="mb-3 col-md-3">
                   <label for="event_coordinates" class="form-label"> Koordinate:</label>
                   <input type="text" class="form-control" id="event_coordinates" name="event_coordinates" value="<?php echo $event_coordinates; ?>">
               </div>
           </div>
           <div class="row">
               <div class="mb-3 col-md-3">
                   <label for="event_competition_web" class="form-label">Event Competition Web:</label>
                   <input type="text" class="form-control" id="event_competition_web" name="event_competition_web" value="<?php echo $event_competition_web; ?>">
               </div>
               <div class="mb-3 col-md-3">
                   <label for="event_email" class="form-label">Event Email:</label>
                   <input type="text" class="form-control" id="event_email" name="event_email" value="<?php echo $event_email; ?>">
               </div>
           </div>
           <br>
           <button type="submit" class="btn btn-success">Spremi</button>
       </form>
   </div>
</div>
</body>
</html>
