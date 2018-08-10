<?php 
	session_start();
	include_once "../php_conexion.php";
	include_once "class/class.php";
	include_once "../funciones.php";
	include_once "../class_buscar.php";
	if(!empty($_GET['id'])){
		$factura=$_GET['id'];
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
	
	$usu=$_SESSION['cod_user'];
	$pa=mysql_query("SELECT * FROM cajero WHERE usu='$usu'");				
	while($row=mysql_fetch_array($pa)){
		$id_consultorio=$row['consultorio'];
		$oConsultorio=new Consultar_Deposito($id_consultorio);
		$nombre_Consultorio=$oConsultorio->consultar('nombre');
	}
	
	######### TRAEMOS LOS DATOS DE LA EMPRESA #############
		$pa=mysql_query("SELECT * FROM empresa WHERE id=1");				
        if($row=mysql_fetch_array($pa)){
			$nombre_empresa=$row['empresa'];
			$nit_empresa=$row['nit'];
			$dir_empresa=$row['direccion'];
			$tel_empresa=$row['tel'].'-'.$row['fax'];
			$pais_empresa=$row['pais'].' - '.$row['ciudad'];
			$email=$row['correo'];
		}
	######### TRAEMOS LOS DATOS DE CONSULTORIO #############
		$pax=mysql_query("SELECT * FROM consultorios WHERE id=$id_consultorio");				
        if($row=mysql_fetch_array($pax)){
			$nombre_medico=$row['encargado'];
			
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
font-size: 16px;">Consultorio: <?php echo $nombre_Consultorio; ?> :: Fecha de Acceso : <?php echo fecha(date('Y-m-d')); ?> &nbsp; <a href="../../php_cerrar.php" class="btn btn-danger square-btn-adjust">Salir</a> </div>
        </nav>   
           <?php include_once "../../menu/m_consulta_medica.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">
            <?php if(permiso($_SESSION['cod_user'],'3')==TRUE){ ?>
				
				 <?php											
					$pa=mysql_query("SELECT * FROM consultas_medicas WHERE id='$factura'");				
						while($row=mysql_fetch_array($pa)){
							$oPaciente=new Consultar_Paciente($row['id_paciente']);
							#$oPaciente=new Consultar_Paciente($row['id_paciente']);
							$peso=$row['peso'];
				?>
				<div class="alert alert-info" align="center">
                    <div class="row">
					  <div class="col-md-4"><strong>USUARIO: </strong><?php echo $cajero_nombre; ?></div>
					  <div class="col-md-4">EXPEDIENTE: </strong><strong><?php echo $factura; ?></strong></strong><br></strong><strong>FECHA: </strong><?php echo fecha($fecha); ?> ||  
                        <strong>HORA: </strong><?php echo date($hora); ?><h5></div>
					  <div class="col-md-4">MEDICO: </strong><?php echo $nombre_medico; ?> </div>
					</div>
                 </div> 				                
                 <!-- /. ROW  -->            
                    <!-- /. TABLA  -->              
				<div>			
            <div class="row">           
                <div class="col-md-12">
                 <div align="center">
                    <div class="btn-group">
                      <a href="../consultas_medicas/index.php" class="btn btn-danger" title="Regresar"><i class="fa fa-arrow-left" ></i><strong> Consultas</strong></a>
                      <button type="button" onclick="imprimir();" class="btn btn-success"><i class=" fa fa-print "></i> Imprimir</button>
                      <!--<button type="button" class="btn btn-default"><i class=" fa fa-list"></i> PDF</button>-->
                    </div>
                </div><br>
                  <div class="table-responsive">
                  <div id="imprimeme">
                <table class="table table-bordered" width="100%" style="border: 0px solid #660000;">
                          	<tr>
                            	<td>
                                	<center>                                 	                                                                	                                   											
										<br>
										<table class="table" width="95%" style="border: 0px solid #660000; -moz-border-radius: 12px;-webkit-border-radius: 30px;padding: 10px;">
										<?php											
											$pa=mysql_query("SELECT * FROM consultas_medicas WHERE id='$factura'");				
												while($row=mysql_fetch_array($pa)){
													$oPaciente=new Consultar_Paciente($row['id_paciente']);
													#$oPaciente=new Consultar_Paciente($row['id_paciente']);
										?>
						                 <tr>
						                    <td align="center">												
							                    <img src="../../img/logo.jpg" width="130px" height="130px"><br>							             							                                                                     
						                    </td>
						                    <td align="center" class="text-danger">
												<div style="font-size: 20px;"><strong><?php echo $nombre_empresa; ?></strong></div>
							                    <div style="font-size: 20px;"><strong><em><?php echo $nombre_medico; ?></em></strong></div>
							                    <div style="font-size: 18px;"><strong><?php echo $nombre_Consultorio; ?></strong></div>
							                    		<div style="font-size: 16px;">Post-Grado Hospital Infantil de México Federico Gómez <br>
															J.V.P.M 10606</div>							              							                                                                     
						                    </td>
						                     <td align="center">																             							                                                                     
						                    </td>
						                 </tr>                     	
						                </table>                                       												 																											
								<table class="table table-striped table-hover" width="95%" style="border: 1px solid #660000; -moz-border-radius: 12px;-webkit-border-radius: 12px;padding: 10px;">
						                 <tr>
											   <td colspan="3" align="left" class="text-danger" style="font-size: 14px;"><strong>Paciente:</strong> <?php echo $oPaciente->consultar('nombre'); ?></td>
											   <td colspan="1" align="center" class="text-danger" style="font-size: 14px;"><strong>Fecha: <?php echo fecha($fecha); ?> </td>
										</tr>
						                <tr>
											   <td colspan="3" align="left" class="text-danger" style="font-size: 14px;"><strong>Edad:</strong> 	<?php echo CalculaEdad($oPaciente->consultar('edad')); ?> Años</td>
											   <td colspan="1" align="center" class="text-danger" style="font-size: 14px;"><strong>Peso: <?php echo $peso; ?> </td>
									    </tr>
										<tr>
											   <!--<td colspan="4" align="left" class="text-danger" style="font-size: 13px;"><strong>Firma:________________________</strong></td>-->																			  										  
										</tr>                       	
										<?php											
												$pa=mysql_query("SELECT * FROM medicamentos WHERE consulta='$factura'");				
													while($row=mysql_fetch_array($pa)){
														$oPaciente=new Consultar_Paciente($row['paciente']);
														#$oPaciente=new Consultar_Paciente($row['id_paciente']);
											?>		
										<tr>
												<td style="font-size: 13px;" width="20%"></td>
													<td colspan="3" style="font-size: 12px;"><br>
														 <ul>
															<l><strong><?php echo $row['med1']; ?></strong></li><br>
															<?php echo $row['indi1']; ?><br>
															
															<l><strong><?php echo $row['med2']; ?></strong></li><br>
															<?php echo $row['indi2']; ?><br>
														
															<l><strong><?php echo $row['med3']; ?></strong></li><br>
															<?php echo $row['indi3']; ?><br>
															
															<l><strong><?php echo $row['med4']; ?></strong></li><br>
															<?php echo $row['indi4']; ?><br>
															
															<l><strong><?php echo $row['med5']; ?></strong></li><br>
															<?php echo $row['indi5']; ?><br>
															
															<l><strong><?php echo $row['med6']; ?></strong></li><br>
															<?php echo $row['indi6']; ?><br>
															
															<l><strong><?php echo $row['med7']; ?></strong></li><br>
															<?php echo $row['indi7']; ?><br>
															
															<l><strong><?php echo $row['med8']; ?></strong></li><br>
															<?php echo $row['indi8']; ?><br>
															
															<l><strong><?php echo $row['med9']; ?></strong></li><br>
															<?php echo $row['indi9']; ?><br>
															
															<l><strong><?php echo $row['med10']; ?></strong></li><br>
															<?php echo $row['indi10']; ?><br>
															
															<l><strong><?php echo $row['med11']; ?></strong></li><br>
															<?php echo $row['indi11']; ?><br>
															
															<l><strong><?php echo $row['med12']; ?></strong></li><br>
															<?php echo $row['indi12']; ?><br>
															
															<l><strong><?php echo $row['med13']; ?></strong></li><br>
															<?php echo $row['indi13']; ?><br>
															
															<l><strong><?php echo $row['med14']; ?></strong></li><br>
															<?php echo $row['indi14']; ?><br>
															
															<l><strong><?php echo $row['med15']; ?></strong></li><br>
															<?php echo $row['indi15']; ?><br>
															
														</ul>
													</td>
												</tr>                    
										</table>
										<table class="table" width="95%" style="border: 0px solid #660000; -moz-border-radius: 12px;-webkit-border-radius: 12px;padding: 10px;">
						                  <tr>
											   <td colspan="4" align="center" class="text-danger" style="font-size: 12px;"><?php echo $dir_empresa; ?></td>
											</tr>
											<tr>
											   <td colspan="4" align="center" class="text-danger" style="font-size: 12px;"><?php echo $tel_empresa; ?> * <?php echo $pais_empresa; ?> * <?php echo $email; ?> </td>																			  										  
											</tr>                       	
						                </table>             																																						                                                                         
                                    </center>
                                </td>
                        	</tr>
                    	</table>
                    	</div>
                    <!-- Advanced Tables -->                                                                         																			                            																												
										<?php }}} ?>                                    																		
									 								                                                                                               
                    <!--End Advanced Tables -->
                </div>
            </div>
                <!-- /. ROW  --> 
			</div>
        </div>               
    </div>
             <!-- /. PAGE INNER  -->
			 <?php }else{ echo mensajes("NO TIENES PERMISO PARA ENTRAR A ESTE FORMULARIO","rojo"); }?>
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
