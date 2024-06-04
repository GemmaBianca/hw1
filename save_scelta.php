<?php
include 'auth.php';

save_scelta();

function save_scelta() {
    global $dbconfig;
    $userid = checkAuth();
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['id'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    $userid = mysqli_real_escape_string($conn, $userid);
    if(!isset($_POST['materie']) || !is_array($_POST['materie'])) {
        echo json_encode(array('ok' => false,'error'=> 'Nessuna materia selezionata'));
        exit;
    }
    $subjects = $_POST['materie'];
    foreach($subjects as $subject) {
        $query = "INSERT INTO materie_scelte(id_studente, id_materia) VALUES ('$userid', '$subject')";
        $result = mysqli_query($conn, $query);
    }
    error_log($query);
    header('Location: piano_studi.php');
}
?>