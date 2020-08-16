<?php
session_start();
if (!$_SESSION['acesso']){
  header ('Location: http://localhost/projetos/DesafioPHPSQL/login.php');
}

include 'sql.php';
include 'header.php';

$id = $_GET['id'];
$extensoesValidas = ['image/jpeg','image/png', 'image/jpg'];
$salvo=false;
$msg='';

$query = $db->prepare ("SELECT *
                        FROM produtos
                        WHERE id=:id;");
$query->execute([':id' => $id]);

$produtos=$query->fetchAll(PDO::FETCH_ASSOC);

if ($_POST){
  if ($_FILES['foto']['name'] != "") {//verifica se tem files
    if ($_FILES['foto']['error'] == 0) {//verifica se não tem erro
      if (array_search($_FILES['foto']['type'], $extensoesValidas) == false) { //valida as extensoes
        $msg="Extensão do arquivo inválida!<br>";
        }
        else {
          move_uploaded_file($_FILES['foto']['tmp_name'],'../DesafioPHPSQL/Imagens/'.$id.'.jpg');
          $query = $db-> prepare("UPDATE produtos SET nome = :nome,
                                                      descricao = :descricao,
                                                      preco = :preco,
                                                      foto = :foto
                                                  WHERE id = :id;");
          $query->execute([':id' => $id,
                           ':nome'=>$_POST['nomeProduto'],
                           ':descricao'=>$_POST['descricao'],
                           ':preco'=>$_POST['preco'],
                           ':foto'=>$_FILES['foto']['name']]);
          header ('Location: http://localhost/projetos/DesafioPHPSQL/indexProdutos.php');
        }
      }
      else {
        $msg="Erro no envio do arquivo!";
      }
    }
     else {
      $query = $db-> prepare("UPDATE produtos SET nome = :nome,
                                                  descricao = :descricao,
                                                  preco = :preco
                                              WHERE id = :id;");
      $query->execute([':id' => $id,
                       ':nome'=>$_POST['nomeProduto'],
                       ':descricao'=>$_POST['descricao'],
                       ':preco'=>$_POST['preco']]);
      header ('Location: http://localhost/projetos/DesafioPHPSQL/indexProdutos.php');
      }
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Editar Produto</title>
</head>
  <body>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-3"></div>
        <div class="col-6 border border-success rounded">
          <?php foreach ($produtos as $produto): ?>
          <form method="post" enctype="multipart/form-data">
            <div class="form-group">
              <br>
              <h5><label class="font-weight-bold" for="nomeProduto">Nome do Produto</label></h5>
              <input type="text" class="form-control" name="nomeProduto" value="<?= $produto['NOME']?>" required>
            </div>

            <div class="form-group">
              <h5><label class="font-weight-bold" for="descricao">Descrição</label></h5>
              <input type="text" class="form-control" name="descricao" value="<?= $produto['DESCRICAO']?>">
            </div>

            <div class="form-group">
              <h5><label class="font-weight-bold" for="preco">Preço</label></h5>
              <input type="number" class="form-control" name="preco" min="0" step=".01" value="<?= $produto['PRECO']?>">
            </div>

            <div class="form-group">
              <h5><label class="font-weight-bold" for="foto">Foto</label></h5>
              <img src="../DesafioPHPSQL/Imagens/<?=$id;?>.jpg" alt="" width="50%" class="rounded mx-auto d-block">
              <input type="file" accept="image/jpeg, image/png, image/jpg" class="form-control-file" name="foto"><br>
                <?php echo $msg;?>
            </div>

              <input type="hidden" name="id" value="<?= $id ?>">
              <input class="btn btn-outline-success float-right mb-2" type="submit" name="button" value="Atualizar Produto">
          </form>
          <?php endforeach; ?>
        </div>
          <div class="col-3"></div>
      </div>
    </div>
  </body>
</html>
