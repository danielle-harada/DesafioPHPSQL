<?php
session_start();
unset($_SESSION['acesso']);

include 'sql.php';


$query = $db-> prepare ("SELECT *
                          FROM usuarios;");
$query -> execute();
$acessos = $query->fetchAll(PDO::FETCH_ASSOC);

if ($_POST) {
  foreach ($acessos as $acesso) {
    if ($_POST['emailLogin'] == $acesso['EMAIL']){
      if (password_verify($_POST['senhaLogin'], $acesso['SENHA'])){
        $_SESSION['acesso']=$acesso['NOME'];
        header('Location: http://localhost/projetos/DesafioPHPSQL/createUsuario.php');
        // unset($_SESSION['acesso']);
      }
    }
      }
  $erro = 'E-mail e/ou senha não encontrados';
}

// var_dump($acesso);
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Login</title>
   </head>
   <body>
     <?php if(isset($erro)): ?>
       <p><?= $erro ?></p>
    <?php endif; ?>

     <form class="" method="post">
       <label for="emailLogin">E-mail do Usuário</label><br>
        <input type="email" name="emailLogin" value="" required <?php if (isset($_COOKIE['emailUsuario'])) { echo "value='$_COOKIE[emailUsuario]'"; } ?>><br>
        <label for="senhaLogin">Senha</label><br>
        <input type="password" name="senhaLogin" value="" required <?php if (isset($_COOKIE['senhaUsuario'])) { echo "value='$_COOKIE[senhaUsuario]'"; } ?>><br>
       <button type="submit" name="button">Entrar</button>
     </form>
<br>

   </body>
 </html>
