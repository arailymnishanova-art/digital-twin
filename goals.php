
<?php
session_start();
require_once __DIR__ . "/config/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$userId = (int) $_SESSION["user_id"];
$message = "";

// Мақсаттарды қосу, өңдеу, өшіру және күйін өзгерту
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";
    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $goalId = (int) ($_POST["goal_id"] ?? 0);

    if ($action === "add") {
        if ($title === "") {
            $message = "Мақсаттың атауын енгіз.";
        } else {
            $stmt = $pdo->prepare(
                "INSERT INTO goals (user_id, title, description)
                 VALUES (?, ?, ?)"
            );
            $stmt->execute([$userId, $title, $description]);
            $message = "Мақсат сәтті қосылды!";
        }
    }

    elseif ($action === "edit") {
        if ($goalId <= 0 || $title === "") {
            $message = "Мақсаттың атауын дұрыс енгіз.";
        } else {
            $stmt = $pdo->prepare(
                "UPDATE goals
                 SET title = ?, description = ?
                 WHERE id = ? AND user_id = ?"
            );
            $stmt->execute([
                $title,
                $description,
                $goalId,
                $userId
            ]);
            $message = "Мақсат жаңартылды!";
        }
    }

    elseif ($action === "status") {
        $newStatus = $_POST["status"] ?? "";
        $allowedStatuses = [
            "Жоспарда",
            "Орындалуда",
            "Орындалды"
        ];

        if (
            $goalId > 0 &&
            in_array($newStatus, $allowedStatuses, true)
        ) {
            $stmt = $pdo->prepare(
                "UPDATE goals
                 SET status = ?
                 WHERE id = ? AND user_id = ?"
            );
            $stmt->execute([$newStatus, $goalId, $userId]);
            $message = "Мақсаттың күйі жаңартылды!";
        } else {
            $message = "Мақсаттың күйін дұрыс таңда.";
        }
    }

    elseif ($action === "delete" && $goalId > 0) {
        $stmt = $pdo->prepare(
            "DELETE FROM goals
             WHERE id = ? AND user_id = ?"
        );
        $stmt->execute([$goalId, $userId]);
        $message = "Мақсат өшірілді!";
    }
}

// Өңделетін мақсатты алу
$editGoal = null;

if (isset($_GET["edit"])) {
    $stmt = $pdo->prepare(
        "SELECT id, title, description, status
         FROM goals
         WHERE id = ? AND user_id = ?"
    );
    $stmt->execute([(int) $_GET["edit"], $userId]);
    $editGoal = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Пайдаланушының барлық мақсаттарын алу
$stmt = $pdo->prepare(
    "SELECT id, title, description, status, target_date
     FROM goals
     WHERE user_id = ?
     ORDER BY id DESC"
);
$stmt->execute([$userId]);
$goals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Менің мақсаттарым | Digital Twin</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f0ff;
            margin: 0;
            padding: 25px 15px;
            color: #333;
        }

        main {
            max-width: 700px;
            margin: auto;
        }

        a {
            color: #6545a5;
        }

        .card {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 15px #ddd;
        }

        input, textarea, select, button {
            width: 100%;
            padding: 12px;
            margin: 8px 0 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font: inherit;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        button {
            background: #8064c9;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.9;
        }

        .goal {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
            overflow-wrap: anywhere;
        }

        .actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .actions form {
            flex: 1;
        }

        .actions a {
            padding: 10px 0;
        }

        .delete-button {
            background: #c94c65;
        }

        .message {
            padding: 12px;
            background: #f0eaff;
            border-radius: 8px;
            color: #6545a5;
        }

        .muted {
            color: #777;
            font-size: 14px;
        }

        @media (max-width: 480px) {
            .card {
                padding: 18px;
            }
        }
    </style>
</head>

<body>
<main>
    <p><a href="dashboard.php">← Жеке кабинетке қайту</a></p>

    <section class="card">
        <h1>🎯 Менің мақсаттарым</h1>
        <p>Мақсаттарыңды жазып, өз жетістіктеріңді бақыла.</p>

        <?php if ($message !== ""): ?>
            <p class="message">
                <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
            </p>
        <?php endif; ?>

        <h2>
            <?= $editGoal ? "Мақсатты өңдеу" : "Жаңа мақсат қосу" ?>
        </h2>

        <form method="POST" action="goals.php">
            <input type="hidden" name="action"
                   value="<?= $editGoal ? "edit" : "add" ?>">

            <?php if ($editGoal): ?>
                <input type="hidden" name="goal_id"
                       value="<?= (int) $editGoal["id"] ?>">
            <?php endif; ?>

            <label for="title">Мақсаттың атауы</label>
            <input
                id="title"
                name="title"
                maxlength="200"
                value="<?= htmlspecialchars($editGoal["title"] ?? "", ENT_QUOTES, "UTF-8") ?>"
                placeholder="Мысалы, ағылшын тілін үйрену"
                required
            >

            <label for="description">Сипаттамасы</label>
            <textarea
                id="description"
                name="description"
                placeholder="Бұл мақсатқа қалай жетемін?"
            ><?= htmlspecialchars($editGoal["description"] ?? "", ENT_QUOTES, "UTF-8") ?></textarea>

            <button type="submit">
                <?= $editGoal ? "Өзгерісті сақтау" : "Мақсатты сақтау" ?>
            </button>

            <?php if ($editGoal): ?>
                <a href="goals.php">Өңдеуден бас тарту</a>
            <?php endif; ?>
        </form>
    </section>

    <section class="card">
        <h2>Менің тізімім</h2>

        <?php if (empty($goals)): ?>
            <p class="muted">Әзірге мақсат қосылмаған.</p>
        <?php else: ?>
            <?php foreach ($goals as $goal): ?>
                <article class="goal">
                    <h3>
                        <?= htmlspecialchars($goal["title"], ENT_QUOTES, "UTF-8") ?>
                    </h3>

                    <p>
                        <?= nl2br(htmlspecialchars(
                            $goal["description"] ?? "",
                            ENT_QUOTES,
                            "UTF-8"
                        )) ?>
                    </p>

                    <p>
                        <strong>Қазіргі күйі:</strong>
                        <?= htmlspecialchars(
                            $goal["status"] ?? "Жоспарда",
                            ENT_QUOTES,
                            "UTF-8"
                        ) ?>
                    </p>

                    <?php if (!empty($goal["target_date"])): ?>
                        <p class="muted">
                            Мақсат күні:
                            <?= htmlspecialchars(
                                $goal["target_date"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>
                        </p>
                    <?php endif; ?>

                    <form method="POST" action="goals.php">
                        <input type="hidden" name="action" value="status">
                        <input type="hidden" name="goal_id"
                               value="<?= (int) $goal["id"] ?>">

                        <label for="status-<?= (int) $goal["id"] ?>">
                            Мақсаттың күйін өзгерту
                        </label>

                        <select
                            id="status-<?= (int) $goal["id"] ?>"
                            name="status"
                        >
                            <?php
                            $statuses = [
                                "Жоспарда",
                                "Орындалуда",
                                "Орындалды"
                            ];
                            $currentStatus = $goal["status"] ?? "Жоспарда";
                            ?>

                            <?php foreach ($statuses as $status): ?>
                                <option
                                    value="<?= htmlspecialchars($status, ENT_QUOTES, "UTF-8") ?>"
                                    <?= $currentStatus === $status ? "selected" : "" ?>
                                >
                                    <?= htmlspecialchars($status, ENT_QUOTES, "UTF-8") ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <button type="submit">Күйді сақтау</button>
                    </form>

                    <div class="actions">
                        <a href="goals.php?edit=<?= (int) $goal["id"] ?>">
                            Өңдеу
                        </a>

                        <form
                            method="POST"
                            action="goals.php"
                            onsubmit="return confirm('Осы мақсатты өшіргің келе ме?');"
                        >
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="goal_id"
                                   value="<?= (int) $goal["id"] ?>">

                            <button class="delete-button" type="submit">
                                Өшіру
                            </button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
