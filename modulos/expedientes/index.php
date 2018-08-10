<?php 
	session_start();
	include_once "../php_conexion.php";
	include_once "class/class.php";
	include_once "../citas_medicas/class/class.php";
	include_once "../funciones.php";
	include_once "../class_buscar.php";
	#$documento=limpiar($_SESSION['cod_user']);
	if($_SESSION['cod_user']){
	}else{
		header('Location: ../../php_cerrar.php');
	}
	$id_medico=$_SESSION['cod_user'];
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
		}
	######### TRAEMOS LOS DATOS DE CONSULTORIO #############
		$pax=mysql_query("SELECT * FROM consultorios WHERE id=$id_consultorio");				
        if($row=mysql_fetch_array($pax)){
			$nombre_medico=$row['encargado'];
			
		}	
	
	if(!empty($_GET['del'])){
		$id=$_GET['del'];
		mysql_query("DELETE FROM citas_medicas WHERE id='$id'");
		header('index.php');
		
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
     <!-- MORRIS CHART STYLES-->
	 <link  href="../../assets/css/bootstrap-wysihtml5.css" rel="stylesheet" />
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
           <?php include_once "../../menu/m_consultorio.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">						                
<?php if(permiso($_SESSION['cod_user'],'3')==TRUE){ ?>
                <div align="center">
                    <div class="btn-group">
                      <a href="" data-toggle="modal" data-target="#new" class="btn btn-danger btn-sm" title="NUEVO EXPEDIENTE"><i class="glyphicon glyphicon-time" ></i><strong> Nuevo Expediente</strong></a>
                      <!--<a href="" data-toggle="modal" data-target="#new_pac"  class="btn btn-success btn-sm" title="NUEVO PACIENTE"><i class="glyphicon glyphicon-user" ></i><strong> Nuevo Paciente</strong></a>-->
                      <a href="" data-toggle="modal" data-target="#search"  class="btn btn-default btn-sm" title="BUSCAR PACIENTE"><i class="glyphicon glyphicon-search" ></i></a>
                    </div>
                </div><br>
                 
                     <!-- Modal -->           			
				<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">													
					<form name="contado">																				
					<div class="modal-dialogx">
				<?php if(permiso($_SESSION['cod_user'],'2')==TRUE){ ?>	
						<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>													
						<h3 align="center" class="modal-title" id="myModalLabel">Pacientes Registrados</h3>
						</div>
						<div class="modal-body">                                     
						<table class="table table-bordered table table-hover" id="dataTables-example">
						<thead>
                                  <tr class="well">
                                    <td><strong><center>Nombre</center></strong></td>
                                    <td><strong><center>Edad</center></strong></td>
                                    <td><strong><center>Telefono</center></strong></td>
                                  </tr>
                                 </thead>
                                 <tbody>
                                  <?php 
								  	$paa=mysql_query("SELECT * FROM pacientes 
									WHERE consultorio='$id_consultorio' AND estado='s'");					
									while($dato=mysql_fetch_array($paa)){
										
								  ?>
                                  <tr>
                                    <td><?php echo $dato['nombre']; ?></td>
                                    <td align="center"><?php echo CalculaEdad($dato['edad']); ?> Años</td>
                                    <td align="center"><?php echo $dato['telefono']; ?></td>
                                  </tr>
                                  <?php } ?>
                                  </tbody>
                        </table>																																																																																																						
						</div> 						
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>																										
						</div>										 
						</div>
				<?php }else{ echo mensajes("NO TIENES PERMISO PARA REALIZAR ESTA ACCION","rojo"); }?>
					</div>
					</form>													
				</div>
		<!-- End Modals-->
					 
							 <div class="table-responsive">
							 <?php
								################## GUARDA EL FORMULARIO GENERAL ###############	
									if(!empty($_POST['id_paciente'])){ 												
										$id_general=limpiar($_POST['id_paciente']);
										$consulta=limpiar($_POST['consulta']);																											
										#$examenes=limpiar($_POST['examenes']);																											
										$tratamiento=limpiar($_POST['tratamiento']);																																																						
										$observaciones=limpiar($_POST['observaciones']);
										
										$ant_per=limpiar($_POST['ant_per']);
										$ant_fm=limpiar($_POST['ant_fm']);
										$peso=limpiar($_POST['peso']);
										$talla=limpiar($_POST['talla']);
										$ta=limpiar($_POST['ta']);
										$sc=limpiar($_POST['sc']);
										$pc=limpiar($_POST['pc']);
										$exlab=limpiar($_POST['exlab']);
										
										$fecha=limpiar($_POST['fecha']);
										$hora=date('H:i:s');
										$status='PENDIENTE';
										$tipo=limpiar($_POST['tipo']);
										#lOS MEDICAMENTOS
										$med1=limpiar($_POST['med1']);										
										$indi1=limpiar($_POST['indi1']);
										$med2=limpiar($_POST['med2']);										
										$indi2=limpiar($_POST['indi2']);
										$med3=limpiar($_POST['med3']);										
										$indi3=limpiar($_POST['indi3']);
										$med4=limpiar($_POST['med4']);										
										$indi4=limpiar($_POST['indi4']);
										$med5=limpiar($_POST['med5']);										
										$indi5=limpiar($_POST['indi5']);
										$med6=limpiar($_POST['med6']);										
										$indi6=limpiar($_POST['indi6']);
										$med7=limpiar($_POST['med7']);										
										$indi7=limpiar($_POST['indi7']);
										$med7=limpiar($_POST['med7']);										
										$indi7=limpiar($_POST['indi7']);
										$med8=limpiar($_POST['med8']);										
										$indi8=limpiar($_POST['indi8']);
										$med9=limpiar($_POST['med9']);										
										$indi9=limpiar($_POST['indi9']);
										$med10=limpiar($_POST['med10']);										
										$indi10=limpiar($_POST['indi10']);
										$med11=limpiar($_POST['med11']);										
										$indi11=limpiar($_POST['indi11']);
										$med12=limpiar($_POST['med12']);										
										$indi12=limpiar($_POST['indi12']);
										$med13=limpiar($_POST['med13']);										
										$indi13=limpiar($_POST['indi13']);
										$med14=limpiar($_POST['med14']);										
										$indi14=limpiar($_POST['indi14']);
										$med15=limpiar($_POST['med15']);										
										$indi15=limpiar($_POST['indi15']);
										
																						
										if(empty($_POST['id'])){
											$oConsulta=new Proceso_Consulta('',$id_general,$id_medico,$id_consultorio,$consulta,$tratamiento,$observaciones,$fecha,$hora,$status,$tipo,
																			   $ant_per,$ant_fm,$peso,$talla,$ta,$sc,$pc,$exlab,
												                               $med1,$indi1,$med2,$indi2,$med3,$indi3,$med4,$indi4,$med5,$indi5,$med6,$indi6,$med7,$indi7,$med8,$indi8,$med9,$indi9,$med10,$indi10,
																			   $med11,$indi11,$med12,$indi12,$med13,$indi13,$med14,$indi14,$med15,$indi15);
											$oConsulta->crear();
											echo mensajes('Consulta General Creada con Exito','verde');
										}else{
											$id=limpiar($_POST['id_gen']);
											$oConsulta=new Proceso_Consulta($id,$consulta,$tratamiento,$observaciones,$ant_per,$ant_fm,$peso,$talla,$ta,$sc,$pc,$exlab);
											$oConsulta->actualizar();
											echo mensajes('Consulta General Actualizada con Exito','verde');
										}
									}
									
									if(!empty($_POST['idcon']) and !empty($_POST['consulta'])){
											$idcon=limpiar($_POST['idcon']);
											$consulta=limpiar($_POST['consulta']);																																																					
											$tratamiento=limpiar($_POST['tratamiento']);																																																						
											$observaciones=limpiar($_POST['observaciones']);
											$ant_per=limpiar($_POST['ant_per']);
											$ant_fm=limpiar($_POST['ant_fm']);
											$peso=limpiar($_POST['peso']);
											$talla=limpiar($_POST['talla']);
											$ta=limpiar($_POST['ta']);
											$sc=limpiar($_POST['sc']);
											$pc=limpiar($_POST['pc']);
											$exlab=limpiar($_POST['exlab']);
																				
											mysql_query("UPDATE consultas_medicas SET sintomas='$consulta',
																					  diagnostico='QUITAR', 
																					  tratamiento='$tratamiento',  
																					  observaciones='$observaciones', 
																					  ant_per='$ant_per', 
																					  ant_fm='$ant_fm', 
																					  peso='$peso', 
																					  talla='$talla', 
																					  ta='$ta', 
																					  sc='$sc', 
																					  pc='$pc', 
																					  exlab='$exlab' 
																					WHERE id='$idcon'");
											echo mensajes('Consulta Medica Actualizada con Exito','verde');
									}
									if(!empty($_POST['idmed']) and !empty($_POST['med1'])){
											$idmed=limpiar($_POST['idmed']);
											$med1=limpiar($_POST['med1']);										
											$indi1=limpiar($_POST['indi1']);
											$med2=limpiar($_POST['med2']);										
											$indi2=limpiar($_POST['indi2']);
											$med3=limpiar($_POST['med3']);										
											$indi3=limpiar($_POST['indi3']);
											$med4=limpiar($_POST['med4']);										
											$indi4=limpiar($_POST['indi4']);
											$med5=limpiar($_POST['med5']);										
											$indi5=limpiar($_POST['indi5']);
											$med6=limpiar($_POST['med6']);										
											$indi6=limpiar($_POST['indi6']);
											$med7=limpiar($_POST['med7']);										
											$indi7=limpiar($_POST['indi7']);
											$med7=limpiar($_POST['med7']);										
											$indi7=limpiar($_POST['indi7']);
											$med8=limpiar($_POST['med8']);										
											$indi8=limpiar($_POST['indi8']);
											$med9=limpiar($_POST['med9']);										
											$indi9=limpiar($_POST['indi9']);
											$med10=limpiar($_POST['med10']);										
											$indi10=limpiar($_POST['indi10']);
											$med11=limpiar($_POST['med11']);										
											$indi11=limpiar($_POST['indi11']);
											$med12=limpiar($_POST['med12']);										
											$indi12=limpiar($_POST['indi12']);
											$med13=limpiar($_POST['med13']);										
											$indi13=limpiar($_POST['indi13']);
											$med14=limpiar($_POST['med14']);										
											$indi14=limpiar($_POST['indi14']);
											$med15=limpiar($_POST['med15']);										
											$indi15=limpiar($_POST['indi15']);
																				
											mysql_query("UPDATE medicamentos SET 
																					  med1='$med1',
																					  indi1='$indi1',
																					   med2='$med2',
																					  indi2='$indi2',
																					   med3='$med3',
																					  indi3='$indi3',
																					   med4='$med4',
																					  indi4='$indi4',
																					   med5='$med5',
																					  indi5='$indi5',
																					   med6='$med6',
																					  indi6='$indi6',
																					   med7='$med7',
																					  indi7='$indi7',
																					   med8='$med8',
																					  indi8='$indi8',
																					   med9='$med9',
																					  indi9='$indi9',
																					   med10='$med10',
																					  indi10='$indi10',
																					   med11='$med11',
																					  indi11='$indi11',
																					   med12='$med12',
																					  indi12='$indi12',
																					   med13='$med13',
																					  indi13='$indi13',
																					   med14='$med14',
																					  indi14='$indi14',
																					   med15='$med15',
																					  indi15='$indi15'
																					WHERE consulta='$idmed'");
											echo mensajes('Medicamentos Actualizados con Exito','verde');
									}
									if(!empty($_POST['alergia']) and !empty($_POST['enf_cro']) and !empty($_POST['id'])){
											$id=limpiar($_POST['id']);
											$alergia=limpiar($_POST['alergia']);						
											$enf_cro=limpiar($_POST['enf_cro']);						
											$cuadro_vac=limpiar($_POST['cuadro_vac']);
											$ant_quir=limpiar($_POST['ant_quir']);					
											
																						
											mysql_query("UPDATE pacientes SET alergia='$alergia',
																			enf_cro='$enf_cro',
																			cuadro_vac='$cuadro_vac',
																			ant_quir='$ant_quir'																																					
																	WHERE id=$id
											");	
											echo mensajes('Expedinte Registrado con Exito','verde');
									}
									
								
								?>
				<!--  Modals ****** MEDICINA GENERAL ***** -->
										 <div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
													<div class="modal-dialog modal-lg" role="document">
														<div class="modal-content">
															<div class="modal-body">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																<h4 align="center" class="modal-title" id="myModalLabel">NUEVO EXPEDIENTE</h4>
															</div>
												<div class="panel-body">
													<ul class="nav nav-tabs nav-justified">
		                                            <li class="active"><a href="#datos" data-toggle="tab"><i class="glyphicon glyphicon-book" ></i> CONSULTA</a></li>
		                                            <li class="" ><a href="#tipo" data-toggle="tab"><i class="glyphicon glyphicon-book" ></i> RECETA/FARMACOS</a></li>                                                                                                                                                                                     
		                                            </ul><br>
		                                            <div class="tab-content">
		                                            <div class="tab-pane fade active in" id="datos">
													<div class="col-md-4">											
													<select class="form-control" name="id_paciente" required>
													<option value="" selected disabled>---PACIENTE---</option>
														<?php
															$salx=mysql_query("SELECT * FROM pacientes WHERE consultorio='$id_consultorio' and estado='s'");				
															while($col=mysql_fetch_array($salx)){
																echo '<option value="'.$col['id'].'">'.$col['nombre'].'</option>';
															}
														?>
													</select><br>
													</div>
													<div class="col-md-4">
														<select class="form-control" name="tipo" autocomplete="off" required>
															<option value="" selected disabled>--CONSULTA--</option>
															<option value="GEN">PEDIATRIA</option>
															<option value="NP">NEFROLOGIA PEDIATRICA</option>																										
														</select><br>																																												
													</div>
													<div class="col-md-4">
														<div class='input-group date form_date' id='form_date' data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
															<input type='text' name="fecha" id="form_date" class="form-control" placeholder="Fecha" onfocus="(this.type='')" required autocomplete="off" />
															<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
														</div>
														<input type="hidden" id="dtp_input2" name="fecha" /><br/> 																																											
													</div>
																																																			   													
													<div class="col-md-4">
													<span class="input-group-addon">1.CONSULTA POR:</span>
													<textarea class="form-control" name="consulta" rows="4" required></textarea><br>
													<span class="input-group-addon">2.ANTECEDENTES PERINATALES:</span>
													<textarea class="form-control" name="ant_per" rows="4"></textarea><br>
													<span class="input-group-addon">3.ANTECEDENTES FAMILIARES:</span>
													<textarea class="form-control" name="ant_fm" rows="4" required></textarea><br>
													</div>		
													<div class="col-md-4">
													<span class="input-group-addon">4.EXAMEN FÍSICO:</span>
													<textarea class="form-control" name="observaciones" rows="4"></textarea><br>													
													<input class="form-control" name="peso" placeholder="PESO" required><br>															
													<input class="form-control" name="talla" placeholder="TALLA" required><br>															
													<input class="form-control" name="ta" placeholder="T.A" required><br>															
													<input class="form-control" name="sc" placeholder="S.C" required><br>															
													<input class="form-control" name="pc" placeholder="PERIMETRO CEFALICO" required><br>															
													</div>														
													<div class="col-md-4">
													<span class="input-group-addon">5.EXAMEN DE LABORATORIO:</span>
													<textarea class="form-control" name="exlab" rows="4" required></textarea><br>																					
													<span class="input-group-addon">6.DIAGNOSTICO:</span>
													<textarea class="form-control" name="tratamiento" rows="4" required></textarea><br>	
													<span class="input-group-addon">7.TRATAMIENTO:</span>
													<textarea class="form-control" name="tratamiento" rows="4" required></textarea><br>														
													</div>                                                                       																																												 																																													 
												</div>
													<div class="tab-pane fade" id="tipo">
                                                    <div class="col-md-4">											
													<input class="form-control" name="med1" placeholder="Medicamento 1" autocomplete="off">
                                                    <textarea class="form-control" name="indi1" placeholder="Indicación" rows="2" ></textarea><br>
                                                    <input class="form-control" name="med2" placeholder="Medicamento 2" autocomplete="off">
                                                    <textarea class="form-control" name="indi2" placeholder="Indicación" rows="2" ></textarea><br>
                                                    <input class="form-control" name="med3" placeholder="Medicamento 3" autocomplete="off">
                                                    <textarea class="form-control" name="indi3" placeholder="Indicación" rows="2" ></textarea><br>
                                                    <input class="form-control" name="med4" placeholder="Medicamento 4" autocomplete="off">
                                                    <textarea class="form-control" name="indi4" placeholder="Indicación" rows="2"></textarea><br>
                                                    <input class="form-control" name="med5" placeholder="Medicamento 5" autocomplete="off">
                                                    <textarea class="form-control" name="indi5" placeholder="Indicación" rows="2"></textarea><br>
													</div>
													<div class="col-md-4">																				
													<input class="form-control" name="med6" placeholder="Medicamento 6" autocomplete="off">
                                                    <textarea class="form-control" name="indi6" placeholder="Indicación" rows="2"></textarea><br>
                                                    <input class="form-control" name="med7" placeholder="Medicamento 7" autocomplete="off">
                                                    <textarea class="form-control" name="indi7" placeholder="Indicación" rows="2" ></textarea><br>
                                                    <input class="form-control" name="med8" placeholder="Medicamento 8" autocomplete="off">
                                                    <textarea class="form-control" name="indi8" placeholder="Indicación" rows="2"></textarea><br>
                                                    <input class="form-control" name="med9" placeholder="Medicamento 9" autocomplete="off">
                                                    <textarea class="form-control" name="indi9" placeholder="Indicación" rows="2"></textarea><br>
                                                    <input class="form-control" name="med10" placeholder="Medicamento 10" autocomplete="off">
                                                    <textarea class="form-control" name="indi10" placeholder="Indicación" rows="2"></textarea><br>																							
													</div> 
													<div class="col-md-4">																				
													<input class="form-control" name="med11" placeholder="Medicamento 11" autocomplete="off">
                                                    <textarea class="form-control" name="indi11" placeholder="Indicación" rows="2"></textarea><br>
                                                    <input class="form-control" name="med12" placeholder="Medicamento 12" autocomplete="off">
                                                    <textarea class="form-control" name="indi12" placeholder="Indicación" rows="2" ></textarea><br>
                                                    <input class="form-control" name="med13" placeholder="Medicamento 13" autocomplete="off">
                                                    <textarea class="form-control" name="indi13" placeholder="Indicación" rows="2"></textarea><br>
                                                    <input class="form-control" name="med14" placeholder="Medicamento 14" autocomplete="off">
                                                    <textarea class="form-control" name="indi14" placeholder="Indicación" rows="2"></textarea><br>
                                                    <input class="form-control" name="med15" placeholder="Medicamento 15" autocomplete="off">
                                                    <textarea class="form-control" name="indi15" placeholder="Indicación" rows="2"></textarea><br>																							
													</div> 
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
								 </div>			        			 								 
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                             ULTIMOS EXPEDIENTES
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    
									<thead>
                                        <tr>
                                            <th>#</th>
                                            <th>PACIENTE</th>
                                            <th>CONSULTA</th>                                                                                                                              
                                            <th>FECHA</th>                                                                                      
                                            <!--<th>MEDICO</th>-->                                                                                      
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
											################# CONSULTA GENERLA ####################
											$pame=mysql_query("SELECT * FROM consultas_medicas INNER JOIN medicamentos ON consultas_medicas.id=medicamentos.consulta WHERE consultas_medicas.consultorio='$id_consultorio' AND  consultas_medicas.vista='n' ORDER BY consultas_medicas.id DESC LIMIT 10");		 	
											while($row=mysql_fetch_array($pame)){
											$oPaciente=new Consultar_Paciente($row['id_paciente']);				               
											$url=$row['id'];
											$genconsul=$row['consulta'];
											$general=$row['id_paciente'];
											$id_gen_pago=$row['id_paciente'];
											$id_gen_cita=$row['id_paciente'];
											$tipo=$row['tipo'];
											$status=$row['status'];
											if ($status == "PENDIENTE"){
												$pago='<a href="#" data-toggle="modal" data-target="#pago'.$id_gen_pago.'" class="btn btn-sm btn-danger" title="PAGO">
															<i class="fa fa-dollar" ></i>
														    </a>';
															
												}
												else {
												$pago='<a href="#" data-toggle="modal" data-target="#pago" class="btn btn-sm btn-success" title="PAGADO">
															<i class="fa fa-star" ></i>
														    </a>';
												}
											if (($status=='PENDIENTE')) { 
												$color="class=danger";
												$cita='<a href="#" data-toggle="modal" data-target="#cita'.$id_gen_cita.'"><i class="glyphicon glyphicon-time"></i> Nueva Cita Medica</a>'; 
											}else{ 
												$color="";
												$cita='';
											} 			
											################# CONSULTA PARA ULTRA PROSTATICA ####################
											$prostata=0;
											$prostatax=mysql_query("SELECT * FROM ultra_prostata WHERE consultorio='$id_consultorio' AND id_consulta=$url");		 	
											if($ep=mysql_fetch_array($prostatax)){
											$prostata=$ep['id_paciente'];
											}
											################# CONSULTA PARA ULTRA DE MAMAS ####################
											$mamas=0;
											$mamasx=mysql_query("SELECT * FROM ultra_mamas WHERE consultorio='$id_consultorio' AND id_consulta=$url");		 	
											if($um=mysql_fetch_array($mamasx)){
											$mamas=$um['id_paciente'];
											}
											################# CONSULTA PARA ULTRA DE EMBARAZO ####################
											$embarazox=mysql_query("SELECT * FROM ultra_embarazo WHERE consultorio='$id_consultorio' AND id_consulta=$url");
											$embarazo=0;
											if($uem=mysql_fetch_array($embarazox)){
											$embarazo=$uem['id_paciente'];											
											}
											################# CONSULTA PARA ULTRA ABDOMINAL ####################
											$abdominalx=mysql_query("SELECT * FROM ultra_abdominal WHERE consultorio='$id_consultorio' AND id_consulta=$url");
											$abdominal=0;
											if($uabd=mysql_fetch_array($abdominalx)){
											$abdominal=$uabd['id_paciente'];											
											}
											################# CONSULTA PARA ULTRA ABDOMINAL ####################
											$ginecologiax=mysql_query("SELECT * FROM ultra_ginecologica WHERE consultorio='$id_consultorio' AND id_consulta=$url");
											$ginecologia=0;
											if($ug=mysql_fetch_array($ginecologiax)){
											$id_ginecologia=$ug['id_paciente'];											
											}
											################# CONDICIONALES PARA EDITAR FORMULARIO ####################
											if ($tipo == 'GEN'){
											$formulario = '<div class="btn-group">
											  <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
											  <ul class="dropdown-menu pull-right">
												<li><a href="#" data-toggle="modal" data-target="#actualizar'.$genconsul.'"><i class="fa fa-edit"></i> Editar Consulta</a></li>
												<li class="divider"></li>
												<li><a href="#" data-toggle="modal" data-target="#receta'.$genconsul.'"><i class="fa fa-edit"></i> Editar Receta</a></li>
												<li class="divider"></li>
												<li>'.$cita.'</li>																																				
											  </ul>
											</div>	<a href="../imprimir/index.php?id='.$url.'" class="btn btn-sm btn-primary" title="Imprimir">
											<i class="fa fa-print" ></i>
										    </a>
										    ';
											}
											elseif ($tipo == 'NP'){
											$formulario = '<div class="btn-group">
											  <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
											  <ul class="dropdown-menu pull-right">
												<li><a href="#" data-toggle="modal" data-target="#actualizar'.$genconsul.'"><i class="fa fa-edit"></i> Editar Consulta</a></li>
												<li class="divider"></li>
												<li><a href="#" data-toggle="modal" data-target="#receta'.$genconsul.'"><i class="fa fa-edit"></i> Editar Receta</a></li>
												<li class="divider"></li>
												<li>'.$cita.'</li>																																				
											  </ul>
											</div>	<a href="../imprimir/index.php?id='.$url.'" class="btn btn-sm btn-primary" title="Imprimir">
											<i class="fa fa-print" ></i>
										    </a>
										    ';
											}
										?>
                                        <tr class="odd gradeX">
                                            <td <?php echo $color; ?>><?php echo $row['id']; ?></td>
                                            <td <?php echo $color; ?>><i class="fa fa-user fa-2x"></i> <?php echo $oPaciente->consultar('nombre'); ?></td>
                                            <td <?php echo $color; ?>><?php echo tipo_pago($row['tipo']); ?></td>                                                                                   
                                            <td <?php echo $color; ?>><?php echo fecha($row['fecha']).' '.$row['hora']; ?></td>
											<!--<td><?php echo $nombre_medico; ?></td>-->  
                                            <td <?php echo $color; ?> class="center">
											<?php echo $formulario; ?>											
											</td>								
                                        </tr> 																										
								<!--  Modals MODIFICAR CONSULTA GENERAL-->
										 <div class="modal fade" id="actualizar<?php echo $genconsul; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												<input type="hidden" name="idcon" value="<?php echo $genconsul; ?>">
													<div class="modal-dialog modal-lg" role="document" >
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>															
																<h4 align="center" class="modal-title" id="myModalLabel">MODIFICAR CONSULTA GENERAL <?php echo $row['id_paciente']; ?></h4>
															</div>
															<div class="panel-body">
															<div class="row">
																<div class="col-md-12">
																<div class="alert alert-info" align="center"><strong><?php echo $oPaciente->consultar('nombre'); ?></strong></div>
																<input type="hidden" name="nombre">																				
																</div>
																<div class="col-md-4">
															<span class="input-group-addon">1.CONSULTA POR:</span>
															<textarea class="form-control" name="consulta" rows="4" required value="<?php echo $row['sintomas']; ?>"><?php echo $row['sintomas']; ?></textarea><br>
															<span class="input-group-addon">2.ANTECEDENTES PERINATALES:</span>
															<textarea class="form-control" name="ant_per" rows="4" value="<?php echo $row['ant_per']; ?>"><?php echo $row['ant_per']; ?></textarea><br>
															<span class="input-group-addon">3.ANTECEDENTES FAMILIARES:</span>
															<textarea class="form-control" name="ant_fm" rows="4" required value="<?php echo $row['ant_fm']; ?>"><?php echo $row['ant_fm']; ?></textarea><br>
															</div>		
															<div class="col-md-4">
															<span class="input-group-addon">4.EXAMEN FÍSICO:</span>
															<textarea class="form-control" name="observaciones" value="<?php echo $row['observaciones']; ?>" rows="4"><?php echo $row['observaciones']; ?></textarea><br>													
															<div class="input-group">
																  <span class="input-group-addon">PESO:</span>
																  <input class="form-control" name="peso" value="<?php echo $row['peso']; ?>"  placeholder="PESO" required>											
															</div><br>
															<div class="input-group">
																  <span class="input-group-addon">TALLA:</span>
																  <input class="form-control" name="talla"  value="<?php echo $row['talla']; ?>"  placeholder="TALLA" required>										
															</div><br>
															<div class="input-group">
																  <span class="input-group-addon">T.A:</span>
																  <input class="form-control" name="ta" value="<?php echo $row['ta']; ?>"  placeholder="T.A" required>									
															</div><br>															
															<div class="input-group">
																  <span class="input-group-addon">S.C:</span>
																  <input class="form-control" name="sc" value="<?php echo $row['sc']; ?>"  placeholder="S.C" required>									
															</div><br>
															<div class="input-group">
																  <span class="input-group-addon">P.C:</span>
																  <input class="form-control" name="pc" value="<?php echo $row['pc']; ?>"  placeholder="PERIMETRO CEFALICO" required>									
															</div><br>
																																																											
															</div>														
															<div class="col-md-4">
															<span class="input-group-addon">5.EXAMEN DE LABORATORIO:</span>
															<textarea class="form-control" name="exlab" value="<?php echo $row['exlab']; ?>" rows="4" required><?php echo $row['exlab']; ?></textarea><br>																					
															<span class="input-group-addon">6.DIAGNOSTICO:</span>
															<textarea class="form-control" name="observaciones" rows="4" value="<?php echo $row['observaciones']; ?>" required><?php echo $row['observaciones']; ?></textarea><br>	
															<span class="input-group-addon">7.TRATAMIENTO:</span>
															<textarea class="form-control" name="tratamiento" rows="4" value="<?php echo $row['tratamiento']; ?>" required><?php echo $row['tratamiento']; ?></textarea><br>														
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
										 <!--  Modals MODIFICAR CONSULTA GENERAL MEDICAMENTOS-->
										 <div class="modal fade" id="receta<?php echo $genconsul; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												<input type="hidden" name="idmed" value="<?php echo $genconsul; ?>">
													<div class="modal-dialog modal-lg" role="document" >
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>															
																<h4 align="center" class="modal-title" id="myModalLabel">MODIFICAR RECETA <?php echo $oPaciente->consultar('nombre'); ?></h4>
															</div>
															<div class="panel-body">
															<div class="row">
															     <div class="col-md-4">											
																	<input class="form-control" name="med1" placeholder="Medicamento 1" value="<?php echo $row['med1']; ?>" autocomplete="off">
																	<textarea class="form-control" name="indi1" placeholder="Indicación" rows="2" value="<?php echo $row['indi1']; ?>" ><?php echo $row['indi1']; ?></textarea><br>
																	<input class="form-control" name="med2" placeholder="Medicamento 2" value="<?php echo $row['med2']; ?>" autocomplete="off">
																	<textarea class="form-control" name="indi2" placeholder="Indicación" rows="2" value="<?php echo $row['indi2']; ?>"><?php echo $row['indi2']; ?></textarea><br>
																	<input class="form-control" name="med3" placeholder="Medicamento 3" value="<?php echo $row['med3']; ?>" autocomplete="off">
																	<textarea class="form-control" name="indi3" placeholder="Indicación" rows="2" value="<?php echo $row['indi3']; ?>" ><?php echo $row['indi3']; ?></textarea><br>
																	<input class="form-control" name="med4" placeholder="Medicamento 4" value="<?php echo $row['med4']; ?>" autocomplete="off">
																	<textarea class="form-control" name="indi4" placeholder="Indicación" rows="2" value="<?php echo $row['indi4']; ?>"><?php echo $row['indi4']; ?></textarea><br>
																	<input class="form-control" name="med5" placeholder="Medicamento 5" value="<?php echo $row['med5']; ?>" autocomplete="off">
																	<textarea class="form-control" name="indi5" placeholder="Indicación" rows="2" value="<?php echo $row['indi5']; ?>"><?php echo $row['indi5']; ?></textarea><br>
																	</div>
																	<div class="col-md-4">																				
																	<input class="form-control" name="med6" placeholder="Medicamento 6" value="<?php echo $row['med6']; ?>" autocomplete="off">
																	<textarea class="form-control" name="indi6" placeholder="Indicación" rows="2" value="<?php echo $row['indi6']; ?>"><?php echo $row['indi6']; ?></textarea><br>
																	<input class="form-control" name="med7" placeholder="Medicamento 7" value="<?php echo $row['med7']; ?>" autocomplete="off">
																	<textarea class="form-control" name="indi7" placeholder="Indicación" rows="2" value="<?php echo $row['indi7']; ?>" ><?php echo $row['indi7']; ?></textarea><br>
																	<input class="form-control" name="med8" placeholder="Medicamento 8" value="<?php echo $row['med8']; ?>" autocomplete="off">
																	<textarea class="form-control" name="indi8" placeholder="Indicación" rows="2" value="<?php echo $row['indi8']; ?>"><?php echo $row['indi8']; ?></textarea><br>
																	<input class="form-control" name="med9" placeholder="Medicamento 9" value="<?php echo $row['med9']; ?>" autocomplete="off">
																	<textarea class="form-control" name="indi9" placeholder="Indicación" rows="2" value="<?php echo $row['indi9']; ?>"><?php echo $row['indi9']; ?></textarea><br>
																	<input class="form-control" name="med10" placeholder="Medicamento 10" value="<?php echo $row['med10']; ?>" autocomplete="off">
																	<textarea class="form-control" name="indi10" placeholder="Indicación" rows="2" value="<?php echo $row['indi10']; ?>"><?php echo $row['indi10']; ?></textarea><br>																							
																	</div> 
																	<div class="col-md-4">																				
																	<input class="form-control" name="med11" placeholder="Medicamento 11" value="<?php echo $row['med11']; ?>" autocomplete="off">
																	<textarea class="form-control" name="indi11" placeholder="Indicación" rows="2" value="<?php echo $row['indi11']; ?>"><?php echo $row['indi11']; ?></textarea><br>
																	<input class="form-control" name="med12" placeholder="Medicamento 12" value="<?php echo $row['med12']; ?>" autocomplete="off">
																	<textarea class="form-control" name="indi12" placeholder="Indicación" rows="2" value="<?php echo $row['indi12']; ?>" ><?php echo $row['indi12']; ?></textarea><br>
																	<input class="form-control" name="med13" placeholder="Medicamento 13" value="<?php echo $row['med13']; ?>" autocomplete="off">
																	<textarea class="form-control" name="indi13" placeholder="Indicación" rows="2" value="<?php echo $row['indi13']; ?>"><?php echo $row['indi13']; ?></textarea><br>
																	<input class="form-control" name="med14" placeholder="Medicamento 14" value="<?php echo $row['med14']; ?>" autocomplete="off">
																	<textarea class="form-control" name="indi14" placeholder="Indicación" rows="2" value="<?php echo $row['indi14']; ?>" ><?php echo $row['indi14']; ?></textarea><br>
																	<input class="form-control" name="med15" placeholder="Medicamento 15" value="<?php echo $row['med15']; ?>" autocomplete="off">
																	<textarea class="form-control" name="indi15" placeholder="Indicación" rows="2" value="<?php echo $row['15']; ?>"><?php echo $row['indi15']; ?></textarea><br>																							
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
											 <!--  Modals ****** ECOGRAFIA PROSTATICA ***** -->
										 <div class="modal fade" id="prostata_edit<?php echo $prostata; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												 <input type="hidden" name="prostata" value="<?php echo $prostata; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															
																<h4 align="center" class="modal-title" id="myModalLabel">MODIFICAR ECOGRAFIA PROSTATICA</h4>
															</div>
												<div class="panel-body">
													<div class="col-md-12">
																<div class="alert alert-info" align="center"><strong><?php echo $oPaciente->consultar('nombre'); ?></strong></div>
																<input type="hidden" name="nombre">																				
																</div>
												<div class="row">																																		   													
													<div class="col-md-12">
													<span class="input-group-addon">VEGIGA:</span>
													<textarea class="form-control" name="vejiga" value="<?php echo $ep['vejiga']; ?>" rows="2" required><?php echo $ep['vejiga']; ?></textarea><br>												
													<span class="input-group-addon">PROSTOTA:</span>
													<textarea class="form-control" name="prostata" value="<?php echo $ep['prostata']; ?>" rows="2" required><?php echo $ep['prostata']; ?></textarea><br>
													<span class="input-group-addon">CONCLUSION:</span>
													<textarea class="form-control" name="conclusion" value="<?php echo $ep['conclusion']; ?>" rows="2"><?php echo $ep['conclusion']; ?></textarea><br>	
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
										</div>
								 <!-- End Modals-->
								  <!--  Modals ****** ULTRASONOGRAFIA MAMAS ***** -->
										 <div class="modal fade" id="mamas_edit<?php echo $mamas; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												 <input type="hidden" name="mamas" value="<?php echo $mamas; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															
																<h4 align="center" class="modal-title" id="myModalLabel">MODIFICAR ULTRASONIDO DE MAMAS</h4>
															</div>
												<div class="panel-body">
													<div class="col-md-12">
																<div class="alert alert-info" align="center"><strong><?php echo $oPaciente->consultar('nombre'); ?></strong></div>
																<input type="hidden" name="nombre">																				
																</div>
												<div class="row">																																		   													
													<div class="col-md-12">	
													<textarea class="textarea form-control" name="informe" placeholder="Enter text ..." rows="8"><?php echo $um['informe']; ?></textarea><br>
													 <span class="input-group-addon">DX:</span>
													<textarea class="form-control" name="dx" rows="2"><?php echo $um['dx']; ?></textarea><br>
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
										</div>
								 <!-- End Modals-->
								 
								 <!--  Modals-->
                                 <div class="modal fade" id="pago<?php echo $id_gen_pago; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <form name="contado" action="" method="post">
                                <input type="hidden" value="<?php echo $id_gen_pago; ?>" name="id_gen_pago">
                                <input type="hidden" value="<?php echo $tipo; ?>" name="tipo">   
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h3 align="center" class="modal-title" id="myModalLabel"><?php echo $oPaciente->consultar('nombre'); ?></h3>
                                                    </div>
                                        <div class="panel-body">
                                        <div class="row" align="center">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                        </div>                                       
                                            <br>
                                              <div class="col-md-3">
                                               </div>
                                              <div class="col-md-6">
                                             <div class="input-group">
                                                <span class="input-group-addon"><?php echo $s; ?></span>
                                                <input class="form-control input-lg" name="valor_recibido"  autocomplete="off" required><br>                                         
                                                <span class="input-group-addon">.00</span>
                                             </div><br>                                           
                                            <!--<input type="hidden" value="<?php echo $neto; ?>" name="valor_recibido">-->                 
                                           </div>                                                                                                              
                                        </div> 
                                        </div> 
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Procesar</button>
                                        </div>                                       
                                    </div>
                                </div>
                                </form>
                            </div>
                     <!-- End Modals-->
                      <!--  Modals NUEVA CITA-->
                     <div class="modal fade" id="cita<?php echo $id_gen_cita; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<form name="form1" method="post" action="">
							<input type="hidden" value="<?php echo $id_gen_cita; ?>" name="id_gen_cita">
							<input type="hidden" value="<?php echo $tipo; ?>" name="tipo">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>										
                                            <h3 align="center" class="modal-title" id="myModalLabel">NUEVA CITA<?php echo $tipo; ?></h3><br>
                                            <h3 align="center" class="modal-title" id="myModalLabel"><?php echo $oPaciente->consultar('nombre'); ?></h3>
                                        </div>
										<div class="panel-body">
										<div class="row">                                       
											<div class="col-md-6"><br><br>																																					
												<select class="form-control" name="tipo" autocomplete="off" required>
													<option value="" selected disabled>--CONSULTA--</option>
													<option value="GEN">PEDIATRIA</option>
													<option value="NP">NEFROLOGIA PEDIATRICA</option>
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
													<input type='text' name="fechai" id="form_date" class="form-control" placeholder="Fecha Proxima Cita" required autocomplete="off" />
													<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
												</div>
												<input type="hidden" id="dtp_input2" name="fechai" /><br/>  
												<div class='input-group date form_time' id='form_time' data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
													<input type='text' name="horario" id="form_time" class="form-control" placeholder="Horario" required autocomplete="off" />
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
											<?php } ?>
                                    </tbody>
									
                                </table>
								
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
	
	<script src="../../assets/js/wysihtml5-0.3.0.js"></script>
	<script src="../../assets/css/bootstrap3-wysihtml5.js"></script>
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
                $('#dataTables-examplex').dataTable();
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
        });
   </script>         
    <script>
    $('.textarea').wysihtml5();
</script>
<script type="text/javascript" charset="utf-8">
    $(prettyPrint);
</script>
<!-- CUSTOM SCRIPTS -->
    <script src="../../assets/js/custom.js"></script>
</body>
</html>