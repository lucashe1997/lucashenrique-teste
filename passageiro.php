<?php
require('config.php');

if(isset($_GET['deleteid'])){
	$deleteid= $_GET['deleteid'];
	$deletepassageiroSQL = "DELETE FROM tb_passageiros WHERE id='$deleteid'";
	$deletepassageiro = mysqli_query($con,$deletepassageiroSQL);
	header('location: passageiro.php');
}

if(isset($_POST['passageirosform'])){
	$nomepass = mysqli_real_escape_string($con,$_POST['nomepass']);
	$datapass = mysqli_real_escape_string($con,$_POST['datapass']);
	$cpfpass = mysqli_real_escape_string($con,$_POST['cpfpass']);
	$sexopass = mysqli_real_escape_string($con,$_POST['sexopass']);
	$addnew = mysqli_real_escape_string($con,$_POST['addnew']);
	
	if($addnew == 'true'){
		$addpassageiroSQL = "INSERT INTO tb_passageiros VALUES(DEFAULT,'$nomepass','$datapass','$cpfpass','$sexopass')";
		$addpassageiro = mysqli_query($con,$addpassageiroSQL);
	}else{
		$updatepassageiroSQL = "UPDATE tb_passageiros SET pass_nome='$nomepass', pass_data='$datapass', pass_cpf='$cpfpass', pass_sexo='$sexopass' WHERE id='$addnew'"; 
		$updatepassageiro = mysqli_query($con,$updatepassageiroSQL);
	}
	
	
}
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Passageiros</title>
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
					<h4>Lista de Passageiros</h4>
											
					<div class="card">
						<div class="card-body">
						<form method="POST" class="form-inline" style="margin: 10px 0">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-novo="true" data-name="Adicionar Passageiro" data-target="#passageiromodal" style="margin-right:60px;">
							Adicionar Passageiro
							</button>
							<div class="form-group  col-6">
								<input type="text" class="form-control col-12" id="searchsql" name="searchsql" placeholder="Pesquisar por nome">
							</div>
							<button type="submit" class="btn btn-primary">Pesquisar</button>
						</form>
						
						<!-- Modal -->
						<div class="modal fade" id="passageiromodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
											<label for="nomepass">Nome do Passageiro</label>
											<input type="text" class="form-control" id="nomepass" name="nomepass" placeholder="Nome do Passageiro" required>
										</div>										
										<div class="form-group">
											<label for="exampleFormControlInput1">Data de Nascimento</label>
											<input type="text" class="form-control date" id="datapass" name="datapass" placeholder="11/08/1997" required>
										</div>										
										<div class="form-group">
											<label for="exampleFormControlInput1">CPF</label>
											<input type="text" class="form-control cpf" id="cpfpass" name="cpfpass" placeholder="777.666.555.44" required>
										</div>									
										<div class="form-group">
											<label for="exampleFormControlInput1">Sexo</label>
											<select class="form-control" id="sexopass" name="sexopass" required>
												<option value="Masculino">Masculino</option>
												<option value="Feminino">Feminino</option>
											</select>
										</div>
									</div>
									<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
									<button type="sumbit" name="passageirosform" class="btn btn-primary">Salvar</button>
									</form>
									</div>
								</div>
							</div>
						</div>
						<table class="table">
							<thead>
								<tr>
									<th scope="col">Passageiro</th>
									<th scope="col">Nascimento</th>
									<th scope="col">CPF</th>
									<th scope="col">Sexo</th>
									<th scope="col"></th>
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody>
								<?php
									if(isset($_POST['searchsql'])){
										$termo = mysqli_real_escape_string($con,$_POST['searchsql']);
										$listpassageirosSQL = "SELECT * FROM tb_passageiros WHERE (`pass_nome` LIKE '%$termo%') ORDER BY pass_nome ASC";
									}else{
										$listpassageirosSQL = "SELECT * FROM tb_passageiros ORDER BY pass_nome ASC";
									}
									$listpassageiros = mysqli_query($con,$listpassageirosSQL);

									if(mysqli_num_rows($listpassageiros)>0){
										while ($passageiros =  mysqli_fetch_assoc($listpassageiros) ){
											echo '<tr><td id="passnome">'.$passageiros['pass_nome'].'</td>';
											echo '<td id="passdata">'.$passageiros['pass_data'].'</td>';
											echo '<td id="passcpf">'.$passageiros['pass_cpf'].'</span></td>';
											echo '<td id="passsexo">'.$passageiros['pass_sexo'].'</span></td>';
											echo '<td><a data-toggle="modal" data-target="#passageiromodal" data-novo="'.$passageiros['id'].'" data-name="Editar Passageiro"><i class="fa fa-pencil-square-o" style="color:blue"></i></a></td>
									<td><a href="?deleteid='.$passageiros['id'].'" onclick="return confirm(\'Você quer mesmo deletar esse passageiro?\')"><i class="fa fa-trash" style="color:red"></i></a></td></tr>';
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
	
	$('#passageiromodal').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var nome = button.data('name') // Extract info from data-* attributes
		var addnew = button.data('novo')
	  var passnome = button.parent().siblings('td#passnome').text();
	  var passdata = button.parent().siblings('td#passdata').text();
	  var passcpf = button.parent().siblings('td#passcpf').text();
	  var passsexo = button.parent().siblings('td#passsexo').text();
	  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
	  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
	  var modal = $(this)
	  modal.find('.modal-title').text(nome)
	  modal.find('.modal-body input#nomepass').val(passnome)
	  modal.find('.modal-body input#datapass').val(passdata)
	  modal.find('.modal-body input#cpfpass').val(passcpf)
	  modal.find('.modal-body select#sexopass').val(passsexo)
		modal.find('.modal-body input#new').val(addnew)
	  
	})
	 </script>
</html>