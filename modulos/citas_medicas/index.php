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
	$id_medico=$_SESSION['cod_user'];
	$usu=$_SESSION['cod_user'];
	$oPersona=new Consultar_Cajero($usu);
	$cajero_nombre=$oPersona->consultar('nom');
	
	$fechay=date('Y-m-d');
	$horay=date('H:m:s');
	
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
		}
	
	if(!empty($_GET['del'])){
		$id=$_GET['del'];
		mysql_query("DELETE FROM citas_medicas WHERE status='PENDIENTE' and id='$id'");
		header('index.php');
		
	}
	#paginar
        $maximo=15;
        if(!empty($_GET['pag'])){
            $pag=limpiar($_GET['pag']);
        }else{
            $pag=1;
        }
        $inicio=($pag-1)*$maximo;
        
        $cans=mysql_query("SELECT COUNT(id)as total FROM citas_medicas");
        if($dat=mysql_fetch_array($cans)){
            $total=$dat['total']; #inicializo la variable en 0
        }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $nombre_empresa; ?></title>
	<!-- BOOTSTRAP STYLES-->
    <link href="../../assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="../../assets/css/font-awesome.css" rel="stylesheet" />
     <!-- CALENDARIO STYLES-->
   <link href="../../assets/todo/bootstrap-datetimepicker.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="../../assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="../../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
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
           <?php include_once "../../menu/m_citas_medica.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">						                				
<?php if(permiso($_SESSION['cod_user'],'2')==TRUE){ ?>					 
				  <!--  Modals-->
                     <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<form name="form1" method="post" action="">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										
                                            <h3 align="center" class="modal-title" id="myModalLabel">NUEVA CITA</h3>
                                        </div>
										<div class="panel-body">
										<div class="row">                                       
											<div class="col-md-6">
												<!--<form name="form1" method="post" action="">
												  <label>
												  <input type="text" autofocus class="form-control" id="id_paciente" name="id_paciente" list="characters" placeholder="Codigo o Nombre" autocomplete="off">
													  <datalist id="characters">
													  <?php $can=mysql_query("SELECT * FROM pacientes");while($dato=mysql_fetch_array($can)){echo '<option value="'.$dato['nombre'].'">';}?>
													</datalist>
													</label>
												</form><br>-->
								
												<label>Paciente:</label>												
												<select class="form-control" name="id_paciente" required>
												<option value="" selected disabled>---SELECCIONE---</option>
                                                	<?php
														$sal=mysql_query("SELECT * FROM pacientes WHERE consultorio='$id_consultorio' and estado='s'");				
														while($col=mysql_fetch_array($sal)){
															echo '<option value="'.$col['id'].'">'.$col['nombre'].'</option>';
														}
													?>
                                                </select><br>
												<select class="form-control" name="tipo" autocomplete="off" required>
													<option value="" selected disabled>--CONSULTA--</option>
													<option value="GEN">CONSULTA GENERAL</option>
													<option value="NP">CONTROL PRENATAL</option>
													<!--<option value="EP">ECOGRAFIA PROSTATICA</option>
													<option value="UM">ULTRASONIDO DE MAMAS</option>													
													<option value="UEM">ULTRASONOGRAFIA EMBARAZO</option>													
													<option value="UABD">ULTRASONOGRAFIA ABDOMINAL</option>													
													<option value="UG">ULTRASONOGRAFIA GINECOLOGICA</option>
													<option value="CPREN">CONTROL PRENATAL</option>
													<option value="CPED">CONTROL PEDIATRIA</option>	-->																									
												</select><br>												            																																
											</div>
											<div class="col-md-6"><br>
												<div class='input-group date form_date' id='form_date' data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
													<input type='text' name="fechai" id="form_date" class="form-control" placeholder="Fecha Proxima Cita" onfocus="(this.type='')" required autocomplete="off" />
													<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
												</div>
												<input type="hidden" id="dtp_input2" name="fechai" /><br/>  
												<div class='input-group date form_time' id='form_time' data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
													<input type='text' name="horario" id="form_time" class="form-control" placeholder="Horario" onfocus="(this.type='')" required autocomplete="off" />
													<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
												</div>
												<input type="hidden" id="dtp_input3" name="horario" /><br/>       												
												<!--<input type="date" class="form-control" name="fechai" min="1"  autocomplete="off" required><br>-->																															
											</div>                                                                        
										</div> 
										</div> 
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>										 
                                    </div>
                                </div>
								</form>
                            </div>
                     <!-- End Modals-->
					 
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            CITAS
							<ul class="nav pull-right">
								<a href="" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal" title="Agregar"><i class="fa fa-plus"> </i> <strong>Nueva</strong></a>								                            																										                            
							</ul>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
								<?php 
									if(!empty($_POST['id_paciente'])){ 												
										$id_paciente=limpiar($_POST['id_paciente']);																											
										$fechai=limpiar($_POST['fechai']);																																																						
										$horario=limpiar($_POST['horario']);																																																						
										$tipo=limpiar($_POST['tipo']);
										$fecha=date('Y-m-d');
										$hora=date('H:i:s');
										$status='PENDIENTE';
										$consulta='PENDIENTE';
										
																						
										if(empty($_POST['id'])){
											$oCita=new Proceso_Cita('',$id_paciente,$id_medico,$id_consultorio,$fechai,$tipo,$fecha,$hora,$horario,$status,$consulta);
											$oCita->crear();
											echo mensajes('Cita Medica Guardada con Exito','verde');
										}else{
											$id=limpiar($_POST['id']);
											$oCita=new Proceso_Cita($id,$fechai,$tipo,$horario);
											$oCita->actualizar();
											echo mensajes('Cita Medica Actualizada con Exito','verde');
										}
									}
									if(!empty($_POST['idx']) and !empty($_POST['fechai'])){
											$idx=limpiar($_POST['idx']);																											
											$fechai=limpiar($_POST['fechai']);																																																						
											$horario=limpiar($_POST['horario']);																																																						
											$tipo=limpiar($_POST['tipo']);										
											mysql_query("UPDATE citas_medicas SET fechai='$fechai',
																				  tipo='$tipo',
																				  horario='$horario' 
																				   WHERE id='$idx'
																				   ");
											echo mensajes('Cita Medica Actualizada con Exito','verde');
									}

								?>
								<div class="col-md-12 col-sm-6">
				                    <div class="panel panel-default">
				                    <?php 
			                                if(!empty($_GET['fechaf']) and !empty($_GET['fechai'])){
			                                    $fechai=limpiar($_GET['fechai']);
			                                    $fechaf=limpiar($_GET['fechaf']);

			                                }else{
			                                    
			                                    $fechai=date('Y-m-d');
			                                    $fechaf=date('Y-m-d');
			                                }
			                            ?>                      
				                        <div class="panel-body">
										<form name="form1" action="" method="get" class="form-inline">
				                           <div class="panel-body">
										   <div class="row"> 
				                                <div class="col-md-4">
				                                    <strong>Fecha Inicial</strong><br>
				                                    <input class="form-control" value="<?php echo $fechai; ?>" name="fechai" type="date" autocomplete="off" required>
				                                </div>
				                                <div class="col-md-4">
				                                    <strong>Fecha Finalizacion</strong><br>
				                                    <input class="form-control" value="<?php echo $fechaf; ?>" name="fechaf" type="date" autocomplete="off" required>
				                                </div>
				                                <div class="col-md-4" align="left"><br>
				                                    <button type="submit" class="btn btn-primary"><i class="icon-search"></i> <strong>Consultar</strong></button>
				                                </div>
				                            </div>
				                           </div>
							            </form>                                 
				                        </div>
				                    </div>
				                </div><br>	
                                <table class="table table-striped table-bordered table-hover" style="font-size:12px; font-family:Times New Roman;">
                                    
									<thead>
                                        <tr>
                                            <th>#</th>
                                            <th>PACIENTE</th>                                                                                                                              
                                            <th>FECHA DE PROXIMA CITA</th>                                                                                      
                                            <th>MED/ASIST.</th>                                                                                      
                                            <th>CONSULTA</th>                                                                                      
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 											
											$pame=mysql_query("SELECT * FROM citas_medicas WHERE consultorio='$id_consultorio' AND fecha between '$fechai' AND '$fechaf' LIMIT $inicio, $maximo");		 						
											while($row=mysql_fetch_array($pame)){
											$oPaciente=new Consultar_Paciente($row['id_paciente']);
							                #$oMedico=new Consultar_Medico($row['id_medico']);
											$url=$row['id'];									
											############# STATUS FULL ######################
											if($row['status']=='PENDIENTE'){
												
												 $status='<span class="label label-warning">PENDIENTE</span>';
												  $modal='#actualizar';
												  $modald='#eliminar';
											}else{
												$status='<span class="label label-success">ATENDIDO</span>';
												$modal='#mensaje';
												$modald='#mensajed';
											}
											$pamela=strftime( "%Y-%m-%d-%H-%M-%S", time() );										
											if($row['fechai']==$pamela){
													$status='si';
												}																								
												elseif($row['fechai']>$pamela){
													$status='<span class="label label-danger">PENDIENTE</span>';
												}
												$horario=$row['horario'];
										?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $row['id']; ?></td>
                                            <td><i class="fa fa-user fa-2x"></i> <?php echo $oPaciente->consultar('nombre'); ?></td>                                                                                   
                                            <td><?php echo fecha($row['fechai']).' '.$row['horario']; ?></td>
											<td><?php echo consultar('nom','persona',' doc='.$row['id_medico']); ?></td>  
											<td><?php echo $status; ?></td>  
                                            <td class="center">
											<div class="btn-group">
											  <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
											  <ul class="dropdown-menu pull-right">
												<li><a href="#" data-toggle="modal" data-target="<?php echo $modal; ?><?php echo $row['id']; ?>"><i class="fa fa-edit"></i> Editar</a></li>
												<li class="divider"></li>
												<li><a  href="#" data-toggle="modal" data-target="<?php echo $modald; ?><?php echo $row['id']; ?>"><i class="fa fa-pencil"></i> Eliminar</a></li>																																				
											  </ul>
											</div>
											</td>
											<!--  Modals-->
										 <div class="modal fade" id="actualizar<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form2" method="post" action="">
												<input type="hidden" name="idx" value="<?php echo $row['id']; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															
																<h3 align="center" class="modal-title" id="myModalLabel">MODIFICAR CITA</h3>
															</div>
															<div class="panel-body">
															<div class="row">                                       
																<div class="col-md-6">
																	<label>Paciente:</label>
																		<select class="form-control" name="id_paciente" disabled >
																			<option>---SELECCIONE---</option>
																			<?php
																				$p=mysql_query("SELECT * FROM pacientes WHERE estado='s'");				
																				while($r=mysql_fetch_array($p)){
																					if($r['id']==$row['id_paciente']){
																						echo '<option value="'.$r['id'].'" selected>'.$r['nombre'].'</option>';
																					}else{
																						echo '<option value="'.$r['id'].'">'.$r['nombre'].'</option>';
																					}
																				}
																			?>
																		</select><br>
																		<label>Tipo:</label>
																		<select class="form-control" name="tipo" autocomplete="off" required>											
																			<option value="GEN" <?php if($row['tipo']=='GEN'){ echo 'selected'; } ?>>CONSULATA GENERAL</option>
																			<option value="GEN" <?php if($row['tipo']=='GEN'){ echo 'selected'; } ?>>CONTROL PRENATAL</option>
																			<!--<option value="EP" <?php if($row['tipo']=='EP'){ echo 'selected'; } ?>>ECOGRAFIA PROSTATICA</option>
																			<option value="UM" <?php if($row['tipo']=='UM'){ echo 'selected'; } ?>>ULTRASONIDO DE MAMAS</option>													
																			<option value="UEM" <?php if($row['tipo']=='UEM'){ echo 'selected'; } ?>>ULTRASONOGRAFIA EMBARAZO</option>													
																			<option value="UABD" <?php if($row['tipo']=='UABD'){ echo 'selected'; } ?>>ULTRASONOGRAFIA ABDOMINAL</option>													
																			<option value="UG" <?php if($row['tipo']=='UG'){ echo 'selected'; } ?>>ULTRASONOGRAFIA GINECOLOGICA</option>
																			<option value="CPREN" <?php if($row['tipo']=='CPREN'){ echo 'selected'; } ?>>CONTROL PRENATAL</option>
																			<option value="CPED" <?php if($row['tipo']=='CPED'){ echo 'selected'; } ?>>CONTROL PEDIATRIA</option>-->
																		</select><br>																																																																									
																		</div>
																<div class="col-md-6">
																		<label>Fecha:</label>
																		<div class="input-group date form_date" data-link-format="yyyy-mm-dd">													 						
																			<input type="text" class="form-control" name="fechai" autocomplete="off" required min="1" value="<?php echo $row['fechai']; ?>" ><br>
																			<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
																			<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
																		</div><br>																		
																		<label>Horario:</label>																		
																		<div class="input-group date form_time" data-link-format="hh:ii">											 						
																			<input type="text" class="form-control" name="horario" autocomplete="off" required min="1" value="<?php echo $row['horario']; ?>"><br>
																			<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
																			<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
																		</div><br>											
																</div>                                                                        
															</div> 
															</div> 
															<div class="modal-footer">
																<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
																<button type="submit" class="btn btn-primary">Guardar</button>
															</div>										 
														</div>
													</div>
													</form>
												</div>
										 <!-- End Modals-->
										 <!--  Modals-->
										 <div class="modal fade" id="mensaje<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form2" method="post" action="">
												<input type="hidden" name="idx" value="<?php echo $row['id']; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															
																<h3 align="center" class="modal-title" id="myModalLabel">MODIFICAR CITA</h3>
															</div>
															<div class="panel-body">
															<div class="row" align="center">                                       
																<strong>Hola! <?php echo $cajero_nombre; ?></strong><br><br>
														<div class="alert alert-danger">
																	<h4>NO SE PUEDE REALIZAR ESTA ACCIÒN<br><br> 
																	LA CITA HA SIDO PROCEDADA [ <?php echo fecha($row['fechai']).' '.$row['horario']; ?> ]<br> 
																	</h4>
														</div>                                                                        
															</div> 
															</div> 
															<div class="modal-footer">
																<button type="submit" class="btn btn-primary">Aceptar</button>
															</div>										 
														</div>
													</div>
													</form>
												</div>
										 <!-- End Modals-->
										 <!--  Modals-->
										 <div class="modal fade" id="mensajed<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form2" method="post" action="">
												<input type="hidden" name="idx" value="<?php echo $row['id']; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															
																<h3 align="center" class="modal-title" id="myModalLabel">ELIMINAR CITA</h3>
															</div>
															<div class="panel-body">
															<div class="row" align="center">                                       
																<strong>Hola! <?php echo $cajero_nombre; ?></strong><br><br>
														<div class="alert alert-danger">
																	<h4>NO SE PUEDE REALIZAR ESTA ACCIÒN<br><br> 
																	LA CITA HA SIDO PROCEDADA [ <?php echo fecha($row['fechai']).' '.$row['horario']; ?> ]<br> 
																	</h4>
														</div>                                                                        
															</div> 
															</div> 
															<div class="modal-footer">
																<button type="submit" class="btn btn-primary">Aceptar</button>
															</div>										 
														</div>
													</div>
													</form>
												</div>
										 <!-- End Modals-->
										 <!-- Modal -->           			
												<div class="modal fade" id="eliminar<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">													
													<form name="contado" action="index.php?del=<?php echo $row['id']; ?>" method="get">													
													<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
													<div class="modal-dialog">
													<?php if(permiso($_SESSION['cod_user'],'2')==TRUE){ ?>	
														<div class="modal-content">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>													
																			<h3 align="center" class="modal-title" id="myModalLabel">Seguridad</h3>
																		</div>
															<div class="panel-body">
															<div class="row" align="center">                                       
																										
																<strong>Hola! <?php echo $cajero_nombre; ?></strong><br><br>
																<div class="alert alert-danger">
																	<h4>¿Esta Seguro de Realizar esta Acción?<br><br> 
																	una vez Eliminada la cita Medica con fecha <strong>[ <?php echo fecha($row['fecha']); ?> ]</strong><br>
																	con paciente <strong>[ <?php echo $oPaciente->consultar('nombre'); ?> ]</strong>
																	no podran ser Recuperados sus datos.<br>
																	Tenga en cuenta que si la cita fue procesada no podra ser eliminada.
																	</h4>
																</div>																																																																																																								
															</div> 
															</div> 
															<div class="modal-footer">
																<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
																<a href="index.php?del=<?php echo $row['id']; ?>"  class="btn btn-danger" title="Eliminar">
																	<i class="fa fa-times" ></i> <strong>Eliminar</strong>
																</a>																
															</div>										 
														</div>
														<?php }else{ echo mensajes("NO TIENES PERMISO PARA REALIZAR ESTA ACCION","rojo"); }?>
													</div>
													</form>
													
												</div>
										 <!-- End Modals-->       	
                                        </tr> 																																								
											<?php } ?>
                                    </tbody>
									
                                </table>
                                <div align="center">
                                    <ul class="pagination pagination-split" >
                                        <?php
                                        if(empty($_POST['bus'])){
                                            $tp = ceil($total/$maximo);#funcion que devuelve entero redondeado
                                            for ($n=1; $n<=$tp ; $n++){
                                                if($pag==$n){
                                                    echo '<li class="active"><a href="index.php?pag='.$n.'"><strong>'.$n.'</strong></a></li>';   
                                                }else{
                                                    echo '<li><a href="index.php?pag='.$n.'"><strong>'.$n.'</strong></a></li>';  
                                                }
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>			
								
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
                <!-- /. ROW  -->
<?php }else{ echo mensajes("NO TIENES PERMISO PARA ENTRAR A ESTE FORMULARIO","rojo"); }?>				
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
	<!-- CALENDARIO SCRIPTS -->
    <script src="../../assets/todo/bootstrap-datetimepicker.js"></script>
    <script src="../../assets/todo/locales/bootstrap-datetimepicker.es.js"></script>
	<!-- VALIDACIONES -->
	<script src="../../assets/js/jasny-bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
     <!-- DATATIMEPICKER -->
   <script  src="../../assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
   <script  src="../../assets/js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
   <script type="text/javascript">
        $(function () {
           $('#form_date').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('#form_time').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
    $('#form_datex').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
    $('#form_timex').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });		
        });
   </script>
         <!-- CUSTOM SCRIPTS -->
    <script src="../../assets/js/custom.js"></script>
</body>
</html>
