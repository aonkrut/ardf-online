<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script defer src="js/bootstrap.bundle.min.js"></script>
    
    <style>
        .form-signin {
            width: 75%; 
        }

        @media (min-width: 768px) {
            .form-signin {
                width: 25%; 
            }
        }
      
    </style>
</head>
<body>
<?php
include 'config.php'; 

include 'navigation.php';

$username = $_SESSION['username'];

// Priprema upita
$sql = "SELECT * FROM ardf_user WHERE username = '$username'";

// Izvršavanje upita
$result = $mysqli->query($sql);

// Provjera rezultata
if($result->num_rows > 0){
    // Prikazivanje forme za uređivanje informacija
    while($row = $result->fetch_assoc()){
?>
        
</div>
    <div class=" m-5">
    <h3 class="d-inline">Informacije o korisniku: <b><?php echo $row['name']; ?> <?php echo $row['surname']; ?></b> </h3>
    <a href="#" id="editProfile">Uredi profil</a>
    
<hr>
<div class="row g-0 text-left">
    <div class="col-sm-6 col-md-8">
        <h5>Općenito</h5>
        
        <form action="action.php" method="post" id="userForm">
    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
    <div class="form-group row mt-1">
        <label for="name" class="col-sm-2 col-form-label">Ime:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>" readonly>
        </div>
    </div>
    <div class="form-group row mt-1">
        <label for="surname" class="col-sm-2 col-form-label">Prezime:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $row['surname']; ?>" readonly>
        </div>
    </div>
    <div class="form-group row mt-1">
        <label for="username" class="col-sm-2 col-form-label">Korisničko ime:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" readonly>
        </div>
    </div>
    <div class="form-group row mt-1">
        <label for="email" class="col-sm-2 col-form-label">Email:</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" readonly>
        </div>
    </div>
    <div class="form-group row mt-1">
    <label for="dob" class="col-sm-2 col-form-label">Datum rođenja:</label>
    <div class="col-sm-10">
        <?php
        // Konverzija formata datuma iz baze (Y-m-d) u format koji će se prikazati korisniku (d.m.Y)
        $dob_display = date('d.m.Y', strtotime($row['user_date_of_birth']));
        ?>
        <input type="text" class="form-control" id="dob" name="dob" value="<?php echo $dob_display; ?>" readonly>
    </div>
</div>

    <div class="form-group row mt-1">
        <label for="sex" class="col-sm-2 col-form-label">Spol:</label>
        <div class="col-sm-10">
            <select class="form-control" id="sex" name="sex" disabled> 
                <option value="M" <?php if ($row['user_sex'] == 'M') echo 'selected'; ?>>Muško</option>
                <option value="F" <?php if ($row['user_sex'] == 'F') echo 'selected'; ?>>Žensko</option>
            </select>
        </div>
    </div>
    <div class="form-group row mt-1">
        <label for="call" class="col-sm-2 col-form-label">CALL:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="call" name="call" value="<?php echo $row['user_call']; ?>" maxlength="10">
        </div>
    </div>
    <div class="form-group row mt-1">
        <div class="col-sm-10 offset-sm-2">
            <input type="hidden" name="update_user_submit" value="1">
            <button type="submit" class="btn btn-primary" id="updateBtn" style="display: none;">Spremi</button>
        </div>
    </div>
</form>
    </div>
    

        </div>
        <hr>
        
    <div class="col-sm-6 col-md-4">
    <h5>Klub</h5>
    <?php
    // Pomoću PHP-a provjeri u koji klub je učlanjeni korisnik
    $user_id = $_SESSION['user_id']; // Pretpostavljajući da imate sesiju sa user_id

    // Priprema upita za pronalaženje kluba korisnika
    $club_query = "SELECT c.club_id, c.club_name, c.club_call, cc.country_name 
                   FROM ardf_club_members AS cm 
                   INNER JOIN ardf_club AS c ON cm.member_club_id = c.club_id
                   INNER JOIN ardf_country AS cc ON c.club_country_id = cc.country_id
                   WHERE cm.member_user_id = $user_id";
    
    $club_result = $mysqli->query($club_query);

    // Provjeri rezultat upita
    if ($club_result->num_rows > 0) {
        // Prikazi karticu s detaljima kluba
        $club_row = $club_result->fetch_assoc();
    ?>
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <a href="club.php" style="text-decoration: none; color: inherit;">
                    <h5 class="card-title"><?php echo $club_row['club_name']; ?></h5>
                </a>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $club_row['club_call']; ?></h6>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $club_row['country_name']; ?></h6>
                <!-- Ukloni iz kluba -->
                <a href="action.php?remove_from_club=<?php echo $club_row['club_id']; ?>" style="color: red;" class="card-link">Ukloni</a>
                <!-- Uredi klub -->
                
                <a href="club.php" class="card-link">
                <?php  
                if(isset($_SESSION['username'])) {
                    $username = $_SESSION['username'];
                    
                    // Priprema upita za pronalaženje korisnika u tablici ardf_user
                    $user_query = "SELECT user_id FROM ardf_user WHERE username = '$username'";
                    $user_result = $mysqli->query($user_query);
                    
                    if($user_result->num_rows > 0) {
                        $user_row = $user_result->fetch_assoc();
                        $user_id = $user_row['user_id'];
                        
                        // Provjera da li korisnik ima klub i da li je admin
                        $club_query = "SELECT * FROM ardf_club_members WHERE member_user_id = $user_id AND member_admin = true";
                        $club_result = $mysqli->query($club_query);
                        
                        if($club_result->num_rows > 0) {
                            echo "Uredi";
                        }
                    }
                }
                ?>
            </a>
            </div>
        </div>
    <?php
    } else {
        ?>
        <h7 class="card-title">Niste član nijednog kluba</h7>
            <form action="action.php" method="post">

            

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                Pridruži se klubu
            </button>

            <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Odaberite klub</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Odaberite klub:</p>
                            <select name="club_id" class="form-select" aria-label="Default select example">
                                <?php
                                // Učitavanje konfiguracije i konekcije na bazu podataka
                                include 'config.php';

                                // Upit za dohvaćanje klubova iz baze podataka
                                $sql = "SELECT club_id, club_name FROM ardf_club";

                                // Izvršavanje upita
                                $result = $mysqli->query($sql);

                                // Provjera rezultata i generiranje HTML opcija za padajući izbornik
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['club_id'] . '">' . $row['club_name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Nema dostupnih klubova</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
                            <button type="submit" class="btn btn-primary" name="action" value="join_club">Pridruži se</button>
                        </div>
                    </div>
                </div>
       
    </div>
</form> 

<form action="action.php" method="post">
 
            <!-- Gumb "Kreiraj novi klub" -->
            <button type="button" class="btn btn-primary mt-1" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                Kreiraj novi klub
            </button>

            <!-- Modal za kreiranje novog kluba -->
            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Unos novog kluba</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h2 class="mb-4">Unos novog kluba</h2>
                            <form action="action.php" method="post">
                                <div class="form-group">
                                    <label for="clubName">Naziv kluba:</label>
                                    <input type="text" class="form-control" id="clubName" name="clubName" required>
                                </div>
                                <div class="form-group">
                                    <label for="country">Država:</label>
                                    <?php
                                        // Povezivanje s bazom podataka
                                        include 'config.php';

                                        // Dohvaćanje država iz baze podataka
                                        $sql_countries = "SELECT * FROM ardf_country";
                                        $result_countries = $mysqli->query($sql_countries);

                                        // Provjera rezultata
                                        if ($result_countries->num_rows > 0) {
                                            // Ako postoje države, prikaži padajući izbornik
                                            echo '<select class="form-control" id="country" name="country" required>';
                                            echo '<option value="">Odaberite državu</option>';
                                            while ($row_country = $result_countries->fetch_assoc()) {
                                                echo '<option value="' . $row_country['country_id'] . '">' . $row_country['country_name'] . '</option>';
                                            }
                                            echo '</select>';
                                        } else {
                                            // Ako nema država, prikaži poruku
                                            echo 'Nema dostupnih država.';
                                        }

                                        // Zatvaranje konekcije
                                        $mysqli->close();
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label for="clubCall">Pozivni znak kluba:</label>
                                    <input type="text" class="form-control" id="clubCall" name="clubCall" required>
                                </div>
                                <input type="hidden" name="action" value="action_add_club"/>
                                <button type="submit" class="btn btn-primary">Dodaj klub</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
                        </div>
                    </div>
                </div>
         
    </div>
</form>
</br>
        
        <?php
    }
    ?>
    

</div>


</div>


<script>
    var myModal = document.getElementById('myModal')
var myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
})
</script>
<script>
    function enableEdit() {
        // Uklonite "readonly" atribut sa svih input polja
        document.querySelectorAll("input, textarea").forEach(function(element) {
            element.removeAttribute("readonly");
        });
        
        // Omogućite selekt polje za uređivanje
        document.getElementById('sex').removeAttribute('disabled');
        
        // Prikažite gumb "Ažuriraj"
        document.getElementById("updateBtn").style.display = "block";
    }

    // Dodajte event listener na gumb "Uredi profil"
    document.getElementById("editProfile").addEventListener("click", function(event) {
        event.preventDefault();
        enableEdit(); // Pozovite funkciju enableEdit() kada se klikne na gumb "Uredi profil"
    });
</script>


<?php

if (isset($_GET['success'])) {
    $successMessage = htmlspecialchars($_GET['success'], ENT_QUOTES, 'UTF-8');
    echo '<div class="alert alert-success">' . $successMessage . '</div>';
}
?>


</div>

</div>

    </div>


<?php
    }
} else{
    echo "Nema podataka.";
    header("Location: index.php");
}

?>
</body>
</html>

    