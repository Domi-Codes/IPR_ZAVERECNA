<?php
// Seznam žáků z dokumentu
$students = [
    "Dominik Poláček",
    "Daniel Opustil",
    "Kristian Ondráček",
    "Vít Halas",
    "Max Adamec",
    "Martin Kolmačka",
    "Martin Kunc",
    "Dominik Dobeš",
    "Štěpán Hanousek",
    "Štěpán Málek",
    "Alexandr Smolka",
    "Štěpán Teplý",
    "Vojtěch Maňoušek",
    "Jakub Přibyl",
    "Pavel Minich",
    "Matyáš Zavadil",
    "David Štros",
    "Daniel Ruberto",
    "Filip Navrátil",
    "Vojtěch Tížek",
    "Vojtěch Vitvar"
];

// Soubor s historií
$historyFile = "history.txt";

// Načtení historie
$called = file_exists($historyFile) ? file($historyFile, FILE_IGNORE_NEW_LINES) : [];

// Zbývající žáci
$remaining = array_diff($students, $called);

// Losování
$selected = null;
if (isset($_POST['losuj'])) {
    if (!empty($remaining)) {
        $selected = $remaining[array_rand($remaining)];

        // Uložit do historie
        file_put_contents($historyFile, $selected . PHP_EOL, FILE_APPEND);

        // Aktualizovat seznam
        $called[] = $selected;
        $remaining = array_diff($students, $called);
    }
}

// Reset
if (isset($_POST['reset'])) {
    file_put_contents($historyFile, "");
    $called = [];
    $remaining = $students;
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
<meta charset="UTF-8">
<title>Losování žáka</title>
<style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        background: #f4f4f4;
        padding: 20px;
    }
    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        max-width: 900px;
        margin: auto;
    }
    .student {
        padding: 12px 18px;
        margin: 6px;
        background: #e0e0e0;
        border-radius: 8px;
        font-size: 17px;
    }
    .called {
        background: #ff6b6b;
        color: white;
    }
    .selected {
        background: #4caf50 !important;
        color: white;
        font-weight: bold;
        border: 2px solid #2e7d32;
    }
    button {
        padding: 12px 25px;
        font-size: 18px;
        margin: 10px;
        cursor: pointer;
        border-radius: 6px;
        border: none;
    }
    .losuj {
        background: #2196f3;
        color: white;
    }
    .reset {
        background: #333;
        color: white;
    }
</style>
</head>
<body>

<h1>Losování žáka k tabuli</h1>

<form method="post">
    <button class="losuj" name="losuj">🎲 Losuj žáka</button>
    <button class="reset" name="reset">Resetovat</button>
</form>

<?php if ($selected): ?>
    <h2>Vylosovaný žák: <span style="color:green"><?= htmlspecialchars($selected) ?></span></h2>
<?php endif; ?>

<div class="container">
<?php foreach ($students as $student): ?>
    <div class="student
        <?= in_array($student, $called) ? 'called' : '' ?>
        <?= ($selected === $student) ? 'selected' : '' ?>
    ">
        <?= htmlspecialchars($student) ?>
    </div>
<?php endforeach; ?>
</div>

</body>
</html>
