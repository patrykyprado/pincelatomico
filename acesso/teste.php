<!DOCTYPE html>
<html lang="en">
<?php
include('includes/head.php');
include('includes/funcoes.php');
include('includes/topo.php');
include('includes/menu_lateral.php');

?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript"> 
	
	 
	 $(document).ready(function(){
	 	 $("#b_buscar_aluno").click(function(){
			var busca_aluno = $("#buscar_aluno").val();
			
			$.ajax({  
	 	 		
	 	 		   url: "ajax/buscar_aluno.php", 
				   dataType: 'html',
				   data: {busca:busca_aluno},
				   type: "POST", 
				   
				    beforeSend: function ()   { 
				    	$('#carregando').show();
				    },
				    success: function(data){
						$('#carregando').hide();
						$("#corpo_busca").html(data);

				    },
					error: function(data){
						$('#carregando').html(data);
						
					}

						  	
			        
			});
	 	 });
	 });
     
</script>

  <body>

  <section id="container" >



<!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                          <header class="panel-heading">
                              <b>Listar Alunos</b>
                          </header>
                          <header class="panel-body">
  Nome / Matrícula <input type="text" id="buscar_aluno" name="busca">
		<button type="button" id="b_buscar_aluno">Pesquisar</button>

                          </header>
              </section>
              <div class="directory-info-row" style="margin-top:-10px;">
              <div class="row">
              <div align="center" id="carregando" style="display:none; position:fixed; right:40%; z-index:9000"><img src="http://www.cedtecvirtual.com.br/pincelatomico/images/load.gif" /></div>
<div id="corpo_busca"></div>
</div>
              
              
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
        

