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
		$usu=limpiar($_SESSION['cod_user']);
		
		$usu=$_SESSION['cod_user'];
	$pa=mysql_query("SELECT * FROM cajero WHERE usu='$usu'");				
	while($row=mysql_fetch_array($pa)){
		$id_consultorio=$row['consultorio'];
		$oConsultorio=new Consultar_Deposito($id_consultorio);
		$nombre_Consultorio=$oConsultorio->consultar('nombre');
	}
		
		$pa=mysql_query("SELECT * FROM pacientes WHERE consultorio='$id_consultorio' and id='$factura'");				
		if($row=mysql_fetch_array($pa)){			
			$nombre=$row['nombre'];
			$direccion=$row['direccion'];
			$telefono=$row['telefono'];
			$edad=$row['edad'];
			$refpor=$row['refpor'];
			$sexo=$row['sexo'];
			$alergia=$row['alergia'];
			$enf_cro=$row['enf_cro'];
			$cuadro_vac=$row['cuadro_vac'];
			$ant_quir=$row['ant_quir'];				
			$nomp=$row['nomp'];				
			$nomm=$row['nomm'];				
			$edad=$row['edad'];				
			$feccita=$row['feccita'];				
			$seguro=$row['seguro'];				
			$estado=$row['estado'];			
		}else{
			header('Location:error.php');
		}
		
	}
	
	$usu=$_SESSION['cod_user'];
	
	$oPersona=new Consultar_Cajero($usu);
	$cajero_nombre=$oPersona->consultar('nom');
	$fecha=date('Y-m-d');
	$hora=date('H:i:s');
	
	$pa=mysql_query("SELECT * FROM cajero WHERE usu='$usu'");				
	while($row=mysql_fetch_array($pa)){
		$id_bodega=$row['consultorio'];
		$oDeposito=new Consultar_Deposito($id_bodega);
		$nombre_deposito=$oDeposito->consultar('nombre');
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
           <?php include_once "../../menu/m_pacientes.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">						                
                <div align="center">
                    <div class="btn-group">
                      <a href="../pacientes/index.php" class="btn btn-danger" title="Regresar"><i class="fa fa-users" ></i><strong> Pacientes</strong></a>
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
                        <div style="font-size: 25px;"><strong><em><?php echo $nombre_medico; ?></em></strong></div>
                        <div style="font-size: 14px;"><strong><?php echo $nombre_Consultorio; ?></strong></div>
                                   
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
                <div style="font-size: 12px;">
                    	<strong>PACIENTE: </strong><?php echo $nombre; ?><br>
	                    <strong>FECHA: </strong><?php echo fecha($fecha); ?> ||  
	                    <strong>HORA: </strong><?php echo date($hora); ?><br>
	                    <strong>USUARIO: </strong><?php echo $cajero_nombre; ?>
						</div>
						<hr/>
                        <div style="font-size: 14px;"align="center">
                         <strong>PERFIL DEL PACIENTE</strong><br>                              
		                </div> 
		                <hr/>				
                    <!-- /. TABLA  -->									
				<div class="col-md-6 col-sm-6">
				<div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" width="100%" style="font-size: 12px; border: 1px solid #660000; -moz-border-radius: 12px;-webkit-border-radius: 12px;padding: 10px;">
			                 <tr align="center">
			                 <td colspan="2"><strong>INFORMACIÓN PERSONAL</strong></td><br>
			                 </tr>
			                 <tr>
			                    <td><br>
			                    <!-- Advanced Tables -->                                           				
									    <strong>PACIENTE: </strong><?php echo $nombre; ?><br><br>
										<strong>DIRECCION: </strong><?php echo $direccion; ?><br><br>                               
										<strong>TEL: </strong><?php echo $telefono; ?><br><br>                                   
										<strong>EDAD: </strong><?php echo CalculaEdad($edad); ?> AÑOS<br><br>                                   
										<strong>SEXO: </strong><?php echo sexo($sexo); ?><br><br>                                   
										<strong>FECHA DE NACIMIENTO: </strong><?php echo fecha($edad); ?><br><br>                                     
																		                  																												
																				                                                                      
			                    </td>
								<td>
			                    <!-- Advanced Tables -->                                           				
									    <strong>NOMBRE DEL PADRE: </strong><?php echo $nomp; ?><br><br>
										<strong>NOMBRE DE LA MADRE: </strong><?php echo $nomm; ?><br><br>                                                          
										<strong>FECHA PRIMERA CITA: </strong><?php echo fecha($feccita); ?><br><br>                                   
										<strong>SEGURO: </strong><?php echo seguro($seguro); ?><br><br>                                   
										<strong>REFERIDO POR: </strong><?php echo $refpor; ?><br><br>
										<strong>ESTADO: </strong><?php echo estado($estado); ?><br>																						                                                                      
			                    </td>
			                    </tr>			                  
			                    </table>	
                            </div>                                                                                         
                </div><br>
                <div class="col-md-6 col-sm-6">
				<div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" width="100%" style="font-size: 12px; border: 1px solid #660000; -moz-border-radius: 12px;-webkit-border-radius: 12px;padding: 10px;">
			                 <tr align="center">
			                 <td colspan="2"><strong>CUADRO CLINICO</strong></td>
			                 </tr>
			                 <tr>
			                    <td>
			                    <!-- Advanced Tables -->                                           				
									    <strong>Alergias: </strong><?php echo $alergia; ?><br><br>
										<strong>Enfermedades Cronicas: </strong><?php echo $enf_cro; ?><br><br>
										<strong>Cuadro de Vacunas: </strong><?php echo $cuadro_vac; ?><br><br>                                   
										<strong>Antecedentes Quirurgicos: </strong><?php echo $ant_quir; ?><br><br>                                      									                  																												
																				                                                                      
			                    </td>
			                    </tr>			                  
			                    </table>	
                            </div>                                                                                         
                </div><br>
                <div style="font-size: 14px;" align="center">
										<strong><?php echo $nombre_empresa; ?></strong><br>
										<strong><?php echo $tel_empresa; ?></strong><br>
										<strong><?php echo $pais_empresa; ?></strong><br>
										<strong><?php echo $dir_empresa; ?></strong><br>
				</div>	 
						
			 </div>
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
