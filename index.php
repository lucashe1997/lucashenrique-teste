<?php
require('config.php');

if(isset($_GET['deleteid'])){
	$deleteid= $_GET['deleteid'];
	$deletecorridasSQL = "DELETE FROM tb_corridas WHERE id='$deleteid'";
	$deletecorridas = mysqli_query($con,$deletecorridasSQL);
	header('location: index.php');
}

if(isset($_POST['corridasform'])){
	$motonome = mysqli_real_escape_string($con,$_POST['motonome']);
	$passnome = mysqli_real_escape_string($con,$_POST['passnome']);
	$precovalue = mysqli_real_escape_string($con,$_POST['precovalue']);
	$preco = str_replace('.','',$precovalue);
	$precovalue = str_replace(',','.',$preco);
	$addnew = mysqli_real_escape_string($con,$_POST['addnew']);
	
	if($addnew == 'true'){
		$addcorridasSQL = "INSERT INTO tb_corridas VALUES(DEFAULT,'$motonome','$passnome','$precovalue')";
		$addcorridas = mysqli_query($con,$addcorridasSQL);
	}else{
		$updatecorridasSQL = "UPDATE tb_corridas SET n_motorista='$motonome', n_passageiro='$passnome', preco='$precovalue' WHERE id='$addnew'"; 
		$updatecorridas = mysqli_query($con,$updatecorridasSQL);
	}
	
	
}
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Corridas</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">	
		<link rel="stylesheet" href="assets/css/selectize.css">
  </head>
  <body style="margin-top: 40px;">
		<div class="container">
			<div class="row">
				<!-- main navbar  start-->
				<?php require('includes/menu.php');?>
				<!-- main navbar  end-->
				<!-- main content  start-->
				<div class="col-9">
						<h4 style="margin-bottom:10px;">Lista de Corridas</h4>
					<div class="card">
						<div class="card-body">
						
						<form method="POST" class="form-inline" style="margin: 10px 0">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#corridamodal" data-name="Adicionar Corrida" data-novo="true" style="margin-right:60px;">
							Adicionar Corrida
							</button>
							<div class="form-group  col-6">
								<input type="text" class="form-control col-12" id="searchsql" name="searchsql" placeholder="Pesquisar por nome">
							</div>
							<button type="submit" class="btn btn-primary">Pesquisar</button>
						</form>
						
						<!-- Modal -->
						<div class="modal fade" id="corridamodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">######</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
									<form method="POST">
										<input type="hidden" id="new" name="addnew" value="false">
										<div class="form-group">
											<label for="exampleFormControlInput1">Motorista</label>
											<select class="form-control" id="motonome" name="motonome" placeholder="Nome do motorista" required>
												<?php
												$nmotoristasSQL = "SELECT moto_nome FROM tb_motoristas WHERE moto_ativo = 's' ORDER BY moto_nome ASC";
												$nmotoristas = mysqli_query($con,$nmotoristasSQL);

												if(mysqli_num_rows($nmotoristas)>0){
													while ($motorista =  mysqli_fetch_assoc($nmotoristas) ){
														echo '<option value="'.$motorista['moto_nome'].'">'.$motorista['moto_nome'].'</option>';
													}
												}
												?>
											</select>
										</div>										
										<div class="form-group">
											<label for="exampleFormControlInput1">Passageiro</label>
											<select class="form-control" id="passnome" name="passnome" placeholder="Nome do passageiro" required>
												<?php
												$npassageiroSQL = "SELECT pass_nome FROM tb_passageiros ORDER BY pass_nome ASC";
												$npassageiro = mysqli_query($con,$npassageiroSQL);

												if(mysqli_num_rows($npassageiro)>0){
													while ($passageiro =  mysqli_fetch_assoc($npassageiro) ){
														echo '<option value="'.$passageiro['pass_nome'].'">'.$passageiro['pass_nome'].'</option>';
													}
												}
												?>
											</select>
										</div>										
										<div class="form-group">
											<label for="exampleFormControlInput1">Preço</label>
											<input type="text" class="form-control money" id="precovalue" name="precovalue" placeholder="100,00" required>
										</div>
									</div>
									<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
									<button type="sumbit" name="corridasform" class="btn btn-primary">Salvar</button>
									</form>
									</div>
								</div>
							</div>
						</div>
						<table class="table">
							<thead>
								<tr>
									<th scope="col">Motorista</th>
									<th scope="col">Passageiro</th>
									<th scope="col">Valor</th>
									<th scope="col"></th>
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody>
								
									<?php
										if(isset($_POST['searchsql'])){
											$termo = mysqli_real_escape_string($con,$_POST['searchsql']);
											$listCorridasSQL = "SELECT * FROM tb_corridas WHERE ((`n_motorista` LIKE '%$termo%') OR (`n_passageiro` LIKE '%$termo%')) ORDER BY id DESC";
										}else{
											$listCorridasSQL = "SELECT * FROM tb_corridas ORDER BY id DESC";
										}
										$listCorridas = mysqli_query($con,$listCorridasSQL);
							
										if(mysqli_num_rows($listCorridas)>0){
											while ($corridas =  mysqli_fetch_assoc($listCorridas) ){
												echo '<tr><td id="nomemoto">'.$corridas['n_motorista'].'</td>';
												echo '<td id="nomepass">'.$corridas['n_passageiro'].'</td>';
												echo '<td id="valuepreco">R$ <span>'.$corridas['preco'].'</span></td>';
												echo '<td><a data-toggle="modal" data-target="#corridamodal" data-novo="'.$corridas['id'].'" data-name="Editar Corrida"><i class="fa fa-pencil-square-o" style="color:blue"></i></a></td>
									<td><a href="?deleteid='.$corridas['id'].'" onclick="return confirm(\'Você quer mesmo deletar essa corrida?\')"><i class="fa fa-trash" style="color:red"></i></a></td></tr>';
											}
										}
								?>
								
							</tbody>
						</table>
						</div>
					</div>
				</div>
				<!-- main content  end-->
			</div>
		</div>
 		 <script src="assets/js/jquery.min.js"></script>
    <!--script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
		<script src="http://35.192.119.156/teste/assets/js/jquery.mask.js"></script>
		<script type="text/javascript" src="assets/js/selectize.js"></script>
	<script>
	$(document).ready(function(){
		$('.date').mask('00/00/0000');
		$('.money').mask("#.##0,00", {reverse: true});
	});
	
	$('#corridamodal').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var nome = button.data('name') // Extract info from data-* attributes
		var addnew = button.data('novo')
	  var nomepass = button.parent().siblings('td#nomepass').text();
	  var nomemoto = button.parent().siblings('td#nomemoto').text();
	  var valuepreco = button.parent().siblings('td#valuepreco').children('span').text();
	  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
	  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
	  var modal = $(this)
	  modal.find('.modal-title').text(nome)
	  modal.find('.modal-body input#passnome').val(nomepass)
	  modal.find('.modal-body input#motonome').val(nomemoto)
	  modal.find('.modal-body input#precovalue').val(valuepreco)
		modal.find('.modal-body input#new').val(addnew)
	});

	$('#motonome').selectize({});
	$('#passnome').selectize({});	
	</script>
			</div>
  </body>
</html>