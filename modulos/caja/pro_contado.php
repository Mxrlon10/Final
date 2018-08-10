<?php 
	session_start();
	include_once "../php_conexion.php";
	include_once "class/class.php";
	include_once "../funciones.php";
	include_once "../class_buscar.php";
	if($_SESSION['cod_user']){
	}else{
		header('Location: ../../php_cerrar.php');
	}	
	
	$usu=$_SESSION['cod_user'];
	$oPersona=new Consultar_Cajero($usu);
	$cajero_nombre=$oPersona->consultar('nom');
	
	$pa=mysql_query("SELECT * FROM cajero WHERE usu='$usu'");				
	while($row=mysql_fetch_array($pa)){
		$id_consultorio=$row['consultorio'];
		$oConsultorio=new Consultar_Deposito($id_consultorio);
		$nombre_Consultorio=$oConsultorio->consultar('nombre');
	}
	
	if(!empty($_GET['valor_recibido']) and !empty($_GET['neto'])){
		$valor_recibido=limpiar($_GET['valor_recibido']);
		$netoO=limpiar($_GET['neto']);
		$neto=$netoO;
		$fecha=date('Y-m-d');
		$hora=date('H:i:s');
		
		$pa=mysql_query("SELECT * FROM caja_tmp WHERE usu='$usu'");				
		if(!$row=mysql_fetch_array($pa)){	
			header('Location: index.php');
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
		
		
		
		######### SACAMOS EL VALOR MAXIMO DE LA FACTURA Y LE SUMAMOS UNO ##########
		$pa=mysql_query("SELECT MAX(factura)as maximo FROM factura");				
        if($row=mysql_fetch_array($pa)){
			if($row['maximo']==NULL){
				$factura='100000001';
			}else{
				$factura=$row['maximo']+1;
			}
		}	
		
	}
	$paz=mysql_query("SELECT * FROM tarifas WHERE config='df'");				
		while($row=mysql_fetch_array($paz)){
			$preciodf=$row['valor'];
			
		}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Las Perlitas</title>
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
font-size: 16px;"> Fecha de Acceso : <?php echo fecha(date('Y-m-d')); ?> &nbsp; <a href="../../php_cerrar.php" class="btn btn-danger square-btn-adjust">Salir</a> </div>
        </nav>   
           <?php include_once "../../menu/m_caja.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">
				<center><button onclick="imprimir();" class="btn btn-default"><i class=" fa fa-print "></i> Imprimir</button></center><br>
				 <div id="imprimeme">
				 	<div class="table-responsive">	
						<table  width="100%" style="border: 1px solid #660000; -moz-border-radius: 12px;-webkit-border-radius: 12px;padding: 10px;">
		                 <tr>
		                    <td>
								<center>
			                    <img src="../../img/logo.jpg" width="75px" height="75px"><br>
			                    <!--<strong><?php echo $nombre_empresa; ?></strong><br>-->
			                    </center>                                                    
		                    </td>
		                    <td>
							<td align="center">                     
		                        <div style="font-size: 25px;"><strong><em><?php echo $nombre_Consultorio; ?></em></strong></div>
		                        <div style="font-size: 14px;"><strong>ORTODISTA Y TRAUMATOLOGA</strong></div>
		                                    <strong>JVPM 7511</strong><br>
		                                Post-grado Hospital Docente Universitario
		                                     Dr. Dario Contreras, R.D.<br>
		                        <!--<strong><?php echo $nombre_empresa; ?></strong><br>-->                                                 
		                    </td>                                                  
		                    </td>
		                    <td>
		                    	<center>
			                    <img src="../../img/logo_dos.png" width="75px" height="75px"><br>
			                    </center> 
		                    </td>
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
                        <br>
                <!-- /. ROW  -->
			<div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
						<div class="table-responsive">
                        <div class="panel-body">                                                                 	                                                                                               
                          <table class="table table-striped table-bordered table-hover" width="100%" style="font-size: 14px; border: 1px solid #660000; -moz-border-radius: 12px;-webkit-border-radius: 12px;padding: 10px;">
                                        	<tr>
                                            	
                                                <!--<td><strong>Cod. Articulo</strong></td>-->
												<td><strong>CANTIDAD</strong></td>                                              
                                                <td><strong>PACIENTE</strong></td>
                                                <!--<td><strong>Motivo</strong></td>-->
												<!--<td><strong>Categoria</strong></td>-->
                                                <td><div align="right"><strong>COSTO DE CONSULTA</strong></div></td>
                                                <td><div align="right"><strong>TOTAL</strong></div></td>
                                            </tr>
                                            <?php 
												$item=0;
												$neto=0;
												$neto_full=0;
												#$preciodf=0;
												$pa=mysql_query("SELECT * FROM caja_tmp INNER JOIN pacientes ON caja_tmp.paciente=pacientes.id INNER JOIN consultas_medicas ON caja_tmp.paciente=consultas_medicas.id_paciente
												WHERE caja_tmp.usu='$usu' and consultas_medicas.status='PENDIENTE' GROUP BY consultas_medicas.id_paciente");				
										        while($row=mysql_fetch_array($pa)){												
													$item=$item+$row['cant'];
													$cantidad=$row['cant'];
													$nit=$row['paciente'];
													$codigo=$row['paciente'];
													$p_nombre=$row['nombre'];
													$tipo=$row['tipo'];

													$precio='0';                                   																		
													#$oValor=new Consultar_Tarifa($row['ref']);
													############# RUTA ######################
													if($row['ref']==NULL){																				
														#$valor=$oValor->consultar('nombre');
														$valor=$preciodf;
													}else{
														$valor=$row['ref'];
														
													}
													$preciot=$valor;
													$neto=$neto+$preciot;																										
													$importe=$preciot;
													$neto=$neto+$importe;
																										
													 ########################################
													$new_valor=$row['ref'];
													$importe_dos=$preciot;
													$neto_full=$neto_full+$importe_dos;															
																				
													$detalle_sql="INSERT INTO detalle (factura, codigo, nombre, valor, importe, tipo, consultorio)
							                        VALUES ('$factura','$codigo','$p_nombre','$preciot','$importe_dos','$tipo','$id_consultorio')";
					                                mysql_query($detalle_sql);																																																				
											?>
                                            <tr>
                                            	
                                                <!--<td><?php echo $codigo; ?></td>-->
												<td align="center"><?php echo $cantidad; ?></td>                                                
                                                <td><?php echo $p_nombre; ?></td>
                                                <!--<td><?php echo $referencia; ?></td>-->
												<!--<td><?php echo $row['tipo']; ?></td>-->
                                                <td><div align="right">$<?php echo formato($valor); ?></div></td>
                                                <td><div align="right">$<?php echo formato($importe_dos); ?></div></td>
                                            </tr>
											<?php } ?>
                                            <tr>
                                              <td colspan="3"><div align="right"><strong>Total</strong></div></td>
                                              <td><div align="right"><strong>$ <?php echo formato($neto_full); ?></strong></div></td>
                                            </tr>
                                        </table>                                                                                                                          
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
                <!-- /. ROW  -->  
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                     <br>
									<div style="font-size: 10px;" align="center">
										<strong><?php echo $nombre_empresa; ?></strong><br>
										<strong><?php echo $tel_empresa; ?></strong><br>
										<strong><?php echo $pais_empresa; ?></strong><br>
										<strong><?php echo $dir_empresa; ?></strong><br>
									</div>	 
        </div>               
    </div>
             <!-- /. PAGE INNER  -->
            </div>
			</div>
			<?php 
		######## GUARDAMOS LA INFORMACION DE LA FACTURA EN LA TABLA COMPRA
		$fecha=date('Y-m-d');					
		$hora=date('H:i:s');
		#mysql_query("INSERT INTO fac_operacion (factura,valor,fecha,estado,usu) VALUE ('$factura','$netoO','$fecha','s','$usu')");
		mysql_query("INSERT INTO factura (factura,valor,fecha,estado,consultorio,usu) VALUE ('$factura','$neto_full','$fecha','s','$id_consultorio','$usu')");
		
		$mensaje='Operacion al Contado';
		mysql_query("INSERT INTO resumen (paciente,concepto,factura,clase,valor,tipo,fecha,hora,status,usu,consultorio,estado) VALUE ('$codigo','$mensaje','$factura','CONSULTA','$neto_full','$tipo','$fecha','$hora','CANCELADO','$usu','$id_consultorio','s')");
		#mysql_query("INSERT INTO resumen (concepto,clase,valor,tipo,fecha,hora,usu,estado) VALUE ('$mensaje','DESPERDICIO','$neto_full','DESPERDICIO','$fecha','$hora','$usu','s')");
										
		mysql_query("DELETE FROM caja_tmp WHERE usu='$usu'");
		mysql_query("Update citas_medicas Set status='PROCESADO' Where id_paciente='$nit'");	
		mysql_query("Update consultas_medicas  Set status='PROCESADO' Where id_paciente='$nit'");	
		
		
		
	?>
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
