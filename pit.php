<?php
function obliczPIT($dochod) {
    $kwota_wolna = 30000;
    $prog = 120000;
    $stawka1 = 0.12;
    $stawka2 = 0.32;
    $kwota_zmniejszajaca = 3600;

    if ($dochod <= $kwota_wolna) {
        return 0;
    } 
    elseif ($dochod <= $prog) {
        return ($dochod * $stawka1) - $kwota_zmniejszajaca;
    } 
    else {
        $podatek_do_progu = ($prog * $stawka1) - $kwota_zmniejszajaca;
        $nadwyzka = ($dochod - $prog) * $stawka2;
        return $podatek_do_progu + $nadwyzka;
    }
}

$wynik = "";
$dochod = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dochod = floatval($_POST["dochod"]);
    $wynik = round(obliczPIT($dochod), 2);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kalkulator PIT</title>
</head>
<body>

<h2>Kalkulator PIT</h2>

<form method="post">
    Dochód roczny brutto:<br>
    <input type="number" name="dochod" step="0.01" required value="<?php echo $dochod; ?>">
    <br><br>
    <input type="submit" value="Oblicz">
</form>

<?php
if ($wynik !== "") {
    echo "<h3>Podatek do zapłaty: " . $wynik . " zł</h3>";
}
?>

</body>
</html>