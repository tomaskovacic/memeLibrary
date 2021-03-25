<?php
include_once('glava.php');


function publish($title, $desc)
{
    global $conn;
    $title = mysqli_real_escape_string($conn, $title);
    $desc = mysqli_real_escape_string($conn, $desc);
    $user_id = $_SESSION["USER_ID"];

    $filetemp = $_FILES['image']['tmp_name'];
    $filename = $_FILES['image']['name'];
    $filepath = "upload/".$filename;
    move_uploaded_file($filetemp, $filepath);
    $filepath = mysqli_real_escape_string($conn, $filepath);
    $datetime = date_create()->format('Y-m-d H:i:s');

    $query = "INSERT INTO memes (title, description, image, IDfk, datePosted)
				VALUES('$title', '$desc', '$filepath', '$user_id', '$datetime');";
    if ($conn->query($query)) {
        return true;
    } else {
        return false;
    }
}

$error = "";
if (isset($_POST["poslji"])) {
    if (publish($_POST["title"], $_POST["description"])) {
        header("Location: meme.php?page=1");
        die();
    } else {
        $error = "Prišlo je do napake pri objavi mema.";
    }
}


?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Objavi Meme</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" <!-- Custom styles for this template -->
    <link href="prijava.css" rel="stylesheet">
</head>

<body>
    <form action="objava.php" method="POST" enctype="multipart/form-data" style="width:50%;">

        <h1 class="h3 mb-3 font-weight-normal">Objavi meme</h1>

        <label>Naslov</label>
        <input type="text" name="title" id="inputNaslov" class="form-control" required autofocus>

        <label>Opis</label>
        <textarea class="form-control" rows="10" cols="50" name="description"></textarea>

        <br>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Naložite</span>
            </div>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="inputGroupFile01" name="image" required>
                <label class="custom-file-label" for="inputGroupFile01">Izberite sliko</label>
            </div>
        </div>
        <label><?php echo $error; ?></label>



        <button class="btn btn-lg btn-primary btn-block" type="submit" name="poslji">Objavi</button>
    </form>

</body>

</html>