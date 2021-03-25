<?php
include_once('glava.php');

function edit_meme($title, $desc)
{
    global $conn;
    $title = mysqli_real_escape_string($conn, $title);
    $desc = mysqli_real_escape_string($conn, $desc);

    $filetemp = $_FILES['image']['tmp_name'];
    $filename = $_FILES['image']['name'];
    $filepath = "upload/" . $filename;
    move_uploaded_file($filetemp, $filepath);
    $datetime = date_create()->format('Y-m-d H:i:s');

    $filepath = mysqli_real_escape_string($conn, $filepath);

    if ($filepath=="upload/") {
        $meme_id = (int)$_GET["id"];
        $meme_id = mysqli_real_escape_string($conn, $meme_id);
        echo $meme_id;
        $query = "UPDATE memes SET title='$title', description='$desc', dateEdited='$datetime' WHERE id=$meme_id";
        if ($conn->query($query)) {
            return true;
        } else {
            return false;
        }
    } else {
        $meme_id = (int)$_GET["id"];
        $meme_id = mysqli_real_escape_string($conn, $meme_id);
        $query = "UPDATE memes SET title='$title', description='$desc', image='$filepath', dateEdited='$datetime' WHERE id=$meme_id";
        if ($conn->query($query)) {
            return true;
        } else {
            return false;
        }
    }
}

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

$meme_id = $_GET["id"];
$meme = get_meme($meme_id);

if ($meme == null) {
    echo "Meme ne obstaja.";
    die();
}

$error = "";
if (isset($_POST["uredi"])) {
    if (edit_meme($_POST["title"], $_POST["desc"])) {
        header("Location:kolekcija.php");
        die();
    } else {
        $error = "Prišlo je do napake pri urejanju mema.";
    }
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
    <title>Uredi</title>
</head>

<body>
    </br> </br>
    <form action="uredi.php?id=<?php echo $meme->id ?>" method="POST" enctype="multipart/form-data" style="width:50%;margin: 0 auto; ">

        <h1 class="h3 mb-3 font-weight-normal">Uredi meme</h1>
        <label>Naslov</label>
        <input type="text" name="title" id="inputNaslov" class="form-control" value="<?php echo $meme->title; ?>" required autofocus>
        <label>Opis</label>
        <textarea class="form-control" rows="10" cols="50" name="desc"><?php echo $meme->description; ?></textarea>
        <br>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Naložite</span>
            </div>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="inputGroupFile01" name="image">
                <label class="custom-file-label" for="inputGroupFile01">Izberite sliko</label>
            </div>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="uredi">Shrani</button>
        <br>
    </form>
    <div style="  text-align: center;">
        <button style="width:10%;" class="btn btn-danger" onclick="history.go(-1);">Prekliči </button>
    </div>

    <label><?php echo $error; ?></label>

</body>

<footer class="text-muted">
    <div class="container">
        <p class="float-left">
            <a>Solve-x</a>
    </div>
</footer>

</html>