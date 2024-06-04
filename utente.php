<?php
    include 'auth.php';
    include 'course_names.php';
    if (!$userid = checkAuth()) {
        header("Location: login_student.php");
        exit;
    }
?>

<html>
    <?php 
        // Carico le informazioni dell'utente loggato per visualizzarle nella sidebar
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['id'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
        $userid = mysqli_real_escape_string($conn, $userid);
        $query = "SELECT * FROM users WHERE id = $userid";
        $res_1 = mysqli_query($conn, $query);
        $userinfo = mysqli_fetch_assoc($res_1);   
    ?>
    <head>
        <meta charset="utf-8">
        <title>Conservatorio Bellini</title>
        <link rel="stylesheet" href="utente.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <nav>
            <a class="logo">
                <img src="photo/LogoConservatorioWeb.jpeg">
            </a>
            <div id="main-nav">
                <div><a class="nav-link" href="logout.php">Esci</a></div>
                <div><a class="nav-link" href="home.html">Home</a></div>
                <div><a class="nav-link" href="utente.php">Profilo utente</a></div>
                <div>
                    <select onchange="window.location.href=this.value">
                        <option value="iscrizioni">Iscrizioni</option>
                        <option value="piano_studi.php">Piano di Studi</option>
                        <option value="prenota_esami">Prenota esami</option>
                        <option value="prenotati">Esami prenotati</option>
                        <option value="confermati">Esami da confermare</option>
                        <option value="scegli_materie.php">Materie a scelta</option>
                        <option value="biblioteca.php">Servizio biblioteca</option>
                    </select>
                </div>
                <div><a class="nav-link" href="">Guida</a></div>
            </div>
        </nav>
        <div id="layoutContent">
            <div class="sectionTitle">Profilo utente
                <form>
                    <div>
                        <label for="username">* ID:</label>
                        <span><?php echo $userinfo['id'] ?></span>
                    </div>
                    <div>
                        <label for="name">* Nome:</label>
                        <span><?php echo $userinfo['name'] ?></span>
                    </div>
                    <div>
                        <label for="name">* Cognome:</label>
                        <span><?php echo $userinfo['surname'] ?></span>
                    </div>
                    <div>
                        <label for="ruolo">* Ruolo:</label>
                        <span>
                            <select id="ruolo">
                                <option value="student" selected>student</option>
                            </select>
                        </span>
                    </div>
                    <div>
                        <label for="email">* Email:</label>
                        <span><?php echo $userinfo['email'] ?></span>
                    </div>
                    <div>
                        <label for="birthdate">* Data di nascita</label>
                        <span><?php echo $userinfo['data_nascita'] ?></span>
                    </div>
                    <div>
                        <label for="corso">* Corso di laurea</label>
                        <span><?php echo $course_names[$userinfo['corso']] ?></span>
                    </div>
                </form>
            </div>
        </div>
        <footer>
        <div class="container">
            <div class="row">
                <div class="footer_left">
                    <a href="https://www.netsenseweb.com"><img src="photo/nspowered.png"></a>
                </div>
                <div class="footer_right">
                    <span>Portale ottimizzato per <a href="https://www.google.com/intl/it_it/chrome/browser/">Google Chrome <img src="photo/chrome.png"></a>
                    <span></span>
                    </span>
                </div>
            </div>
        </div>
        </footer>
    </body>
</html>