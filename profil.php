<?php
include "spajanje.php";
include "nav.php"; 
session_start();

$ime = $_SESSION['ime']; // Dohvaćanje imena iz sesije

// Postavljanje cookie-a
echo "<script>
document.cookie = 'ime=$ime; expires=Thu, 18 Dec 2025 12:00:00 UTC; path=/;';
</script>";

$prezime = $_SESSION['prezime'];
$email = $_SESSION['email'];
$korisnicko_ime = $_SESSION['korisnicko_ime'];
$id = $_SESSION['id'];

?>

<!DOCTYPE html>
<html lang="hr">
<head>
<title>Škartoc ljubavi</title>
<meta charset="UTF-8">
<meta name="description" content="Škartoc ljubavi - Prvi street food truck u Međimurju koji pruža ukusne burgere i gastronomska iskustva. Posjetite nas i uživajte u vrhunskim jelima.">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script defer src="js/bootstrap.bundle.min.js"></script>
<link rel="icon" href="slike/lgo2.svg" type="image/icon">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<meta name="keywords" content="Škartoc ljubavi,Škartoc Ljubavi, Ljubav, Škartoc, street food, Međimurje, burgeri, gastronomija, food truck, catering, catering u Međimurju, firme, pričesti, ketering, hrana, privatne zabave, ljubav, vjenčanja, street food Međimurje, mobilni catering, gourmet hrana, festivali, događaji, team building, događaj organizacija, Škartoc ljubavi, street food Međimurje, kako naručiti catering, događaj organizacija Međimurje, cijene cateringa, Škartoc ljubavi menu, gdje pronaći Škartoc ljubavi, street food truck najam, catering za zabave, catering za 500 ljudi, catering za događaje, catering za vjenčanja, hrana za firme, street food catering, najam food trucka za evente, gourmet burgeri, street food festivali, catering usluge Međimurje, najam food trucka za zabave, hrana za privatne evente, ketering, krstitke hrana, kvalitetna hrana, premium burgeri, prilagođeni meni, vege hrana ">
<meta name="author" content="Ivica Šipuš">
<meta name="robots" content="index, follow">
</head>
<body>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Osobni podaci</h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Ime:</strong> <?php echo $ime; ?></li>
            <li class="list-group-item"><strong>Prezime:</strong> <?php echo $prezime; ?></li>
            <li class="list-group-item"><strong>Email:</strong> <?php echo $email; ?></li>
            <li class="list-group-item"><strong>Korisničko ime:</strong> <?php echo $korisnicko_ime; ?></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
