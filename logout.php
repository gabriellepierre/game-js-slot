<?php

  // Starts session
    session_start();

  // Destroys session
  session_destroy();

  // Redirects to index.php
  header('Location: index.php');
?>