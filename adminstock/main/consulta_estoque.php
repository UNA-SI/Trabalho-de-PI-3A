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
if($_SESSION['permissao'] != "1" && $_SESSION['permissao'] != "2" & $_SESSION['permissao'] != "3") 
{
  	echo "<script>
			alert('Voc\u00ea n\u00e3o tem acesso a essa p\u00e1gina, fa\u00e7a o login para poder acessar.');
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

  <title>AdminStock - Consultar Estoque</title>

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
			<h1>Consultar Estoque</h1>
			<hr>
			<br>
        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Estoque Atual</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" id="dataTable">
                <thead>
                  <tr>
                    <th>Cód. do Produto</th>
                    <th>Desc. do Produto</th>
                    <th>Categoria</th>
					<th>Última Movimentação</th>
                    <th>Saldo em Estoque</th>
                  </tr>
                </thead>
                <tbody>
				<tr>
				<?php 
					
				
					$select = "SELECT cod_item, item_desc, cod_categoria, saldo
					FROM estoque";
					$result = $mysqli->query($select);
					
					while($row = $result->fetch_assoc()){
						
						$select_cat = "SELECT desc_categoria
						FROM categoria
						WHERE cod_categoria = '{$row['cod_categoria']}' ";
						$result_cat = $mysqli->query($select_cat);
						$row_cat = $result_cat->fetch_assoc();					
						
						$select_dat = "SELECT dat_movimento
						FROM estoque_movnto
						WHERE cod_item = '{$row['cod_item']}'
						ORDER BY dat_movimento DESC LIMIT 1";
						$result_dat = $mysqli->query($select_dat);
						$row_dat = $result_dat->fetch_assoc();
						
						echo "		
						<tr>
							<td>".$row['cod_item']."</td>
							<td>".$row['item_desc']."</td>
							<td>".$row_cat['desc_categoria']."</td>
							<td>".$row_dat['dat_movimento']."</td>
							<td>".$row['saldo']."</td>
						</tr>";		
						
					}
				
				?>       
                </tbody>
              </table>
            </div>
          </div>
        </div>

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
