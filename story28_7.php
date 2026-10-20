<?php
require_once 'story28_1_functions.php';
story28_start_session();

if (($_SESSION['story28_ending'] ?? '') !== 'bad') {
    header('Location: story28_1.php');
    exit;
}

$content = <<<HTML
<h1>The Bad Ending</h1>
<p class="meta">You either arrived without the Waterproof Travel Journal from Story 27, damaged the album beyond forgiveness, or forced Noctero at the wrong moment.</p>
<p class="ending" style="color:#ffb3b3;">Bad Ending</p>
<p>The album snaps shut like a tide trap. Pictures blur, routes disappear, and the black page seals itself. Without the journal's guidance—or after too much force—there is no safe line through the story. Noctero vanishes into undeveloped dark.</p>
<p>When the cover opens again, you find yourself back before the previous story's threshold. To try for a better outcome, you must return and recover what was lost.</p>
<div class="note warn">Database result for Story 28: <strong>item = 0</strong>. Because this is a bad ending, the required navigation is a link back to the previous story.</div>
<div class="nav">
    <a class="button-link" href="story27_1.php">Return to Story 27</a>
    <a class="button-link secondary" href="story28_1.php?restart=1">Replay Story 28</a>
</div>
HTML;

story28_render_page('Story 28 - Bad Ending', 'story28_7_image1.svg', $content);
