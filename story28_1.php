<?php
require_once 'story28_1_functions.php';
session_start();

if (isset($_GET['restart'])) {
    story28_reset_session();
}

$conn = story28_db();
$previousStoryId = 27;
$hasPreviousItem = story28_prev_item_status($conn, $previousStoryId);
$conn->close();

$_SESSION['story28_has_prev'] = $hasPreviousItem;
unset($_SESSION['story28_choice1'], $_SESSION['story28_choice2'], $_SESSION['story28_ending']);

$extraIntro = $hasPreviousItem
    ? '<p>Your <strong>Waterproof Travel Journal</strong> survived the last story. When a bead of moisture slides across its cover, hidden blue routes bloom across the album page like coral veins. The journal is not just luggage now. It is a key.</p>'
    : '<p>You reach for your <strong>Waterproof Travel Journal</strong>, but it never made it out of the previous story. The album pages are damp with salt and memory, and all the tiny handwritten captions smear before you can read them.</p>';

$statusNote = $hasPreviousItem
    ? '<div class="note">Previous-story item check: success. Story 28 may still reach a perfect or good ending.</div>'
    : '<div class="note warn">Previous-story item check: failed. A bad ending is now much more likely because the journal was not obtained in Story 27.</div>';

$content = <<<HTML
<h1>Story 28 — The Album That Remembered the Sea</h1>
<p class="meta">Story ID 28 · Uses the location <strong>An Old Photo Album</strong>, your item <strong>A Waterproof Travel Journal</strong>, and the next story's item <strong>Noctero</strong>.</p>
<p>You open an old photo album in the school archive. It is heavier than it should be, and the plastic sleeves inside move like shallow water. Every photograph seems unfinished: a pier with no ocean, a boat with no harbor, a moonlit street with no sky. From the inside cover falls a paper slip:</p>
<p><em>Return the missing route, and Noctero will guide the next traveler.</em></p>
{$extraIntro}
{$statusNote}
<p>You hear a soft rustle from the last black page. Two pale eyes blink and disappear.</p>
<div>
    <span class="tag">Object carried from Story 27: Waterproof Travel Journal</span>
    <span class="tag">Object for Story 29: Noctero</span>
    <span class="tag">Location: inside an old photo album</span>
</div>
<div class="nav">
    <a class="button-link" href="story28_2.php">Open the first moving page</a>
    <a class="button-link secondary" href="story28_1.php?restart=1">Restart Story 28</a>
</div>
HTML;

story28_render_page('Story 28 - Opening', 'story28_1_image1.svg', $content);
