<?php 
include('../includes/conectar.php');
$sql_config = mysql_query("SELECT * FROM config_app");
$dados_config = mysql_fetch_array($sql_config);
$config_titulo = $dados_config["titulo_app"];
$config_nome_app = $dados_config["nome_app"];
$config_footer = $dados_config["footer"];
$config_link_footer = $dados_config["link_footer"];
$config_horario_verao = $dados_config["horario_verao"];
$config_extensoes = array($dados_config["extensoes"]);
$config_max_arquivo = $dados_config["max_arquivo"];

if($config_horario_verao == 0){
	$add_time = "00:00:00";
} else {
	$add_time = "01:00:00";
}

?>
  <head>
    <meta charset="iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Patryky Prado de Oliveira">
    <meta name="keyword" content="Sistema Acad�mico, CEDTEC, Pincel At�mico">
    <link rel="shortcut icon" href="img/favicon.png">
<script type='text/javascript' src='ckeditor/ckeditor.js'></script>
<script type='text/javascript' src='ckeditors/adapters/jquery.js'></script>
<script type='text/javascript' src='ckeditor/plugins/div/dialogs/div.js'></script>


<script>

	$(function()
	{
		var config = {};

		$('.ckeditor').ckeditor(config);
	});
</script>
<script type="text/javascript">//<![CDATA[
      CKEDITOR.replace('descricao_dicas',{
    filebrowserBrowseUrl : '/ckeditor/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl : 'ckeditor/ckfinder/ckfinder.html?type=Images',
    filebrowserFlashBrowseUrl : 'ckeditor/ckfinder/ckfinder.html?type=Flash',
    filebrowserUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    }    
    );
//]]></script>  
<script type='text/javascript' src='ckeditor/ckeditor.js'></script>
<script type='text/javascript' src='ckeditor/adapters/jquery.js'></script>
<script type='text/javascript' src='ckeditor/plugins/div/dialogs/div.js'></script>
<script>

	$(function()
	{
		var config = {};

		$('.ckeditor').ckeditor(config);
		
	});
	
CKEDITOR.replace( 'editor',{
    filebrowserBrowseUrl : 'ckeditor/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl : 'ckeditor/ckfinder/ckfinder.html?type=Images',
    filebrowserFlashBrowseUrl : 'ckeditor/ckfinder/ckfinder.html?type=Flash',
    filebrowserUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&amp;type=Files',
    filebrowserImageUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&amp;type=Images',
    filebrowserFlashUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&amp;type=Flash'
} )
</script>
    <title><?php echo $config_titulo;?></title>
    <link rel="stylesheet" type="text/css" href="../assets/shadowbox/shadowbox.css">
    <script type="text/javascript" src="../assets/shadowbox/shadowbox.js"></script>
    <script type="text/javascript">
    Shadowbox.init({
        handleOversize: "drag",
        modal: true
    });
    </script>

	<!-- CSS DE IMPRESS�O -->
    <link href="../css/imprimir_inside.css" media="print" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

      <!--right slidebar-->
      <link href="../css/slidebars.css" rel="stylesheet">

    <!-- Custom styles for this template -->


    <!-- Custom styles for this template -->

    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/style-responsive.css" rel="stylesheet" />



    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="../js/html5shiv.js"></script>
      <script src="../js/respond.min.js"></script>
    <![endif]-->
<style>
html, body {
    max-width: 100%;
    overflow-x: hidden;
}
</style>
  </head>
  <body onkeydown='return Verificar_ctrl();'>