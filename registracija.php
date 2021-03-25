<?php
include_once('glava.php');

function username_exists($username)
{
  global $conn;
  $username = mysqli_real_escape_string($conn, $username);
  $query = "SELECT id, username, password, name, lastname, email FROM users WHERE username='$username'";
  $res = $conn->query($query);
  return mysqli_num_rows($res) > 0;
}

function email_exists($email)
{
  global $conn;
  $email = mysqli_real_escape_string($conn, $email);
  $query = "SELECT id, username, password, name, lastname, email FROM users WHERE email='$email'";
  $res = $conn->query($query);
  return mysqli_num_rows($res) > 0;
}

function register_user($username, $password, $name, $surname, $email)
{
  global $conn;
  $username = mysqli_real_escape_string($conn, $username);
  $password = mysqli_real_escape_string($conn, $password);
  $name = mysqli_real_escape_string($conn, $name);
  $surname = mysqli_real_escape_string($conn, $surname);
  $email = mysqli_real_escape_string($conn, $email);
  $pass = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
  $query = "INSERT INTO users (username, password , name , lastname, email) VALUES ('$username', '$pass', '$name', '$surname', '$email');";
  if ($conn->query($query)) {
    return true;
  } else {
    echo mysqli_error($conn);
    return false;
  }
}

$error = "";
if (!empty($_POST["password"]) && $_POST["password"] != "") {
  if (isset($_POST["poslji"])) {
    if ($_POST["password"] != $_POST["repeat_password"]) {
      $error = "Gesli se ne ujemata.";
    } else if (username_exists($_POST["username"])) {
      $error = "Uporabniško ime je že zasedeno.";
    } else if (email_exists($_POST["email"])) {
      $error = "Račun s tem e-mailom že obstaja.";
    } else if (!preg_match("#[0-9]+#", $_POST["password"])) {
      $error = "Geslo mora vsebovati vsaj 1 številko!" . "<br>";
    } else if (!preg_match("#[A-Z]+#", $_POST["password"])) {
      $error = "Geslo mora vsebovati vsaj 1 veliko začetnico!" . "<br>";
    } else if (!preg_match("#[a-z]+#", $_POST["password"])) {
      $error = "Geslo mora vsebovati vsaj 1 malo črko!" . "<br>";
    } else if (register_user($_POST["username"], $_POST["password"], $_POST["name"], $_POST["surname"], $_POST["email"])) {
      header("Location: prijava.php");
      die();
    } else {
      $error = "Prišlo je do napake med registracijo uporabnika.";
    }
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

  <title>Registracija</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" <!-- Custom styles for this template -->
  <link href="prijava.css" rel="stylesheet">
</head>

<body class="text-center">
  <form action="registracija.php" method="POST" class="form-signin">
    <br><br>
    <h1 class="h3 mb-3 font-weight-normal">Registracija</h1>

    <label for="inputIme" class="sr-only">Ime</label>
    <input type="text" name="name" id="inputIme" class="form-control" placeholder="Ime" required autofocus>

    <label for="inputPriimek" class="sr-only">Priimek</label>
    <input type="text" id="inputPriimek" name="surname" class="form-control" placeholder="Priimek" required autofocus>

    <label for="inputEmail" class="sr-only">E-mail naslov</label>
    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email naslov" required autofocus>

    <label for="inputUsername" class="sr-only">Uporabniško ime</label>
    <input type="text" name="username" id="inputUsername" class="form-control" placeholder="Uporabniško ime" required autofocus>

    <label for="inputPassword" class="sr-only">Geslo</label>
    <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Geslo" minlength="8" required>

    <label for="reinputPassword" class="sr-only">Ponovi geslo</label>
    <input type="password" name="repeat_password" id="reinputPassword" class="form-control" placeholder="Ponovi geslo" minlength="8" required>
    <label style="color:red;"><?php echo $error; ?></label>

    <br>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="poslji">Registriraj</button>
    <br>
    <div>
      <label>
        <p>Že imate račun?</p>
        <a href="/prijava.php" class="prijava">
          <p>Prijava</p>
        </a>
      </label>
    </div>


  </form>

</body>

</html>