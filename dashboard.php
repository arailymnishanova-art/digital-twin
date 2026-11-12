<?php
session_start();
require_once __DIR__ . "/config/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$userId = (int) $_SESSION["user_id"];
$userName = $_SESSION["user_name"] ?? "Пайдаланушы";

// Барлық мақсаттар
$stmt = $pdo->prepare(
    "SELECT COUNT(*) FROM goals WHERE user_id = ?"
);
$stmt->execute([$userId]);
$totalGoals = (int) $stmt->fetchColumn();

// Орындалған мақсаттар
$stmt = $pdo->prepare(
    "SELECT COUNT(*) FROM goals
     WHERE user_id = ? AND status = ?"
);
$stmt->execute([$userId, "Орындалды"]);
$completedGoals = (int) $stmt->fetchColumn();

// Күнделік жазбалары
$stmt = $pdo->prepare(
    "SELECT COUNT(*) FROM journal_entries WHERE user_id = ?"
);
$stmt->execute([$userId]);
$totalEntries = (int) $stmt->fetchColumn();

// Соңғы мақсаттар
$stmt = $pdo->prepare(
    "SELECT title, status
     FROM goals
     WHERE user_id = ?
     ORDER BY id DESC
     LIMIT 5"
);
$stmt->execute([$userId]);
$goals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика | Digital Twin</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f7f5ff;
            color: #29243d;
        }

        header {
            background: white;
            padding: 22px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            box-shadow: 0 2px 12px #29243d08;
        }

        .logo {
            color: #8064d8;
            font-size: 24px;
            font-weight: bold;
        }

        nav {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
        }

        nav a {
            color: #51486a;
            text-decoration: none;
        }

        nav a:hover {
            color: #8064d8;
        }

        main {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        h1 {
            margin-bottom: 10px;
        }

        .subtitle {
            color: #706982;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card, .plan {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 5px 20px #29243d0d;
        }

        .card h3 {
            color: #706982;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .number {
            color: #8064d8;
            font-size: 32px;
            font-weight: bold;
        }

        .plan h2 {
            margin-bottom: 20px;
        }

        .goal {
            padding: 15px 0;
            border-bottom: 1px solid #eeeaf7;
        }

        .goal:last-child {
            border-bottom: none;
        }

        .muted {
            color: #706982;
            margin-top: 7px;
        }

        .empty {
            color: #706982;
            line-height: 1.6;
        }

        .manage-link {
            display: inline-block;
            margin-top: 20px;
            color: #8064d8;
            text-decoration: none;
            font-weight: bold;
        }

        .quick-links {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 30px;
        }

        .quick-links a {
            display: inline-block;
            padding: 12px 20px;
            background: #8064d8;
            color: white;
            border-radius: 10px;
            text-decoration: none;
        }

        .quick-links a:hover {
            background: #674bb8;
        }

        footer {
            text-align: center;
            color: #706982;
            padding: 25px;
        }

        @media (max-width: 600px) {
            header {
                flex-direction: column;
            }

            nav {
                justify-content: center;
            }
        }
    </style>
</head>

<body>

<header>
    <div class="logo">Digital Twin ✦</div>

    <nav>
        <a href="index.php">Басты бет</a>
        <a href="dashboard.php">Статистика</a>
        <a href="journal.php">Күнделік</a>
        <a href="goals.php">Мақсаттар</a>
        <a href="logout.php">Шығу</a>
    </nav>
</header>

<main>

    <h1>
        Қош келдің, <?= htmlspecialchars($userName, ENT_QUOTES, "UTF-8") ?>! ✨
    </h1>

    <p class="subtitle">
        Өз мақсаттарың мен күнделікті жетістіктеріңді бақыла.
    </p>

    <div class="quick-links">
        <a href="journal.php">+ Күнделік жазу</a>
        <a href="goals.php">+ Мақсат қосу</a>
    </div>

    <section class="stats">

        <div class="card">
            <h3>🎯 Барлық мақсаттар</h3>
            <p class="number"><?= $totalGoals ?></p>
        </div>

        <div class="card">
            <h3>⭐ Орындалған мақсаттар</h3>
            <p class="number"><?= $completedGoals ?></p>
        </div>

        <div class="card">
            <h3>📔 Күнделік жазбалары</h3>
            <p class="number"><?= $totalEntries ?></p>
        </div>

    </section>

    <section class="plan">

        <h2>Менің соңғы мақсаттарым</h2>

        <?php if (empty($goals)): ?>

            <p class="empty">
                Әзірге мақсаттарың жоқ. Алғашқы мақсатыңды қос!
            </p>

        <?php else: ?>

            <?php foreach ($goals as $goal): ?>

                <div class="goal">
                    <h3>
                        <?= htmlspecialchars($goal["title"], ENT_QUOTES, "UTF-8") ?>
                    </h3>

                    <p class="muted">
                        Күйі:
                        <?= htmlspecialchars($goal["status"] ?? "Жоспарда", ENT_QUOTES, "UTF-8") ?>
                    </p>
                </div>

            <?php endforeach; ?>

        <?php endif; ?>

        <a href="goals.php" class="manage-link">
            Барлық мақсаттарды басқару →
        </a>

    </section>

</main>

<footer>
    © 2026 Digital Twin. Барлық құқықтар қорғалған.
</footer>

</body>
</html>
