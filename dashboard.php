
<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Жеке күнделік — Digital Twin</title>

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
        }

        .logo {
            color: #8064d8;
            font-size: 24px;
            font-weight: bold;
        }

        nav a {
            color: #51486a;
            text-decoration: none;
            margin-left: 18px;
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
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
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

        .plan {
            background: white;
            padding: 25px;
            border-radius: 16px;
        }

        .plan h2 {
            margin-bottom: 20px;
        }

        .task {
            padding: 15px 0;
            border-bottom: 1px solid #eeeaf7;
        }

        .task:last-child {
            border-bottom: none;
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

            nav a {
                margin: 0 6px;
            }
        }
    </style>
</head>

<body>

<header>
    <div class="logo">Digital Twin ✦</div>

    <nav>
        <a href="index.php">Басты бет</a>
        <a href="login.php">Кіру</a>
        <a href="journal.php">Күнделік</a>
    </nav>
</header>

<main>
    <h1>Менің күнделікті өмірім ✨</h1>
    <p class="subtitle">Өз мақсаттарың мен жетістіктеріңді бір жерден бақыла.</p>

    <section class="stats">
        <div class="card">
            <h3>📌 Бүгінгі тапсырмалар</h3>
            <p class="number">5</p>
        </div>

        <div class="card">
            <h3>🎯 Мақсаттар</h3>
            <p class="number">3</p>
        </div>

        <div class="card">
            <h3>⭐ Жетістіктер</h3>
            <p class="number">12</p>
        </div>
    </section>

    <section class="plan">
        <h2>Бүгінгі жоспарым</h2>

        <div class="task">☐ Сабаққа дайындалу</div>
        <div class="task">☐ Жоба бойынша жұмыс істеу</div>
        <div class="task">☐ Күннің нәтижесін жазу</div>
    </section>
</main>

<footer>
    © 2026 Digital Twin
</footer>

</body>
</html>
