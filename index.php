
<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Digital Twin — Жеке цифрлық күнделік</title>

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

        nav {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        nav a {
            text-decoration: none;
            color: #51486a;
            font-size: 15px;
        }

        nav a:hover {
            color: #8064d8;
        }

        .hero {
            min-height: 70vh;
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
            padding: 14px 30px;
            border-radius: 12px;
            text-decoration: none;
            transition: 0.3s;
        }

        .button:hover {
            background: #674bb8;
        }

        .features {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            padding: 30px 8% 70px;
        }

        .card-link {
            text-decoration: none;
            color: inherit;
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 18px;
            width: 260px;
            min-height: 160px;
            box-shadow: 0 5px 20px #29243d0d;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px #29243d18;
        }

        .card h3 {
            margin-bottom: 15px;
            color: #8064d8;
        }

        .card p {
            line-height: 1.7;
            color: #706982;
        }

        footer {
            text-align: center;
            padding: 25px;
            color: #706982;
            background: white;
        }

        @media (max-width: 600px) {
            header {
                flex-direction: column;
                gap: 18px;
            }

            nav {
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px;
            }

            .hero h1 {
                font-size: 34px;
            }
        }
    </style>
</head>

<body>

<?php include __DIR__ . "/includes/header.php"; ?>

<section class="hero">

    <h1>Өміріңді <span>басқар!</span></h1>

    <p>
        Digital Twin — күнделікті мақсаттарыңды, тапсырмаларыңды
        және жетістіктеріңді бір жерде сақтауға арналған
        жеке цифрлық күнделік.
    </p>

    <a href="register.php" class="button">Бастау →</a>

</section>

<section class="features">

    <a href="login.php" class="card-link">
        <div class="card">
            <h3>📅 Күнделікті жоспар</h3>
            <p>
                Күн сайынғы тапсырмаларың мен жоспарларыңды
                жазып, олардың орындалуын бақыла.
            </p>
        </div>
    </a>

    <a href="login.php" class="card-link">
        <div class="card">
            <h3>🎯 Мақсаттар</h3>
            <p>
                Жеке мақсаттарыңды белгіле, өңде және
                олардың орындалуын бақыла.
            </p>
        </div>
    </a>

    <a href="login.php" class="card-link">
        <div class="card">
            <h3>📊 Өмір статистикасы</h3>
            <p>
                Жеке жетістіктеріңді бақылап,
                өз дамуыңдағы өзгерістерді көр.
            </p>
        </div>
    </a>

</section>

<?php include __DIR__ . "/includes/footer.php"; ?>

</body>
</html>
