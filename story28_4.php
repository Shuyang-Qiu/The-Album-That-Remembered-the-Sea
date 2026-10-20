<?php
require_once 'story28_1_functions.php';
story28_start_session();

if (!isset($_SESSION['story28_has_prev'], $_SESSION['story28_choice1'], $_SESSION['story28_choice2'])) {
    header('Location: story28_1.php');
    exit;
}

$hasPreviousItem = (bool)$_SESSION['story28_has_prev'];
$choice1 = (string)$_SESSION['story28_choice1'];
$choice2 = (string)$_SESSION['story28_choice2'];

$ending = 'bad';
$file = 'story28_7.php';
$hasNextItem = false;

if ($hasPreviousItem && $choice1 === 'careful' && $choice2 === 'offer') {
    $ending = 'perfect';
    $file = 'story28_5.php';
    $hasNextItem = true;
} elseif ($hasPreviousItem && (
    ($choice1 === 'careful' && $choice2 === 'trap') ||
    ($choice1 === 'reckless' && $choice2 === 'offer')
)) {
    $ending = 'good';
    $file = 'story28_6.php';
}

$_SESSION['story28_ending'] = $ending;

$conn = story28_db();
story28_save_outcome($conn, 28, $hasNextItem, $ending);
$conn->close();

header('Location: ' . $file);
exit;
