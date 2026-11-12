<?php
require_once __DIR__ . "/config/db.php";

$message = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($name === "" || $email === "" || $password === "") {
        $message = "Барлық өрісті толтырыңыз.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Электрондық пошта дұрыс емес.";
    } elseif (strlen($password) < 8) {
        $message = "Құпиясөз кемінде 8 таңбадан тұруы керек.";
    } else {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                "INSERT INTO users (name, email, password)
                 VALUES (?, ?, ?)"
            );

            $stmt->execute([$name, $email, $hash]);

            $message = "Тіркелу сәтті аяқталды! Енді аккаунтыңа кіре аласың.";
            $success = true;

        } catch (PDOException $e) {
            if ($e->getCode() === "23000") {
                $message = "Бұл электрондық пошта бұрын тіркелген.";
            } else {
                $message = "Қате орын алды. Қайта көріңіз.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тіркелу | Digital Twin</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: #f4f5fa;
            font-family: Arial, sans-serif;
            color: #252842;
        }

        .card {
            width: min(420px, 92%);
            padding: 32px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 35px #25284212;
        }

        h1 {
            margin-top: 0;
            color: #7067e8;
        }

        p {
            color: #666b80;
            line-height: 1.5;
        }

        label {
            display: block;
            margin: 16px 0 7px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #dcdfea;
            border-radius: 10px;
        }

        input:focus {
            outline: none;
            border-color: #7067e8;
        }

        button {
            width: 100%;
            margin-top: 22px;
            padding: 13px;
            border: 0;
            border-radius: 10px;
            background: #7067e8;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #574dc8;
        }

        .message {
            color: #5146c8;
            line-height: 1.5;
        }

        a {
            color: #6258dc;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <main class="card">
        <h1>Қош келдің! ✨</h1>
        <p>Digital Twin жүйесінде жеке аккаунтыңды жаса.</p>

        <?php if ($message !== ""): ?>
            <p class="message">
                <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
            </p>
        <?php endif; ?>

        <form method="POST">
            <label for="name">Атың</label>
            <input
                id="name"
                type="text"
                name="name"
                required
                maxlength="100"
                autocomplete="name"
            >

            <label for="email">Электрондық пошта</label>
            <input
                id="email"
                type="email"
                name="email"
                required
                maxlength="150"
                autocomplete="email"
            >

            <label for="password">Құпиясөз</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                minlength="8"
                autocomplete="new-password"
            >

            <button type="submit">Тіркелу</button>
        </form>

        <p>Аккаунтың бар ма? <a href="login.php">Кіру</a></p>
        <a href="index.php">← Басты бет</a>
    </main>
</body>
</html>
