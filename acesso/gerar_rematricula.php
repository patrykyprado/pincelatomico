<head>
<!-- CSS DE IMPRESS�O -->
    <link href="css/imprimir.css" media="print" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" media="screen" rel="stylesheet">
    
</head>
<body>
 <?php 
 include('includes/funcoes.php');
 ?>
<?php
include('includes/conectar.php');
$id_turma = $_GET["id_turma"];
?>
<div class="filtro"><center><a href="javascript:window.print();">[IMPRIMIR]</a></center></div>
<?php
$garantia_contratual = $_GET["garantia"];
if(isset($_GET["matricula"])){
	$comp_sql_aluno = " AND alu.codigo = ".$_GET["matricula"]."";
} else {
	$comp_sql_aluno = "";
}

$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_cod_turma = $dados_turma["cod_turma"];
$turma_nivel = format_curso($dados_turma["nivel"]);
$turma_curso = format_curso($dados_turma["curso"]);
$turma_modulo = $dados_turma["modulo"];
$turma_unidade = $dados_turma["unidade"];
$turma_polo = $dados_turma["polo"];
$turma_turno = $dados_turma["turno"];
$turma_grupo = $dados_turma["grupo"];
$turma_anograde = $dados_turma["anograde"];
$turma_tipo_etapa = $dados_turma["tipo_etapa"];
$turma_empresa = $dados_turma["empresa"];

if($turma_modulo == 1){
	$modulo_exib = "I"; 	
}
if($turma_modulo == 2){
	$modulo_exib = "II"; 	
}
if($turma_modulo == 3){
	$modulo_exib = "III"; 
}

if(strtoupper(trim($turma_unidade)) == "SERRA"){
	$cc2 = "LA";
}
if(strtoupper(trim($turma_unidade)) == "CARIACICA"){
	$cc2 = "CA";
}
if(strtoupper(trim($turma_unidade)) == "GUARAPARI"){
	$cc2 = "GA";
}

$sql_empresa = mysql_query("SELECT razao, uf, cidade, endereco, bairro, cep, cnpj FROM cc2 WHERE id_filial LIKE '$cc2'");
$dados_empresa = mysql_fetch_array($sql_empresa);
$empresa_nome = $dados_empresa["razao"];
$empresa_cnpj = $dados_empresa["cnpj"];
$empresa_endereco = $dados_empresa["endereco"]." - ".$dados_empresa["bairro"].", ".$dados_empresa["cidade"]." - ".$dados_empresa["uf"].", CEP: ".$dados_empresa["cep"];
?>


<?
	$sql_alunos = mysql_query("SELECT DISTINCT alu.*
FROM ced_turma_aluno cta 
INNER JOIN alunos alu
ON cta.matricula = alu.codigo
WHERE cta.id_turma = $id_turma $comp_sql_aluno ORDER BY alu.nome
");
	$contador = 1;
	if(mysql_num_rows($sql_alunos)==0){
		"";
	} else {
		$contador_max = mysql_num_rows($sql_alunos);
		while($dados_aluno_turma = mysql_fetch_array($sql_alunos)){
			$aluno_matricula = $dados_aluno_turma["codigo"];
			$aluno_nome = strtoupper($dados_aluno_turma["nome"]);
			$aluno_responsavel = strtoupper($dados_aluno_turma["nome_fin"]);
			if($contador < $contador_max){
				$quebra = "<p class='break'>&nbsp</p>";
			} else {
				$quebra = "";
			}
			$contador +=1;
			//DADOS DO FIADOR
			$fiador_nome = strtoupper($dados_aluno_turma["nome_fia"]);
			$fiador_rg = strtoupper($dados_aluno_turma["rg_fia"]);
			$fiador_email = ($dados_aluno_turma["email_fia"]);
			$fiador_cpf = strtoupper($dados_aluno_turma["cpf_fia"]);
			$fiador_cep = strtoupper($dados_aluno_turma["cep_fia"]);
			$fiador_uf = strtoupper($dados_aluno_turma["uf_fia"]);
			$fiador_cidade = strtoupper($dados_aluno_turma["cidade_fia"]);
			$fiador_bairro = strtoupper($dados_aluno_turma["bairro_fia"]);
			$fiador_endereco = strtoupper($dados_aluno_turma["end_fia"]);
			$fiador_nascimento = strtoupper($dados_aluno_turma["nasc_fia"]);
			$fiador_nacionalidade = strtoupper($dados_aluno_turma["nacio_fia"]);
			$fiador_tel = strtoupper($dados_aluno_turma["tel_fia"]);
			$conjuge_nome = strtoupper($dados_aluno_turma["nome_conj"]);
			$conjuge_cpf = strtoupper($dados_aluno_turma["cpf_conj"]);
			$conjuge_rg = strtoupper($dados_aluno_turma["rg_conj"]);
			$conjuge_nascimento = strtoupper($dados_aluno_turma["nasc_conj"]);
			$conjuge_nacio = strtoupper($dados_aluno_turma["nacio_conj"]);
			//GERA OS BOLETOS DE REMATR�CULA
			$sql_financeiro = mysql_query("SELECT matricula FROM ced_aluno_rematriculas WHERE id_turma = $id_turma AND matricula LIKE '$aluno_matricula'");
			if(mysql_num_rows($sql_financeiro)==0){
				// CENTRO DE CUSTO EMPRESA 1
				$cc1 = $turma_empresa;
				//CENTRO DE CUSTO FILIAL
				$sql_cc2 = mysql_query("SELECT id_filial FROM cc2 WHERE nome_filial LIKE '%CEDTEC%' AND nome_filial LIKE '%$turma_unidade%' AND niveltxt LIKE '%geral%'");
				$dados_cc2 = mysql_fetch_array($sql_cc2);
				$cc2 = $dados_cc2["id_filial"];
				//CENTRO DE CUSTO 3
				$cc3 = 21;
				// CENTRO DE CUSTO 4
				$sql_cc4 = mysql_query("SELECT * FROM cc4 WHERE cc4 LIKE '$cc3%' AND nome_cc4 LIKE '%$turma_nivel%'  LIMIT 1");
				$c4dados = mysql_fetch_array($sql_cc4);
				$cc4 = $c4dados["cc4"];
				// CENTRO DE CUSTO DO CURSO 5
				$cc5    = mysql_query("SELECT * FROM cc5 WHERE id_cc5 LIKE '$cc4' AND nome_cc5 LIKE '%$turma_curso%'");
				$cdados = mysql_fetch_array($cc5);
				$cc5final = $cdados["cc5"];
				
				// CENTRO DE CUSTO FINAL
				$c_custo = $cc1.$cc2.$cc3.$cc4.$cc5final;
				
				//PEGA DADOS DO CURSO
				$sql_curso_rematricula = mysql_query("SELECT * FROM cursos_rematricula WHERE (nivel LIKE '%$turma_nivel%' AND curso LIKE '%$turma_curso%' AND modulo = '$turma_modulo' AND unidade LIKE '%$turma_unidade%' AND turno LIKE '%$turma_turno%') LIMIT 1");
				if(mysql_num_rows($sql_curso_rematricula)==0){
					$sql_curso_rematricula = mysql_query("SELECT * FROM cursos_rematricula WHERE (nivel LIKE '%$turma_nivel%' AND curso LIKE '%$turma_curso%' AND modulo = 0 AND unidade LIKE '%$turma_unidade%' AND turno LIKE '%$turma_turno%') LIMIT 1");
				}
				
				
				//INSERE O DADO DO ALUNO NA TABELA DE REMATRICULA
				mysql_query("INSERT INTO ced_aluno_rematriculas (id_rematricula, matricula, id_turma) VALUES(NULL, '$aluno_matricula', '$id_turma');");
				
				
				while($dados_rematricula = mysql_fetch_array($sql_curso_rematricula)) {
				$parcela = $dados_rematricula["qtd_parcelas"];
				$vencimento = $dados_rematricula["inicio_vencimento"];
				$vencimento2 = $dados_rematricula["inicio_vencimento"];
				$valor = $dados_rematricula["valor_parcela"];
				$desconto = $dados_rematricula["desconto"];
				$conta = $dados_rematricula["conta"];
				$id_curso = '201501-'.$dados_rematricula["id_curso"];
				$parcelas		= 1;
				$datahoje = date("Y-m-d");
					while($parcelas <= $parcela){
						if(@mysql_query("INSERT INTO titulos(cliente_fornecedor, documento_fiscal, dt_doc, descricao, vencimento, valor, desconto, parcela, tipo, c_custo,valor_pagto,conta,status) VALUES('$aluno_matricula','$id_curso', '$datahoje', 'Boleto Aluno','$vencimento','$valor','$desconto','$parcelas','2','$c_custo','0','$conta','1')")) {			
								if(mysql_affected_rows() == 1){
									$parcelas += 1;
						//CALCULA SALDO AP�S MATR�CULA NOVA
										for ($i = 1; $i <= $parcelas; $i++)
											$vencimento = date("Y-m-d", strtotime(" " . $i-1 . " Month", strtotime($vencimento2)));
											}	
								} else {
									if(mysql_errno() == 1062) {
										echo $erros[mysql_errno()];
										exit;
								} else {	
										echo "";
										exit;
									}
								@mysql_close();
								}
										}
										}
				
				
				
			}//fecha o if
			
			//pega o boleto gerado
			$sql_boleto = mysql_query("SELECT * FROM titulos WHERE cliente_fornecedor = '$aluno_matricula' AND parcela = 1 AND documento_fiscal LIKE '%201501-%' LIMIT 1");
			$dados_boleto = mysql_fetch_array($sql_boleto);
			$id_titulo = $dados_boleto["id_titulo"];
			$parcela = $dados_boleto["parcela"];
			$link = "../boleto/boleto_santander2.php?id=".$id_titulo."&p=".$parcela."&id2=".$aluno_matricula."&refreshed=no";
			echo '<div class="contrato_final">
			<div class="contrato_topo">
			<B>ADITIVO AO CONTRATO DE PRESTA��O DE SERVI�OS EDUCACIONAIS</B>
			</div>
			<div class="contrato_lateral">
			Pelo presente ADITIVO ao Contrato de Presta��o de Servi�os Educacionais Presencial e � Dist�ncia, j� firmados entre as partes e na melhor forma de direito de um lado o:
			</div>
			<div class="contrato_corpo">
			
			<p><strong>'.$empresa_nome.'</strong>, devidamente  inscrito no CNPJ sob o n�. <strong>'.$empresa_cnpj.'</strong>, com endere�o  na '.$empresa_endereco.', neste  ato, representado pelo seu Diretor Geral Corporativo e procurador, pelo Diretor  por ele nomeado, ou procurador devidamente constitu�do, doravante denominada <strong>CONTRATADA, </strong>e<strong> </strong>de outro lado, <b><u>'.$aluno_responsavel.'</u></b> como<strong> CONTRATANTE </strong>assim denominado, nos termos  da Lei e do Contrato de Presta��o de Servi�os Educacionais, assinado em  __/__/____, para Presta��o de Servi�os Educacionais ao aluno <b><u>'.$aluno_nome.'</b></u>,  mat. n� <b><u>'.$aluno_matricula.'</u></b>, devidamente qualificado no seu requerimento de matr�cula.  Tem entre si justo e acordado o que se segue: <br>
  <strong>CL�USULA PRIMEIRA</strong>: Constitui objeto deste termo aditivo  a prorroga��o da vig�ncia do Contrato de Presta��o de Servi�os Educacionais por  mais um semestre letivo do Ensino T�cnico, per�odo 2015.1 ou ano letivo 2015,  para o Ensino M�dio, ao fim do qual, o <strong>CONTRATANTE</strong> dever� renovar sua matr�cula mediante um novo TERMO ADITIVO, para que possa  realizar as disciplinas subsequentes ou ano subsequente, condicionado a  aprova��o nas disciplinas do m�dulo/ano anterior, conforme a matriz curricular  (fluxograma) e seu calend�rio, ambos definidos pela <strong>CONTRATADA</strong>.<br>
  <strong>PAR�GRAFO �NICO: </strong>A configura��o formal  da prorroga��o da vig�ncia do Contrato de Presta��o de Servi�os Educacionais dar-se-�  pela assinatura e entrega deste Termo Aditivo, por parte do <strong>CONTRATANTE</strong>, no Setor da Secretaria da <strong>CONTRATADA, </strong>bem como pelo pagamento da  primeira parcela do m�dulo/ano contratado.</p>
<p><strong>CL�USULA SEGUNDA: </strong>O presente Termo de Aditamento passa a  fazer parte integrante do Contrato de Presta��o de Servi�os Educacionais Presencial  e � Dist�ncia, permanecendo inalteradas todas as demais disposi��es nele  contidas e n�o referidas no presente aditivo.</p>
<p>E  por estarem, assim, justas e contratadas, assinam o presente em 02 (duas) vias  de igual teor e forma, juntamente com as testemunhas abaixo.</p>
<center><p>� ������������_________________, ____ de��������������������� de 20__.����������� <br>
  <strong>��� </strong> <br>
  <strong>CONTRATANTE:  __________________________________________________</strong></p>
<p><strong>CONTRATADA:  ____________________________________________________</strong><br>
  <strong>'.$empresa_nome.'</strong></p></center>
			
			</div>
			</div>
			<div class="rodape_contrato"> C�d: '.$aluno_matricula.'</div>
			<p class="break">&nbsp</p>
			';
			
			//segunda via aditivo
			echo '<div class="contrato_final">
			<div class="contrato_topo">
			<B>ADITIVO AO CONTRATO DE PRESTA��O DE SERVI�OS EDUCACIONAIS</B>
			</div>
			<div class="contrato_lateral">
			Pelo presente ADITIVO ao Contrato de Presta��o de Servi�os Educacionais Presencial e � Dist�ncia, j� firmados entre as partes e na melhor forma de direito de um lado o:
			</div>
			<div class="contrato_corpo">
			
			<p><strong>'.$empresa_nome.'</strong>, devidamente  inscrito no CNPJ sob o n�. <strong>'.$empresa_cnpj.'</strong>, com endere�o  na '.$empresa_endereco.', neste  ato, representado pelo seu Diretor Geral Corporativo e procurador, pelo Diretor  por ele nomeado, ou procurador devidamente constitu�do, doravante denominada <strong>CONTRATADA, </strong>e<strong> </strong>de outro lado, <b><u>'.$aluno_responsavel.'</u></b> como<strong> CONTRATANTE </strong>assim denominado, nos termos  da Lei e do Contrato de Presta��o de Servi�os Educacionais, assinado em  __/__/____, para Presta��o de Servi�os Educacionais ao aluno <b><u>'.$aluno_nome.'</b></u>,  mat. n� <b><u>'.$aluno_matricula.'</u></b>, devidamente qualificado no seu requerimento de matr�cula.  Tem entre si justo e acordado o que se segue: <br>
  <strong>CL�USULA PRIMEIRA</strong>: Constitui objeto deste termo aditivo  a prorroga��o da vig�ncia do Contrato de Presta��o de Servi�os Educacionais por  mais um semestre letivo do Ensino T�cnico, per�odo 2015.1 ou ano letivo 2015,  para o Ensino M�dio, ao fim do qual, o <strong>CONTRATANTE</strong> dever� renovar sua matr�cula mediante um novo TERMO ADITIVO, para que possa  realizar as disciplinas subsequentes ou ano subsequente, condicionado a  aprova��o nas disciplinas do m�dulo/ano anterior, conforme a matriz curricular  (fluxograma) e seu calend�rio, ambos definidos pela <strong>CONTRATADA</strong>.<br>
  <strong>PAR�GRAFO �NICO: </strong>A configura��o formal  da prorroga��o da vig�ncia do Contrato de Presta��o de Servi�os Educacionais dar-se-�  pela assinatura e entrega deste Termo Aditivo, por parte do <strong>CONTRATANTE</strong>, no Setor da Secretaria da <strong>CONTRATADA, </strong>bem como pelo pagamento da  primeira parcela do m�dulo/ano contratado.</p>
<p><strong>CL�USULA SEGUNDA: </strong>O presente Termo de Aditamento passa a  fazer parte integrante do Contrato de Presta��o de Servi�os Educacionais Presencial  e � Dist�ncia, permanecendo inalteradas todas as demais disposi��es nele  contidas e n�o referidas no presente aditivo.</p>
<p>E  por estarem, assim, justas e contratadas, assinam o presente em 02 (duas) vias  de igual teor e forma, juntamente com as testemunhas abaixo.</p>
<center><p>� ������������_________________, ____ de��������������������� de 20__.����������� <br>
  <strong>��� </strong> <br>
  <strong>CONTRATANTE:  __________________________________________________</strong></p>
<p><strong>CONTRATADA:  ____________________________________________________</strong><br>
  <strong>'.$empresa_nome.'</strong></p></center>
			
			</div>
			</div>
			<div class="rodape_contrato"> C�d: '.$aluno_matricula.'</div>
			<p class="break">&nbsp</p>';
			
			if($garantia_contratual == 1){
				echo '
				<div class="contrato_final">
				<div class="contrato_corpo">
			<center><b>Anexo I - Da Garantia Contratual</b></center><br><br>
			
			<p>Como  garantia deste contrato, o <strong>CONTRATANTE</strong> indica a modalidade fian�a pessoal ora prestada pelo <strong>FIADOR</strong> abaixo qualificado, que, como <strong><u>principal pagador e solidariamente respons�vel at� a conclus�o do  curso, compromete-se por si e seus herdeiros, ilimitadamente, a satisfazer  todas as obriga��es pecuni�rias aqui contra�das, como tamb�m, as d�vidas que,  decorrentes deste instrumento, venham a ser constitu�das por for�a de  renova��es de matr�cula para m�dulo/ano subsequente ou de parcelamentos  (morat�ria) de parcelas mensais em atraso e, ainda por todos os acess�rios da  d�vida principal, inclusive as despesas extrajudiciais e judiciais</u></strong>, nos  termos do art. 821 e 822 da Lei 10.406 de 10 de janeiro de 2002.</p>
<div>
  <p><strong>FIADOR</strong>: <u>'.$fiador_nome.'</u><br>
    Data de nascimento: <u>'.$fiador_nascimento.'</u> Nacionalidade: <u>'.$fiador_nacionalidade.'</u><br>
    CPF: <u>'.$fiador_cpf.'</u> RG:  <u>'.$fiador_rg.'</u><br>
    <strong>C�NJUGE:</strong> <u>'.$conjuge_nome.'</u><br>
    Data de nascimento: <u>'.$conjuge_nascimento.'</u> Nacionalidade: <u>'.$conjuge_nacionalidade.'</u><br>
    CPF: <u>'.$conjuge_cpf.'</u> RG: <u>'.$conjuge_rg.'</u><br>
    Endere�o: <u>'.$fiador_endereco.'</u><br>
    Bairro: <u>'.$fiador_bairro.'</u> Cidade: <u>'.$fiador_cidade.'</u>  UF: <u>'.$fiador_uf.'</u><br>
    CEP: <u>'.$fiador_cep.'</u> Telefone(s): <u>'.$fiador_tel.'</u><br>
  E-mail: <u>'.$fiador_email.'</u></p>
</div>
<p><strong>&nbsp;</strong></p>
<p>____________________(ES),  ________ de _______________________ de ______</p>
<p align="center">&nbsp;</p>
<p>_________________________________  �����������____________________________<br>
  <strong>CONTRATADA�����������������������������������������������  CONTRATANTE</strong></p>
<p>_________________________________���������� _____________________________<br>
  <strong>ALUNO�����������������������������������������������������������  FIADOR</strong></p>
<p align="center">��������������������������������������� <br>
  _____________________________________<br>
  <strong>C�NJUGE DO FIADOR</strong></p>
<p>TESTEMUNHAS: </p>
<p>1)  _________________________________________<br>
  CPF:_______________________________________</p>
<p>2)  _________________________________________<br>
  CPF:_______________________________________</p>
</div>
</div>

<div class="rodape_contrato"> C�d: '.$aluno_matricula.'</div>
<p class="break">&nbsp</p>';
//segunda via
				echo '
				<div class="contrato_final">
				<div class="contrato_corpo">
			<center><b>Anexo I - Da Garantia Contratual</b></center><br><br>
			
			<p>Como  garantia deste contrato, o <strong>CONTRATANTE</strong> indica a modalidade fian�a pessoal ora prestada pelo <strong>FIADOR</strong> abaixo qualificado, que, como <strong><u>principal pagador e solidariamente respons�vel at� a conclus�o do  curso, compromete-se por si e seus herdeiros, ilimitadamente, a satisfazer  todas as obriga��es pecuni�rias aqui contra�das, como tamb�m, as d�vidas que,  decorrentes deste instrumento, venham a ser constitu�das por for�a de  renova��es de matr�cula para m�dulo/ano subsequente ou de parcelamentos  (morat�ria) de parcelas mensais em atraso e, ainda por todos os acess�rios da  d�vida principal, inclusive as despesas extrajudiciais e judiciais</u></strong>, nos  termos do art. 821 e 822 da Lei 10.406 de 10 de janeiro de 2002.</p>
<div>
  <p><strong>FIADOR</strong>: <u>'.$fiador_nome.'</u><br>
    Data de nascimento: <u>'.$fiador_nascimento.'</u> Nacionalidade: <u>'.$fiador_nacionalidade.'</u><br>
    CPF: <u>'.$fiador_cpf.'</u> RG:  <u>'.$fiador_rg.'</u><br>
    <strong>C�NJUGE:</strong> <u>'.$conjuge_nome.'</u><br>
    Data de nascimento: <u>'.$conjuge_nascimento.'</u> Nacionalidade: <u>'.$conjuge_nacionalidade.'</u><br>
    CPF: <u>'.$conjuge_cpf.'</u> RG: <u>'.$conjuge_rg.'</u><br>
    Endere�o: <u>'.$fiador_endereco.'</u><br>
    Bairro: <u>'.$fiador_bairro.'</u> Cidade: <u>'.$fiador_cidade.'</u>  UF: <u>'.$fiador_uf.'</u><br>
    CEP: <u>'.$fiador_cep.'</u> Telefone(s): <u>'.$fiador_tel.'</u><br>
  E-mail: <u>'.$fiador_email.'</u></p>
</div>
<p><strong>&nbsp;</strong></p>
<p>____________________(ES),  ________ de _______________________ de ______</p>
<p align="center">&nbsp;</p>
<p>_________________________________  �����������____________________________<br>
  <strong>CONTRATADA�����������������������������������������������  CONTRATANTE</strong></p>
<p>_________________________________���������� _____________________________<br>
  <strong>ALUNO�����������������������������������������������������������  FIADOR</strong></p>
<p align="center">��������������������������������������� <br>
  _____________________________________<br>
  <strong>C�NJUGE DO FIADOR</strong></p>
<p>TESTEMUNHAS: </p>
<p>1)  _________________________________________<br>
  CPF:_______________________________________</p>
<p>2)  _________________________________________<br>
  CPF:_______________________________________</p>
</div>
</div>

<div class="rodape_contrato"> C�d: '.$aluno_matricula.'</div>';
			}
			echo'
			<iframe src="'.$link.'" width="100%" scrolling="no" height="97%"></iframe>
			<div class="rodape_contrato"> C�d: '.$aluno_matricula.'</div>
			'.$quebra.'
			
			';
		}
	}
?>
</body>



    

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