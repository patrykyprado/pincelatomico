<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head_inside.php');
include('includes/funcoes.php');
include('includes/topo_inside.php');
if(isset($_GET["id_bq"])){
	$get_bq = $_GET["id_bq"];
} else {
	$get_bq = 0;
}

$get_id_questao = $_GET["id_questao"];
$get_id_inativo = $_GET["id_inativo"];
$get_id_bq = $_GET["id_bq"];


if($get_id_questao != "" || $get_id_questao != 0){
		if($get_id_inativo ==0){
			mysql_query("UPDATE ea_questao SET inativo = 1 WHERE id_questao = $get_id_questao");
			echo "<script language=\"javascript\">
	alert('Quest�o Inativada Com Sucesso!');
	window.location.href='ea_questoes.php?id_bq=$get_id_bq'
	</script>";
		} else {
			mysql_query("UPDATE ea_questao SET inativo = 0 WHERE id_questao = $get_id_questao");
			echo "<script language=\"javascript\">
	alert('Quest�o Ativada Com Sucesso!');
	window.location.href='ea_questoes.php?id_bq=$get_id_bq'
	</script>";
		}
		
		
		
} else {
	echo "<script language=\"javascript\">
	alert('Erro: Contate o administrador do sistema!');
	window.location.href='ea_questoes.php?id_bq=$get_id_bq'
	</script>";
	
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
                              <b>Bloquear Quest&atilde;o</b>
                          </header>
                        <div class="panel-body">

                          </div>
                          <div class="panel-footer">
                              <center><a onClick="ShadowClose()" href="javascript:parent.location.reload();">FECHAR</a></center>
                          </div>
                      </section>
                 
              </div>
              </div>
              
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->



 <?php 
 include('includes/footer.php');
 ?>
  </section>
 <?php 
 include('includes/js.php');
 ?>


  </body>
</html>


    

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir o cliente/fornecedor? '))
{
location.href="apagar_forn.php?id="+id;
}
else
{
return false;
}
}

function usuario(id){
alert("o n� de usu�rio �: "+id);
}
//-->

</script>

<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">

function baixa (){
var data;
do {
    data = prompt ("DIGITE O N�MERO DO T�TULO?");

	var width = 700;
    var height = 500;
    var left = 300;
    var top = 0;
} while (data == null || data == "");
if(confirm ("DESEJA VISUALIZAR O T�TULO N�:  "+data))
{
window.open("editar_forn.php?id="+data,'_blank');
}
else
{
return;
}

}
</SCRIPT>

<script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
function enviar(valor){
//nome = id do campo que ir� receber o valor, esse campo deve da pagina que gerou o popup
//opener � elemento que faz a vincula��o/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor').value = valor;
}
function enviar2(valor){
//nome = id do campo que ir� receber o valor, esse campo deve da pagina que gerou o popup
//opener � elemento que faz a vincula��o/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor2').value = valor;
this.close();
}
</script>
    </script>
    
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
     $(document).ready(function() {
   
   $("#button").click(function() {
      var theURL = $("#select").val();
window.location = theURL;
});
       
});
     </script>
     
<script>
function validarAction(frm){
   frm.action = frm.tipo.value;
   frm.submit();
}
  </script> 