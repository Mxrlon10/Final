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
			
		}					
	$oPersona=new Consultar_Cajero($usu);
	$cajero_nombre=$oPersona->consultar('nom');
	$fecha=date('Y-m-d');
	$hora=date('H:i:s');		
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
                 <!-- /. ROW  -->
<?php if(permiso($_SESSION['cod_user'],'3')==TRUE){ ?>
                 <div align="center">
                    <div class="btn-group">
                      <a href="../pacientes/index.php" class="btn btn-danger" title="Pacientes"><i class="fa fa-users" ></i><strong> Pacientes</strong></a> 
                      <button type="button" onclick="imprimir();" class="btn btn-success"><i class=" fa fa-print "></i> Imprimir</button>
                      <!--<button type="button" class="btn btn-default"><i class=" fa fa-list"></i> PDF</button>-->
                    </div>
                </div><br>
				 <div id="imprimeme">
                <div class="table-responsive">  
                <table  width="100%" style="border: 0px solid #660000; -moz-border-radius: 13px;-webkit-border-radius: 12px;padding: 10px;">
                 <tr>
                    <td>
                        <center>
                        <img src="../../img/logo.jpg" width="130px" height="130px"><br>
                        <!--<strong><?php echo $nombre_empresa; ?></strong><br>-->
                        </center>                                                    
                    </td>
                    <td align="center">                     
                        <div style="font-size: 20px;"><strong><em>Dra. <?php echo $nombre_medico; ?></em></strong></div>
                        <div style="font-size: 14px;"><strong><?php echo $nombre_Consultorio; ?></strong></div>
                                    <strong>J.V.P.M 10606</strong><br>
                                 Post-Grado Hospital Infantil de México Federico Gómez<br>
                        <!--<strong><?php echo $nombre_empresa; ?></strong><br>-->                                                 
                    </td>
                    <!--<td>
                        <center>
                        <img src="../../img/logo_dos.png" width="130px" height="130px"><br>
                        </center> 
                    </td>-->
                 </tr>                          
                </table>
                </div>                       
                <hr/>
                    <!-- /. TABLA  -->
                <div style="font-size: 12px;">					
				<strong>PACIENTE: </strong><?php echo $nombre; ?><br>
                <strong>DIRECCION: </strong><?php echo $direccion; ?><br>
                <strong>TELEFONO: </strong><?php echo $telefono; ?><br>
                <strong>FECHA: </strong><?php echo fecha($fecha); ?> ||  
                <strong>HORA: </strong><?php echo date($hora); ?><br>
                <strong>USUARIO: </strong><?php echo $cajero_nombre; ?>
                </div>
                 <hr/>
                  <div style="font-size: 14px;"align="center">
                     <strong>PAGOS REALIZADOS</strong><br>                              
                </div> 
                <hr/>      
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->                    
                            <div class="table-responsive">								
                                <table class="table table-striped table-bordered table-hover" width="100%"  style="font-size: 12px; border: 1px solid #660000; -moz-border-radius: 10px;-webkit-border-radius: 12px;padding: 10px;">                                    
									<thead>
                                        <tr align="center">
                                            <th>FECHA Y HORA</th>                                            
                                            <th>FACTURA</th>
                                            <th>VALOR</th>                                                                                       
                                            <th>SERVICIO</th>
                                            <th>MEDICO</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
											$total=0;
											$pa=mysql_query("SELECT * FROM resumen WHERE consultorio='$id_consultorio' and paciente='$factura'");				
												while($row=mysql_fetch_array($pa)){
													$oPaciente=new Consultar_Paciente($row['paciente']);
													$url=$row['factura'];
                                                    $tipo=$row['tipo'];
													$total=$total+$row['valor'];
                                                ################# CONDICIONALES PARA EDITAR FORMULARIO ####################

										?>
                                        <tr class="odd gradeX">
                                            <td><?php echo fecha($row['fecha']).' '.$row['hora']; ?></td>                                            
                                            <td><?php echo $row['factura']; ?></td>
                                              <td><?php echo $s.' '.formato($row['valor']); ?></td>                                                                                    
                                            <td><?php echo tip_consulta($row['tipo']); ?></td>                                                                                   
                                            <td><?php echo $nombre_medico; ?></td>                                                                                   
                                            <td>
											<a href="../detalle/detalle_two.php?detalle=<?php echo $url; ?>"  class="btn btn-info btn-sm" title="Detalle">
                                            <i class="fa fa-list-alt" ></i>
                                            </a>    
											</td>                                                                                                                               
                                        </tr> 																														
										<?php } ?>
                                    </tbody>
                                           <?php 
                                                $paX=mysql_query("SELECT * FROM resumen WHERE consultorio='$id_consultorio' and paciente='$factura'");               
                                                if(!$row=mysql_fetch_array($paX)){
                                            ?>
                                         <tr><div class="alert alert-danger" align="center"><strong>NO SE ENCONTARON REGISTROS DE PAGOS</strong></div></tr>
                                         <?php } ?>
									<tr>
										<td colspan="2" align="right">Total:</td>
										<td><?php echo $s.' '.formato($total); ?></td>
									</tr> 
                                </table><br><br><br><br>
                                <div align="right">
                                    <strong>F.___________________________</strong><br>
                                            <?php echo $nombre_medico; ?><br>
                                </div>   
									 <hr/>
									 <center> 
                                    <div style="font-size: 14px;">
                                        <strong><?php echo $nombre_empresa; ?></strong><br>
                                        <strong><?php echo $tel_empresa; ?></strong><br>
                                        <strong><?php echo $pais_empresa; ?></strong><br>
                                        <strong><?php echo $dir_empresa; ?></strong><br>
                                    </div>
                                    </center>


                            </div>                                                                     
                    <!--End Advanced Tables -->
                </div>
            </div>
                <!-- /. ROW  --> 
<?php }else{ echo mensajes("NO TIENE PERMISO PARA VISUALIZAR A ESTE FORMULARIO","rojo"); }?>
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
