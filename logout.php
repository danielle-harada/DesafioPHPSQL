<?php
  session_start();

  session_destroy();

  header ('Location: http://localhost/projetos/DesafioPHPSQL/login.php');

 ?>
