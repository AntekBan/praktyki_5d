<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator Pochodnych</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<header>
    Firma
</header>

<main>
    <div class="dzial">
        <h2>Menu</h2>
        <ul>
            <li><a href="StronaGlowna.html">Strona główna</a></li>
        </ul>
    </div>

    <div class="dzial">
        <h2>Kalkulator pochodnej wielomianu</h2>

        <p>Podaj wyrażenie np: 3x^2 + 4x^1 + 5x^0</p>

        <input type="text" id="expression" size="40">
        <br><br>
        <button onclick="calculateDerivative()">Oblicz pochodną</button>

        <h3>Wynik:</h3>
        <p id="result"></p>
    </div>
</main>

<script>
function calculateDerivative() {
    var tekst = document.getElementById("expression").value;
    var kawalki = tekst.split("+");
    var dane = {};

    for (var i = 0; i < kawalki.length; i++) {
        var element = kawalki[i].trim();
        var podzial = element.split("x^");
        
        var a = Number(podzial[0]);
        var n = Number(podzial[1]);

        if (dane[n]) {
            dane[n] += a;
        } else {
            dane[n] = a;
        }
    }

    var stopnie = Object.keys(dane).sort(function(a, b) { return b - a; });

    var wynik = "";

    for (var j = 0; j < stopnie.length; j++) {
        var n = Number(stopnie[j]);
        var a = dane[n];

        if (n > 0) { 
            var nowyWspolczynnik = a * n;
            var nowyWykladnik = n - 1;

            if (wynik !== "") wynik += " + ";
            wynik += nowyWspolczynnik + "x^" + nowyWykladnik;
        }
    }

    document.getElementById("result").innerHTML = wynik || "0";
}
</script>

</body>
</html>