<?php
    include 'auth.php';
    include 'course_names.php';
    if (!$userid = checkAuth()) {
        header("Location: login_student.php");
        exit;
    }
    // Materie scelte dall'utente
    $chosenSubjects = !empty($_SESSION['piano_studi']) ? $_SESSION['piano_studi'] : [];
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
        <link rel="stylesheet" href="piano_studi.css">
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
            <div class="sectionTitle">Piano di Studi
                <form>
                    <div>
                        <label for="name">* Nome:</label>
                        <span><?php echo $userinfo['name'] ?></span>
                    </div>
                    <div>
                        <label for="name">* Cognome:</label>
                        <span><?php echo $userinfo['surname'] ?></span>
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
            <div class="table">
                <div class="table_section">
                    <div>
                        <span class="text-esame">Esame</span>
                        <span>Crediti</span>
                        <span class=>Esito</span>
                        <span class="text-data">Data</span>
                    </div>
                </div>
                <div>
                    <div class="sectionTitle">Insegnamenti del 1° anno </div>
                </div>
                <div class="table_section">
                    <div>
                        <spam class="text-esame">Formazione corale I</spam>
                        <span class="text-crediti">3</span>
                        <span class="text-esito">-</span>
                        <span class="text-data">-</span>
                    </div>
                    <div>
                        <span class="text-esame">Musica da camera I</span>
                        <span class="text-crediti">6</span>
                        <span class="text-esito">-</span>
                        <span class="text-data">-</span>
                    </div>
                    <div>
                        <span class="text-esame"><?php echo $course_names[$userinfo['corso']] ?> I</span>
                        <span id="strumento">18</span>
                        <span class="text-esito" id="strumento">-</span>
                        <span class="text-data">-</span>
                    </div>
                </div>
                <div>
                    <div class="sectionTitle">Insegnamenti del 2° anno </div>
                </div>
                <div class="table_section">
                    <div>
                        <spam class="text-esame">Formazione corale II</spam>
                        <span class="text-crediti">3</span>
                        <span class="text-esito">-</span>
                        <span class="text-data">-</span>
                    </div>
                    <div>
                        <span class="text-esame">Musica da camera II</span>
                        <span class="text-crediti">6</span>
                        <span class="text-esito">-</span>
                        <span class="text-data">-</span>
                    </div>
                    <div>
                        <span class="text-esame"><?php echo $course_names[$userinfo['corso']] ?> II</span>
                        <span id="strumento">18</span>
                        <span class="text-esito" id="strumento">-</span>
                        <span class="text-data">-</span>
                    </div>
                </div>
                <div>
                    <div class="sectionTitle">Insegnamenti del 3° anno </div>
                </div>
                <div class="table_section">
                    <div>
                        <spam class="text-esame">Materie a scelta</spam>
                        <span id="crediti_scelta">12</span>
                        <span class="text-esito" id="esito_scelta">-</span>
                        <span class="text-data">-</span>
                    </div>
                    <div id="materie_scelte">
                        <?php
                            $sql = "SELECT m.nome_materia, m.cfu FROM materie_scelte ms
                                    JOIN materie m ON ms.id_materia = m.id
                                    WHERE ms.id_studente = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $userid);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<span>" . $row['nome_materia'] . " - " . $row['cfu'] . " CFU</span><br>";
                                }
                            }
                        ?>
                    </div>
                    <div>
                        <span class="text-esame">Musica da camera III</span>
                        <span class="text-crediti">6</span>
                        <span class="text-esito">-</span>
                        <span class="text-data">-</span>
                    </div>
                    <div>
                        <span class="text-esame"><?php echo $course_names[$userinfo['corso']] ?> III</span>
                        <span id="strumento">18</span>
                        <span class="text-esito" id="strumento">-</span>
                        <span class="text-data">-</span>
                    </div>
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