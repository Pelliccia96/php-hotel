<?php

$hotels = [

    [
        'name' => 'Hotel Belvedere',
        'description' => 'Hotel Belvedere Descrizione',
        'parking' => true,
        'vote' => 4,
        'distance_to_center' => 10.4
    ],
    [
        'name' => 'Hotel Futuro',
        'description' => 'Hotel Futuro Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 2
    ],
    [
        'name' => 'Hotel Rivamare',
        'description' => 'Hotel Rivamare Descrizione',
        'parking' => false,
        'vote' => 1,
        'distance_to_center' => 1
    ],
    [
        'name' => 'Hotel Bellavista',
        'description' => 'Hotel Bellavista Descrizione',
        'parking' => false,
        'vote' => 5,
        'distance_to_center' => 5.5
    ],
    [
        'name' => 'Hotel Milano',
        'description' => 'Hotel Milano Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 50
    ],

];

$hasFilters = isset($_GET["parking"]) || isset($_GET["vote"]);

if ($hasFilters) {
    if ($_GET["parking"] === "si") {
        $_GET["parking"] = true;
    } elseif ($_GET["parking"] === "no") {
        $_GET["parking"] = "false";
    }
    
    $filteredHotels = false;
    foreach ($hotels as $hotel) {
        $mustPush = true;
        if (isset($_GET["parking"]) && !str_contains(strtolower($hotel["parking"]), strtolower($_GET["parking"]))) {
            $mustPush = false;
        }
        if (isset($_GET["vote"]) && $hotel["vote"] < $_GET["vote"]) {
            $mustPush = false;
        }
        if ($mustPush) {
            $filteredHotels[] = $hotel;
        }
    }
} else {

    $filteredHotels = $hotels;
}

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php-hotel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-dark">
    <!-- Barra di ricerca Hotel -->
    <div class="container text-white">
        <div class="mt-3">
            <h1 class="pt-3 text-center text-primary">PHP-HOTEL</h1>
        </div>
        <form action="" method="GET" class="my-5 border p-5">
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label class="form-label">Desideri cercare l'hotel con parcheggio? Digita "si" oppure "no"</label>
                        <input type="text" class="form-control" name="parking" value="<?php echo $_GET["parking"] ?? '' ?>">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label class="form-label">Inserire le stelle dell'hotel desiderato</label>
                        <input type="number" class="form-control" name="vote" value="<?php echo $_GET["vote"] ?? '' ?>">
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button class="btn btn-primary me-2">Cerca</button>
                <a class="btn btn-primary ms-2" href="index.php">Annulla</a>
            </div>
        </form>
    </div>
    <!-- Lista Hotels -->
    <div class="container">
        <table class="table text-white">
            <thead>
                <tr>
                    <th>Hotels</th>
                    <th>Descrizione</th>
                    <th>Parcheggio</th>
                    <th>Voto</th>
                    <th>Distanza dal Centro</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (($filteredHotels) !== false) foreach ($filteredHotels as $hotel) {
                ?>
                    <tr>
                        <td><?php echo $hotel["name"] ?></td>
                        <td><?php echo $hotel["description"] ?></td>
                        <td><?php if ($hotel["parking"] === true) {
                                echo "Disponibile";
                            } else {
                                echo "Non Disponibile";
                            }  ?></td>
                        <td><?php echo $hotel["vote"] . " &#9733;" ?></td>
                        <td><?php echo $hotel["distance_to_center"] . " Km" ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
