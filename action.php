<?php
session_start(); 
include 'config.php'; // Uključivanje konfiguracije za bazu podataka
if ($_POST['action'] === 'individual_entry') {
    // Provjera postojanja potrebnih podataka u POST zahtjevu
    if (isset($_POST['name'], $_POST['surname'], $_POST['dateOfBirth'], $_POST['userCall'], $_POST['category'], $_POST['competition_id'])) {
        // Dohvaćanje podataka iz POST zahtjeva
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $dateOfBirth = $_POST['dateOfBirth'];
        $userCall = $_POST['userCall'];
        $category_id = $_POST['category'];
        $competition_id = $_POST['competition_id']; // Dodano
        $a=$_SESSION['a'] = '0';
        // SQL upit za unos nove pojedinačne prijave u tablicu ardf_entries
        $sql = "INSERT INTO ardf_entries (entry_user_id, entry_competition_id, entry_category_id) VALUES (?, ?, ?)";

        // Priprema upita
        $stmt = $mysqli->prepare($sql);

        if ($stmt) {
            // Dohvaćanje user_id iz sesije
            $user_id = $_SESSION['user_id'];

            // Bindanje parametara i izvršavanje upita za dodavanje nove pojedinačne prijave
            $stmt->bind_param("iii", $user_id, $competition_id, $category_id); // Dodano
            $stmt->execute();

            // Provjera uspješnosti izvršavanja upita
            if ($stmt->affected_rows > 0) {
                echo "Pojedinačna prijava je uspješno spremljena.";
                if ($a='0'){
                header("Location: view_competition.php?competition_id=$competition_id");
                }
                else{
                    header("Location: group_entry.php?competition_id=$competition_id");
                }
                
            } else {
                echo "Došlo je do greške prilikom spremanja pojedinačne prijave.";
            }

            // Zatvaranje upita
            $stmt->close();
        } else {
            // Greška u pripremi upita
            echo "Error: " . $mysqli->error;
        }
    } else {
        // Nisu svi potrebni podaci poslani u POST zahtjevu
        echo "Nisu svi potrebni podaci poslani.";
    }
} else {
    // Akcija nije postavljena na 'individual_entry'
    echo "Akcija nije ispravno postavljena.";
}

if(isset($_POST['action'])) {
    // Ako je akcija 'new_member', dodaj novog člana
    if($_POST['action'] === 'new_member') {
        // Podaci o novom članu iz obrasca
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $dateOfBirth = $_POST['dateOfBirth'];
        $sex = $_POST['sex'];
        $userCall = $_POST['userCall'];
        
        $clubId = $_SESSION['club_id'];

        // SQL upit za dodavanje novog člana u tablicu ardf_user
        $sqlInsertUser = "INSERT INTO ardf_user (name, surname, user_date_of_birth, user_sex, user_call) VALUES (?, ?, ?, ?, ?)";

        // Priprema upita za dodavanje novog člana u tablicu ardf_user
        $stmtInsertUser = $mysqli->prepare($sqlInsertUser);

        if ($stmtInsertUser) {
            // Bindanje parametara i izvršavanje upita za dodavanje novog člana u tablicu ardf_user
            $stmtInsertUser->bind_param("sssss", $name, $surname, $dateOfBirth, $sex, $userCall);
            $stmtInsertUser->execute();

            // Provjera uspješnosti izvršavanja upita za dodavanje novog člana u tablicu ardf_user
            if($stmtInsertUser->affected_rows > 0) {
                // Dobivanje ID-a novog člana
                $userId = $stmtInsertUser->insert_id;

                // SQL upit za dodavanje novog člana u tablicu ardf_club_members
                $sqlInsertMember = "INSERT INTO ardf_club_members (member_user_id, member_club_id) VALUES (?, ?)";

                // Priprema upita za dodavanje novog člana u tablicu ardf_club_members
                $stmtInsertMember = $mysqli->prepare($sqlInsertMember);

                if ($stmtInsertMember) {
                    // Bindanje parametara i izvršavanje upita za dodavanje novog člana u tablicu ardf_club_members
                    $stmtInsertMember->bind_param("ii", $userId, $clubId);
                    $stmtInsertMember->execute();

                    // Provjera uspješnosti izvršavanja upita za dodavanje novog člana u tablicu ardf_club_members
                    if($stmtInsertMember->affected_rows > 0) {
                        header("Location: club_members.php");
                        exit();
                    } else {
                        echo "Došlo je do greške prilikom dodavanja novog člana u tablicu ardf_club_members.";
                    }

                    // Zatvaranje upita za dodavanje novog člana u tablicu ardf_club_members
                    $stmtInsertMember->close();
                } else {
                    // Greška u pripremi upita za dodavanje novog člana u tablicu ardf_club_members
                    echo "Error: " . $mysqli->error;
                }
            } else {
                echo "Došlo je do greške prilikom dodavanja novog člana u tablicu ardf_user.";
            }

            // Zatvaranje upita za dodavanje novog člana u tablicu ardf_user
            $stmtInsertUser->close();
        } else {
            // Greška u pripremi upita za dodavanje novog člana u tablicu ardf_user
            echo "Error: " . $mysqli->error;
        }
    }
}
if($_POST['action'] === 'remove_member') {
    // Provjera je li postavljen user_id za korisnika koji se želi ukloniti
    if(isset($_POST['userm_id'])) {
        $userm_id = $_POST['userm_id']; // ID korisnika koji se želi ukloniti
        $current_user_id = $_SESSION['user_id']; // ID prijavljenog korisnika

        // Provjera je li prijavljeni korisnik pokušava ukloniti samog sebe
        if($userm_id != $current_user_id) {
            // SQL upit za brisanje člana kluba
            $sql = "DELETE FROM ardf_club_members WHERE member_user_id = ?";

            // Priprema upita
            $stmt = $mysqli->prepare($sql);

            if($stmt) {
                // Bindanje parametara i izvršavanje upita
                $stmt->bind_param("i", $userm_id);
                $stmt->execute();

                // Provjera je li korisnik uspješno uklonjen iz kluba
                if($stmt->affected_rows > 0) {
                    header("Location: club_members.php");
                } else {
                    echo "Došlo je do greške prilikom uklanjanja člana iz kluba.";
                    echo '<script>setTimeout(function() { window.location.href = "club_members.php"; }, 2500);</script>';
                }

                // Zatvaranje upita
                $stmt->close();
            } else {
                echo "Greška u pripremi upita.";
                echo '<script>setTimeout(function() { window.location.href = "club_members.php"; }, 2500);</script>';
            }
        } else {
            echo "Nije moguće ukloniti samog sebe iz kluba.";
            echo '<script>setTimeout(function() { window.location.href = "club_members.php"; }, 2500);</script>';
        }
    } else {
        echo "Nedostaje ID korisnika za uklanjanje.";
        echo '<script>setTimeout(function() { window.location.href = "club_members.php"; }, 2500);</script>';
    }
}


if(isset($_POST['action']) && $_POST['action'] === 'edit_member') {
    // Provjeri jesu li svi potrebni podaci poslani putem POST metode
    if(isset($_POST['user_id'], $_POST['name'], $_POST['surname'], $_POST['dateOfBirth'], $_POST['sex'], $_POST['userCall'])) {
        // Spremi poslane podatke
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $dateOfBirth = $_POST['dateOfBirth'];
        $sex = $_POST['sex'];
        $userCall = $_POST['userCall'];

        // Priprema SQL upita za ažuriranje podataka korisnika
        $sql = "UPDATE ardf_user SET name=?, surname=?, user_date_of_birth=?, user_sex=?, user_call=? WHERE user_id=?";
        $stmt = $mysqli->prepare($sql);
        
        // Veži parametre uz SQL upit
        $stmt->bind_param("sssssi", $name, $surname, $dateOfBirth, $sex, $userCall, $user_id);
        
        // Izvrši SQL upit
        $stmt->execute();

        // Nakon izvršenja SQL upita, prikaži odgovarajuću poruku
        echo "Podaci su uspješno ažurirani.";
        
        header("Location: club_members.php");
        
        // Zatvori pripremljeni upit
        $stmt->close();
    } else {
        // Ako nisu poslani svi potrebni podaci, prikaži poruku o grešci
        echo "Nisu poslani svi potrebni podaci.";
    }
} 






if(isset($_POST['update_event_submit'])){
  // Priprema podataka za unos u bazu
  $event_id = $_POST['event_id'];
  $event_name = $_POST['event_name'];
  $event_start_date = $_POST['event_start_date'];
  $event_end_date = $_POST['event_end_date'];
  $event_location = $_POST['event_location'];
  $event_coordinates = $_POST['event_coordinates'];
  $event_competition_web = $_POST['event_competition_web'];
  $event_email = $_POST['event_email'];
  $event_country_id = $_POST['country']; // Dobiveno iz select polja

  // SQL upit za ažuriranje podataka u bazi
  $sql_update_event = "UPDATE ardf_event SET 
                      event_name = '$event_name', 
                      event_start_date = '$event_start_date', 
                      event_end_date = '$event_end_date', 
                      event_location = '$event_location', 
                      event_cordinates = '$event_coordinates', 
                      event_competition_web = '$event_competition_web', 
                      event_email = '$event_email', 
                      event_country_id = '$event_country_id' 
                      WHERE event_id = $event_id";

  // Izvršavanje SQL upita
  if ($mysqli->query($sql_update_event) === TRUE) {
      // Uspješno ažuriranje
      header("Location: admin_event.php?event_id=$event_id");
      exit;
  } else {
      // Greška pri ažuriranju
      echo "Error updating event: " . $mysqli->error;
  }
}
if(isset($_POST['update_competition_submit'])){
    
    // Dohvaćanje podataka iz forme
    $competition_id = $_POST['competition_id'];
    $competition_name = $_POST['competition_name'];
    $competition_type = $_POST['competition_type'];
    $competition_start_date = $_POST['competition_start_date'];
    $competition_description = $_POST['competition_description'];
    $competition_start_entry_date = $_POST['competition_start_entry_date'];
    $competition_end_entry_date = $_POST['competition_end_entry_date'];
    $location = $_POST['location'];
    $coordinates = $_POST['coordinates'];
    $competition_start_time = $_POST['competition_start_time'];
    $gathering_time = $_POST['gathering_time'];
    $departure_to_start = $_POST['departure_to_start'];
    $goniometer_delay = $_POST['goniometer_delay'];

   
        // Priprema upita za ažuriranje podataka natjecanja
        $update_query = "UPDATE ardf_competition SET 
            competition_name = '$competition_name',
            competition_type_id = '$competition_type',
            competition_start_date = '$competition_start_date',
            competition_description = '$competition_description',
            competition_start_entry_date = '$competition_start_entry_date',
            competition_end_entry_date = '$competition_end_entry_date',
            competition_location = '$location',
            competition_coordinates = '$coordinates',
            competition_start_time = '$competition_start_time',
            gathering_time = '$gathering_time',
            departure_to_start = '$departure_to_start',
            goniometer_delay = '$goniometer_delay'
            WHERE competition_id = '$competition_id'";

        // Izvršavanje upita za ažuriranje podataka
        if ($mysqli->query($update_query) === true) {
            // Ažuriranje je uspješno
            header("Location: competition.php?competition_id=$competition_id");
            exit();
        } else {
            // Greška prilikom ažuriranja
            header("Location: competition.php?competition_id=$competition_id");
            exit();
        }
}


if(isset($_POST['update_user_submit'])){
    
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $dob = date('Y-m-d', strtotime($_POST['dob']));
    $sex = $_POST['sex'];
    $call = $_POST['call'];
    $username1 = $_POST['username']; // Dodano polje username

    // Provjera postojanja korisničkog imena ili e-pošte u bazi
    $check_query = "SELECT * FROM ardf_user WHERE (username = '$username1' OR email = '$email') AND user_id != '$user_id'";
    $check_result = $mysqli->query($check_query);

    if ($check_result->num_rows > 0) {
        // Korisničko ime ili e-pošta već postoje u bazi
        header("Location: profile.php?error=" . urlencode("Korisničko ime ili e-pošta već postoje"));
        exit();
    } else {
        // Provjera različitosti ažuriranih podataka od postojećih
        $user_query = "SELECT * FROM ardf_user WHERE user_id = '$user_id'";
        $user_result = $mysqli->query($user_query);
        $user_row = $user_result->fetch_assoc();

        if ($user_row['name'] == $name && $user_row['surname'] == $surname && $user_row['email'] == $email && $user_row['user_date_of_birth'] == $dob && $user_row['user_sex'] == $sex && $user_row['user_call'] == $call && $user_row['username'] == $username1) {
            // Podaci nisu promijenjeni
            header("Location: profile.php?error=" . urlencode("Nema promjena za ažuriranje"));
            exit();
        } else {
            // Priprema upita za ažuriranje podataka
            $sql = "UPDATE ardf_user SET name='$name', username='$username1', surname='$surname', email='$email', user_date_of_birth='$dob', user_sex='$sex', user_call='$call' WHERE user_id = '$user_id'";

            // Izvršavanje upita za ažuriranje podataka
            if ($mysqli->query($sql) === true) {
                // Ažuriranje je uspješno
                $_SESSION['username'] = $username1;
                header("Location: profile.php?success=" . urlencode("Podaci uspješno ažurirani"));
                exit(); // Prekid izvršavanja skripte nakon preusmjeravanja
            } else {
                // Greška prilikom ažuriranja
                header("Location: profile.php?error=" . urlencode("Greška prilikom ažuriranja"));
                exit();
            }
        }
    }
}


if (isset($_GET["action"]) && $_GET["action"] == "publish_event") {
    // Dobivanje potrebnih parametara iz URL-a
    $event_id = $_GET['event_id'];

    // Priprema upita za ažuriranje event_public na 1 (true) za odabrani događaj
    $sql_publish_event = "UPDATE ardf_event SET event_public = '1' WHERE event_id = $event_id";

    // Izvršavanje upita
    if ($mysqli->query($sql_publish_event) === TRUE) {
        // Uspješno objavljen
        header("Location: organisation.php?success=" . urlencode("Dogadjaj je uspješno objavljen."));
        exit;
    } else {
        // Greška prilikom objavljivanja
        header("Location: organisation.php?error=" . urlencode("Greška prilikom objavljivanja događaja: " . $mysqli->error));
        exit;
    }
}
if (isset($_GET["action"]) && $_GET["action"] == "depublish_event") {
    // Dobivanje potrebnih parametara iz URL-a
    $event_id = $_GET['event_id'];

    // Priprema upita za ažuriranje event_public na 1 (true) za odabrani događaj
    $sql_publish_event = "UPDATE ardf_event SET event_public = '0' WHERE event_id = $event_id";

    // Izvršavanje upita
    if ($mysqli->query($sql_publish_event) === TRUE) {
        // Uspješno objavljen
        header("Location: organisation.php?success=" . urlencode("Događaj je uspješno privatiziran."));
        exit;
    } else {
        // Greška prilikom objavljivanja
        header("Location: organisation.php?error=" . urlencode("Greška prilikom privatiziranja događaja: " . $mysqli->error));
        exit;
    }
}

// Logika za brisanje događaja
if (isset($_GET["action"]) && $_GET["action"] == "delete_event") {
    // Dobivanje potrebnih parametara iz URL-a
    $event_id = $_GET['event_id'];

    // Priprema upita za brisanje događaja iz baze podataka
    $sql_delete_event = "DELETE FROM ardf_event WHERE event_id = $event_id";

    // Izvršavanje upita
    if ($mysqli->query($sql_delete_event) === TRUE) {
        // Uspješno obrisan
        header("Location: organisation.php?success=" . urlencode("Dogadjaj je uspješno obrisan."));
        exit;
    } else {
        // Greška prilikom brisanja
        header("Location: organisation.php?error=" . urlencode("Greška prilikom brisanja događaja: " . $mysqli->error));
        exit;
    }
}


// Provjera je li korisnik poslao zahtjev za uklanjanje iz kluba
if (isset($_GET['remove_from_club']) && !empty($_GET['remove_from_club'])) {
    // Dobivanje ID-a kluba i ID-a trenutnog korisnika
    $club_id = $_GET['remove_from_club'];
    $user_id = $_SESSION['user_id']; // Pretpostavljajući da imate sesiju sa user_id

    // Priprema upita za brisanje korisnika iz kluba
    $remove_member_query = "DELETE FROM ardf_club_members WHERE member_club_id = $club_id AND member_user_id = $user_id";

    // Izvršavanje upita
    if ($mysqli->query($remove_member_query)) {
        // Ako je korisnik uspješno uklonjen iz kluba, možete preusmjeriti korisnika ili prikazati poruku
        header("Location: profile.php?success=Uspješno uklonjeni iz kluba.");
        $_SESSION['club_id'] = 0; 
        exit();
    } else {
        // Ako je došlo do greške pri brisanju korisnika iz kluba, možete preusmjeriti korisnika ili prikazati poruku
        header("Location: profile.php?error=Došlo je do greške pri uklanjanju iz kluba.");
        exit();
    }
} 

if (isset($_GET['remove_from_event']) && !empty($_GET['remove_from_event'])) {
    // Dobivanje ID-a natjecanja
    $competition_id = $_GET['remove_from_event'];
    $event_id = $_GET['event_id']; // Ispravak: Treba dobiti ID događaja, a ne ponovno ID natjecanja

    // Brisanje natjecanja
    $remove_competition_query = "UPDATE ardf_competition SET event_id = NULL WHERE competition_id = $competition_id";

    // Izvršavanje upita za brisanje
    if ($mysqli->query($remove_competition_query)) {
        // Ako je natjecanje uspješno obrisano, preusmjeri korisnika ili prikaži poruku
        header("Location: admin_event.php?event_id=$event_id");
        exit();
    } else {
        // Ako dođe do pogreške pri brisanju, možete prikazati poruku ili obraditi pogrešku na neki drugi način
        echo "Error deleting competition: " . $mysqli->error;
    }
}

// Provjerite je li poslan zahtjev za stvaranje novog natjecanja
if (isset($_GET['create_competition']) && $_GET['create_competition'] == 1) {
    // Provjerite postoji li event_id u zahtjevu
    if (isset($_GET['event_id'])) {
        // Dobivanje event_id iz zahtjeva
        $event_id = $_GET['event_id'];

        // Ovdje možete izvršiti provjeru i validaciju ostalih potrebnih podataka

        // Pripremite upit za unos novog natjecanja u bazu
        $insert_competition_query = "INSERT INTO ardf_competition (event_id) VALUES ($event_id)";

        // Izvršite upit za unos natjecanja u bazu
        if ($mysqli->query($insert_competition_query)) {
            // Ako je natjecanje uspješno dodano, preusmjerite korisnika ili prikažite poruku
            header("Location: admin_event.php?event_id=$event_id");
            exit();
        } else {
            // Ako dođe do pogreške pri dodavanju natjecanja, možete prikazati poruku ili obraditi pogrešku na drugi način
            echo "Error creating competition: " . $mysqli->error;
        }
    } else {
        // Ako nije poslan event_id, prikažite odgovarajuću poruku ili obradite situaciju na drugi način
        echo "Event ID is missing!";
    }
}






if (isset($_POST["action"]) && $_POST["action"] == "action_add_club") {
    // Provjera postojanja potrebnih podataka
    if (isset($_POST['clubName']) && isset($_POST['country']) && isset($_POST['clubCall'])) {
        // Priprema podataka za unos
        $clubName = $_POST['clubName'];
        $countryId = $_POST['country']; // ID odabrane države
        $clubCall = $_POST['clubCall'];

        // Priprema upita za unos podataka
        $sql = "INSERT INTO ardf_club (club_name, club_country_id, club_call) VALUES ('$clubName', '$countryId', '$clubCall')";

        // Izvršavanje upita za unos podataka
        if ($mysqli->query($sql) === true) {
            // Uspješno upisani podaci

            // Dobivanje ID-a novog kluba
            $new_club_id = $mysqli->insert_id;

            // Provjera postoji li korisnik prijavljen
            if (isset($_SESSION['user_id'])) {
                // Dobivanje ID-a prijavljenog korisnika
                $user_id = $_SESSION['user_id'];

                // Priprema upita za dodavanje korisnika kao člana i administratora kluba
                $add_member_query = "INSERT INTO ardf_club_members (member_club_id, member_user_id, member_admin) VALUES (?, ?, true)";

                // Priprema statementa
                $stmt = $mysqli->prepare($add_member_query);

                // Provjera je li priprema uspjela
                if ($stmt) {
                    // Povezivanje parametara
                    $stmt->bind_param("ii", $new_club_id, $user_id);

                    // Izvršavanje upita
                    if ($stmt->execute()) {
                        // Ako je korisnik uspješno dodan u klub kao član i administrator
                        $_SESSION['club_id'] = $new_club_id; 
                        header("Location: profile.php");
                        exit();
                    } else {
                        // Ako je došlo do greške pri izvršavanju upita
                        echo "Greška pri izvršavanju upita: " . $stmt->error;
                        exit();
                    }
                } else {
                    // Ako priprema nije uspjela
                    echo "Priprema upita nije uspjela: " . $mysqli->error;
                    exit();
                }

            } else {
                // Ako korisnik nije prijavljen
                echo "Korisnik nije prijavljen.";
                exit();
            }
        } else {
            // Greška prilikom upisa podataka
            echo "Greška prilikom upisa u bazu podataka: " . $mysqli->error;
            exit();
        }
    } else {
        // Ako nedostaju potrebni podaci
        echo "Nedostaju potrebni podaci za unos kluba.";
        exit();
    }
}

// Provjera postoji li akcija za ažuriranje kluba
if (isset($_POST["action"]) && $_POST["action"] == "action_edit_club") {
    // Provjera postoji li club_id u sesiji
    if (isset($_SESSION['user_id'])) {
        // Dohvati user_id iz sesije
        $user_id = $_SESSION['user_id'];
    
        // Priprema upita za dohvaćanje club_id
        $club_id_query = "SELECT member_club_id FROM ardf_club_members WHERE member_user_id = $user_id";
        $club_id_result = $mysqli->query($club_id_query);
    
        if ($club_id_result->num_rows > 0) {
            // Dohvati club_id iz rezultata upita
            $club_id_row = $club_id_result->fetch_assoc();
            $club_id = $club_id_row['member_club_id'];
    
            // Postavi club_id u sesiju
            $_SESSION['club_id'] = $club_id;
    
        } else {
            // Ako nije pronađen club_id za korisnika
            echo "Nije moguće pronaći klub za ažuriranje.";
            exit();
        }
    } else {
        // Ako korisnik nije prijavljen
        echo "Korisnik nije prijavljen.";
        exit();
    }

    // Provjera postojanja potrebnih podataka za ažuriranje kluba
    if (isset($_POST['clubName']) && isset($_POST['country']) && isset($_POST['clubCall'])) {
        // Dohvati club_id iz sesije
        $club_id = $_SESSION['club_id'];

        // Priprema podataka za ažuriranje
        $clubName = $_POST['clubName'];
        $countryId = $_POST['country']; // ID odabrane države
        $clubCall = $_POST['clubCall'];

        // Priprema upita za ažuriranje podataka
        $sql = "UPDATE ardf_club SET club_name = '$clubName', club_country_id = '$countryId', club_call = '$clubCall' WHERE club_id = $club_id";

        // Izvršavanje upita za ažuriranje podataka
        if ($mysqli->query($sql) === true) {
            // Uspješno ažurirani podaci
            header("Location: club.php"); // Preusmjeri korisnika na odgovarajuću stranicu
            exit();
        } else {
            // Greška prilikom ažuriranja podataka
            echo "Greška prilikom ažuriranja podataka u bazi: " . $mysqli->error;
            exit();
        }
    } else {
        // Ako nedostaju potrebni podaci za ažuriranje kluba
        echo "Nedostaju potrebni podaci za ažuriranje kluba.";
        exit();
    }
}

// Provjera je li korisnik poslao zahtjev za pridruživanje klubu
if (isset($_POST['action']) && $_POST['action'] == "join_club") {
    // Provjera postoji li sesija za korisnika
    if(isset($_SESSION['user_id'])) {
        // Dobivanje ID-a kluba i ID-a trenutnog korisnika
        $club_id = $_POST['club_id']; // Pretpostavljam da je ID kluba poslan iz forme
        $user_id = $_SESSION['user_id']; 

        // Priprema upita za provjeru je li korisnik već član kluba
        $check_membership_query = "SELECT * FROM ardf_club_members WHERE member_club_id = $club_id AND member_user_id = $user_id";

        // Izvršavanje upita
        $check_result = $mysqli->query($check_membership_query);

        // Provjera rezultata
        if ($check_result->num_rows > 0) {
            // Korisnik je već član kluba
            header("Location: profile.php?error=Već ste član ovog kluba.");
            exit();
        } else {
            // Priprema upita za dodavanje korisnika u klub
            $add_member_query = "INSERT INTO ardf_club_members (member_club_id, member_user_id) VALUES ($club_id, $user_id)";

            // Izvršavanje upita
            if ($mysqli->query($add_member_query)) {
                // Ako je korisnik uspješno dodan u klub
                $_SESSION['club_id'] = $club_id;
                header("Location: profile.php?success=Uspješno ste se pridružili klubu.");
                exit();
            } else {
                // Ako je došlo do greške pri dodavanju korisnika u klub
                header("Location: profile.php?error=Došlo je do greške prilikom pridruživanja klubu.");
                exit();
            }
        }
    } 
}


?>
