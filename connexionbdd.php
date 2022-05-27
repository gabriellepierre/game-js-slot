<?php
  try
    {
      $bdd=new PDO('mysql:host=localhost:3306;charset=utf8;dbname=banditmanchot','root','');
      array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    }
    catch(Exception $e)
    {
      die('Erreur : ' . $e->getMessage());
    }
?>
