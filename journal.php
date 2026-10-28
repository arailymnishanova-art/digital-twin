
<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Менің күнделігім — Digital Twin</title>

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
            max-width: 850px;
            margin: 40px auto;
            padding: 0 20px;
        }

        h1 {
            margin-bottom: 12px;
        }

        .subtitle {
            color: #706982;
            margin-bottom: 28px;
            line-height: 1.6;
        }

        .journal-box {
            background: white;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 5px 20px #29243d0d;
        }

        label {
            display: block;
            margin: 18px 0 8px;
            font-weight: bold;
        }

        input, textarea, select {
            width: 100%;
            padding: 13px;
            border: 1px solid #ddd6f5;
            border-radius: 10px;
            font-size: 15px;
            font-family: inherit;
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        button {
            margin-top: 20px;
            padding: 13px 22px;
            background: #8064d8;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 15px;
        }

        .example {
            background: #fff;
            padding: 22px;
            margin-top: 25px;
            border-radius: 16px;
            border-left: 4px solid #8064d8;
        }

        .example p {
            margin-top: 10px;
            color: #706982;
            line-height: 1.6;
        }

        footer {
            text-align: center;
            padding: 25px;
            color: #706982;
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
        <a href="dashboard.php">Статистика</a>
    </nav>
</header>

<main>
    <h1>Менің жеке күнделігім 📔</h1>
    <p class="subtitle">
        Ойларыңды, күнделікті оқиғаларыңды және жетістіктеріңді жаз.
    </p>

    <section class="journal-box">
        <form id="journalForm">
            <label for="date">Күні</label>
            <input type="date" id="date" required>

            <label for="title">Жазбаның тақырыбы</label>
            <input type="text" id="title"
                   placeholder="Мысалы: Бүгінгі жетістігім"
                   maxlength="100" required>

            <label for="mood">Көңіл күйім</label>
            <select id="mood" required>
                <option value="">Таңда</option>
                <option>😊 Керемет</option>
                <option>🙂 Жақсы</option>
                <option>😐 Қалыпты</option>
                <option>😔 Көңілсіз</option>
            </select>

            <label for="content">Күнделіктегі жазба</label>
            <textarea id="content"
                      placeholder="Бүгінгі күнің қалай өтті?"
                      maxlength="3000" required></textarea>

            <button type="submit">Жазбаны сақтау</button>
        </form>
    </section>

    <section id="entries">
        <div class="example">
            <h3>✨ Күнделіктің мақсаты</h3>
            <p>
                Әр күніңді жазып, көңіл күйіңді бақыла.
                Уақыт өте келе өзіңнің жетістіктеріңді
                және өзгерістеріңді байқай аласың.
            </p>
        </div>
    </section>
</main>

<footer>© 2026 Digital Twin</footer>

<script>
    const dateInput = document.getElementById("date");
    dateInput.value = new Date().toLocaleDateString("en-CA");

    const form = document.getElementById("journalForm");
    const entries = document.getElementById("entries");

    form.addEventListener("submit", function(event) {
        event.preventDefault();

        const date = dateInput.value;
        const title = document.getElementById("title").value.trim();
        const mood = document.getElementById("mood").value;
        const content = document.getElementById("content").value.trim();

        if (!date || !title || !mood || !content) {
            alert("Барлық жолды толтыр!");
            return;
        }

        const card = document.createElement("div");
        card.className = "example";

        const heading = document.createElement("h3");
        heading.textContent = title;

        const details = document.createElement("p");
        details.textContent = date + " · " + mood;

        const text = document.createElement("p");
        text.textContent = content;

        card.append(heading, details, text);
        entries.prepend(card);

        form.reset();
        dateInput.value = new Date().toLocaleDateString("en-CA");

        alert("Жазба осы бетке қосылды!");
    });
</script>

</body>
</html>
