﻿<!DOCTYPE html>
<html lang="en">
<?php
include('../includes/head_ead.php');
include('../includes/restricao.php');
include('../includes/topo_inside_ead.php');
include('../includes/conectar.php');
include('../includes/funcoes.php');
$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '". $_SESSION["coddisc"]."' AND anograde LIKE '". $_SESSION["anograde"]."'");
$dados_disc = mysql_fetch_array($sql_disc);
$nome_disciplina = ($dados_disc["disciplina"]);
$get_acao = 1;//$_GET["acao"];
$get_id_estudo = $_GET["id"];


if($get_acao == 1){
	$nome_acao = "Enviar arquivo - ";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
//PEGA DADOS DO ESTUDO
$sql_estudo = mysql_query("SELECT * FROM ea_estudo_dirigido WHERE id_estudo LIKE '$get_id_estudo'");
$dados_estudo = mysql_fetch_array($sql_estudo);
$estudo_max_tentativa = $dados_estudo["tentativas"];

//PEGA ENVIOS DO ALUNO
$sql_envios = mysql_query("SELECT * FROM ea_estudo_envio WHERE id_estudo LIKE '$get_id_estudo' AND matricula LIKE '$user_usuario'");
$contar_envios = mysql_num_rows($sql_envios);

if($contar_envios >= $estudo_max_tentativa){
	echo "<script language=\"javascript\">
	alert('Você já realizou o máximo de envios de trabalho permitidos.');
	window.close();
	</script>
	";
	return;
		
}


// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = '../../trabalhos/';


// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * $config_max_arquivo; // 20Mb

// Array com as extensões permitidas
$_UP['extensoes'] = array("jpg","png","gif","doc","docx","ppt","pptx","xls","csv","xlsx","pdf","rtf","odt","txt", "ods");

// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'Não houve erro';
$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
if ($_FILES['arquivo']['error'] != 0) {
die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']]);
exit; // Para a execução do script
}

// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar

// Faz a verificação da extensão do arquivo
$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
if (array_search($extensao, $_UP['extensoes']) === false) {
echo "Por favor, envie arquivos com as extensões permitidas";
}

// Faz a verificação do tamanho do arquivo
else if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
echo "O arquivo enviado é muito grande, envie arquivos de até 20Mb.";
}

// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
else {
	$tentativa = $contar_envios +1;
	// Primeiro verifica se deve trocar o nome do arquivo
	$nome_final = $get_id_estudo."_".$_SESSION["MM_Username"]."_".$tentativa.".".$extensao;
}


// Depois verifica se é possível mover o arquivo para a pasta escolhida
if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
	$datahoraatual = date("Y-m-d H:i:s", strtotime("-2 hour"));
	mysql_query("INSERT INTO `ea_estudo_envio` (`id_envio`, `id_estudo`, `matricula`, `data_envio`, `arquivo`, `tentativa`) VALUES (NULL, '$get_id_estudo', '$user_usuario', '$datahoraatual', '$nome_final', '$tentativa');");
	echo "<script language=\"javascript\">
	alert('Arquivo enviado com sucesso! Em breve será avaliado pelo tutor.');
	window.parent.frames['frame_central_ead'].location.reload();
	window.parent.Shadowbox.close();
	</script>";
} else {
// Não foi possível fazer o upload, provavelmente a pasta está incorreta
echo "<script language=\"javascript\">
	alert('Erro: Arquivo não enviado! Tente novamente.');
	</script>";
}

}
}

?>

  <body>

  <section id="container" class="sidebar-closed">


<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-md-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <b>Envio de Trabalho</b>
                          </header>
                        <div class="panel-body">
<form method="post" action="#" enctype="multipart/form-data">
<label>Escolha o Arquivo:</label>
<input type="file" name="arquivo" /><br><br>
<input type="submit" value="Enviar" />
</form>
                          </div>
                          <div class="panel-footer">
                          </div>
                      </section>
                 
              </div>
              </div>
              
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->



 <?php 
 include('../includes/footer.php');
 ?>
  </section>
 <?php 
 include('../includes/js_ead.php');
 ?>


  </body>
</html>
