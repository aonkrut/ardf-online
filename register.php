<?php
include 'config.php';

$registration_message = ''; 

if(isset($_POST['register'])) {
    
    if(empty($_POST['name']) || empty($_POST['surname']) || empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
        $registration_message = "Molimo popunite sva polja.";
    } else {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $check_query = "SELECT * FROM ardf_user WHERE username='$username' OR email='$email'";
        $check_result = $mysqli->query($check_query);

        if($check_result->num_rows > 0) {
            $registration_message = "Korisničko ime ili email već postoje. Molimo odaberite drugo.";
        } else {
            $insert_query = "INSERT INTO ardf_user (name, surname, username, email, password) VALUES ('$name', '$surname', '$username', '$email', '$hashed_password')";
            if($mysqli->query($insert_query)) {
                $registration_message = "Registracija uspješna. Molimo prijavite se.";
            } else {
                $registration_message = "Greška prilikom registracije. Molimo pokušajte ponovo.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARDF-online</title>
    
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
    <?php include 'navigation.php'; ?>

    <div class="form-signin m-auto mt-5">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h1 class="h3 mb-1 fw-normal">Registracija korisničkog računa</h1>
            <a class="fw-normal" href="login.php">Imate korisnički račun?</a>
            <?php if(!empty($registration_message)) { ?>
                <div class="alert alert-<?php echo ($registration_message == "Registracija uspješna. Molimo prijavite se.") ? 'success' : 'danger'; ?>" role="alert">
                    <?php echo $registration_message; ?>
                </div>
            <?php } ?>

            <div class="form-floating">
                <input type="text" name="name" class="form-control mt-3" id="name" placeholder="Ime">
                <label for="name">Ime</label>
            </div>

            <div class="form-floating">
                <input type="text" name="surname" class="form-control mt-3" id="surname" placeholder="Prezime">
                <label for="surname">Prezime</label>
            </div>

            <div class="form-floating">
                <input type="text" name="username" class="form-control mt-3" id="username" placeholder="Korisničko ime">
                <label for="username">Korisničko ime</label>
            </div>

            <div class="form-floating">
                <input type="email" name="email" class="form-control mt-3" id="email" placeholder="Email">
                <label for="email">Email</label>
            </div>

            <div class="form-floating">
                <input type="password" name="password" class="form-control mt-3" id="password" placeholder="Lozinka">
                <label for="password">Lozinka</label>
            </div>

            <button class="btn btn-primary w-100 py-2 mt-4" type="submit" name="register">Registriraj se</button>
        </form>
    </div>
</body>
</html>

