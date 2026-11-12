<?php include __DIR__ . "/includes/header.php"; ?>

<style>
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
    }

    .card h3 {
        margin-bottom: 15px;
        color: #8064d8;
    }

    .card p {
        line-height: 1.7;
        color: #706982;
    }

    @media (max-width: 600px) {
        .hero h1 {
            font-size: 34px;
        }
    }
</style>

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
            <p>Күн сайынғы тапсырмаларың мен жоспарларыңды жазып, олардың орындалуын бақыла.</p>
        </div>
    </a>

    <a href="login.php" class="card-link">
        <div class="card">
            <h3>🎯 Мақсаттар</h3>
            <p>Жеке мақсаттарыңды белгіле, өңде және олардың орындалуын бақыла.</p>
        </div>
    </a>

    <a href="login.php" class="card-link">
        <div class="card">
            <h3>📊 Өмір статистикасы</h3>
            <p>Жеке жетістіктеріңді бақылап, өз дамуыңдағы өзгерістерді көр.</p>
        </div>
    </a>

</section>

<?php include __DIR__ . "/includes/footer.php"; ?>
