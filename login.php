<?php
session_start();
require_once __DIR__ . "/config/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $pdo->prepare(
        "SELECT id, name, password FROM users WHERE email = ?"
    );
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];

        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Электрондық пошта немесе құпиясөз қате.";
    }
}
?>
<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кіру | Digital Twin</title>

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
            color: #c0392b;
        }

        a {
            color: #6258dc;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <main class="card">
        <h1>Digital Twin ✦</h1>
        <p>Жеке күнделігіңе қош келдің!</p>

        <?php if ($message !== ""): ?>
            <p class="message">
                <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
            </p>
        <?php endif; ?>

        <form method="POST">
            <label for="email">Электрондық пошта</label>
            <input
                id="email"
                type="email"
                name="email"
                required
                autocomplete="email"
            >

            <label for="password">Құпиясөз</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            >

            <button type="submit">Кіру</button>
        </form>

        <p>Аккаунтың жоқ па? <a href="register.php">Тіркелу</a></p>
        <a href="index.php">← Басты бетке қайту</a>
    </main>
</body>
</html>
