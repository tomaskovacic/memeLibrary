<?php
session_start(); //Naloži sejo
session_unset(); //Odstrani sejne spremenljivke
session_destroy(); //Uniči sejo
header("Location: meme.php?page=1"); //Preusmeri na index.php
?>