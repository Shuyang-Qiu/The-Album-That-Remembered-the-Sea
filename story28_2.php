<?php
require_once 'story28_1_functions.php';
story28_start_session();

if (!isset($_SESSION['story28_has_prev'])) {
    header('Location: story28_1.php');
    exit;
}

$hasPreviousItem = (bool)$_SESSION['story28_has_prev'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $choice1 = filter_input(INPUT_POST, 'choice1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($choice1 === 'careful' || $choice1 === 'reckless') {
        $_SESSION['story28_choice1'] = $choice1;
        header('Location: story28_3.php');
        exit;
    }
}

$guidance = $hasPreviousItem
    ? '<p>The journal reveals two possible entries into the album. One route follows glowing captions in the margin. The other would require tearing through the album binding and forcing your way toward the black page.</p>'
    : '<p>Without the journal, the glowing captions are gone. You can still trust the faint impressions left in the paper, or you can force the album open and hope brute strength will reach the black page first.</p>';

$content = <<<HTML
<h1>The First Choice</h1>
<p class="meta">Decision point one · The way you enter the album will shape the tone of the ending.</p>
{$guidance}
<p>The sea-salt smell grows stronger. Somewhere deeper in the album, something winged shifts between the sleeves.</p>
<form method="post" class="choices">
    <button type="submit" name="choice1" value="careful">Follow the hidden route carefully and read the album page by page</button>
    <button type="submit" name="choice1" value="reckless">Pry open the binding and cut straight toward the black page</button>
</form>
<div class="nav">
    <a class="button-link secondary" href="story28_1.php">Go back to the cover page</a>
</div>
HTML;

story28_render_page('Story 28 - First Choice', 'story28_2_image1.svg', $content);
