<?php
require_once 'story28_1_functions.php';
story28_start_session();

if (!isset($_SESSION['story28_has_prev'], $_SESSION['story28_choice1'])) {
    header('Location: story28_1.php');
    exit;
}

$hasPreviousItem = (bool)$_SESSION['story28_has_prev'];
$choice1 = (string)$_SESSION['story28_choice1'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $choice2 = filter_input(INPUT_POST, 'choice2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($choice2 === 'offer' || $choice2 === 'trap') {
        $_SESSION['story28_choice2'] = $choice2;
        header('Location: story28_4.php');
        exit;
    }
}

if ($choice1 === 'careful') {
    $scene = $hasPreviousItem
        ? '<p>You follow the water-bloomed route until the album opens onto a silvery page. There, perched on the corner of a moonlit photograph, is <strong>Noctero</strong>—small, alert, and made of shadow-blue feathers. It watches the journal, not you.</p>'
        : '<p>You move slowly through the album, but without the journal the captions remain incomplete. You still find the black page. Noctero waits there, but the creature tilts its head as if it already knows you arrived unprepared.</p>';
} else {
    $scene = '<p>You wrench the binding apart. A sharp crack echoes through the sleeves and old photographs flutter like wounded birds. The black page swings open, and Noctero appears in a scatter of loose corners and silver dust. It looks offended—and ready to flee.</p>';
}

$content = <<<HTML
<h1>Noctero Appears</h1>
<p class="meta">Decision point two · This choice determines whether Story 29 receives Noctero.</p>
{$scene}
<p>The creature lands beside the photograph of a harbor that has no horizon. Your journal glints with seawater. The ripped or untouched album pages wait for your answer.</p>
<form method="post" class="choices">
    <button type="submit" name="choice2" value="offer">Offer Noctero a blank waterproof page and promise to carry its route forward</button>
    <button type="submit" name="choice2" value="trap">Seal Noctero inside a plastic sleeve and try to take it by force</button>
</form>
<div class="nav">
    <a class="button-link secondary" href="story28_2.php">Go back to the first choice</a>
</div>
HTML;

story28_render_page('Story 28 - Second Choice', 'story28_3_image1.svg', $content);
