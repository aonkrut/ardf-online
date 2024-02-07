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
include 'config.php';?>
<?php



if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user_id = $_GET['user_id'];
    $_SESSION['a'] = '0';
    if (isset($_GET['competition_id'])) {
        $competition_id = $_GET['competition_id'];
    }
    else{
        $competition_id="0";
        header("Location: login.php");
        exit();
    }}

$check_entry_query = "SELECT * FROM ardf_entries WHERE entry_user_id = ? AND entry_competition_id = ?";
$stmt_check_entry = $mysqli->prepare($check_entry_query);
$stmt_check_entry->bind_param("ii", $user_id, $competition_id);
$stmt_check_entry->execute();
$stmt_check_entry->store_result();

// Provjerite ima li rezultata (tj. je li korisnik već prijavljen)
if ($stmt_check_entry->num_rows > 0) {
    
    // Ispis poruke "Već ste prijavljeni"
    echo "<h1>Već ste prijavljeni</h1>";
    
    // Preusmjeravanje korisnika na stranicu za pregled natjecanja nakon kratkog vremenskog odgađanja
    echo '<script>';
    echo 'setTimeout(function() {';
    echo 'window.location.href = "view_competition.php?competition_id=' . $competition_id . '";';
    echo '}, 1500);';
    echo '</script>';

    exit(); // Prekinite izvođenje skripte nakon preusmjeravanja
}

// SQL upit za dohvaćanje informacija o korisniku iz tablice ardf_user na temelju user_id
$sql = "SELECT name, surname, user_date_of_birth, user_call FROM ardf_user WHERE user_id = ?";

// Priprema upita
$stmt = $mysqli->prepare($sql);

if ($stmt) {
    // Bindanje parametara i izvršavanje upita
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Povezivanje rezultata
    $stmt->bind_result($name, $surname, $user_date_of_birth, $user_call);

    // Dohvaćanje redaka rezultata
    $stmt->fetch();

    // Zatvaranje upita
    $stmt->close();
} else {
    // Greška u pripremi upita
    echo "Error: " . $mysqli->error;
}
$natjecateljska_starost=19;
// Zatvaranje veze s bazom podataka
$mysqli->close();

// Prikaz informacija o korisniku u formi
// Ovdje možete uključiti ranije prikazanu formu ili izvršiti bilo kakvu drugu željenu logiku s dohvaćenim podacima
?>

    <div class="container">
    <h3>Pojedinačna prijava</h3>
    <form action="action.php" method="post">
        <div class="form-group">
            <label for="name">Ime:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="surname">Prezime:</label>
            <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $surname; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="dateOfBirth">Datum rođenja:</label>
            <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" value="<?php echo $user_date_of_birth; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="userCall">Pozivni znak:</label>
            <input type="text" class="form-control" id="userCall" name="userCall" value="<?php echo $user_call; ?>" readonly>
        </div>
        <div class="form-group">
    <label for="category">Odaberite kategoriju:</label>
    <select class="form-control" id="category" name="category">
        <?php
        include 'config.php'; // Uključivanje datoteke za povezivanje na bazu podataka

        // Dohvaćanje natjecateljske starosti na temelju datuma rođenja korisnika iz tablice ardf_user
        $current_year = date("Y"); // Trenutna godina
        $user_birth_year = date("Y", strtotime($user_date_of_birth)); // Godina rođenja korisnika
        $natjecateljska_starost = $current_year - $user_birth_year;

        // Dohvaćanje spola korisnika iz tablice ardf_user na temelju user_id iz sesije
        $user_id = $_SESSION['user_id'];
        $sex_query = "SELECT user_sex FROM ardf_user WHERE user_id = ?";
        $stmt = $mysqli->prepare($sex_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($user_sex);
        $stmt->fetch();
        $stmt->close();

        // SQL upit za dohvaćanje kategorija iz tablice ardf_all_categories koje odgovaraju natjecateljskoj starosti i spolu korisnika
        $category_query = "SELECT * FROM ardf_all_categories WHERE ? BETWEEN category_youngest AND category_oldest AND category_sex = ?";

        // Priprema upita
        $stmt = $mysqli->prepare($category_query);

        if ($stmt) {
            // Bindanje parametara i izvršavanje upita
            $stmt->bind_param("is", $natjecateljska_starost, $user_sex);
            $stmt->execute();

            // Povezivanje rezultata
            $result = $stmt->get_result();

            // Iteriranje kroz rezultat i prikazivanje opcija u select elementu
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
            }

            // Zatvaranje upita
            $stmt->close();
        } else {
            // Greška u pripremi upita
            echo "Error: " . $mysqli->error;
        }

        // Zatvaranje veze s bazom podataka
        $mysqli->close();
        ?>
    </select>
</div>

<input type="hidden" name="action" value="individual_entry"/>
<input type="hidden" name="competition_id" value="<?php echo $competition_id; ?>">
        <button type="submit" class="btn btn-primary mt-2">Pošalji prijavu</button>
    </form>
</div>

</body>
</html>