
<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Twin — Жеке күнделік</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f7f5ff;
            color: #29243d;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 8%;
            background: white;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #8064d8;
        }

        nav a {
            text-decoration: none;
            color: #51486a;
            margin-left: 24px;
        }

        .hero {
            min-height: 75vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px 20px;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero h1 span {
            color: #8064d8;
        }

        .hero p {
            max-width: 600px;
            line-height: 1.8;
            color: #706982;
            margin-bottom: 30px;
        }

        .button {
            display: inline-block;
            background: #8064d8;
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            text-decoration: none;
        }

        .features {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px 8% 60px;
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 18px;
            width: 260px;
            box-shadow: 0 5px 20px #29243d0d;
        }

        .card h3 {
            margin-bottom: 12px;
            color: #8064d8;
        }

        .card p {
            line-height: 1.6;
            color: #706982;
        }

        footer {
            text-align: center;
            padding: 25px;
            color: #706982;
        }

        @media (max-width: 600px) {
            header {
                flex-direction: column;
                gap: 18px;
            }

            nav a {
                margin: 0 8px;
            }

            .hero h1 {
                font-size: 34px;
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
        <a href="dashboard.php">Күнделік</a>
    </nav>
</header>

<section class="hero">
    <h1>Өміріңді <span>басқар!</span></h1>

    <p>
        Digital Twin — күнделікті мақсаттарыңды, тапсырмаларыңды
        және жетістіктеріңді бір жерде сақтауға арналған
        жеке цифрлық күнделік.
    </p>

    <a href="login.php" class="button">Бастау →</a>
</section>

<section class="features">
    <div class="card">
        <h3>📅 Күнделікті жоспар</h3>
        <p>Күн сайынғы тапсырмаларың мен жоспарларыңды жаз.</p>
    </div>

    <div class="card">
        <h3>🎯 Мақсаттар</h3>
        <p>Мақсаттарыңды белгіле және орындалуын бақыла.</p>
    </div>

    <div class="card">
        <h3>📊 Өмір статистикасы</h3>
        <p>Жетістіктеріңді бақылап, өзгерістеріңді көр.</p>
    </div>
</section>

<footer>
    © 2026 Digital Twin | Жеке цифрлық күнделік
</footer>

</body>
</html>
