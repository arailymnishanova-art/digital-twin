
<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кіру — Digital Twin</title>

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
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-box {
            background: white;
            width: 100%;
            max-width: 420px;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 8px 30px #29243d12;
        }

        h1 {
            text-align: center;
            color: #8064d8;
            margin-bottom: 12px;
        }

        .subtitle {
            text-align: center;
            color: #706982;
            margin-bottom: 28px;
        }

        label {
            display: block;
            margin: 16px 0 8px;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #ddd6f5;
            border-radius: 10px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 14px;
            margin-top: 24px;
            border: none;
            border-radius: 10px;
            background: #8064d8;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #8064d8;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="login-box">
    <h1>Digital Twin ✦</h1>
    <p class="subtitle">Жеке күнделігіңе қош келдің!</p>

    <form>
        <label for="email">Электрондық пошта</label>
        <input type="email" id="email" placeholder="example@mail.com" required>

        <label for="password">Құпиясөз</label>
        <input type="password" id="password" placeholder="Құпиясөзіңді енгіз" required>

        <button type="submit">Кіру</button>
    </form>

    <a class="back" href="index.php">← Басты бетке қайту</a>
</div>

</body>
</html>
