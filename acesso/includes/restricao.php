<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

//pega as variaveis dos usuarios
$user_usuario = $_SESSION['MM_Username'];
$user_nivel = $_SESSION['MM_UserGroup'];
$user_empresa = $_SESSION['MM_empresa'];
$user_unidade = $_SESSION['MM_unidade'];
$user_email = $_SESSION['MM_email'];
$user_acessos = $_SESSION['MM_Acessos'];
$user_iduser = $_SESSION['MM_iduser'];
$user_nome = $_SESSION['MM_Nome'];
$user_foto = $_SESSION['MM_Foto'];
$user_senha = $_SESSION['MM_Senha'];
$user_setor = $_SESSION['MM_Setor'];


$sql_nivel = mysql_query("SELECT * FROM nivel_user WHERE nivel = $user_nivel");
if(mysql_num_rows($sql_nivel)==1){
	$dados_nivel = mysql_fetch_array($sql_nivel);	
	$user_nivel_nome = $dados_nivel["funcao"];
	$user_nivel_pagina = $dados_nivel["pagina"];
} else {
	$user_nivel_nome = "";
	$user_nivel_pagina = "";
}

//PERMISS�ES DE EDI��O
$user_permissoes = array(1,2,3,4,6,7,8,80);

if(in_array($user_nivel,$user_permissoes)){
	$permitido = 1;	
} else {
	$permitido = 0;	
}

$permissao_financeiro = array(1,2,3,4,5);
if(in_array($user_nivel,$permissao_financeiro)){
	$permitido_pesquisa = 1;	
} else {
	$permitido_pesquisa = 0;	
}
?>

