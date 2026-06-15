<?php
/*

PROSIM - VELMI AKUTNE POTREBUJI NEJHUR DVOJKU
S pozdravem a přáním hezkého dne,
Dominik Poláček

*/
// SEZNAM ŽÁKŮ
$studenti = [
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

$aktualni = "";

// KONTROLA SOUBORU
if (!file_exists("data.txt"))
    {
        fopen("data.txt","w");
    }

// NAČTENÍ HISTORIE
$a = file("data.txt");
$vyvolani = [];
foreach ($a as $radek)
    {
        $radek = trim($radek);
        if (!empty($radek))
            {
                $vyvolani[] = $radek;
            }
    }

// ZJIŠTĚNÍ ZBÝVAJÍCÍCH
$zbyvajici = [];
foreach ($studenti as $s)
    {
        if (!in_array($s, $vyvolani))
            {
                $zbyvajici[] = $s;
            }
    }

// LOSOVÁNÍ
if (!empty($_GET["losuj"]))
    {
        if (count($zbyvajici) > 0)
            {
                $nahoda = rand(0, count($zbyvajici)-1);
                $aktualni = $zbyvajici[$nahoda];

                $soubor = fopen("data.txt","a");
                fwrite($soubor, $aktualni.PHP_EOL);
                fclose($soubor);

                // po zápisu znovu načteme historii a zbyvající
                $a = file("data.txt");
                $vyvolani = [];
                foreach ($a as $radek)
                    {
                        $radek = trim($radek);
                        if (!empty($radek))
                            {
                                $vyvolani[] = $radek;
                            }
                    }

                $zbyvajici = [];
                foreach ($studenti as $s)
                    {
                        if (!in_array($s, $vyvolani))
                            {
                                $zbyvajici[] = $s;
                            }
                    }
            }
    }

// RESET
if (!empty($_GET["reset"]))
    {
        $soubor = fopen("data.txt","w");
        fclose($soubor);
        $vyvolani = [];
        $zbyvajici = $studenti;
        $aktualni = "";
    }
?>
<!DOCTYPE html>
<html lang="cs">
<head>
<meta charset="UTF-8">
<title>Losovacka</title>
<style>
.zak        {border: 3px solid black; border-radius: 10px; padding: 10px; font-size: 150%; text-decoration: none; background: rgba(0,0,0,0.15); color: black; margin: 5px; display: inline-block;}
.vyvolany   {background: rgba(255,0,0,0.40); color: white;}
.aktualni   {background: rgba(0,150,0,0.60); color: white; border: 3px solid green;}
p           {margin: 20px}
</style>
</head>
<body>

<h1>Losování žáka</h1>

<p>
    <a class="zak" href="?losuj=1">Losuj žáka</a>
    <a class="zak" href="?reset=1">Resetuj</a>
</p>

<?php
if (!empty($aktualni))
    {
        echo"<h2>Vylosovaný žák: $aktualni</h2>";
    }
?>

<h2>Seznam žáků:</h2>

<?php
foreach ($studenti as $s)
    {
        $trida = "zak";

        if ($s == $aktualni)
            {
                $trida .= " aktualni";
            }
        else if (in_array($s, $vyvolani))
            {
                $trida .= " vyvolany";
            }

        echo"<a class='$trida'>$s</a>";
    }
?>

</body>
</html>
