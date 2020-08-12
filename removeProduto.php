<?php
include 'sql.php';

$id = $_POST['id'];

$query = $db-> prepare("DELETE FROM produtos WHERE id = :id;");
$query -> execute([':id'=>$id]);

header('Location: http://localhost/projetos/DesafioPHPSQL/indexProdutos.php');
 ?>
