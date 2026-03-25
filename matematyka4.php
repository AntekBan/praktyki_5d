<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator Pochodnych</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Kalkulator Pochodnych</h1>
    <p>Podaj wyrażenie np: 4x^6 + 3x^6 + 2x + 4</p>
</header>

<main>
    <div class="dzial">
        <h2>Menu</h2>
        <ul>
            <li><a href="StronaGlowna.html">Strona główna</a></li>
        </ul>
    </div>

    <div class="dzial">
        <form method="POST">
            <input type="text" name="wyrazenie" size="40" value="<?php echo isset($_POST['wyrazenie']) ? htmlspecialchars($_POST['wyrazenie']) : ''; ?>">
            <br><br>
            <button type="submit">Oblicz pochodną</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['wyrazenie'])) {
            $wejscie = strtoupper($_POST['wyrazenie']); 
            $wejscie = str_replace(" ", "", $wejscie); 
            
            // Poprawka dla x bez potęgi (np. 2x -> 2x^1)
            $wejscie = preg_replace('/X(?!\^)/', 'X^1', $wejscie);
            
            // Rozbicie wielomianu na pojedyncze składniki
            $skladniki = explode("+", str_replace("-", "+-", $wejscie));
            $suma_wspolczynnikow = [];

            foreach ($skladniki as $skladnik) {
                if (empty($skladnik)) continue;

                if (strpos($skladnik, 'X^') !== false) {
                    $czesci = explode("X^", $skladnik);
                    $wspolczynnik = (float)$czesci[0];
                    $potega = (int)$czesci[1];
                } else {
                    // Obsługa samej liczby (np. 4 -> 4x^0)
                    $wspolczynnik = (float)$skladnik;
                    $potega = 0;
                }

                if (isset($suma_wspolczynnikow[$potega])) {
                    $suma_wspolczynnikow[$potega] += $wspolczynnik;
                } else {
                    $suma_wspolczynnikow[$potega] = $wspolczynnik;
                }
            }

            // Sortowanie od największej potęgi
            krsort($suma_wspolczynnikow); 

            $wynik_finalny = [];
            foreach ($suma_wspolczynnikow as $n => $a) {
                if ($n > 0) {
                    $nowy_wspolczynnik = $a * $n;
                    $nowa_potega = $n - 1;

                    if ($nowy_wspolczynnik == 0) continue;

                    // Upraszczanie zapisu (brak ^1 i ^0)
                    if ($nowa_potega == 0) {
                        $wynik_finalny[] = $nowy_wspolczynnik;
                    } elseif ($nowa_potega == 1) {
                        $wynik_finalny[] = $nowy_wspolczynnik . "x";
                    } else {
                        $wynik_finalny[] = $nowy_wspolczynnik . "x^" . $nowa_potega;
                    }
                }
            }

            echo "<h3>Wynik:</h3>";
            $tekst_wyniku = implode(" + ", $wynik_finalny);
            $tekst_wyniku = str_replace("+ -", "- ", $tekst_wyniku);
            
            echo "<p><b>" . ($tekst_wyniku ?: "0") . "</b></p>";
        }
        ?>
    </div>
</main>

<footer>
    <p>Strone wykonała: 5D 2/2</p>
</footer>

</body>
</html>
