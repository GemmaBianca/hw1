<?php
    // Verifica che l'utente sia già loggato, in caso positivo va direttamente alla home
    include 'auth.php';
    if (checkAuth()) {
        header('Location: home_student.php');
        exit;
    }
    //include "dbconfig.php";
    if (!empty($_POST["username"]) && !empty($_POST["password"]) )
    {
        // Se username e password sono stati inviati
        // Connessione al DB
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['id'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        // ID e Username per sessione, password per controllo
        $query = "SELECT * FROM users WHERE id = '".$username."'";
        // Esecuzione
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));;
        
        if (mysqli_num_rows($res) > 0) {
            // Ritorna una sola riga, il che ci basta perché l'utente autenticato è solo uno
            $entry = mysqli_fetch_assoc($res);
            if (password_verify($_POST['password'], $entry['password'])) {

                // Imposto una sessione dell'utente
                $_SESSION["_agora_username"] = $entry['username'];
                $_SESSION["_agora_user_id"] = $entry['id'];
                header("Location: home_student.php");
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            }
        }
        // Se l'utente non è stato trovato o la password non ha passato la verifica
        $error = "Username e/o password errati.";
    }
    else if (isset($_POST["username"]) || isset($_POST["password"])) {
        // Se solo uno dei due è impostato
        $error = "Inserisci username e password.";
    }

?>

<html>
    <head>
        <meta charset="utf-8">
        <link rel='stylesheet' href='login_student.css'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Conservatorio Bellini</title>
    </head>
    <body>
        <nav>
            <a class="logo">
                <img src="photo/LogoConservatorioWeb.jpeg">
            </a>
            <div id="main-nav">
                <div><a class="nav-link" href="login_student.php">Entra</a></div>
                <div><a class="nav-link" href="home.html">Home</a></div>
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
            <p id="loginmessage">Inserisci le tue credenziali per accedere al sistema.</p>
            <p class="text-center"></p>
            <form id="FormUtenteLogin" name="login" method="post">
                <div class="zend_form">    
                    <div class="username_label">
                        <label for='username'>ID Utente</label>
                    </div>
                    <div class="username_input">
                        <input type='text' name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                    </div>
                    <div class="password_label">
                        <label for='password'>Password</label>
                    </div>
                    <div class="password_input">
                        <input type='password' name='password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                    </div>
                    <div class="submit-container">
                        <div class="login-btn">
                            <input type='submit' value="Entra!">
                        </div>
                    </div>
                </div>
            </form>
            <div class="text-left">
                <a href="">Hai perso la password?</a>
            </div>
            <div class="signup"><h4>Sei un nuovo studente?</h4></div>
            <div class="signup-btn-container"><a class="signup-btn" href="signup.php">ISCRIVITI</a></div>
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