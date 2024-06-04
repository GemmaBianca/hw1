<?php
    include 'auth.php';
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Conservatorio Bellini</title>
        <link rel="stylesheet" href="home_student.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="login.js" defer="true"></script>
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
        <?php
            // Verifica la presenza di errori
            if (isset($error)) {
                echo "<p class='error'>$error</p>";
            }    
        ?>
        <div id="layoutContent">
            <div id="background">
                <div id="mainBellini">
                    <div>
                        <img src="photo/vbellini.png">
                    </div>
                    <span id="st">Studenti On Line</span>
                    <span id="co">Conservatorio Vincenzo Bellini<br>Catania</span>
                </div>
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