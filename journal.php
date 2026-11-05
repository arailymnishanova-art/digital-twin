
<?php
session_start();
require_once __DIR__ . "/config/db.php";

// Жүйеге кіргенін тексеру
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$userId = (int) $_SESSION["user_id"];

// CSRF қорғанысы
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION["csrf_token"];
$message = $_SESSION["flash_message"] ?? "";
unset($_SESSION["flash_message"]);

$allowedMoods = [
    "😊 Қуанышты",
    "😌 Сабырлы",
    "😔 Көңілсіз",
    "😴 Шаршаған"
];

// Жазбаларды қосу, өңдеу және өшіру
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $token = $_POST["csrf_token"] ?? "";

    if (!hash_equals($csrfToken, $token)) {
        $message = "Сұраныс жарамсыз. Бетті жаңартып көр.";
    } else {

        $action = $_POST["action"] ?? "";
        $entryId = (int) ($_POST["entry_id"] ?? 0);

        if ($action === "add" || $action === "edit") {

            $title = trim($_POST["title"] ?? "");
            $content = trim($_POST["content"] ?? "");
            $mood = $_POST["mood"] ?? "";
            $entryDate = $_POST["entry_date"] ?? "";

            if ($title === "" || $content === "") {
                $message = "Тақырып пен жазбаны толтыр.";
            } elseif (
                !preg_match('/^\d{4}-\d{2}-\d{2}$/', $entryDate)
                || !checkdate(
                    (int) substr($entryDate, 5, 2),
                    (int) substr($entryDate, 8, 2),
                    (int) substr($entryDate, 0, 4)
                )
            ) {
                $message = "Күнді дұрыс таңда.";
            } elseif ($mood !== "" && !in_array($mood, $allowedMoods, true)) {
                $message = "Көңіл күйді дұрыс таңда.";
            } else {

                if ($action === "add") {

                    $stmt = $pdo->prepare(
                        "INSERT INTO journal_entries
                        (user_id, title, content, mood, entry_date)
                        VALUES (?, ?, ?, ?, ?)"
                    );

                    $stmt->execute([
                        $userId,
                        $title,
                        $content,
                        $mood,
                        $entryDate
                    ]);

                    $_SESSION["flash_message"] =
                        "Күнделік жазбасы сәтті қосылды!";

                } elseif ($action === "edit" && $entryId > 0) {

                    $stmt = $pdo->prepare(
                        "UPDATE journal_entries
                         SET title = ?, content = ?, mood = ?, entry_date = ?
                         WHERE id = ? AND user_id = ?"
                    );

                    $stmt->execute([
                        $title,
                        $content,
                        $mood,
                        $entryDate,
                        $entryId,
                        $userId
                    ]);

                    $_SESSION["flash_message"] =
                        "Күнделік жазбасы жаңартылды!";
                }

                if ($action === "add" || ($action === "edit" && $entryId > 0)) {
                    header("Location: journal.php");
                    exit;
                }
            }

        } elseif ($action === "delete" && $entryId > 0) {

            $stmt = $pdo->prepare(
                "DELETE FROM journal_entries
                 WHERE id = ? AND user_id = ?"
            );

            $stmt->execute([$entryId, $userId]);

            $_SESSION["flash_message"] =
                $stmt->rowCount() > 0
                ? "Жазба өшірілді!"
                : "Жазба табылмады.";

            header("Location: journal.php");
            exit;
        }
    }
}

// Өңделетін жазбаны алу
$editEntry = null;

if (isset($_GET["edit"])) {

    $stmt = $pdo->prepare(
        "SELECT id, title, content, mood, entry_date
         FROM journal_entries
         WHERE id = ? AND user_id = ?"
    );

    $stmt->execute([(int) $_GET["edit"], $userId]);
    $editEntry = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Пайдаланушының барлық жазбалары
$stmt = $pdo->prepare(
    "SELECT id, title, content, mood, entry_date
     FROM journal_entries
     WHERE user_id = ?
     ORDER BY entry_date DESC, id DESC"
);

$stmt->execute([$userId]);
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Менің күнделігім | Digital Twin</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px 16px;
            background: #f4f5fa;
            color: #252842;
            font-family: Arial, sans-serif;
        }

        main {
            max-width: 720px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 24px;
            margin-bottom: 20px;
            border-radius: 18px;
            box-shadow: 0 8px 25px #2528420d;
        }

        h1, h2 {
            margin-top: 0;
        }

        label {
            display: block;
            margin: 14px 0 7px;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #dcdfea;
            border-radius: 10px;
            font: inherit;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        button {
            margin-top: 12px;
            padding: 12px 20px;
            border: 0;
            border-radius: 10px;
            background: #7067e8;
            color: white;
            cursor: pointer;
            font: inherit;
        }

        button:hover {
            opacity: 0.9;
        }

        .entry {
            padding: 18px 0;
            border-bottom: 1px solid #eeeef5;
            overflow-wrap: anywhere;
        }

        .entry:last-child {
            border-bottom: 0;
        }

        .message {
            padding: 12px;
            background: #f0eaff;
            border-radius: 8px;
            color: #5146c8;
        }

        .muted {
            color: #777b8e;
        }

        a {
            color: #6258dc;
            text-decoration: none;
        }

        .actions {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 12px;
        }

        .delete-button {
            background: #c94c65;
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

        <h1>Менің күнделігім ✨</h1>

        <p class="muted">
            Ойларыңды, көңіл күйіңді және күнделікті оқиғаларды жаз.
        </p>

        <?php if ($message !== ""): ?>
            <p class="message">
                <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
            </p>
        <?php endif; ?>

        <h2>
            <?= $editEntry ? "Жазбаны өңдеу" : "Жаңа жазба қосу" ?>
        </h2>

        <form method="POST" action="journal.php">

            <input type="hidden" name="csrf_token"
                   value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, "UTF-8") ?>">

            <input type="hidden" name="action"
                   value="<?= $editEntry ? "edit" : "add" ?>">

            <?php if ($editEntry): ?>
                <input type="hidden" name="entry_id"
                       value="<?= (int) $editEntry["id"] ?>">
            <?php endif; ?>

            <label for="title">Жазбаның тақырыбы</label>

            <input
                id="title"
                name="title"
                maxlength="200"
                required
                value="<?= htmlspecialchars($editEntry["title"] ?? "", ENT_QUOTES, "UTF-8") ?>"
                placeholder="Мысалы, бүгінгі күнім"
            >

            <label for="content">Бүгінгі күнің қалай өтті?</label>

            <textarea
                id="content"
                name="content"
                required
                placeholder="Ойларыңды осында жаз..."
            ><?= htmlspecialchars($editEntry["content"] ?? "", ENT_QUOTES, "UTF-8") ?></textarea>

            <label for="mood">Көңіл күйің</label>

            <select id="mood" name="mood">
                <option value="">Таңда</option>

                <?php foreach ($allowedMoods as $mood): ?>
                    <option
                        value="<?= htmlspecialchars($mood, ENT_QUOTES, "UTF-8") ?>"
                        <?= ($editEntry["mood"] ?? "") === $mood ? "selected" : "" ?>
                    >
                        <?= htmlspecialchars($mood, ENT_QUOTES, "UTF-8") ?>
                    </option>
                <?php endforeach; ?>

            </select>

            <label for="entry_date">Күні</label>

            <input
                id="entry_date"
                type="date"
                name="entry_date"
                value="<?= htmlspecialchars($editEntry["entry_date"] ?? date("Y-m-d"), ENT_QUOTES, "UTF-8") ?>"
                required
            >

            <button type="submit">
                <?= $editEntry ? "Өзгерісті сақтау" : "Жазбаны сақтау" ?>
            </button>

            <?php if ($editEntry): ?>
                <p>
                    <a href="journal.php">Өңдеуден бас тарту</a>
                </p>
            <?php endif; ?>

        </form>

    </section>

    <section class="card">

        <h2>Менің жазбаларым</h2>

        <?php if (empty($entries)): ?>

            <p class="muted">
                Әзірге жазбалар жоқ. Алғашқы жазбаңды қос!
            </p>

        <?php else: ?>

            <?php foreach ($entries as $entry): ?>

                <article class="entry">

                    <h3>
                        <?= htmlspecialchars($entry["title"], ENT_QUOTES, "UTF-8") ?>
                    </h3>

                    <p class="muted">
                        <?= htmlspecialchars($entry["entry_date"], ENT_QUOTES, "UTF-8") ?>

                        <?php if (!empty($entry["mood"])): ?>
                            · <?= htmlspecialchars($entry["mood"], ENT_QUOTES, "UTF-8") ?>
                        <?php endif; ?>
                    </p>

                    <p>
                        <?= nl2br(htmlspecialchars(
                            $entry["content"],
                            ENT_QUOTES,
                            "UTF-8"
                        )) ?>
                    </p>

                    <div class="actions">

                        <a href="journal.php?edit=<?= (int) $entry["id"] ?>">
                            Өңдеу
                        </a>

                        <form
                            method="POST"
                            action="journal.php"
                            onsubmit="return confirm('Осы жазбаны өшіргің келе ме?');"
                        >

                            <input type="hidden" name="csrf_token"
                                   value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, "UTF-8") ?>">

                            <input type="hidden" name="action" value="delete">

                            <input type="hidden" name="entry_id"
                                   value="<?= (int) $entry["id"] ?>">

                            <button type="submit" class="delete-button">
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
