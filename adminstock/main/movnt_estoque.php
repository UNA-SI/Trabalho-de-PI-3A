<?php
require_once("../requires/connect.php");
mysqli_set_charset( $mysqli, 'utf8'); // MUDA OS DADOS DO BANCO PARA UTF-8 - **IMPORTANTE**
session_start();
// checa se a SESSION expirou
if($_SESSION['login'] == "" && $_SESSION['permissao'] == "") 
{
  	echo "<script>
			alert('Login expirado, entre novamente.');
			window.location.href='../../index.html';
		  </script>";
}
// Verifica permissão do usuário ao acesso da página
if($_SESSION['permissao'] != "1" && $_SESSION['permissao'] != "2") 
{
  	echo "<script>
			alert('Voc\u00ea n\u00e3o tem acesso a essa p\u00e1gina, fale com o administrador para poder acessar.');
			window.location.href='../../index.html';
		  </script>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>AdminStock - Movimentação de Estoque</title>

  <!-- Custom fonts for this template-->
  <link href="../requires/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="../requires/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../requires/css/sb-admin.css" rel="stylesheet">
	
	<style>
		.nome-footer{
			font-weight: bold;
			font-size: 1.5rem;
			
		}
		#alinhamento
		{
			vertical-align:middle;
		}	
	</style>	
</head>

<body id="page-top">

	<!-- BARRA DE NAVEGAÇÃO SUPERIOR -->
	<?php require_once('nav_bar.php');?>

	<div id="wrapper">

	<!-- Menu lateral -->
	<?php require_once('menu.php');?>

    <div id="content-wrapper">
		<div class="container-fluid">
			<!-- Page Content -->
				<h1>Movimentação de Estoque</h1>
				<hr>
				<br>
			
			<div class="card card-register mx-auto mt-8" style="margin-bottom: 2rem;">
				<div class="card-header">Movimentar Produtos</div>
				<div class="card-body">				
					<form id="busca" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<table class="col-md-12">
							<tr>
								<td>
									<?php 
										$select = "SELECT item_desc, id
										FROM item
										ORDER BY item_desc";
										$result = $mysqli->query($select);

										while($row = $result->fetch_assoc()){
											$items[] = $row['item_desc'];
										}
										echo "<input list='categoria' name='item_desc' class='form-control' 
										placeholder='Nome do Produto' pattern='" . implode('|', $items) . "' required>";                                                                                                                                                                                                                                                                             
												
										echo "<datalist id='categoria'>";
										foreach($items as $item){
											echo "<option value='".$item."'/>";											
										}   
										echo "</datalist>"; 
									?>	
								</td>
								<td>
									
									<input style="width: 70%; margin-left: 15%; margin-right: 15%;" name="submit" type="submit" class="btn btn-primary btn-block" value="Buscar">
								</td>
							</tr>
						</table>
					</form>	
				</div>
			</div>
		

<?php
	if(isset($_POST['submit'])){
?>			
			<!-- Tabela -->		
			<div class="card mb-3">
				<div class="card-header">
					<i class="fas fa-table"></i>
					Produto Selecionado
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Cód. do Produto</th>
									<th>Desc. do Produto</th>
									<th>Quantidade Atual</th>
									<th>Operação</th>
									<th>Qtd. Para Movimentação</th>
									<th>Confirmar Movimentação</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$select = "SELECT cod_item, item_desc, saldo
								FROM estoque
								WHERE item_desc = '{$_POST['item_desc']}'";								
								$result = $mysqli->query($select);					
								$row = $result->fetch_assoc();
								echo "		
								<tr>
									<td id='alinhamento'>".$row['cod_item']."</td>
									<td id='alinhamento'>".$row['item_desc']."</td>
									<td id='alinhamento'>".$row['saldo']."</td>
									<form method='POST' action='interacao_bd/update_movn_estoque.php'>
									<td>
										<div class='form-group'>			
											<select class='form-control' onchange='submitForm(this.form);' name='cod_op' required>";						
											
											$select_op = "SELECT cod_operacao, desc_operacao, tipo
											FROM operacao";								
											$result_op = $mysqli->query($select_op);
											
											echo "<option value=''>Operação</option>";
											while($row_op = $result_op->fetch_assoc()){											
												echo"	
												<option value='".$row_op['cod_operacao']."'>".$row_op['desc_operacao']."</option>";
											}
								echo"		</select>
										</div>					
									</td>
									<td>
										<input name='qtde' class='form-control' placeholder='Quantidade' required>
									</td>
									<td>
										<button style='width: 76%; margin-left: 12%; margin-right: 12%;' type='submit' class='btn btn-success'>
											<i class='fa fa-arrow-circle-right fa-lg'> Confirmar</i>
										</button>
									</td>
									<input type='hidden' value='".$_POST['item_desc']."' name='item_desc'/>
									</form>
								</tr>";						  
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
<?php	
	}
?>
		</div>


       
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span class="nome-footer">AdminStock 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="../requires/vendor/jquery/jquery.min.js"></script>
  <script src="../requires/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../requires/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="../requires/vendor/datatables/jquery.dataTables.js"></script>
  <script src="../requires/vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../requires/js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="../requires/js/demo/datatables-demo.js"></script>

</body>

</html>
