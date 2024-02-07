<!DOCTYPE html>
<html lang="hr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARDF online</title>
    
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
<body>
<?php
        include 'navigation.php';
    ?>
<?php

include 'config.php'; 

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM ardf_user WHERE username = ? OR email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['username'] = $username;
            $_SESSION['club_id'] = '0';
            $_SESSION['a'] = '0';
            $user_id=$row['user_id'];
                
                $club_id_query = "SELECT member_club_id FROM ardf_club_members WHERE member_user_id = $user_id";
                $club_id_result = $mysqli->query($club_id_query); 
        
                if ($club_id_result && $club_id_result->num_rows > 0) { 
                    $club_id_row = $club_id_result->fetch_assoc(); 
                    $club_id = $club_id_row['member_club_id']; 
                    $_SESSION['club_id'] = $club_id; 
                }
            
            header("location: index.php");
            exit();
        } else {
            $login_error = "Neuspješna prijava. Provjerite korisničko ime i lozinku.";
        }
    } else {
        $login_error = "Neuspješna prijava. Provjerite korisničko ime i lozinku.";
    }

    $stmt->close();
    $mysqli->close();
}
?>



<?php if(isset($_SESSION['username'])) { ?>
    <p> Već ste prijavljeni </p>
<?php } else { ?>
    <div class="form-signin m-auto mt-5">
        <form method="post" action="login.php">
            <h1 class="h3 mb-1 fw-normal">Prijava u sustav</h1>
            <a class="fw-normal" href="register.php">Nemate korisnički račun?</a>

            <?php if(isset($login_error)) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $login_error; ?>
                </div>
            <?php } ?>

            <div class="form-floating">
                <input type="text" name="username" class="form-control mt-3" id="floatingInput" placeholder="Username">
                <label for="floatingInput">Username ili email</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Lozinka</label>
                
            </div>
            <button class="btn btn-primary w-100 py-2 mt-3" type="submit" value="login">Sign in</button>
        </form>
    </div>
<?php } ?>

</body>
</html>
