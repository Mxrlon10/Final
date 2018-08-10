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
		$nombre_consultorio=$oConsultorio->consultar('nombre');
	}
	
	######### TRAEMOS LOS DATOS DE LA EMPRESA #############
		$pa=mysql_query("SELECT * FROM empresa WHERE id='$id_consultorio'");				
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
           <?php include_once "../../menu/m_consulta_medica.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">
                 <!-- /. ROW  -->
<?php if(permiso($_SESSION['cod_user'],'3')==TRUE){ ?>
				 <center><button onclick="imprimir();" class="btn btn-success"><i class=" fa fa-print "></i> Imprimir</button></center>
				 <div id="imprimeme"><br>
				  <div class="table-responsive">	
				<table  width="100%" style="border: 0px solid #660000; -moz-border-radius: 12px;-webkit-border-radius: 12px;padding: 10px;">
				<?php											
					$pa=mysql_query("SELECT * FROM consultas_medicas WHERE id='$factura'");				
						while($roww=mysql_fetch_array($pa)){
							$oPaciente=new Consultar_Paciente($roww['id_paciente']);
							#$oPaciente=new Consultar_Paciente($row['id_paciente']);

				?>
                 <tr>
                    <td>
						<center>
	                    <img src="../../img/logo.jpg" width="130px" height="130px"><br>
	                    <!--<strong><?php echo $nombre_empresa; ?></strong><br>-->
	                    </center>                                                    
                    </td>
                    <td>
					<td align="center">                     
                        <div style="font-size: 20px;"><strong><em>Dra. <?php echo $nombre_medico; ?></em></strong></div>
                        <div style="font-size: 14px;"><strong><?php echo $nombre_consultorio; ?></strong></div>
                                    <strong>J.V.P.M 10606</strong><br>
                                Post-Grado Hospital Infantil de México Federico Gómez<br>
                        <!--<strong><?php echo $nombre_empresa; ?></strong><br>-->                                                 
                    </td>                                                  
                    </td>
                   <!-- <td>
                    	<center>
	                    <img src="../../img/logo_dos.png" width="75px" height="75px"><br>
	                    </center> 
                    </td>-->
                 </tr>                       	
                </table>
				</div>
                <hr/>
                <div style="font-size: 14px;"align="center">
                     <strong>DETALLE DE CONSULTA GENERAL</strong><br>                              
                </div> 
                <hr/>  
                    <!-- /. TABLA  -->
                    	<div style="font-size: 12px;">
                    	<strong>EXPEDIENTE: </strong><?php echo $factura; ?><br>				
                        <strong>PACIENTE: </strong><?php echo $oPaciente->consultar('nombre'); ?><br>
                        <strong>DIRECCION: </strong><?php echo $oPaciente->consultar('direccion'); ?><br>
                        <strong>TELEFONO: </strong><?php echo $oPaciente->consultar('telefono'); ?><br>
                        <strong>FECHA: </strong><?php echo fecha($fecha); ?> ||  
                        <strong>HORA: </strong><?php echo date($hora); ?><br>
                        <strong>USUARIO: </strong><?php echo $cajero_nombre; ?><br> 
						</div>
						<hr/>
			
            <div class="row">
                <div class="col-md-12">
                 <div class="table-responsive">	
				
				<table class="table table-striped table-bordered table-hover" width="100%" style="font-size: 12px; border: 1px solid #660000; -moz-border-radius: 12px;-webkit-border-radius: 12px;padding: 10px;">
                 <tr>
                    <td>
                    <!-- Advanced Tables -->                                           				
								             <dl>
											  <dt><strong>MOTIVO DE CONSULTA:</strong></dt>
											  <dd><?php echo $roww['sintomas']; ?>.</dd><br>
											  <dt><strong>EXAMEN FÍSICO:</strong></dt>
											  <dd><?php echo $roww['observaciones']; ?>.</dd><br>
											  <dt><strong>DIAGNOSTICO:</strong></dt>
											  <dd><?php echo $roww['diagnostico']; ?>.</dd><br>
											  <dt><strong>TRATAMIENTO:</strong></dt>
											  <dd><?php echo $roww['tratamiento']; ?>.</dd>
											</dl>
			    </td>
                    </tr>
                    </table><br>
				<table class="table table-striped table-bordered table-hover" width="100%" style="font-size: 12px; border: 1px solid #660000; -moz-border-radius: 12px;-webkit-border-radius: 12px;padding: 10px;">
                 <tr>
                    <td>
											<div class="panel panel-danger">
											  <div class="panel-heading">
												<h4 class="panel-title">MEDICAMENTOS:</h4>
											  </div>
											  <div class="panel-body">
											   <?php											
													$pa=mysql_query("SELECT * FROM medicamentos WHERE consulta='$factura'");				
														while($row=mysql_fetch_array($pa)){
															$oPaciente=new Consultar_Paciente($row['paciente']);
															#$oPaciente=new Consultar_Paciente($row['id_paciente']);
												?>		
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
											  </div>
											</div>                  																												
										<?php }} ?>
										<div align="right">
					                        <strong>F.____________________________</strong><br>
					                                 <?php echo $nombre_medico; ?>
					                    </div> 										                                                                      
                    <!--End Advanced Tables -->
					</td>
                    </tr>
                    </table>
                    </div>
                </div>
            </div>
                <!-- /. ROW  -->
               <br>
                <div style="font-size: 14px;" align="center">
					<strong><?php echo $nombre_empresa; ?></strong><br>
					<strong><?php echo $tel_empresa; ?></strong><br>
					<strong><?php echo $pais_empresa; ?></strong><br>
					<strong><?php echo $dir_empresa; ?></strong><br>
				</div>				
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
