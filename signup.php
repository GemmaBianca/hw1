<?php
    include 'auth.php';
    if (checkAuth()) {
        header("Location: home_student.php");
        exit;
    }
    // Verifica l'esistenza di dati POST
    if (!empty($_POST["password"]) && !empty($_POST["birthdate"]) && !empty($_POST["email"]) && !empty($_POST["name"]) &&
        !empty($_POST["surname"]) && !empty($_POST["confirm_password"]) && !empty($_POST["allow"])){
        $error = array();
        
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['id'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn)); 
        # PASSWORD
        if (strlen($_POST["password"]) < 8) {
            $error[] = "Caratteri password insufficienti (minimo 8)";
        } 
        # CONFERMA PASSWORD
        if (strcmp($_POST["password"], $_POST["confirm_password"]) != 0) {
            $error[] = "Le password non coincidono";
        }
        # EMAIL
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error[] = "Email non valida";
        } else {
            $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
            $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Email già utilizzata";
            }
        }
        # DATA DI NASCITA
        $birthdate = $_POST["birthdate"];
        if (!strtotime($birthdate)) {
            $error[] = "La data di nascita non e' valida";
        } else {
            $age = (time() - strtotime($birthdate)) / (365.25*24*60*60);
            if ($age < 18) {
                $error[] = "Devi avere almeno 18 anni per registrarti";
            }
        }
        # REGISTRAZIONE NEL DATABASE
        if (count($error) == 0) {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $surname = mysqli_real_escape_string($conn, $_POST['surname']);
            $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password = password_hash($password, PASSWORD_BCRYPT);
            $study_plan = mysqli_escape_string($conn, $_POST['corso']);

            $query = "INSERT INTO users(id, password, email, name, surname, data_nascita, corso) VALUES('$username', '$password', '$email', '$name', '$surname', '$birthdate', '$study_plan')";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION["_agora_username"] = $_POST["username"];
                $_SESSION["_agora_user_id"] = mysqli_insert_id($conn);
                mysqli_close($conn);
                header("Location: home_student.php");
                exit;
            } else {
                $error[] = "Errore di connessione al Database";
            }
        }

        mysqli_close($conn);
    }
    else if (isset($_POST["username"])) {
        $error = array("Riempi tutti i campi");
    }

?>


<html>
    <head>
        <meta charset="utf-8">
        <link rel='stylesheet' href='signup.css'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Conservatorio Bellini</title>
        <script src="login.js" defer="true"></script>
    </head>
    <body>
        <nav>
            <a class="logo">
                <img src="photo/LogoConservatorioWeb.jpeg">
            </a>
            <div id="main-nav">
                <div>Iscriviti!</div>    
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
            <h1>Iscriviti gratuitamente per accedere al tuo piano di studi</h1>
            <form name='signup' method='post' enctype="multipart/form-data" autocomplete="off">
                <div class="names">
                    <div class="name">
                        <label for='name'>Nome</label>
                        <!-- Se il submit non va a buon fine, il server reindirizza su questa stessa pagina, quindi va ricaricata con 
                            i valori precedentemente inseriti -->
                        <input type='text' name='name' <?php if(isset($_POST["name"])){echo "value=".$_POST["name"];} ?> >
                    </div>
                    <div class="surname">
                        <label for='surname'>Cognome</label>
                        <input type='text' name='surname' <?php if(isset($_POST["surname"])){echo "value=".$_POST["surname"];} ?> >
                    </div>
                </div>
                <div class="data">
                    <label for="birthdate">Data di nascita:</label>
                    <input type="date" name="birthdate" <?php if(isset($_POST["brithdate"])){echo "value=".$_POST["birthdate"];} ?>>
                </div>
                <div class="email">
                    <label for='email'>Email</label>
                    <input type='text' name='email' <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>>
                </div>
                <div class="password">
                    <label for='password'>Password</label>
                    <input type='password' name='password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                </div>
                <div class="confirm_password">
                    <label for='confirm_password'>Conferma Password</label>
                    <input type='password' name='confirm_password' <?php if(isset($_POST["confirm_password"])){echo "value=".$_POST["confirm_password"];} ?>>
                </div>
                <div class="allow"> 
                    <input type='checkbox' name='allow' value="1" <?php if(isset($_POST["allow"])){echo $_POST["allow"] ? "checked" : "";} ?>>
                    <label for='allow'>Accetto i termini e condizioni d'uso</label>
                </div>
                <div class="corso">
                    <label for="corso">Scegli il tuo corso di studi</label>
                    <select name="corso">
                        <option value="1">Arpa</option>
                        <option value="2">Pianoforte</option>
                        <option value="3">Violino</option>
                    </select>
                </div>
                <?php if(isset($error)) { //stampa potenziali errori riscontrati nelle funzioni di verifica
                    foreach($error as $err) {
                        echo "<div class='errorj'><span>".$err."</span></div>";
                    }
                } ?>
                <div class="submit">
                    <input type='submit' value="Registrati" id="submit">
                </div>
            </form>
            <div class="signup">Hai un account? <a href="login_student.php">Accedi</a>
        </>
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