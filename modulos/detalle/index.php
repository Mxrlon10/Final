<?php 
	session_start();
	include_once "../php_conexion.php";
	include_once "class/class.php";
	include_once "../funciones.php";
	include_once "../class_buscar.php";
	if(!empty($_GET['detalle'])){
		$factura=$_GET['detalle'];
	}else{
		header('Location:error.php');
	}
	if($_SESSION['cod_user']){
	}else{
		header('Location: ../../php_cerrar.php');
	}
	$usu=$_SESSION['cod_user'];		
	$oPersona=new Consultar_Cajero($usu);
	$cajero_nombre=$oPersona->consultar('nom');
	$fecha=date('Y-m-d');
	$hora=date('H:i:s');
	
	
	$pa=mysql_query("SELECT * FROM cajero WHERE usu='$usu'");				
	while($row=mysql_fetch_array($pa)){
		$id_consultorio=$row['consultorio'];
		$oConsultorio=new Consultar_Deposito($id_consultorio);
		$nombre_consultorio=$oConsultorio->consultar('nombre');
	}
	######### TRAEMOS LOS DATOS DE LA EMPRESA #############
		$pa=mysql_query("SELECT * FROM empresa WHERE id=1");				
        if($row=mysql_fetch_array($pa)){
			$nombre_empresa=$row['empresa'];
			$nit_empresa=$row['nit'];
			$dir_empresa=$row['direccion'];
			$tel_empresa=$row['tel'].'-'.$row['fax'];
			$pais_empresa=$row['pais'].' - '.$row['ciudad'];
		}
		######### TRAEMOS LOS DATOS DE CONSULTORIO #############
		$pax=mysql_query("SELECT * FROM consultorios WHERE id=$id_consultorio");				
        if($row=mysql_fetch_array($pax)){
			$nombre_medico=$row['encargado'];
			
		}	
		######### TRAEMOS LOS DATOS DE LA EMPRESA #############
		$pax=mysql_query("SELECT * FROM resumen WHERE factura='$factura'");				
        if($row=mysql_fetch_array($pax)){
			$tipo=$row['tipo'];
			$paciente=$row['paciente'];
			$refererencia=$row['clase'];
			$fecha_guardada=$row['fecha'];
			$hora_guardada=$row['hora'];
			$usu_guardado=$row['usu'];						
		}
	
		
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Consultorio Medico</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="../../assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="../../assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
   
        <!-- CUSTOM STYLES-->
    <link href="../../assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="../../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
	
	<script>
		function imprimir(){
		  var objeto=document.getElementById('imprimeme');  //obtenemos el objeto a imprimir
		  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
		  ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
		  ventana.document.close();  //cerramos el documento
		  ventana.print();  //imprimimos la ventana
		  ventana.close();  //cerramos la ventana
		}
	</script>
	
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../usuarios/perfil.php"><?php echo $_SESSION['user_name']; ?></a> 
            </div>
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;">Consultorio: <?php echo $nombre_consultorio; ?> :: Fecha de Acceso : <?php echo fecha(date('Y-m-d')); ?> &nbsp; <a href="../../php_cerrar.php" class="btn btn-danger square-btn-adjust">Salir</a> </div>
        </nav>   
           <?php include_once "../../menu/m_caja.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">						               
                 <!-- /. ROW  -->			 
				  <div align="center">
                    <div class="btn-group">
                      <a href="../caja/operaciones.php" class="btn btn-danger" title="Regresar"><i class="fa fa-arrow-left" ></i><strong> Regresar</strong></a>
                      <a href="#" class="btn btn-info" title="Historial"><i class="fa fa-list" ></i><strong> Historial</strong></a> 
                      <button type="button" onclick="imprimir();" class="btn btn-success"><i class=" fa fa-print "></i> Imprimir</button>
                      <!--<button type="button" class="btn btn-default"><i class=" fa fa-list"></i> PDF</button>-->
                    </div>
                </div><br>
				 <div id="imprimeme">
				<div class="table-responsive">	
				<table  width="100%" style="border: 0px solid #660000; -moz-border-radius: 12px;-webkit-border-radius: 12px;padding: 10px;">
                 <tr>
                    <td>
						<center>
	                    <img src="../../img/logo.jpg" width="130px" height="130px"><br>
	                    <!--<strong><?php echo $nombre_empresa; ?></strong><br>-->
	                    </center>                                                    
                    </td>
                    <td>
					<td align="center">                     
                        <div style="font-size: 20px;"><strong><em><?php echo $nombre_medico; ?></em></strong></div>
                        <div style="font-size: 14px;"><strong><?php echo $nombre_consultorio; ?></strong></div>
                                    <strong>J.V.P.M 10606</strong><br>
                               Post-Grado Hospital Infantil de México Federico Gómez<br>
                        <!--<strong><?php echo $nombre_empresa; ?></strong><br>-->                                                 
                    </td>                                                  
                    </td>
                    <!--<td>
                    	<center>
	                    <img src="../../img/logo_dos.png" width="75px" height="75px"><br>
	                    </center> 
                    </td>-->
                 </tr>                       	
                </table>
				</div>
                <hr/>
                <div style="font-size: 12px;">
                    	<strong>DOCUMENTO: </strong><?php echo $factura; ?><br>
                        <strong>FECHA: </strong><?php echo fecha($fecha); ?> | 
                        <strong>HORA: </strong><?php echo date($hora); ?><br>
                        <strong>USUARIO/A: </strong><?php echo $cajero_nombre; ?>
						</div>
						<hr/>
                    <!-- /. TABLA  -->
				<?php 
				$oPaciente=new Consultar_Paciente($row['paciente']);

				?>
				 <div style="font-size: 14px;"align="center">
                     <strong>DETALLES DE PAGO</strong><br>                              
                </div> 
                <hr/>						
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->                    
                            <div class="table-responsive">
								<div align="left"><strong>Fecha de Registro: </strong><?php echo fecha($fecha_guardada); ?> <?php echo date($hora_guardada); ?> | |  <strong>Cajero: </strong><?php echo consultar('nom','persona',' doc='.$row['usu']); ?></div>
                                <table class="table table-striped table-bordered table-hover"  width="100%" rules="all"  border="1">                                    
									<thead>
                                        <tr>
                                            <th>CODIGO</th>                                                                                                                                                                           
                                            <th>PACIENTE</th>                                                                                                                                                                                                                                                                                                                                                       
                                            <th>COSTO DE CONSULTA</th>
                                            <th>IMPORTE</th>
                                            										
                                        </tr>
                                    </thead>
                                    <tbody>
										 <?php
											$neto=0;
											$pa=mysql_query("SELECT * FROM detalle WHERE factura='$factura' ORDER BY nombre");				
											while($row=mysql_fetch_array($pa)){
												$cod_alumno=$row['codigo'];#5
												$importe=$row['importe'];
												$ref=$row['tipo'];
												$neto=$neto+$importe;
												$oPaciente=new Consultar_Paciente($row['codigo']);
												
												
										  ?>
                                        <tr>
											<td><span class="label label-info"><?php echo $row['codigo']; ?></span></td>
											<td><?php echo $oPaciente->consultar('nombre'); ?></td>			                   	                    								                        																
											<td><div align="right"><strong><?php echo $s.' '.formato($row['valor']); ?></strong></div></td>
											<td><div align="right"><strong><?php echo $s.' '.formato($row['importe']); ?></strong></div></td>					
										  </tr>  																												
										<?php } ?>
										<tr>
											 <td colspan="3"><div align="right"><strong><h4>Total</h4></strong></div></td>
											 <td><div align="right"><strong><h4>$ <?php echo formato($neto); ?></h4></strong></div></td>
										</tr>
                                    </tbody>									
                                </table><br>
									<div style="font-size: 12px;" align="center">
										<strong><?php echo $nombre_empresa; ?></strong><br>
										<strong><?php echo $tel_empresa; ?></strong><br>
										<strong><?php echo $pais_empresa; ?></strong><br>
										<strong><?php echo $dir_empresa; ?></strong><br>
									</div>
                            </div>                                                                     
                    <!--End Advanced Tables -->
                </div>
            </div>
                <!-- /. ROW  --> 
			</div>
        </div>               
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="../../assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="../../assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="../../assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="../../assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="../../assets/js/dataTables/dataTables.bootstrap.js"></script>
	<!-- VALIDACIONES -->
	<script src="../../assets/js/jasny-bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
         <!-- CUSTOM SCRIPTS -->
    <script src="../../assets/js/custom.js"></script>
    
   
</body>
</html>
