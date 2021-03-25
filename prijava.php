<?php
include_once('glava.php');

function validate_login($username, $password)
{
  global $conn;
  $username = mysqli_real_escape_string($conn, $username);
  $password = mysqli_real_escape_string($conn, $password);
  $query = "SELECT id, username, password, name, lastname, email FROM users WHERE username='$username'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($password, $row["password"])) {
        $user_id =  $row['id'];
        $_SESSION["USER_ID"] = $user_id;
      } else {
        return -1;
      }
    }
  }

  $res = $conn->query($query);
  if ($user_obj = $res->fetch_object()) {
    return $user_obj->id;
  }
  return -1;
}
$error = "";

if (isset($_POST["poslji"])) {
  //Preveri prijavne podatke
  if (($user_id = validate_login($_POST["username"], $_POST["password"])) >= 0) {
    $_SESSION['loggedin'] = true;
    header("Location: meme.php?page=1");
    die();
  } else {
    $error = "Prijava ni uspela.";
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

  <title>Prijava</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" <!-- Custom styles for this template -->
  <link href="prijava.css" rel="stylesheet">
</head>

<body class="text-center">
  <form action="prijava.php" method="POST" class="form-signin">
    <h1 class="h3 mb-3 font-weight-normal">Prijava</h1>
    <label for="inputUsername" class="sr-only">Uporabniško ime</label>
    <input type="text" name="username" id="inputUsername" class="form-control" placeholder="Uporabniško ime" required autofocus>
    <label for="inputPassword" class="sr-only">Geslo</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Geslo" required>
    <label style="color:red;"><?php echo $error; ?></label>


    <button class="btn btn-lg btn-primary btn-block" type="submit" name="poslji">Vpis</button>
    <br>
    <div>
      <label>
        <p>Še nimate računa?</p>
        <a href="/registracija.php" class="registracija">
          <p>Registracija</p>
        </a>
      </label>
    </div>
  </form>

</body>

</html>