<?php
include('../includes/conectar.php');
if(isset($_GET["id_post"])){
	$id_post = $_GET["id_post"];
	$sql_excluir_post = mysql_query("DELETE FROM ea_post_forum WHERE id_post = $id_post");
	echo "<script language=\"javascript\">
	alert('Comentário excluido com sucesso!');
	window.parent.frames['frame_central_ead'].location.reload();
	window.parent.Shadowbox.close();
	</script>";
	
} else {
	echo "<script language=\"javascript\">
	alert('Erro: O sistema apresentou um erro, entre em contato com o administrador do sistema.');
	window.parent.frames['frame_central_ead'].location.reload();
	window.parent.Shadowbox.close();
	</script>";
}
?>