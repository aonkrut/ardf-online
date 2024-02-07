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

include 'config.php'; // Uključivanje datoteke za povezivanje na bazu podataka

// Definiranje $club_id
$club_id=$_SESSION['club_id'];
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
                           $is_admin=true;
                        }}
// SQL upit za dohvaćanje podataka članova kluba i njihovih detalja
$sql = "SELECT u.user_id, u.name, u.surname, u.user_date_of_birth, u.user_sex, u.user_call
        FROM ardf_club_members AS m
        INNER JOIN ardf_user AS u ON m.member_user_id = u.user_id
        WHERE m.member_club_id = ?";

// Priprema upita
$stmt = $mysqli->prepare($sql);

if ($stmt) {
    // Bindanje parametara
    $stmt->bind_param("i", $club_id);

    // Izvršavanje upita
    $stmt->execute();

    // Povezivanje rezultata
    $stmt->bind_result($userm_id, $name, $surname, $date_of_birth, $sex, $user_call);

    // Ispis podataka u tablici s Bootstrap 5 stilovima
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
        if ($is_admin==true){ echo "<td width='10%'>";?>
      <div class="row">
    <div class="col">
        <form action="action.php" method="post">
            <!-- Gumb "Uredi" koji otvara modal -->
            <button type="button" class="btn btn-primary mt-1 mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal2" data-user-id="<?php echo $userm_id; ?>" data-name="<?php echo $name; ?>" data-surname="<?php echo $surname; ?>" data-date-of-birth="<?php echo $date_of_birth; ?>" data-sex="<?php echo $sex; ?>" data-user-call="<?php echo $user_call; ?>">Uredi</button>

            <!-- Modal za uređivanje člana -->
            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Uredi člana</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h2 class="mb-4">Uredi člana</h2>
                            <form action="action.php" method="post" id="editMemberForm">
                                <div class="form-group">
                                    <label for="editName" class="form-label">Ime</label>
                                    <input type="text" class="form-control" id="editName" name="name" value="<?php echo $name; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="editSurname" class="form-label">Prezime</label>
                                    <input type="text" class="form-control" id="editSurname" name="surname" value="<?php echo $surname; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="editDateOfBirth" class="form-label">Datum rođenja</label>
                                    <input type="date" class="form-control" id="editDateOfBirth" name="dateOfBirth" value="<?php echo $date_of_birth; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="editSex" class="form-label">Spol</label>
                                    <select class="form-select" id="editSex" name="sex">
                                        <option value="M" <?php if($sex == 'M') echo 'selected'; ?>>Muško</option>
                                        <option value="F" <?php if($sex == 'F') echo 'selected'; ?>>Žensko</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="editUserCall" class="form-label">Pozivni znak</label>
                                    <input type="text" class="form-control" id="editUserCall" name="userCall" value="<?php echo $user_call; ?>">
                                </div>
                                <!-- Skriveno polje za slanje user_id -->
                                <input type="hidden" id="editUserId" name="user_id" value="<?php echo $userm_id; ?>">
                                <input type="hidden" name="action" value="edit_member">
                                <button type="submit" class="btn btn-success">Spremi</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col">
        
        <form action="action.php" method="post">
            <input type="hidden" name="userm_id" value="<?php echo $userm_id; ?>">
            <button type="submit" class="btn btn-danger mt-1 mb-1" name="action" value="remove_member" data-user-id="<?php echo $userm_id; ?>">Ukloni</button>
            
        </form>

    </div>
</div>

        <?php
        echo "</td>";}
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    // Zatvaranje upita
    $stmt->close();
} else {
    // Greška u pripremi upita
    echo "Error: " . $mysqli->error;
}


$mysqli->close();
?>
</div>
<!-- Gumb za dodavanje novog člana -->
<div class="container mt-2">
    <button type="button" class="btn btn-success mt-1" data-bs-toggle="modal" data-bs-target="#exampleModalNewMember">Dodaj novog člana</button>
</div>

<!-- Modal za dodavanje novog člana -->
<div class="modal fade" id="exampleModalNewMember" tabindex="-1" aria-labelledby="exampleModalLabelNewMember" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelNewMember">Dodaj novog člana</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h2 class="mb-4">Dodaj novog člana</h2>
                <form action="action.php" method="post" id="addNewMemberForm">
                    <div class="form-group">
                        <label for="newName" class="form-label">Ime</label>
                        <input type="text" class="form-control" id="newName" name="name" placeholder="Unesite ime">
                    </div>
                    <div class="form-group">
                        <label for="newSurname" class="form-label">Prezime</label>
                        <input type="text" class="form-control" id="newSurname" name="surname" placeholder="Unesite prezime">
                    </div>
                    <div class="form-group">
                        <label for="newDateOfBirth" class="form-label">Datum rođenja</label>
                        <input type="date" class="form-control" id="newDateOfBirth" name="dateOfBirth">
                    </div>
                    <div class="form-group">
                        <label for="newSex" class="form-label">Spol</label>
                        <select class="form-select" id="newSex" name="sex">
                            <option value="M">Muško</option>
                            <option value="F">Žensko</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="newUserCall" class="form-label">Pozivni znak</label>
                        <input type="text" class="form-control" id="newUserCall" name="userCall" placeholder="Unesite pozivni znak">
                    </div>
                    <input type="hidden" name="action" value="new_member">
                    <button type="submit" class="btn btn-primary">Spremi</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
            </div>
        </div>
    </div>
</div>





</div>
    
</body>
</html>