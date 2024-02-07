<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARDF online</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<?php
include 'navigation.php';
include 'config.php';

// Provjera postoji li korisnik prijavljen
if (isset($_SESSION['username'])) {
    // Dohvaćanje korisničkog imena iz sesije
    $username = $_SESSION['username'];
    $club_id=$_SESSION['club_id'];

    // Priprema upita za dohvaćanje ID-a korisnika
    $user_query = "SELECT user_id FROM ardf_user WHERE username = '$username'";
    $user_result = $mysqli->query($user_query);

    if ($user_result->num_rows > 0) {
        $user_row = $user_result->fetch_assoc();
        $user_id = $user_row['user_id'];

        // Priprema upita za dohvaćanje podataka o klubu korisnika
        $club_query = "SELECT ardf_club.*, ardf_country.country_name 
                        FROM ardf_club_members 
                        JOIN ardf_club ON ardf_club_members.member_club_id = ardf_club.club_id 
                        JOIN ardf_country ON ardf_club.club_country_id = ardf_country.country_id 
                        WHERE member_user_id = $user_id";
        $club_result = $mysqli->query($club_query);

        if ($club_result->num_rows > 0) {
            // Prikaz informacija o klubu
            $club_row = $club_result->fetch_assoc();
?>
            <div class="container mt-5">
                <h3 class="d-inline">Informacije o klubu</h3>
                <?php
                if (isset($_SESSION['username'])) {
                    $username = $_SESSION['username'];

                    // Priprema upita za pronalaženje korisnika u tablici ardf_user
                    $user_query = "SELECT user_id FROM ardf_user WHERE username = '$username'";
                    $user_result = $mysqli->query($user_query);

                    if ($user_result->num_rows > 0) {
                        $user_row = $user_result->fetch_assoc();
                        $user_id = $user_row['user_id'];

                        // Provjera da li korisnik ima klub i da li je admin
                        $club_query = "SELECT * FROM ardf_club_members WHERE member_user_id = $user_id AND member_admin = true";
                        $club_result = $mysqli->query($club_query);
                        $is_admin=false;
                        if ($club_result->num_rows > 0) {
                            echo ' <a href="#" id="editClubLink">Uredi klub</a>';
                           $is_admin=true;
                        }

                    }
                }
                ?>
                <form id="clubForm" action="action.php" method="post">
                    <div class="mb-3">
                        <label for="clubName" class="form-label">Naziv kluba:</label>
                        <input type="text" class="form-control" id="clubName" name="clubName" value="<?php echo $club_row['club_name']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="clubCountry" class="form-label">Država:</label>
                        <select class="form-control" id="clubCountry" name="country" required>
                            <?php
                            // Povezivanje s bazom podataka
                            include 'config.php';

                            // Dohvaćanje država iz baze podataka
                            $sql_countries = "SELECT * FROM ardf_country";
                            $result_countries = $mysqli->query($sql_countries);

                            // Provjera rezultata
                            if ($result_countries->num_rows > 0) {
                                // Ako postoje države, prikaži padajući izbornik
                                while ($row_country = $result_countries->fetch_assoc()) {
                                    echo '<option value="' . $row_country['country_id'] . '"';
                                    if ($row_country['country_id'] == $club_row['club_country_id']) {
                                        echo ' selected';
                                    }
                                    echo '>' . $row_country['country_name'] . '</option>';
                                }
                            } else {
                                // Ako nema država, prikaži poruku
                                echo '<option value="">Nema dostupnih država</option>';
                            }

                            // Zatvaranje konekcije
                            $mysqli->close();
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="clubCall" class="form-label">Pozivni znak kluba:</label>
                        <input type="text" class="form-control" id="clubCall" name="clubCall" value="<?php echo $club_row['club_call']; ?>" readonly>
                        <?php if ($is_admin==true){ echo ' </br><a class="btn btn-light" href="club_members.php" id="editmember">Članovi kluba</a>';}?>
                    </div>
                    
                    <input type="hidden" name="action" value="action_edit_club"/>
                    <button type="submit" class="btn btn-success" id="saveChangesBtn" style="display: none;">Spremi promjene</button>
                </form>
            </div>

            <script>
                document.getElementById('editClubLink').addEventListener('click', function(event) {
                    event.preventDefault();
                    document.querySelectorAll('#clubForm input, #clubForm select').forEach(function(input) {
                        input.removeAttribute('readonly');
                    });
                    document.getElementById('saveChangesBtn').style.display = 'block';
                });
            </script>
<?php
        } else {
            echo "Niste član nijednog kluba.";
        }
    }
} else {
    echo "<div class='container mt-5'>
            <div class='alert alert-warning' role='alert'>
            Morate biti prijavljeni kako biste vidjeli informacije.
            </div>
        </div>";
}

?>

</div>
</body>
</html>
