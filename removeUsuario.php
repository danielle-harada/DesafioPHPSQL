<?php
include 'sql.php';

$id = $_GET['id'];

$query = $db-> prepare("DELETE FROM usuarios WHERE id = :id;");
$query -> execute([':id'=>$id]);

header('Location: http://localhost/projetos/DesafioPHPSQL/createUsuario.php');
 ?>
