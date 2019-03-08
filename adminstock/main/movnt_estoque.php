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

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="consulta_estoque.php">AdminStock</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>
	
	
    <!-- Navbar -->
    <ul class="navbar-nav ml-auto">
		<span style="margin-top: auto; margin-bottom: auto; color: white; float: right;"><?php echo "".$_SESSION['pri_nome']." ".$_SESSION['ult_nome']."&nbsp;&nbsp;"?></span>
	  <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">        
		  <a class="dropdown-item" href="../login/trocar_senha.html">Mudar Senha</a>
		  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Sair</a>
        </div>
      </li>	  
    </ul>
  </nav>

  <div id="wrapper">

	<!-- Menu lateral -->
	<?php require_once('menu.php');?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Movimentação de Estoque</li>
        </ol>
		
		<div class="card card-register mx-auto mt-8" style="margin-bottom: 2rem;">
			<div class="card-header">Movimentar Produtos</div>
				<div class="card-body">				
					<form id="busca" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<table class="col-md-12">
							<tr>
								<td>
									<?php 
										$select = "SELECT item_desc
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
					Estoque
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover" id="dataTable">
							<thead>
								<tr>
									<th>Cód. do Produto</th>
									<th>Desc. do Produto</th>
									<th>Quantidade Atual</th>
									<th>Desc. Operação</th>
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
									<form method='POST' action='#'>
									<td>
										<div class='form-group'>			
											<select class='form-control' onchange='submitForm(this.form);' name='alt_perm' required>";						
											
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
										<input name='desc_prod' class='form-control' placeholder='Quantidade' required>
									</td>
									<td>
										<button style='width: 50%; margin-left: 25%; margin-right: 25%;' type='submit' class='btn btn-success'>
											<i class='fa fa-arrow-circle-right fa-lg'> Confirmar</i>
										</button>
									</td>
									</form>
								</tr>";						  
								
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
<?php	}
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

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Quer realmente sair?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Selecione <b>Sair</b> abaixo para finalizar sua sessão atual.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-primary" href="finalizar_session.php">Sair</a>
        </div>
      </div>
    </div>
  </div>

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