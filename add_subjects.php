<?php
session_start();
include("course_names.php");
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_POST['subjects'])) {
        $selectedSubjects = $_POST['subjects'];
        $totalCredits = 0;

        foreach($selectedSubjects as $subject) {
            if (!isset($subjectsCredits[$subject])) {
                $totalCredits += $subjectsCredits[$subject];
            }
        }
        if ($totalCredits == 12) {
            $_SESSION['piano_studi'] = $selectedSubjects;
            header('Location: piano_studi.php');
            exit();
        } else {
            $_SESSION['error'] = "Devi selezionare esattamente 18 crediti.";
            header('Location: home_student.html');
            exit();
        }
    }
}