<?php
include_once('glava.php');

function get_meme($id)
{
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $query = "SELECT memes.*, users.username FROM memes LEFT JOIN users ON users.id = memes.IDfk WHERE memes.id = $id;";
    $res = $conn->query($query);
    if ($obj = $res->fetch_object()) {
        return $obj;
    }
    return null;
}

if (!isset($_GET["id"])) {
    echo "Manjkajoči parametri.";
    die();
}

$id = $_GET["id"];
$meme = get_meme($id);

if ($meme == null) {
    echo "Meme ne obstaja.";
    die();
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link href="meme.css" rel="stylesheet">

    <title>Ogled</title>

</head>

<body>
    <main role="main">
        <div style="width:800px; margin:0 auto;" class="album py-5 bg-light">
            <div class="container">
                <div>
                    <div>
                        <div class="card mb-10 shadow-sm">
                        <?php echo "<img class='card-img-top' width='400' height='500' src='" . $meme->image . "' />";
                ?>                            <div class="card-body">
                                <b class="card-text"><?php echo $meme->title; ?></b>
                                <p class="card-text"><?php echo $meme->description; ?></p>
                                <small class="text-muted">Objavil: <?php echo $meme->username; ?></small>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


    </main>
    <div style="  text-align: center;">
        <button style="width:10%;" class="btn btn-secondary" onclick="history.go(-1);">Nazaj </button>
    </div>
</body>





<footer class="text-muted">
    <div class="container">
        <p class="float-left">
            <a>Solve-x</a>
    </div>
</footer>

</html>