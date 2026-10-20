<?php
require_once 'story28_1_functions.php';
story28_start_session();

if (($_SESSION['story28_ending'] ?? '') !== 'good') {
    header('Location: story28_1.php');
    exit;
}

$content = <<<HTML
<h1>The Good Ending</h1>
<p class="meta">You had the previous-story item and survived the album, but you did not secure Noctero for the next story.</p>
<p class="ending">Good Ending</p>
<p>The album does not collapse, and neither do you. But Noctero is too clever to be owned and too proud to follow damage. Whether because you rushed the binding and then apologized too late, or because you chose control over trust, the creature stays behind on the moonlit page.</p>
<p>Still, the journal remembers enough. You close the album with its photographs restored, and a shadow shaped like a feather lingers on the cover for a second before fading.</p>
<div class="note">Database result for Story 28: <strong>item = 0</strong>, because the player leaves safely but does not obtain Noctero for Story 29.</div>
<div class="nav">
    <a class="button-link" href="story29_1.php">Continue to Story 29</a>
    <a class="button-link secondary" href="story28_1.php?restart=1">Replay Story 28</a>
</div>
HTML;

story28_render_page('Story 28 - Good Ending', 'story28_6_image1.svg', $content);
