<?php

declare(strict_types=1);

function story28_start_session(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function story28_reset_session(): void
{
    $keys = [
        'story28_has_prev',
        'story28_choice1',
        'story28_choice2',
        'story28_ending'
    ];

    foreach ($keys as $key) {
        unset($_SESSION[$key]);
    }
}

function story28_db(): mysqli
{
    mysqli_report(MYSQLI_REPORT_OFF);
    $conn = new mysqli('localhost', 'root', '', 'story');

    if ($conn->connect_error) {
        die('Database connection failed: ' . htmlspecialchars($conn->connect_error, ENT_QUOTES, 'UTF-8'));
    }

    $conn->set_charset('utf8mb4');
    return $conn;
}

function story28_prev_item_status(mysqli $conn, int $prevId): bool
{
    $stmt = $conn->prepare('SELECT item FROM items WHERE ID = ?');
    if (!$stmt) {
        return false;
    }

    $stmt->bind_param('i', $prevId);
    $stmt->execute();
    $stmt->bind_result($item);
    $value = false;

    if ($stmt->fetch()) {
        $value = ((int)$item === 1);
    }

    $stmt->close();
    return $value;
}

function story28_save_outcome(mysqli $conn, int $storyId, bool $hasItem, string $other): void
{
    $itemValue = $hasItem ? 1 : 0;
    $stmt = $conn->prepare('UPDATE items SET item = ?, other = ? WHERE ID = ?');

    if (!$stmt) {
        die('Failed to prepare update statement.');
    }

    $stmt->bind_param('isi', $itemValue, $other, $storyId);
    $stmt->execute();
    $stmt->close();
}

function story28_e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function story28_render_page(string $title, string $imageFile, string $contentHtml): void
{
    $safeTitle = story28_e($title);
    $safeImage = story28_e($imageFile);
    echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$safeTitle}</title>
    <style>
        :root {
            --bg: #07131d;
            --panel: rgba(8, 20, 30, 0.88);
            --panel-border: rgba(158, 206, 255, 0.18);
            --text: #ecf6ff;
            --muted: #bfd6ea;
            --accent: #78d7ff;
            --accent-2: #b1ffdc;
            --danger: #ff9c9c;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top, rgba(74, 144, 226, 0.15), transparent 40%),
                linear-gradient(180deg, #081521 0%, #07101a 50%, #05090f 100%);
            min-height: 100vh;
        }
        .shell {
            max-width: 980px;
            margin: 0 auto;
            padding: 28px 20px 56px;
        }
        .hero {
            display: grid;
            gap: 20px;
        }
        .hero img {
            width: 100%;
            border-radius: 20px;
            display: block;
            border: 1px solid var(--panel-border);
            box-shadow: 0 18px 40px rgba(0,0,0,0.35);
            background: rgba(255,255,255,0.03);
        }
        .card {
            background: var(--panel);
            border: 1px solid var(--panel-border);
            border-radius: 20px;
            padding: 28px;
            backdrop-filter: blur(8px);
            box-shadow: 0 18px 40px rgba(0,0,0,0.22);
        }
        h1 {
            margin: 0 0 10px;
            font-size: clamp(1.9rem, 2.7vw, 2.8rem);
            line-height: 1.1;
        }
        .meta {
            margin: 0 0 22px;
            color: var(--muted);
            font-size: 0.98rem;
        }
        p {
            line-height: 1.75;
            margin: 0 0 16px;
            font-size: 1.05rem;
        }
        .note {
            padding: 14px 16px;
            border-left: 4px solid var(--accent);
            background: rgba(120, 215, 255, 0.08);
            border-radius: 12px;
            margin: 18px 0 24px;
            color: var(--muted);
        }
        .warn {
            border-left-color: var(--danger);
            background: rgba(255, 156, 156, 0.09);
        }
        form {
            margin: 0;
        }
        .choices, .nav {
            display: grid;
            gap: 14px;
            margin-top: 26px;
        }
        .nav {
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        }
        button, .button-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 56px;
            padding: 14px 18px;
            border-radius: 14px;
            border: 1px solid rgba(120, 215, 255, 0.28);
            background: linear-gradient(180deg, rgba(120, 215, 255, 0.2), rgba(120, 215, 255, 0.11));
            color: var(--text);
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.18s ease, border-color 0.18s ease, background 0.18s ease;
        }
        button:hover, .button-link:hover {
            transform: translateY(-1px);
            border-color: rgba(177, 255, 220, 0.4);
            background: linear-gradient(180deg, rgba(120, 215, 255, 0.26), rgba(120, 215, 255, 0.15));
        }
        button:focus-visible, .button-link:focus-visible {
            outline: 3px solid var(--accent-2);
            outline-offset: 3px;
        }
        .button-link.secondary, button.secondary {
            background: rgba(255,255,255,0.04);
        }
        .tag {
            display: inline-block;
            margin: 4px 10px 14px 0;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255,255,255,0.05);
            color: var(--muted);
            font-size: 0.95rem;
        }
        .ending {
            font-size: 1.2rem;
            margin-bottom: 14px;
            color: var(--accent-2);
            font-weight: 700;
        }
    </style>
</head>
<body>
    <main class="shell">
        <section class="hero">
            <img src="{$safeImage}" alt="Illustration for Story 28">
            <article class="card">
                {$contentHtml}
            </article>
        </section>
    </main>
</body>
</html>
HTML;
}
