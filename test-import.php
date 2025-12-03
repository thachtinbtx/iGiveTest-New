<?php
// Mock session
$_SESSION = array();
require_once('inc/init.inc.php');
$G_SESSION['userid'] = 1;

// Mock POST data
$_POST['import_document'] = "Question: What is the capital of France?
Choice: Berlin
Choice: London
Choice: Paris
Correct: 3
Points: 5
Type: 1
Subject: 0

Question: What is 5+5?
Choice: 10
Choice: 11
Correct: 1
Points: 2
Type: 1
Subject: 0";

$_POST['question_delimiter'] = "Question: ";
$_POST['answer_delimiter'] = "Choice: ";
$_POST['answer2_delimiter'] = "Choice 2: ";
$_POST['preq_delimiter'] = "Intro: ";
$_POST['postq_delimiter'] = "Explanation: ";
$_POST['correct_delimiter'] = "Correct: ";
$_POST['points_delimiter'] = "Points: ";
$_POST['type_delimiter'] = "Type: ";
$_POST['subject_delimiter'] = "Subject: ";

// Include the submit logic
// Note: This will exit() at the end, so we expect the script to terminate.
include('inc/pages/question-bank-import-submit.inc.php');
?>
