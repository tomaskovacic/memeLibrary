<?php
include_once('glava.php');

$error = "";
if (isset($_POST["brisi"])) {
    if (isset($_POST["meme_id"])) {
        $meme_id = mysqli_real_escape_string($conn,$_POST["meme_id"]);
        $brisiQuery = "DELETE FROM memes WHERE id=$meme_id";
        if ($conn->query($brisiQuery) == TRUE) {
            header("Location: kolekcija.php");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}


function get_memes()
{
    global $conn;
    $user_id = $_SESSION["USER_ID"];
    $query = "SELECT id, title, description, image FROM memes WHERE IDfk=$user_id ORDER BY id DESC";
    $res = $conn->query($query);
    $memes = array();
    while ($meme = $res->fetch_object()) {
        array_push($memes, $meme);
    }
    return $memes;
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

    <title>Kolekcija</title>

</head>

<body>


    <main role="main">
        <div class="album py-5 bg-light">
            <div class="container">
                <h1 class="display-4">Moja kolekcija</h1></br>
                <div class="row">

                    <?php
                    $memes = get_memes();
                    //Izpiši memes
                    foreach ($memes as $meme) {
                    ?>
                        <div class="col-md-4">


                            <div class="card mb-4 shadow-sm">
                                <?php echo "<img class='card-img-top' width='300' height='300' src='" . $meme->image . "' />";
                                ?> <div class="card-body">
                                    <b class="card-text"><?php echo $meme->title; ?></b>
                                    <p class="card-text"><?php echo $meme->description; ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <form id="kolekcija.php" method="POST">
                                                <button type="button" name="edit" class="btn btn-sm btn-outline-dark" onclick="window.location.href='/uredi.php?id=<?php echo $meme->id; ?>'">Uredi</button>
                                                <button type="submit" name="brisi" class="btn btn-sm btn-danger">Zbriši</button>
                                                <input type="hidden" name="meme_id" value="<?php echo $meme->id; ?>" />
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php
                    }
                    ?>



    </main>

    <footer class="text-muted">
        <div class="container">
            <p class="float-left">
                <a>Solve-x</a>
        </div>
    </footer>

</body>

</html>