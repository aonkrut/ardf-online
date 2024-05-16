<!DOCTYPE html>
<html lang="hr">
<head>
    <title>Škartoc ljubavi</title>
    <meta charset="UTF-8">
    <meta name="description"
        content="Škartoc ljubavi - Prvi street food truck u Međimurju koji pruža ukusne burgere i gastronomska iskustva. Posjetite nas i uživajte u vrhunskim jelima.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="icon" href="slike/lgo2.svg" type="image/icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="keywords"
        content="Škartoc ljubavi,Škartoc Ljubavi, Ljubav, Škartoc, street food, Međimurje, burgeri, gastronomija, food truck, catering, catering u Međimurju, firme, pričesti, ketering, hrana, privatne zabave, ljubav, vjenčanja, street food Međimurje, mobilni catering, gourmet hrana, festivali, događaji, team building, događaj organizacija, Škartoc ljubavi, street food Međimurje, kako naručiti catering, događaj organizacija Međimurje, cijene cateringa, Škartoc ljubavi menu, gdje pronaći Škartoc ljubavi, street food truck najam, catering za zabave, catering za 500 ljudi, catering za događaje, catering za vjenčanja, hrana za firme, street food catering, najam food trucka za evente, gourmet burgeri, street food festivali, catering usluge Međimurje, najam food trucka za zabave, hrana za privatne evente, ketering, krstitke hrana, kvalitetna hrana, premium burgeri, prilagođeni meni, vege hrana ">
    <meta name="author" content="Ivica Šipuš">
    <meta name="robots" content="index, follow">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="js/bootstrap.bundle.min.js"></script>


  <style>
    .container-bg {
      background-image: url('slike/slj_poz3.jpg');
      background-size: cover;
      background-position: center;
      height: 93vh;
      display: flex;
      align-items: center;
    }
    .kontakt {
    margin: auto;
    max-width: 25vw;
    text-align: left;
  }

  @media screen and (max-width: 768px) {
    .kontakt {
      max-width: 85vw; 
    }
  }

  .kontakt p {
    margin-bottom: 10px;
  }

  footer {
    background-color: #343a40;
    color: white;
    padding: 40vw 0;
  }
  </style>

</head>
<body onload="postaviPozdrav()">
<?php 
    include "spajanje.php";
include("nav.php");
?>

<div class="container-fluid container-bg" id="#" style="padding-top: 100px;">
    <div class="container">
      <div class="row">
      <div class="col-md-6">
          <h1 class="display-4" style="font-family: 'Lobster', cursive; color:white;">Škartoc ljubavi</h1>
          <p id="pozdrav" class="lead" style="font-family: 'Raleway', cursive; color:white;">Pozdrav!</p>

        </div>
      </div>
    </div>
  </div>
<br>
<div class="container-fluid" id="o_nama" style="padding-top: 100px;">

  <div class="container" >
    <h2 class="text-center" style="font-family: 'Lobster', cursive;" >O nama</h2>
    <p class="text-center lead">Škartoc Ljubavi je s ljubavlju osmišljen food truck koji je osvojio srca brojnih gurmana. <br>
      Naša priča počinje na festivalima, privatnim eventima i raznim događanjima diljem sjevernog dijela zemlje. <br> 
      Naša strast je pripremiti najukusnije street food varijacije i pružiti vrhunsku hranu koja osvaja nepce i dušu.
    </p>
    <div class="row justify-content-center" style="margin-top: 64px;">
      <div class="col-lg-4 text-center">
        <i class="fa fa-heart fa-5x mb-4"></i>
        <h3 class="text-center">Ljubav</h3>
        <p class="text-center">Svaki obrok koji pripremamo ima poseban pečat ljubavi, naši obroci su ljubavna pisma gastronomiji i vašem nepcu.</p>
      </div>
      <div class="col-lg-4 text-center">
        <i class="fa fa-cutlery fa-5x mb-4"></i>
        <h3 class="text-center">Hrana</h3>
        <p class="text-center">Naša hrana je umjetnost, cilj nam je očarati vas kvalitetom i nezaboravnim iskustvom uz svaki obrok.</p>
      </div>
      <div class="col-lg-4 text-center">
        <i class="fa fa-car fa-5x mb-4"></i>
        <h3 class="text-center">Mobilnost</h3>
        <p class="text-center">Idemo na razne evente diljem sjeverne Hrvatske, pratite nas na društvenim mrežama za sljedeće lokacije.</p>
      </div>
    </div>
  </div>
</div>
<hr>

<br>
<div class="container-fluid bg-darker py-5" id="usluge">
  <div class="container">
    <h2 class="text-center text-white" style="font-family: 'Lobster', cursive;">Usluge</h2>
    <div class="row mt-5">
      <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 d-flex flex-column justify-content-between">
          <div class="card-header bg-dark border-bottom-0">
            <h4 class="card-title text-center mb-0" style="font-family: 'Raleway', cursive; color:white;">ORGANIZACIJA DOGAĐAJA</h4>
          </div>
          <div class="card-body border-top text-center">
            <ul class="list-unstyled">
              <li><b>Team building</b><br> Pružamo prostor, animaciju, poslugu i muziku, naša ekipa osigurava nezaboravno iskustvo koje potiče timsku suradnju</li>
              <hr>
              <li><b>Završne fešte</b><br> Organiziramo završne fešte, prilagođene vašim željama i potrebama: od dekoracija do zabave, brinemo se za svaki detalj</li>
              <hr>
              <li><b>Pričesti, krizme, vjenčanja</b><br> S posebnom pažnjom pristupamo organizaciji važnih trenutaka u životu od hrane do muzike</li>
            </ul>
          </div>
          <div class="card-footer bg-transparent text-center">
            <button class="btn btn-dark mx-auto" onclick="window.location.href='#kontakt'">KONTAKT</button>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 d-flex flex-column justify-content-between">
          <div class="card-header bg-dark border-bottom-0">
            <h4 class="card-title text-center mb-0" style="font-family: 'Raleway', cursive; color:white;">CATERING</h4>
          </div>
          <div class="card-body border-top text-center">
            <ul class="list-unstyled">
              <li><b>Personalizirani Meni</b><br> Svaki catering događaj je prilika da prilagodimo naš meni vašim željama</li>
              <hr>
              <li><b>Profesionalna Isporuka</b><br> Besprijekorna isporuka hrane na vašem događaju, svaki obrok dolazi svjež i spremno poslužen</li>
              <hr>
              <li><b>Doživljaj u Vašem prostoru</b><br> Uživajte u gurmanskim okusima u udobnosti Vašeg prostora i eventa</li>
            </ul>
          </div>
          <div class="card-footer bg-transparent text-center">
            <button class="btn btn-dark mx-auto" onclick="window.location.href='#kontakt'">KONTAKT</button>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 d-flex flex-column justify-content-between">
          <div class="card-header bg-dark border-bottom-0">
            <h4 class="card-title text-center mb-0" style="font-family: 'Raleway', cursive; color:white;">PRODAJA NA FESTIVALIMA</h4>
          </div>
          <div class="card-body border-top text-center">
            <ul class="list-unstyled">
              <li><b>Gurmansko putovanje</b><br> Razna i svakog puta nova ponuda pruža vam priliku da istražite nove okuse i kombinacije</li>
              <hr>
              <li><b>Festival Vibe</b><br> Doza pozitivne energije, nismo samo food truck, već i dio festivalske atmosfere</li>
              <hr>
              <li><b>Brza Posluga</b><br> Brzo ćete se vratiti festivalu, noseći sa sobom ukusne obroke i nezaboravne trenutke</li>
            </ul>
          </div>
          <div class="card-footer bg-transparent text-center">
            <button class="btn btn-dark mx-auto" onclick="window.location.href='#kontakt'">KONTAKT</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid py-5" id="galerija" style="background-color: #212121">
  <div class="container">
  <h2 class="text-center text-white" style="font-family: 'Lobster', cursive;">Galerija</h2>
    <p class="text-center text-white-50">Istaknuti trenuci</p>

    <!-- Modal -->
    <div id="imageModal" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          
          <div class="modal-body">
            <img id="modalImage" src="" class="img-fluid" alt="Škartoc Ljubavi">
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-6 mb-4">
        <img src="slike/galerija/slj15.jpg" class="img-fluid rounded w-100" onclick="openModal('slike/galerija/slj15.jpg')" alt="Škartoc Ljubavi" loading="auto">
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <img src="slike/galerija/slj2.jpeg" class="img-fluid rounded w-100" onclick="openModal('slike/galerija/slj2.jpeg')" alt="Škartoc Ljubavi" loading="auto">
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <img src="slike/galerija/slj14.jpg" class="img-fluid rounded w-100" onclick="openModal('slike/galerija/slj14.jpg')" alt="Škartoc Ljubavi" loading="auto">
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <img src="slike/galerija/slj4.jpeg" class="img-fluid rounded w-100" onclick="openModal('slike/galerija/slj4.jpeg')" alt="Škartoc Ljubavi" loading="auto">
      </div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-6 mb-4">
        <img src="slike/galerija/slj5.jpg" class="img-fluid rounded w-100" onclick="openModal('slike/galerija/slj5.jpg')" alt="Škartoc Ljubavi" loading="auto">
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <img src="slike/galerija/slj6.jpeg" class="img-fluid rounded w-100" onclick="openModal('slike/galerija/slj6.jpeg')" alt="Škartoc Ljubavi" loading="auto">
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <img src="slike/galerija/slj1.jpg" class="img-fluid rounded w-100" onclick="openModal('slike/galerija/slj1.jpg')" alt="Škartoc Ljubavi" loading="auto">
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <img src="slike/galerija/slj8.jpeg" class="img-fluid rounded w-100" onclick="openModal('slike/galerija/slj8.jpeg')" alt="Škartoc Ljubavi" loading="auto">
      </div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-6 mb-4">
        <img src="slike/galerija/slj17.jpg" class="img-fluid rounded w-100" onclick="openModal('slike/galerija/slj17.jpg')" alt="Škartoc Ljubavi" loading="auto">
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <img src="slike/galerija/slj11.jpg" class="img-fluid rounded w-100" onclick="openModal('slike/galerija/slj11.jpg')" alt="Škartoc Ljubavi" loading="auto">
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <img src="slike/galerija/slj10.jpg" class="img-fluid rounded w-100" onclick="openModal('slike/galerija/slj10.jpg')" alt="Škartoc Ljubavi" loading="auto">
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <img src="slike/galerija/slj12.jpg" class="img-fluid rounded w-100" onclick="openModal('slike/galerija/slj12.jpg')" alt="Škartoc Ljubavi" loading="auto">
      </div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-6 mb-4">
        <img src="slike/galerija/slj3.jpg" class="img-fluid rounded w-100" onclick="openModal('slike/galerija/slj3.jpg')" alt="Škartoc Ljubavi" loading="auto">
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <img src="slike/galerija/slj13.jpg" class="img-fluid rounded w-100" onclick="openModal('slike/galerija/slj13.jpg')" alt="Škartoc Ljubavi" loading="auto">
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <img src="slike/galerija/slj7.jpeg" class="img-fluid rounded w-100" onclick="openModal('slike/galerija/slj7.jpeg')" alt="Škartoc Ljubavi" loading="auto">
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <img src="slike/galerija/slj16.jpg" class="img-fluid rounded w-100" onclick="openModal('slike/galerija/slj16.jpg')" alt="Škartoc Ljubavi" loading="auto">
      </div>
    </div>
  </div>
</div>



<div class="container py-5" id="kontakt">
  <div class="row">
    <div class="col-md-12">
      <div class="text-center">
      <a href="#"><img src="slike/lgo2.svg" width="150" height="150" class="me-3" alt="Škartoc"></a>
        <h2 style="font-family: 'Lobster', cursive;">Kontaktirajte nas!</h2>
        <p class="lead">Imate li upit, primjedbu ili pohvalu?</p>
      </div>
      <div class="kontakt mt-5">
        <p><i class="fa fa-phone fa-fw fa-2x"></i> Broj: +385 97 711 6276</p>
        <p><i class="fa fa-envelope fa-fw fa-2x"></i> Email: skartocljubavi@gmail.com</p>
        <p><i class="fa fa-map-marker fa-fw fa-2x"></i> Sjedište: Borisa Kidriča 13, Sveta Marija</p>
        <p><a href="https://www.facebook.com/skartocljubavi/" target="_blank"><i class="fa fa-facebook-official fa-fw fa-2x"></i></a> Facebook: <a href="https://www.facebook.com/skartocljubavi/" target="_blank">Škartoc Ljubavi</a></p>
        <p><a href="https://www.instagram.com/skartocljubavi/" target="_blank"><i class="fa fa-instagram fa-fw fa-2x"></i></a> Instagram: @<a href="https://www.instagram.com/skartocljubavi/" target="_blank">skartocljubavi</a></p>
      </div>
    </div>
  </div>
</div>

<footer class="text-center py-5">
  <a href="#" class="btn btn-light"><i class="fa fa-arrow-up"></i> Na početak</a>
  <div class="social-icons mt-4">
    <a href="https://www.facebook.com/skartocljubavi/" target="_blank" class="text-white"><i class="fa fa-facebook-official fa-lg mx-3"></i></a>
    <a href="https://www.instagram.com/skartocljubavi/" target="_blank" class="text-white"><i class="fa fa-instagram fa-lg mx-3"></i></a>
  </div>
</footer>
<script>
  function openModal(imageUrl) {
    var modalImage = document.getElementById("modalImage");
    modalImage.src = imageUrl;
    $('#imageModal').modal('show');
    //mogućnost odbacivanje modala klikom na sliku
    modalImage.onclick = function() {
      $('#imageModal').modal('hide');
    }
    //mogućnost odbacivanje modala klikom na gumb x
    $('#imageModal').on('hidden.bs.modal', function() {
      modalImage.src = "";
    });
  
  }

  function postaviPozdrav() {
    var ime = document.cookie.split('; ').find(row => row.startsWith('ime')).split('=')[1];
    var pozdravParagraf = document.getElementById("pozdrav");
    if (ime) {
      pozdravParagraf.textContent = "Dobrodošli natrag, " + ime + "!";
    } else {
      pozdravParagraf.textContent = "Dobrodošli!";
    }
  }

  // Pozivamo funkciju odmah nakon učitavanja stranice
  window.onload = postaviPozdrav;
</script>
</body>
</html>
