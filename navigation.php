<nav class="navbar navbar-expand-md navbar-dark bg-dark" aria-label="Fourth navbar example">
    <div class="container-fluid">
      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample04">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.php">Početna</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://arg.hamradio.hr/index.php/arg/o-arg-u">ARDF</a>
          </li>
          
          <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Natjecanja</a>
                    <ul class="dropdown-menu">
                        <!--drugom prilikom <li><a class="dropdown-item" href="#">Kalendar</a></li>-->
                        <!--drugom prilikom <li><a class="dropdown-item" href="#">Prijava</a></li>-->
                        <li><a class="dropdown-item" href="organisation.php">Organizacija</a></li>
                    </ul>
                </li>

          <li class="nav-item">
                    <a class="nav-link" href="profile.php"> <?php  session_start(); if(isset($_SESSION['username'])) {echo "Profil";}?></a>
          </li>     
          <li class="nav-item">
                      <a class="nav-link" href="club.php">
                <?php  
                include 'config.php'; 
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
                            echo "Klub";
                        }
                    }
                }
                ?>
            </a>
          </li>   
        </ul>
        <form role="search">
        <?php 
               
                
                if(isset($_SESSION['username'])) { 
            ?>
                <a class="nav-link" style="color: red;" href="logout.php">Odjavi se</a>

            <?php  
                } else { 
            ?>
                
                <a class="btn btn-primary" href="login.php" role="button">Prijava</a>
            <?php 
                } 
            ?>
        </form>
      </div>
    </div>
  </nav>