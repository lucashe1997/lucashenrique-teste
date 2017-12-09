<?php
require('config.php');

if(isset($_GET['deleteid'])){
	$deleteid= $_GET['deleteid'];
	$deletemotoristaSQL = "DELETE FROM tb_motoristas WHERE id='$deleteid'";
	$deletemotorista = mysqli_query($con,$deletemotoristaSQL);
	header('location: motorista.php');
}

if(isset($_POST['motoristasform'])){
	$nomemoto = mysqli_real_escape_string($con,$_POST['nomemoto']);
	$datamoto = mysqli_real_escape_string($con,$_POST['datamoto']);
	$cpfmoto = mysqli_real_escape_string($con,$_POST['cpfmoto']);
	$sexomoto = mysqli_real_escape_string($con,$_POST['sexomoto']);
	$ativomoto = mysqli_real_escape_string($con,$_POST['ativomoto']);
	$addnew = mysqli_real_escape_string($con,$_POST['addnew']);
	
	if($addnew == 'true'){
		$addmotoristaSQL = "INSERT INTO tb_motoristas VALUES(DEFAULT,'$nomemoto','$datamoto','$cpfmoto','$sexomoto','$ativomoto')";
		$addmotorista = mysqli_query($con,$addmotoristaSQL);
	}else{
		$updatemotoristaSQL = "UPDATE tb_motoristas SET moto_nome='$nomemoto', moto_data='$datamoto', moto_cpf='$cpfmoto', moto_sexo='$sexomoto', moto_ativo='$ativomoto' WHERE id='$addnew'"; 
		$updatemotorista = mysqli_query($con,$updatemotoristaSQL);
	}
	
	
}
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Motoristas</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body style="margin-top: 40px;">
		<div class="container">
			<div class="row">
				<!-- main navbar  start-->
				<?php require('includes/menu.php');?>
				<!-- main navbar  end-->
				<!-- main content  start-->
				<div class="col-9">
					<h4>Lista de Motoristas</h4>
					<div class="card">
						<div class="card-body">

						<form method="POST" class="form-inline" style="margin: 10px 0">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-novo="true" data-name="Adicionar Motorista" data-target="#motoristamodal" style="margin-right:60px;">
							Adicionar Motorista
							</button>
							<div class="form-group  col-6">
								<input type="text" class="form-control col-12" id="searchsql" name="searchsql" placeholder="Pesquisar por nome">
							</div>
							<button type="submit" class="btn btn-primary">Pesquisar</button>
						</form>
						
						<!-- Modal -->
						<div class="modal fade" id="motoristamodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">######</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
									<form  method="POST">
										<input type="hidden" id="new" name="addnew" value="false">
										<div class="form-group">
											<label for="exampleFormControlInput1">Nome do Motorista</label>
											<input type="text" class="form-control" id="nomemoto" name="nomemoto" placeholder="Nome do motorista" required>
										</div>										
										<div class="form-group">
											<label for="exampleFormControlInput1">Data de Nascimento</label>
											<input type="text" class="form-control date" id="datamoto" name="datamoto" placeholder="11/08/1997" required>
										</div>										
										<div class="form-group">
											<label for="exampleFormControlInput1">CPF</label>
											<input type="text" class="form-control cpf" id="cpfmoto" name="cpfmoto" placeholder="777.666.555.44" required>
										</div>									
										<div class="form-group">
											<label for="exampleFormControlInput1">Sexo</label>
											<select class="form-control" id="sexomoto" name="sexomoto" required>
												<option value="Masculino">Masculino</option>
												<option value="Feminino">Feminino</option>
											</select>
										</div>									
										<div class="form-group">
											<label for="exampleFormControlInput1">Ativo</label>
											<select class="form-control" id="ativomoto" name="ativomoto" required>
												<option value="s">Sim</option>
												<option value="n">Não</option>
											</select>
										</div>
									</div>
									<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
									<button type="sumbit" name="motoristasform" class="btn btn-primary">Salvar</button>
									</form>
									</div>
								</div>
							</div>
						</div>
						<table class="table">
							<thead>
								<tr>
									<th scope="col">Motorista</th>
									<th scope="col">Nascimento</th>
									<th scope="col">CPF</th>
									<th scope="col">Sexo</th>
									<th scope="col">Ativo</th>
									<th scope="col"></th>
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody>
								<?php
									if(isset($_POST['searchsql'])){
										$termo = mysqli_real_escape_string($con,$_POST['searchsql']);
										$listMotoristasSQL = "SELECT * FROM tb_motoristas WHERE (`moto_nome` LIKE '%$termo%') ORDER BY moto_nome ASC";
									}else{
										$listMotoristasSQL = "SELECT * FROM tb_motoristas ORDER BY moto_nome ASC";
									}
									$listMotoristas = mysqli_query($con,$listMotoristasSQL);

									if(mysqli_num_rows($listMotoristas)>0){
										while ($motoristas =  mysqli_fetch_assoc($listMotoristas) ){
											echo '<tr><td id="motonome">'.$motoristas['moto_nome'].'</td>';
											echo '<td id="motodata">'.$motoristas['moto_data'].'</td>';
											echo '<td id="motocpf">'.$motoristas['moto_cpf'].'</span></td>';
											echo '<td id="motosexo">'.$motoristas['moto_sexo'].'</span></td>';
											echo '<td id="motoativo">'.$motoristas['moto_ativo'].'</span></td>';
											echo '<td><a data-toggle="modal" data-target="#motoristamodal" data-novo="'.$motoristas['id'].'" data-name="Editar Motorista"><i class="fa fa-pencil-square-o" style="color:blue"></i></a></td>
									<td><a href="?deleteid='.$motoristas['id'].'" onclick="return confirm(\'Você quer mesmo deletar esse motorista?\')"><i class="fa fa-trash" style="color:red"></i></a></td></tr>';
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
  
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
	<script src="http://35.192.119.156/teste/assets/js/jquery.mask.js"></script>
	<script>
	$(document).ready(function(){
		$('.date').mask('00/00/0000');
		$('.cpf').mask('000.000.000-00', {reverse: true});
	});
	
	$('#motoristamodal').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var nome = button.data('name') // Extract info from data-* attributes
		var addnew = button.data('novo')
	  var motonome = button.parent().siblings('td#motonome').text();
	  var motodata = button.parent().siblings('td#motodata').text();
	  var motocpf = button.parent().siblings('td#motocpf').text();
	  var motosexo = button.parent().siblings('td#motosexo').text();
		var motoativo = button.parent().siblings('td#motoativo').text();
	  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
	  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
	  var modal = $(this)
	  modal.find('.modal-title').text(nome)
	  modal.find('.modal-body input#nomemoto').val(motonome)
	  modal.find('.modal-body input#datamoto').val(motodata)
	  modal.find('.modal-body input#cpfmoto').val(motocpf)
	  modal.find('.modal-body select#sexomoto').val(motosexo)
		modal.find('.modal-body input#new').val(addnew)
		modal.find('.modal-body select#ativomoto').val(motoativo)
	  
	})
	 </script>
  </body>
</html>
<?php 						$listMotoristasSQL = "SELECT * FROM tb_passageiros ORDER BY pass_nome ASC";
									
									$listMotoristas = mysqli_query($con,$listMotoristasSQL);

									if(mysqli_num_rows($listMotoristas)>0){
										while ($motoristas =  mysqli_fetch_assoc($listMotoristas) ){
											echo $motoristas['pass_nome'].', ';
										}
									}
?>