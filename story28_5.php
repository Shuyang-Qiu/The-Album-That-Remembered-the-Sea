<?php
require_once 'story28_1_functions.php';
story28_start_session();

if (($_SESSION['story28_ending'] ?? '') !== 'perfect') {
    header('Location: story28_1.php');
    exit;
}

$content = <<<HTML
<h1>The Perfect Ending</h1>
<p class="meta">You obtained your previous-story item, protected the album, and earned the next-story item.</p>
<p class="ending">Perfect Ending</p>
<p>You let Noctero step onto a blank waterproof page from the journal. Instead of trapping the creature, you give it room to choose. A silver route appears under its feet, then another, until the missing harbor in the photograph finally finds its ocean.</p>
<p>Noctero taps the page once and folds itself into the journal as a living bookmark. The old photo album grows still. Every image is whole again. When you close the cover, a final note writes itself across the inside flap:</p>
<p><em>The next traveler may proceed. Noctero goes willingly.</em></p>
<div class="note">Database result for Story 28: <strong>item = 1</strong>, because the player successfully obtained Noctero for Story 29.</div>
<div class="nav">
    <a class="button-link" href="story29_1.php">Continue to Story 29</a>
    <a class="button-link secondary" href="story28_1.php?restart=1">Replay Story 28</a>
</div>
HTML;

story28_render_page('Story 28 - Perfect Ending', 'story28_5_image1.svg', $content);
