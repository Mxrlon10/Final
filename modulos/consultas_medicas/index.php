<?php 
	session_start();
	include_once "../php_conexion.php";
	include_once "class/class.php";
	include_once "class/class_pago.php";
	include_once "../citas_medicas/class/class.php";
	include_once "class/class_up.php";
	include_once "class/class_um.php";
	include_once "class/class_uem.php";
	include_once "class/class_uabd.php";
	include_once "class/class_ug.php";
	include_once "class/class_prenatal.php";
	include_once "class/class_pediatria.php";
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
           <?php include_once "../../menu/m_consulta_medica.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">						                
<?php if(permiso($_SESSION['cod_user'],'3')==TRUE){ ?>
                <div align="center">
                    <div class="btn-group">
                      <a href="" data-toggle="modal" data-target="#new_consulta" class="btn btn-danger btn-sm" title="NUEVA CONSULTA"><i class="glyphicon glyphicon-time" ></i><strong> Nueva Consulta</strong></a>
                      <!--<a href="" data-toggle="modal" data-target="#new_pac"  class="btn btn-success btn-sm" title="NUEVO PACIENTE"><i class="glyphicon glyphicon-user" ></i><strong> Nuevo Paciente</strong></a>-->
                      <a href="" data-toggle="modal" data-target="#search"  class="btn btn-default btn-sm" title="BUSCAR PACIENTE"><i class="glyphicon glyphicon-search" ></i></a>
                    </div>
                </div><br>
                 <!--  Modals-->
                     <div class="modal fade" id="new_consulta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<form name="form1" method="post" action="">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										
                                            <h3 align="center" class="modal-title" id="myModalLabel">NUEVA CONSULTA ---</h3>
                                        </div>
										<div class="panel-body">
										<div class="row">                                       
											<div class="col-md-6">
												<label>Paciente:</label>												
												<select class="form-control" name="id_pac_con" required>
												<option value="" selected disabled>---SELECCIONE---</option>
                                                	<?php
														$salx=mysql_query("SELECT * FROM pacientes WHERE consultorio='$id_consultorio' and estado='s'");				
														while($col=mysql_fetch_array($salx)){
															echo '<option value="'.$col['id'].'">'.$col['nombre'].'</option>';
														}
													?>
                                                </select><br>																						            																																
											</div>
											<div class="col-md-6"><br>
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
													<option value="CPED">CONTROL PEDIATRIA</option>-->																										
												</select><br>																																												
											</div>                                                                        
										</div> 
										</div> 
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Generar consulta</button>
                                        </div>										 
                                    </div>
                                </div>
								</form>
                            </div>
                     <!-- End Modals-->
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
									if(!empty($_POST['id_general'])){ 												
										$id_general=limpiar($_POST['id_general']);
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
										
										$fecha=date('Y-m-d');
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
									################## GUARDAR PAGO GENERAL ###############	
									if(!empty($_POST['id_gen_pago'])){ 												
										$id_gen_pago=limpiar($_POST['id_gen_pago']);
										$concepto='Operacion al contado';																																																						
										$clase='CONSULTA';																																																						
										$valor=limpiar($_POST['valor_recibido']);
										$tipo=limpiar($_POST['tipo']);
										$fecha=date('Y-m-d');
										$hora=date('H:i:s');
										$status='CANCELADO';
										######### SACAMOS EL VALOR MAXIMO DE LA FACTURA Y LE SUMAMOS UNO ##########
										$pa=mysql_query("SELECT MAX(factura)as maximo FROM factura");				
								        if($row=mysql_fetch_array($pa)){
											if($row['maximo']==NULL){
												$factura='100000001';
											}else{
												$factura=$row['maximo']+1;
											}
										}	
																																
										if(empty($_POST['id'])){
											$oPago=new Proceso_Pago('',$id_gen_pago,$concepto,$factura,$clase,$valor,$tipo,$fecha,$hora,$status,$usu,$id_consultorio);
											$oPago->crear();
											echo mensajes('Pago Realizado Con Exito <a href="../detalle/detalle_two.php?detalle='.$factura.'"  class="btn btn-default btn-sm" title="Detalle">
                                            <i class="fa fa-print" ></i>
                                            </a>','verde');
										}else{
											$id=limpiar($_POST['id']);
											$oPago=new Proceso_Pago($id,$consulta,$examenes,$tratamiento,$observaciones);
											$oPago->actualizar();
											echo mensajes('Consulta General Actualizada con Exito','verde');
										}
									}
								################## NUEVA CITA MEDICA ###############	
								if(!empty($_POST['id_gen_cita'])){ 												
										$id_paciente=limpiar($_POST['id_gen_cita']);																											
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
								################## NUEVA CONSULTA MEDICA ###############
								if(!empty($_POST['id_pac_con'])){ 												
										$id_paciente=limpiar($_POST['id_pac_con']);																											
										$fechai=date('Y-m-d');																																																						
										$horario=date('H:i:s');																																																						
										$tipo=limpiar($_POST['tipo']);
										$fecha=date('Y-m-d');
										$hora=date('h:i:s');
										$status='PENDIENTE';
										$consulta='PENDIENTE';
										
																						
										if(empty($_POST['id'])){
											$oCita=new Proceso_Cita('',$id_paciente,$id_medico,$id_consultorio,$fechai,$tipo,$fecha,$hora,$horario,$status,$consulta);
											$oCita->crear();
											echo mensajes('Consulta Medica Generada con Exito','verde');
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
				          <table class="table table-striped  table-hover" id="dataTables-examplex">                                    
									<thead>
                                        <tr>
                                            <th># CITA</th>
                                            <th>PACIENTES A CONSULTAR</th>                                                                                                                                                                                                                                                                                                                                                                                             
                                            <!--<th>ACTUALIZAR ANT.</th>-->                                                                                                                                                                                                                                                                                                                                                                                             
                                            <th>TIPO CONSULTA</th>                                                                                                                                                                                                                                                                                                                                                                                             
                                            <th>HORA</th>                                                                                                                                                                                                                                                                                                                                                                                             
                                            <th></th>                                           
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 																							
											$pame=mysql_query("SELECT * FROM citas_medicas WHERE date_format(fechai,'%Y%m%d')=date_format(curdate(),'%Y%m%d') AND consultorio='$id_consultorio' and consulta='PENDIENTE' ORDER BY id ASC");																				
											while($row=mysql_fetch_array($pame)){
											$url=$row['id'];											
											$id_pacientex=$row['id_paciente'];											
												$oPaciente=new Consultar_Paciente($row['id_paciente']);
												$id_prostata =$row['id_paciente'];
												$id_general =$row['id_paciente'];
												$id_prenatal =$row['id_paciente'];
												$id_pediatria =$row['id_paciente'];
												$id_mamas =$row['id_paciente'];
												$id_embarazo =$row['id_paciente'];
												$id_abdominal =$row['id_paciente'];
												$id_ginecologia =$row['id_paciente'];
												$url=$row['id'];
												$tipo =$row['tipo'];
												################# LA CONSULTA PARA EL CUADRO CLINICO####################
												$mamas=0;
												$pac=mysql_query("SELECT * FROM pacientes WHERE consultorio='$id_consultorio' AND id=$id_pacientex");		 	
												if($pacc=mysql_fetch_array($pac)){
												$id_cuadro=$pacc['id'];
												
												}
											
												################# CONDICIONALES PARA CADA FORMULARIO ####################
												
												if ($tipo == "GEN"){
												$consulta='<a href="#new'. $id_general.'" role="button" class="btn btn-info btn-xs"  data-toggle="modal">
																<strong>'. $oPaciente->consultar('nombre').'</strong>
																</a> <a href="#cuadro'. $id_cuadro.'" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="CAMBIAR ANTECENDENTES">
																					<i class="glyphicon glyphicon-pencil" ></i>
																					</a>';
												}
												if ($tipo == "NP"){
												$consulta='<a href="#new'. $id_general.'" role="button" class="btn btn-info btn-xs"  data-toggle="modal">
																<strong>'. $oPaciente->consultar('nombre').'</strong>
																</a> <a href="#cuadro'. $id_cuadro.'" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="CAMBIAR ANTECENDENTES">
																					<i class="glyphicon glyphicon-pencil" ></i>
																					</a>';
												}
												elseif ($tipo == "EP"){
												$consulta='<a href="#prostata'. $id_prostata.'" role="button" class="btn btn-info btn-xs"  data-toggle="modal">
																<strong>'. $oPaciente->consultar('nombre').'</strong>
																</a> <a href="#cuadro'. $id_general.'" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="CAMBIAR ANTECENDENTES">
																					<i class="glyphicon glyphicon-pencil" ></i>
																					</a>';
												}				
												elseif ($tipo == "UM"){
												$consulta='<a href="#mamas'. $id_mamas.'" role="button" class="btn btn-info btn-xs"  data-toggle="modal">
																<strong>'. $oPaciente->consultar('nombre').'</strong>
																</a> <a href="#cuadro'. $id_general.'" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="CAMBIAR ANTECENDENTES">
																					<i class="glyphicon glyphicon-pencil" ></i>
																					</a>';
												}
												elseif ($tipo == "UEM"){
												$consulta='<a href="#embarazo'. $id_embarazo.'" role="button" class="btn btn-info btn-xs"  data-toggle="modal">
																<strong>'. $oPaciente->consultar('nombre').'</strong>
																</a> <a href="#cuadro'. $id_general.'" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="CAMBIAR ANTECENDENTES">
																					<i class="glyphicon glyphicon-pencil" ></i>
																					</a>';
												}
												elseif ($tipo == "UABD"){
												$consulta='<a href="#abdominal'. $id_abdominal.'" role="button" class="btn btn-info btn-xs"  data-toggle="modal">
																<strong>'. $oPaciente->consultar('nombre').'</strong>
																</a> <a href="#cuadro'. $id_general.'" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="CAMBIAR ANTECENDENTES">
																					<i class="glyphicon glyphicon-pencil" ></i>
																					</a>';
												}
												elseif ($tipo == "UG"){
												$consulta='<a href="#ginecologia'. $id_ginecologia.'" role="button" class="btn btn-info btn-xs"  data-toggle="modal">
																<strong>'. $oPaciente->consultar('nombre').'</strong>
																</a> <a href="#cuadro'. $id_general.'" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="CAMBIAR ANTECENDENTES">
																					<i class="glyphicon glyphicon-pencil" ></i>
																					</a>';
												}
												elseif ($tipo == "CPREN"){
												$consulta='<a href="#new'. $id_general.'" role="button" class="btn btn-info btn-xs"  data-toggle="modal">
																<strong>'. $oPaciente->consultar('nombre').'</strong>
																</a> <a href="#cuadro'. $id_cuadro.'" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="CAMBIAR ANTECENDENTES">
																	<i class="glyphicon glyphicon-pencil" ></i>
																</a>
																</a> <a href="#prenatal'. $id_general.'" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="CAMBIAR ANTECENDENTES">
																	<i class="glyphicon glyphicon-align-justify" ></i>
																</a>';
												}
												elseif ($tipo == "CPED"){
												$consulta='<a href="#new'. $id_general.'" role="button" class="btn btn-info btn-xs"  data-toggle="modal">
																<strong>'. $oPaciente->consultar('nombre').'</strong>
																</a> <a href="#cuadro'. $id_cuadro.'" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="CAMBIAR ANTECENDENTES">
																	<i class="glyphicon glyphicon-pencil" ></i>
																</a>
																</a> <a href="#pediatria'. $id_general.'" role="button" class="btn btn-xs btn-default" data-toggle="modal" title="CAMBIAR EXPEDIENTE">
																	<i class="glyphicon glyphicon-align-justify" ></i>
																</a>';
												}
										?>
                                        <tr>                                           
                                            <td><?php echo $row['id']; ?></td>                                                                                     
                                            <td><?php echo $consulta; ?></td>
                                            <!--<td align="center"><a href="#" class="btn btn-xs btn-primary" title="Imprimir">
											<i class="glyphicon glyphicon-pencil" ></i>
										    </a>
											</td>-->
                                            <td><?php echo tip_consulta($row['tipo']); ?></td>
											<td><?php echo $row['horario']; ?></td>
											 <td>
												<a href="index.php?del=<?php echo $row['id']; ?>"  class="btn btn-danger btn-xs" title="Quitar">
													<i class="fa fa-times" ></i>
												</a>
											</td>                                             
                                         <!--  Modals-->
								 <div class="modal fade" id="cuadro<?php echo $id_cuadro; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<form name="form1" method="post" action="">
										<input type="hidden" value="<?php echo $pacc['id']; ?>" name="id">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													
														<h3 align="center" class="modal-title" id="myModalLabel">ANTECEDENTES PERSONALES</h3>
													</div>
										<?php if(permiso($_SESSION['cod_user'],'3')==TRUE){ ?>
										<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
											<div class="alert alert-info" align="center"><strong><?php echo $pacc['nombre']; ?></strong></div>
											<input type="hidden" name="nombre">															
											</div>
											<div class="col-md-6">
												<!--<div class="input-group">
												  <span class="input-group-addon">Sangre</span>
												  <select class="form-control" name="sangre" value="<?php echo $row['sangre']; ?>" autocomplete="off" required>
													<option value="" selected disabled>---SELECCIONE---</option>
													<option value="AME" <?php if ($pacc['sangre']=="AME") echo 'selected'; ?>>A RH-</option>
													<option value="AMA" <?php if ($pacc['sangre']=="AMA") echo 'selected';?>>A RH+</option>
													<option value="ABME" <?php if ($pacc['sangre']=="ABME") echo 'selected'; ?>>AB RH-</option>
													<option value="ABMA" <?php if ($pacc['sangre']=="ABMA") echo 'selected'; ?>>AB RH+</option>
													<option value="BME" <?php if ($pacc['sangre']=="BME") echo 'selected'; ?>>B RH-</option>
													<option value="BMA" <?php if ($pacc['sangre']=="BMA") echo 'selected'; ?>>B RH+</option>
													<option value="OME" <?php if ($pacc['sangre']=="OME") echo 'selected'; ?>>O RH-</option>
													<option value="OMA" <?php if ($pacc['sangre']=="OMA") echo 'selected'; ?>>O RH+</option>		
												</select>
												</div><br>-->
												<!--<div class="input-group">
												  <span class="input-group-addon">VIH</span>
												  <select class="form-control" name="vih" autocomplete="off" required>
													<option value="" selected disabled>---SELECCIONE---</option>
													<option value="p" <?php if($pacc['vih']=='p'){ echo 'selected'; } ?>>Positivo</option>
													<option value="n" <?php if($pacc['vih']=='n'){ echo 'selected'; } ?>>Negativo</option>																									
												</select>
												</div><br>-->
												<!--<div class="input-group">
												  <span class="input-group-addon">Peso</span>
												 <input class="form-control" name="peso" value="<?php echo $pacc['peso']; ?>" autocomplete="off" required><br>
												</div><br>
												<div class="input-group">
												  <span class="input-group-addon">Talla</span>
												  <input class="form-control" name="talla" value="<?php echo $pacc['talla']; ?>" autocomplete="off" required><br>
												</div><br>-->
												<span class="input-group-addon"> 1.Alergias:</span>
                                                <textarea class="form-control" name="alergia"  value="<?php echo $pacc['alergia']; ?>" rows="3"><?php echo $pacc['alergia']; ?></textarea><br>
												<span class="input-group-addon"> 2.Efermedades Cronicas:</span>
                                                <textarea class="form-control" name="enf_cro"  value="<?php echo $pacc['enf_cro']; ?>" rows="3"><?php echo $pacc['enf_cro']; ?></textarea><br>
												
											</div>
											<div class="col-md-6">
												<span class="input-group-addon"> 3.Cuadro de Vacunas:</span>
                                                <textarea class="form-control" name="cuadro_vac" value="<?php echo $pacc['cuadro_vac']; ?>"  rows="3"><?php echo $pacc['cuadro_vac']; ?></textarea><br>
												<span class="input-group-addon"> 4.Antecedentes Quirurgicos:</span>
                                                <textarea class="form-control" name="ant_quir" value="<?php echo $pacc['ant_quir']; ?>"  rows="3"><?php echo $pacc['ant_quir']; ?></textarea><br>
											</div>                                 
                                       
										</div> 
										</div> 
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
										<?php }else{ echo mensajes("NO TIENES PERMISO PARA ENTRAR A ESTE FORMULARIO","rojo"); }?>
                                    </div>
                                </div>
								</form>
                            </div>
                     <!-- End Modals-->   
										<!--  Modals ****** MEDICINA GENERAL ***** -->
										 <div class="modal fade" id="new<?php echo $id_general; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												<input type="hidden" name="id_general" value="<?php echo $id_prostata; ?>">
												<input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
													<div class="modal-dialog modal-lg" role="document">
														<div class="modal-content">
															<div class="modal-body">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																<h4 align="center" class="modal-title" id="myModalLabel">CONSULTA GENERAL <?php echo $tipo; ?></h4>
															</div>
												<div class="panel-body">
													<ul class="nav nav-tabs nav-justified">
		                                            <li class="active"><a href="#datos" data-toggle="tab"><i class="glyphicon glyphicon-book" ></i> CONSULTA</a></li>
		                                            <li class="" ><a href="#tipo" data-toggle="tab"><i class="glyphicon glyphicon-book" ></i> RECETA/FARMACOS</a></li>                                                                                                                                                                                     
		                                            </ul><br>
		                                            <div class="tab-content">
		                                            <div class="tab-pane fade active in" id="datos">
													<div class="col-md-6">											
													<label>Nombre:</label> <?php echo $oPaciente->consultar('nombre'); ?><br>													
													<label>Dirección:</label> <?php echo $oPaciente->consultar('direccion'); ?><br>
													</div>
													<div class="col-md-6">
													<?php
														   // primero conectamos siempre a la base de datos mysql
															$sql = "SELECT * FROM citas_medicas WHERE consultorio='$id_consultorio' and id_paciente='$id_general'";  // sentencia sql
															$result = mysql_query($sql);
															$numero = mysql_num_rows($result); // obtenemos el número de filas
																		
														?>
													<label>Edad:</label> <?php echo CalculaEdad($oPaciente->consultar('edad')); ?> Años<br>
													<label>Visitas:</label><span class="label label-success"><?php echo "$numero" ?></span><br><br><br>
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
								 <!-- End Modals-->
								 <!--  Modals ****** ECOGRAFIA PROSTATICA ***** -->
										 <div class="modal fade" id="prostata<?php echo $id_prostata; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												 <input type="hidden" name="id_prostata" value="<?php echo $id_prostata; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																<h4 align="center" class="modal-title" id="myModalLabel">ECOGRAFIA PROSTATICA</h4>
															</div>
												<div class="panel-body">
													<div class="col-md-6">											
													<label>Nombre:</label> <?php echo $oPaciente->consultar('nombre'); ?><br>													
													<label>Dirección:</label> <?php echo $oPaciente->consultar('direccion'); ?><br>																									
													</div>
													<div class="col-md-6">
													<label>Edad:</label> <?php echo CalculaEdad($oPaciente->consultar('edad')); ?> Años<br>
													<label>Visitas:</label><span class="label label-success">0</span><br><br><br>
													</div>
												<div class="row">																																		   													
													<div class="col-md-12">
													<span class="input-group-addon">VEJIGA:</span>
													<textarea class="form-control" name="vejiga" rows="2" required></textarea><br>												
													<span class="input-group-addon">PROSTOTA:</span>
													<textarea class="form-control" name="prostata" rows="2" required></textarea><br>
													<span class="input-group-addon">CONCLUSION:</span>
													<textarea class="form-control" name="conclusion" rows="2"></textarea><br>	
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
										<!--  Modals ****** ULTRASONIDO DE MAMAS ***** -->
										 <div class="modal fade" id="mamas<?php echo $id_mamas; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												 <input type="hidden" name="id_mamas" value="<?php echo $id_mamas; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															
																<h4 align="center" class="modal-title" id="myModalLabel">ULTRASONIDO DE MAMAS</h4>
															</div>
												<div class="panel-body">
													<div class="col-md-6">											
													<label>Nombre:</label> <?php echo $oPaciente->consultar('nombre'); ?><br>													
													<label>Dirección:</label> <?php echo $oPaciente->consultar('direccion'); ?><br>																									
													</div>
													<div class="col-md-6">
													<label>Edad:</label> <?php echo CalculaEdad($oPaciente->consultar('edad')); ?> Años<br>
													<label>Visitas:</label><span class="label label-success">0</span><br>
													</div>
												<div class="row">																																		   													
													<div class="col-md-12"><br>
													 <textarea class="textarea form-control" name="informe" placeholder="Enter text ..." rows="8">
													 SE REALIZA ULTRASONOGRAFIA DE ALTA RESOLUCION DE MAMAS CON TRASDUCTOR LINEAL DE BANDA ANCHA DE: 7.5-11 MHZ,
													APRECIANDOSE LOS SIGUIENTES HALLAZGO:
													 </textarea><br>
													 <span class="input-group-addon">DX:</span>
													<textarea class="form-control" name="dx" rows="2"></textarea><br>	
													</div><br>													                                                                    																																												 																																													 
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
								 <!--  Modals ****** ULTRASONOGRAFIA DE EMBARAZO ***** -->
										 <div class="modal fade" id="embarazo<?php echo $id_embarazo; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												<input type="hidden" name="id_embarazo" value="<?php echo $id_embarazo; ?>">
													<div class="modal-dialogx">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															
																<h5 align="center" class="modal-title" id="myModalLabel">ULTRASONOGRAFIA DE EMBARAZO</h5>
															</div>
												<div class="modal-body">
													<div class="col-md-6">											
													<label>Nombre:</label> <?php echo $oPaciente->consultar('nombre'); ?><br>																																					
													</div>
													<div class="col-md-3">
													<label>Edad:</label> <?php echo CalculaEdad($oPaciente->consultar('edad')); ?> Años<br>
													</div>
													<div class="col-md-3">
													<label>Visitas:</label><span class="label label-success">0</span><br><br>
													</div>
												<div class="row">																																		   													
													<div class="col-md-6">													
													<input type= "text" class="form-control input-sm" name="solicitante" placeholder="Medico Solicitante"  required><br>																														
													</div>
													<div class="col-md-6">													
													<input type= "text" class="form-control input-sm" name="fur" placeholder="FUR"  required><br>																									
													</div>													
													<div class="col-md-6">													
													<input type= "text" class="form-control input-sm" name="saco" placeholder="Saco Gestacional"  required><br>																														
													</div>
													<div class="col-md-6">													
													<input type= "text" class="form-control input-sm" name="lcr" placeholder="LCR"  required><br>																									
													</div>
													<div class="col-md-12">
													<span class="input-group-addon">DIAMETROS:</span><br>					
													</div>
													<div class="col-md-3">													
													<input type= "text" class="form-control input-sm" name="dbp" placeholder="DBP"  required><br>																														
													</div>
													<div class="col-md-3">													
													<input type= "text" class="form-control input-sm" name="lf" placeholder="LF"  required><br>																									
													</div>
													<div class="col-md-3">													
													<input type= "text" class="form-control input-sm" name="lh" placeholder="LH"  required><br>																									
													</div>
													<div class="col-md-3">													
													<input type= "text" class="form-control input-sm" name="lcf" placeholder="FCF"  required><br>																									
													</div>
													<div class="col-md-12">
													<span class="input-group-addon">LIQUIDO AMNIOTICO:</span><br>					
													</div>
													<div class="col-md-6">													
													<input type= "text" class="form-control input-sm" name="liquido" placeholder="INDICE DE LIQUIDO"  required><br>																									
													</div>
													<div class="col-md-12">
													<span class="input-group-addon">PLACENTA:</span><br>					
													</div>
													<div class="col-md-6">													
													<input type= "text" class="form-control input-sm" name="localizacion" placeholder="LOCALIZACIÓN"  required><br>																									
													</div>
													<div class="col-md-6">													
													<input type= "text" class="form-control input-sm" name="grado" placeholder="GRADO"  required><br>																									
													</div>
													<div class="col-md-12">													
													<input type= "text" class="form-control input-sm" name="observaciones" placeholder="OBSERVACIONES"  required>																									
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
								 <!-- End Modals-->
								 <!--  Modals ****** ECOGRAFIA ABDOMINAL***** -->
										 <div class="modal fade" id="abdominal<?php echo $id_abdominal; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												 <input type="hidden" name="id_abdominal" value="<?php echo $id_abdominal; ?>">
													<div class="modal-dialogx">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>															
																<h5 align="center" class="modal-title" id="myModalLabel">ULTRASONOGRAFIA ABDOMINAL</h5>
															</div>
												<div class="panel-body">
													<div class="col-md-6">											
													<label>Nombre:</label> <?php echo $oPaciente->consultar('nombre'); ?><br>													
													<label>Dirección:</label> <?php echo $oPaciente->consultar('direccion'); ?><br>																									
													</div>
													<div class="col-md-6">
													<label>Edad:</label> <?php echo CalculaEdad($oPaciente->consultar('edad')); ?> Años<br>
													<label>Visitas:</label><span class="label label-success">0</span><br><br><br>
													</div>
												<div class="row">																																		   													
													<div class="col-md-6">
													<span class="input-group-addon">HIGADO:</span>
													<textarea class="form-control" name="higado" rows="2" required></textarea><br>												
													<span class="input-group-addon">VESICULA BILIAR:</span>
													<textarea class="form-control" name="vesicula" rows="2" required></textarea><br>
													<span class="input-group-addon">PANCREAS:</span>
													<textarea class="form-control" name="pancreas" rows="2" required></textarea><br>
													<span class="input-group-addon">BAZO:</span>
													<textarea class="form-control" name="bazo" rows="2"></textarea><br>
													</div>
													<div class="col-md-6">																											
													<span class="input-group-addon">RIÑON DERECHO:</span>
													<textarea class="form-control" name="riñond" rows="2"></textarea><br>
													<span class="input-group-addon">RIÑON IZQUIERDO:</span>
													<textarea class="form-control" name="riñoni" rows="2"></textarea><br>	
													<span class="input-group-addon">VEJIGA:</span>
													<textarea class="form-control" name="vejiga" rows="2"></textarea><br>	
													<span class="input-group-addon">OBSERVACIONES:</span>
													<textarea class="form-control" name="observaciones" rows="2"></textarea><br>	
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
								 <!--  Modals ****** ECOGRAFIA GINECOLOGICA***** -->
										 <div class="modal fade" id="ginecologia<?php echo $id_ginecologia; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												 <input type="hidden" name="id_ginecologia" value="<?php echo $id_ginecologia; ?>">
													<div class="modal-dialogx">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>															
																<h5 align="center" class="modal-title" id="myModalLabel">ULTRASONOGRAFIA GINECOLOGICA</h5>
															</div>
												<div class="panel-body">
													<div class="col-md-8">											
													<label>Nombre:</label> <?php echo $oPaciente->consultar('nombre'); ?><br>													
													<label>Dirección:</label> <?php echo $oPaciente->consultar('direccion'); ?><br>																									
													</div>
													<div class="col-md-3">
													<label>Edad:</label> <?php echo CalculaEdad($oPaciente->consultar('edad')); ?> Años<br>
													<label>Visitas:</label><span class="label label-success">0</span><br><br><br>
													</div>
												<div class="row">
													<div class="col-md-12">													
													<input type= "text" class="form-control input-sm" name="solicitante" placeholder="Medico Solicitante" autocomplete="off" required><br>																														
													</div>
													<div class="col-md-6">
													<div class="radio">
													  <label>
														<input type="radio" name="opciones" id="pelvica" value="pelvica" checked>
														PELVICA
													  </label>
													</div>
													<div class="radio">
													  <label>
														<input type="radio" name="opciones" id="transvaginal" value="transvaginal">
														TRANSVAGINAL
													  </label>
													</div><br>
													<span class="input-group-addon">UTERO:</span>
													<textarea class="form-control" name="utero" rows="2" required></textarea><br>												
													<span class="input-group-addon">ENDOMETRIO:</span>
													<textarea class="form-control" name="endometrio" rows="2" required></textarea><br>													
													</div>
													<div class="col-md-6">
													<span class="input-group-addon">ANEXOS:</span>
													<textarea class="form-control" name="anexo" rows="2" required></textarea><br>
													<span class="input-group-addon">FONDO DEL SACO DE DOUGLAS:</span>
													<textarea class="form-control" name="saco" rows="2"></textarea><br>
													<span class="input-group-addon">OBSERVACIONES:</span>
													<textarea class="form-control" name="observaciones" rows="2"></textarea><br>	
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
								 <!--  FORMULARIO PARA PRENATAL-->
								 <div class="modal fade" id="prenatal<?php echo $id_prenatal; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<form name="form1" method="post" action="">
										<input type="hidden" name="id_prenatal" value="<?php echo $id_prenatal; ?>">
											<div class="modal-dialog">
												<div class="modal-content">
										<div class="panel-body">
										<div class="row">
											<ul class="nav nav-tabs nav-justified">
											<li class="active"><a href="#expedientepre" data-toggle="tab"><i class="glyphicon glyphicon-book" ></i> Expedinte</a></li>
											<li class="" ><a href="#familiapre" data-toggle="tab"><i class="glyphicon glyphicon-fullscreen" ></i> Antecedentes</a></li>                                
											<li class="" ><a href="#desarrollopre" data-toggle="tab"><i class="glyphicon glyphicon-dashboard" ></i> Emabarazo Actual</a></li>                                											                               
											</ul>
												<div class="tab-content">
													<div class="tab-pane fade active in" id="expedientepre">
													    <?php 																
																$sqlyy=mysql_query("SELECT MAX(id) AS id, familiares, personales, estado, parto FROM prenatal WHERE id_paciente='$id_prenatal'");
																if($rowpre=mysql_fetch_array($sqlyy)){
																$familiares=$rowpre['familiares'];
																$personales=$rowpre['personales'];
																$estado=$rowpre['estado'];
																$parto=$rowpre['parto'];
																}																														
												        ?>
														<div class="col-md-12">
															<br>
															<input class="form-control"   name="nombrepre" value="<?php echo $pacc['nombre']; ?>"  autocomplete="off" required readonly><br>
															<input class="form-control"   name="direccion" value="<?php echo $pacc['direccion']; ?>"   autocomplete="off" required readonly><br>	
															</div>
															<div class="col-md-6">																																																																																										
															<input class="form-control" name="telefono" value="<?php echo $pacc['telefono']; ?>"  data-mask="9999-9999" autocomplete="off" required readonly><br>												
																											
															</div>											
															<div class="col-md-6">																																																																													 														
																<div class="input-group date form_date" data-link-format="yyyy-mm-dd">
																 <span class="input-group-addon">Nac.</span>
																<input type="text" class="form-control" name="edadp" autocomplete="off" required min="1" value="<?php echo $pacc['edad']; ?>" readonly><br>					
																<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
															</div><br>
															</div>															
															<div class="col-md-6">
															<select class="form-control" name="estado" placeholder="Estado" autocomplete="off" required>						
																	<option value="s" <?php if($estado=='s'){ echo 'selected'; } ?>>Activo</option>
													                <option value="n" <?php if($estado=='n'){ echo 'selected'; } ?>>No Activo</option>												
																</select><br>
															</div>
															<div class="col-md-6">
															<div class="radio">
													  <label>
														<input type="radio" name="opciones" id="primegesta" value="primegesta" checked>
														PRIMEGESTA
													  </label>
													</div>
													<div class="radio">
													  <label>
														<input type="radio" name="opciones" id="multipara" value="multipara">
														MULTIPARA
													  </label>
													</div><br>
															</div>                                
													</div>
													<div class="tab-pane fade" id="familiapre">																
															<br>
															<div class="col-md-6">
															<span class="input-group-addon">ANTECEDENTES FAMILIARES:</span>
															<textarea class="form-control" name="familiares" value="<?php echo $familiares; ?>" rows="3" required><?php echo $familiares; ?></textarea><br>
															</div>
															<div class="col-md-6">
															<span class="input-group-addon">ANTECEDENTES PERSONALES:</span>
															<textarea class="form-control" name="personales" value="<?php echo $personales; ?>" rows="3" required><?php echo $personales; ?></textarea><br>
															</div>
															<div class="col-md-6">
															<div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input5" data-link-format="yyyy-mm-dd">
																	<input class="form-control" size="16" type="text" placeholder="Fecha Ultimo Parto" onfocus="(this.type='')"  name="ultimo" required>
																	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
																	<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
																</div>
																<input type="hidden" id="dtp_input5" name="ultimo" /><br>
															</div>
															<div class="col-md-6">
															<select class="form-control input-sm" name="parto" autocomplete="off" required>
																	<option value="" selected disabled>--ULTIMO PARTO--</option>																	
																	<option value="vaginal" <?php if($parto=='vaginal'){ echo 'selected'; } ?>>VAGINAL</option>
																	<option value="cesarea" <?php if($parto=='cesarea'){ echo 'selected'; } ?>>CESAREA</option>													
																	<option value="aborto" <?php if($parto=='aborto'){ echo 'selected'; } ?>>ABORTO</option>													
															</select><br>
															</div>
													</div>
													<div class="tab-pane fade" id="desarrollopre">
														<?php
														$hemb=mysql_query("SELECT * FROM prenatal_emb WHERE consultorio='$id_consultorio' AND id_paciente=$id_prenatal ORDER BY `id` DESC");
														if($rowem=mysql_fetch_array($hemb)){																																																			
														}																
														?>
														<br>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">PESO:</span>
															<input class="form-control input-sm"  name="pesopre" value="<?php echo $rowem['pesopre']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">TALLA:</span>
															<input class="form-control input-sm"  name="tallapre" value="<?php echo $rowem['tallapre']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">FUR:</span>
															<input class="form-control input-sm"  name="fur" value="<?php echo $rowem['fur']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">APP:</span>
															<input class="form-control input-sm"   name="app" value="<?php echo $rowem['app']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">A:</span>
															<input class="form-control input-sm"   name="a" value="<?php echo $rowem['a']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">HEMOGLOBINA:</span>
															<input class="form-control input-sm"   name="hemoglobina" value="<?php echo $rowem['hemoglobina']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">TIPEO RH:</span>
															<input class="form-control input-sm"  name="rh" value="<?php echo $rowem['rh']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">TOXOPLASMOSIS:</span>
															<input class="form-control input-sm"   name="toxoplasmosis" value="<?php echo $rowem['toxoplasmosis']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-4">
															<div class="input-group">
															 <span class="input-group-addon">GLUCOSA:</span>
															<input class="form-control input-sm"   name="glucosa" value="<?php echo $rowem['glucosa']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-4">
															<div class="input-group">
															 <span class="input-group-addon">IGM:</span>
															<input class="form-control input-sm"   name="igm" value="<?php echo $rowem['igm']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-4">
															<div class="input-group">
															 <span class="input-group-addon">IGG:</span>
															<input class="form-control input-sm"   name="igg" value="<?php echo $rowem['igg']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">VDRL:</span>
															<input class="form-control input-sm"  name="vdrl" value="<?php echo $rowem['vdrl']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">EGO:</span>
															<input class="form-control input-sm"   name="ego" value="<?php echo $rowem['ego']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">HIV:</span>
															<input class="form-control input-sm"  name="hiv" value="<?php echo $rowem['hiv']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">EGH:</span>
															<input class="form-control input-sm"   name="egh" value="<?php echo $rowem['egh']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">CITOLOGOA:</span>
															<input class="form-control input-sm"  name="citologoa" value="<?php echo $rowem['citologoa']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">OTROS:</span>
															<input class="form-control input-sm"   name="otrospre" value="<?php echo $rowem['otrospre']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-12">
															<div class="input-group">
															 <span class="input-group-addon">VACINACION:</span>
															<input class="form-control input-sm"   name="vacinacion" value="<?php echo $rowem['vacinacion']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div>
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
                     <!-- End Modals-->
                      <!--  Modals-->
                      <!--  FORMULARIO PARA PEDIATRIA-->
								 <div class="modal fade" id="pediatria<?php echo $id_pediatria; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<form name="form1" method="post" action="">
										<input type="hidden" name="id_pediatria" value="<?php echo $id_pediatria; ?>">
											<div class="modal-dialog">
												<div class="modal-content">								
										<div class="panel-body">
										<div class="row">
											<ul class="nav nav-tabs nav-justified">
											<li class="active"><a href="#expediente" data-toggle="tab"><i class="glyphicon glyphicon-book" ></i> Expedinte</a></li>
											<li class="" ><a href="#familia" data-toggle="tab"><i class="glyphicon glyphicon-fullscreen" ></i> Famila</a></li>                                
											<li class="" ><a href="#desarrollo" data-toggle="tab"><i class="glyphicon glyphicon-stats" ></i> Desarrollo</a></li>                                
											<li class="" ><a href="#alimentacion" data-toggle="tab"><i class="glyphicon glyphicon-cutlery" ></i> Alimentacion</a></li>                                
											<li class="" ><a href="#enfermedades" data-toggle="tab"><i class="glyphicon glyphicon-compressed" ></i> Enfermedades</a></li>                                
											</ul>
												<div class="tab-content">
													<div class="tab-pane fade active in" id="expediente">
														<div class="col-md-12">
														<?php 																
																$sqlped=mysql_query("SELECT MAX(id) AS id, nombre, direccion, telefono, edad, sexo, estado FROM pacientes WHERE id='$id_pediatria'");
																if($rowped=mysql_fetch_array($sqlped)){
																$nombre=$rowped['nombre'];
																$direccion=$rowped['direccion'];
																$telefono=$rowped['telefono'];
																$edad=$rowped['edad'];
																$sexo=$rowped['sexo'];
																$estado=$rowped['estado'];
																}																														
												        ?>
															<br>
															<input class="form-control"  value="<?php echo $rowped['nombre']; ?>" name="nombrep"  autocomplete="off" required readonly><br>
															<input class="form-control"  value="<?php echo $rowped['direccion']; ?>" name="direccion"  autocomplete="off" required readonly><br>	
															</div>
															<div class="col-md-6">																																																																																										
															<input class="form-control" value="<?php echo $rowped['telefono']; ?>" name="telefono"  title="Se necesita un Telefono" data-mask="9999-9999" placeholder="Telefono" autocomplete="off" required readonly><br>												
															<select class="form-control" name="sexo" autocomplete="off" required>
																	<option value="" selected disabled>--SEXO--</option>
																	<option value="m" <?php if($sexo=='m'){ echo 'selected'; } ?>>Masculino</option>
													                <option value="f" <?php if($sexo=='f'){ echo 'selected'; } ?>>Femenino</option>											
																</select><br>												
															</div>											
															<div class="col-md-6">
																<?php
																$pedt=mysql_query("SELECT * FROM pediatria WHERE consultorio='$id_consultorio' AND id_paciente=$id_pediatria ORDER BY `id` DESC");
																if($rowpedt=mysql_fetch_array($pedt)){																																																			
																}																
																?>																																							
																<div class="input-group">
															  <span class="input-group-addon">Obstetra:</span>
																<input class="form-control" name="obstetra" value="<?php echo $rowpedt['obstetra']; ?>" autocomplete="off"><br>																							 
															</div><br>
																<div class="input-group date form_date" data-link-format="yyyy-mm-dd">
																 <span class="input-group-addon">Nac.</span>
																<input type="text" class="form-control" name="edad" autocomplete="off" required min="1" value="<?php echo $rowped['edad']; ?>" readonly><br>					
																<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
															</div><br>
															</div>
															<div class="col-md-12">
																<div class="input-group">
															  <span class="input-group-addon">Lugar Nac.:</span>																					
																<input class="form-control"  name="lugar"  value="<?php echo $rowpedt['lugar']; ?>" autocomplete="off" required><br>
															</div><br>
															<div class="input-group">
															  <span class="input-group-addon">Nombre de Madre:</span>	
																<input class="form-control"  name="madre"   value="<?php echo $rowpedt['padre']; ?>" autocomplete="off" required><br>	
															</div><br>
															<div class="input-group">
															  <span class="input-group-addon">Nombre de Padre:</span>
																<input class="form-control"  name="padre"   value="<?php echo $rowpedt['madre']; ?>"autocomplete="off" required><br>		
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															  <span class="input-group-addon">Estado:</span>
															<select class="form-control" name="estado" placeholder="Estado" autocomplete="off" required>						
																	<option value="s" <?php if($rowpedt['estado']=='s'){ echo 'selected'; } ?>>Activo</option>
													      			<option value="n" <?php if($rowpedt['estado']=='n'){ echo 'selected'; } ?>>No Activo</option>													
																</select><br>
															</div>
															</div><br>
															<div class="col-md-6">
															<div class="input-group">
															  <span class="input-group-addon">Ref.:</span>
															<input class="form-control" name="referido" placeholder="Referdido Por" value="<?php echo $rowpedt['referido']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>                                 
													</div>
													<div class="tab-pane fade" id="familia">
														     <?php
															$hf=mysql_query("SELECT * FROM pediatria_hf WHERE consultorio='$id_consultorio' AND id_paciente=$id_pediatria ORDER BY `id` DESC");
															if($rowf=mysql_fetch_array($hf)){																																																			
															}																
															?>
															<br>
															<div class="col-md-8">
															<div class="input-group">
															  <span class="input-group-addon">Padre:</span>
															<input class="form-control"  name="padrehf" value="<?php echo $rowf['padrehf']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-4">
															<div class="input-group">
															  <span class="input-group-addon">Edad:</span>
															<input class="form-control" type="number"  name="edadpdre"  value="<?php echo $rowf['edadpdre']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-8">
															<div class="input-group">
															  <span class="input-group-addon">Madre:</span>
															<input class="form-control"  name="madrehf"  value="<?php echo $rowf['madrehf']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-4">
															<div class="input-group">
															  <span class="input-group-addon">Edad:</span>
															<input class="form-control" type="number"  name="edadmdre"  value="<?php echo $rowf['edadmdre']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-8">
															<div class="input-group">
															  <span class="input-group-addon">Hermano:</span>
															<input class="form-control" name="hermanohf"  value="<?php echo $rowf['hermanohf']; ?>" autocomplete="off"><br>
															</div><br>
															</div>
															<div class="col-md-4">
															<div class="input-group">
															  <span class="input-group-addon">Edad:</span>
															<input class="form-control" type="number"  name="edadhno"  value="<?php echo $rowf['edadhno']; ?>" autocomplete="off"><br>
															</div><br>
															</div>
															<div class="col-md-8">
															<div class="input-group">
															  <span class="input-group-addon">Hermana:</span>
															<input class="form-control" name="hermanahf"  value="<?php echo $rowf['hermanahf']; ?>" autocomplete="off"><br>
															</div><br>
															</div>
															<div class="col-md-4">
															<div class="input-group">
															  <span class="input-group-addon">Edad:</span>
															<input class="form-control" type="number"  name="edadhna"  value="<?php echo $rowf['edadhna']; ?>" autocomplete="off"><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															  <span class="input-group-addon">Tuberculosis:</span>
															<select class="form-control" name="tuberculosis" autocomplete="off" required>														
																	<option value="s" <?php if($rowf['tuberculosis']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowf['tuberculosis']=='n'){ echo 'selected'; } ?>>NO</option>														
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															  <span class="input-group-addon">Diabetes:</span>
															<select class="form-control" name="diabetes" autocomplete="off" required>
																	<option value="s" <?php if($rowf['diabetes']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowf['diabetes']=='n'){ echo 'selected'; } ?>>NO</option>												
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															  <span class="input-group-addon">Alergia:</span>
															<select class="form-control" name="alergia" autocomplete="off" required>
																	<option value="s" <?php if($rowf['alergia']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowf['alergia']=='n'){ echo 'selected'; } ?>>NO</option>												
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															  <span class="input-group-addon">Convulsiones:</span>
															<select class="form-control" name="convulsioneshf" autocomplete="off" required>
																	<option value="s" <?php if($rowf['convulsioneshf']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowf['convulsioneshf']=='n'){ echo 'selected'; } ?>>NO</option>												
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															  <span class="input-group-addon">Congenicas:</span>
															<select class="form-control" name="congenicas" autocomplete="off" required>
																	<option value="s" <?php if($rowf['congenicas']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowf['congenicas']=='n'){ echo 'selected'; } ?>>NO</option>														
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															  <span class="input-group-addon">Otros:</span>
															<input class="form-control"  name="otroshf" placeholder="Otros" value="<?php echo $rowf['otroshf']; ?>"  autocomplete="off"><br>
															</div><br>
															</div>
													</div>
													<div class="tab-pane fade" id="desarrollo">
														<?php
														$drllo=mysql_query("SELECT * FROM pediatria_drllo WHERE consultorio='$id_consultorio' AND id_paciente=$id_pediatria ORDER BY `id` DESC");
														if($rowdllr=mysql_fetch_array($drllo)){																																																			
														}																
														?>
														<br>
															<div class="col-md-4">
															<input class="form-control" title="Termino" name="termino" placeholder="Termino" value="<?php echo $rowdllr['termino']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Parto" name="parto" placeholder="Parto" value="<?php echo $rowdllr['parto']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Grupo Rh" name="rh" placeholder="Grupo Rh" value="<?php echo $rowdllr['rh']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Cond. Nac." name="con_nac" placeholder="Cond. Nac." value="<?php echo $rowdllr['con_nac']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Peso al Nac." name="peso_nac" placeholder="Peso al Nac." value="<?php echo $rowdllr['peso_nac']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Talla al Nac." name="talla_nac" placeholder="Talla al Nac." value="<?php echo $rowdllr['talla_nac']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Condicion 1. semana" name="con_semana" placeholder="Condicion 1. semana" value="<?php echo $rowdllr['con_semana']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-8">
															<input class="form-control" title="Alimentacion" name="alimentacion" placeholder="Alimentacion" value="<?php echo $rowdllr['alimentacion']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Cianosis" name="cianosis" placeholder="Cianosis" value="<?php echo $rowdllr['cianosis']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se Sentó" name="sento" placeholder="Se Sentó" value="<?php echo $rowdllr['sento']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se Paró" name="paro" placeholder="Se Paró" value="<?php echo $rowdllr['paro']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Convulsiones" name="convulsiones" placeholder="Convulsiones" value="<?php echo $rowdllr['convulsiones']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Caminó" name="camino" placeholder="Caminó" value="<?php echo $rowdllr['camino']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Primeras Palabras" name="palabras" placeholder="Primeras Palabras" value="<?php echo $rowdllr['palabras']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Ictericia" name="ictericia" placeholder="Ictericia" value="<?php echo $rowdllr['ictericia']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Primer Diente" name="diente" placeholder="Primer Diente" value="<?php echo $rowdllr['diente']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Fraces Cortas" name="fraces" placeholder="Fraces Cortas" value="<?php echo $rowdllr['fraces']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Apga-2" name="apga" placeholder="Apga-2" value="<?php echo $rowdllr['apga']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Control Vesical" name="vesical" placeholder="Control Vesical" value="<?php echo $rowdllr['vesical']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Control Instestinos" name="instestinos" placeholder="Control Instestinos" value="<?php echo $rowdllr['instestinos']; ?>" autocomplete="off" required><br>
															</div>
													</div>
													<div class="tab-pane fade" id="alimentacion">
															<?php
															$alim=mysql_query("SELECT * FROM pediatria_alim WHERE consultorio='$id_consultorio' AND id_paciente=$id_pediatria ORDER BY `id` DESC");
															if($rowalim=mysql_fetch_array($alim)){																																																			
															}																
															?>
															<br>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Pecho:</span>
															<input class="form-control"  name="pecho"  value="<?php echo $rowalim['pecho']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Formula:</span>
															<input class="form-control" name="formula"  value="<?php echo $rowalim['formula']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Vitaminas:</span>
															<input class="form-control"  name="vitaminas"  value="<?php echo $rowalim['vitaminas']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Alim. Suaves:</span>
															<input class="form-control"  name="suaves"  value="<?php echo $rowalim['suaves']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Dieta:</span>
															<input class="form-control"  name="dieta"  value="<?php echo $rowalim['dieta']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Hab. alim.:</span>
															<input class="form-control"  name="habitos"  value="<?php echo $rowalim['habitos']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Vomitos:</span>
															<input class="form-control"  name="vomitos"  value="<?php echo $rowalim['vomitos']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Cólicos:</span>
															<input class="form-control"  name="colicos"  value="<?php echo $rowalim['colicos']; ?>" autocomplete="off" required><br>
															</div><br>
															</div> 	
													</div>
													<div class="tab-pane fade" id="enfermedades">
															<?php
															$enf=mysql_query("SELECT * FROM pediatria_enf WHERE consultorio='$id_consultorio' AND id_paciente=$id_pediatria ORDER BY `id` DESC");
															if($rowenf=mysql_fetch_array($enf)){																																																			
															}																
															?>
															<br>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Tosferina:</span>
															<select class="form-control input-sm" name="tosferina" autocomplete="off" required>
																	<option value="s" <?php if($rowenf['tosferina']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowenf['tosferina']=='n'){ echo 'selected'; } ?>>NO</option>												
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Apendicitis:</span>
															<select class="form-control input-sm" name="apendicitis" autocomplete="off" required>
																	<option value="s" <?php if($rowenf['apendicitis']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowenf['apendicitis']=='n'){ echo 'selected'; } ?>>NO</option>													
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Sarampion:</span>
															<select class="form-control input-sm" name="sarampion" autocomplete="off" required>
																	<option value="s" <?php if($rowenf['sarampion']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowenf['sarampion']=='n'){ echo 'selected'; } ?>>NO</option>													
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Reumatica:</span>
															<select class="form-control input-sm" name="reumatica" autocomplete="off" required>
																	<option value="s" <?php if($rowenf['reumatica']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowenf['reumatica']=='n'){ echo 'selected'; } ?>>NO</option>													
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Rubeola:</span>
															<select class="form-control input-sm" name="rubeola" autocomplete="off" required>
																	<option value="s" <?php if($rowenf['rubeola']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowenf['rubeola']=='n'){ echo 'selected'; } ?>>NO</option>													
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Otitis:</span>
															<select class="form-control input-sm" name="otitis" autocomplete="off" required>
																	<option value="s" <?php if($rowenf['otitis']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowenf['otitis']=='n'){ echo 'selected'; } ?>>NO</option>														
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Paperas:</span>
															<select class="form-control input-sm" name="paperas" autocomplete="off" required>
																	<option value="s" <?php if($rowenf['paperas']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowenf['paperas']=='n'){ echo 'selected'; } ?>>NO</option>													
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Irs:</span>
															<select class="form-control input-sm" name="irs" autocomplete="off" required>
																	<option value="s" <?php if($rowenf['irs']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowenf['irs']=='n'){ echo 'selected'; } ?>>NO</option>														
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Varicela:</span>
															<select class="form-control input-sm" name="varicela" autocomplete="off" required>
																	<option value="s" <?php if($rowenf['varicela']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowenf['varicela']=='n'){ echo 'selected'; } ?>>NO</option>													
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Amigdalitis:</span>
															<select class="form-control input-sm" name="amigdalitis" autocomplete="off" required>
																	<option value="s" <?php if($rowenf['amigdalitis']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowenf['amigdalitis']=='n'){ echo 'selected'; } ?>>NO</option>													
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Escarlatina:</span>
															<select class="form-control input-sm" name="escarlatina" autocomplete="off" required>
																	<option value="s" <?php if($rowenf['escarlatina']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowenf['escarlatina']=='n'){ echo 'selected'; } ?>>NO</option>													
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Convulsiones:</span>
															<select class="form-control input-sm" name="convulsionesx" autocomplete="off" required>
																	<option value="s" <?php if($rowenf['convulsionesx']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowenf['convulsionesx']=='n'){ echo 'selected'; } ?>>NO</option>													
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Difteria:</span>
															<select class="form-control input-sm" name="difteria" autocomplete="off" required>
																	<option value="s" <?php if($rowenf['difteria']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowenf['difteria']=='n'){ echo 'selected'; } ?>>NO</option>													
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Constipacion:</span>
															<select class="form-control input-sm" name="constipacion" autocomplete="off" required>
																	<option value="s" <?php if($rowenf['constipacion']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowenf['constipacion']=='n'){ echo 'selected'; } ?>>NO</option>													
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Operaciones:</span>
															<select class="form-control input-sm" name="operaciones" autocomplete="off" required>
																	<option value="s" <?php if($rowenf['operaciones']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowenf['operaciones']=='n'){ echo 'selected'; } ?>>NO</option>													
															</select><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Diarrea:</span>
															<select class="form-control input-sm" name="diarrea" autocomplete="off" required>
																	<option value="s" <?php if($rowenf['diarrea']=='s'){ echo 'selected'; } ?>>SI</option>
													      			<option value="n" <?php if($rowenf['diarrea']=='n'){ echo 'selected'; } ?>>NO</option>													
															</select><br>
															</div><br>
															</div>														
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Amebiasis:</span>
															<input class="form-control input-sm"  name="amebiasis" value="<?php echo $rowenf['amebiasis']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Otros:</span>
															<input class="form-control input-sm"  name="otrosenf" value="<?php echo $rowenf['otrosenf']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div> 	
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
                     <!-- End Modals-->
									
                                        </tr>
										<?php } ?>
                                    </tbody>									
                                </table>
								 </div>			        			 								 
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                             ULTIMAS CONSULTAS
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
											$pame=mysql_query("SELECT * FROM consultas_medicas INNER JOIN medicamentos ON consultas_medicas.id=medicamentos.consulta WHERE consultas_medicas.consultorio='$id_consultorio' AND consultas_medicas.vista='s' ORDER BY consultas_medicas.id DESC LIMIT 10");		 	
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
										    '.$pago.'';
											}
											if ($tipo == 'NP'){
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
										    '.$pago.'';
											}
											elseif($tipo == 'EP'){
											$formulario = '<div class="btn-group">
											  <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
											  <ul class="dropdown-menu pull-right">
												<li><a href="#" data-toggle="modal" data-target="#prostata_edit'.$prostata.'"><i class="fa fa-edit"></i> Editar</a></li>
												<li class="divider"></li>
												<li>'.$cita.'</li>																																				
											  </ul>
											</div> <a href="../imprimir/prostatica.php?id='.$url.'" class="btn btn-sm btn-primary" title="Imprimir">
											<i class="fa fa-print" ></i>
										    </a>
										    '.$pago.'';
											}
											elseif($tipo == 'UM'){
											$formulario = '<div class="btn-group">
											  <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
											  <ul class="dropdown-menu pull-right">
												<li><a href="#" data-toggle="modal" data-target="#mamas_edit'.$mamas.'"><i class="fa fa-edit"></i> Editar</a></li>
												<li class="divider"></li>
												<li>'.$cita.'</li>																																				
											  </ul>
											</div>	<a href="../imprimir/mamas.php?id='.$url.'" class="btn btn-sm btn-primary" title="Imprimir">
											<i class="fa fa-print" ></i>
										    </a>
										    '.$pago.'';
											}
											elseif($tipo == 'UEM'){
											$formulario = '<div class="btn-group">
											  <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
											  <ul class="dropdown-menu pull-right">
												<li><a href="#" data-toggle="modal" data-target="#embarazo_edit'.$embarazo.'"><i class="fa fa-edit"></i> Editar</a></li>
												<li class="divider"></li>
												<li>'.$cita.'</li>																																				
											  </ul>
											</div>	<a href="../imprimir/obstetrica.php?id='.$url.'" class="btn btn-sm btn-primary" title="Imprimir">
											<i class="fa fa-print" ></i>
										    </a>
										    '.$pago.'';
											}
											elseif($tipo == 'UABD'){
											$formulario = '<div class="btn-group">
											  <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
											  <ul class="dropdown-menu pull-right">
												<li><a href="#" data-toggle="modal" data-target="#abdominal_edit'.$abdominal.'"><i class="fa fa-edit"></i> Editar</a></li>
												<li class="divider"></li>
												<li>'.$cita.'</li>																																				
											  </ul>
											</div> <a href="../imprimir/abdominal.php?id='.$url.'" class="btn btn-sm btn-primary" title="Imprimir">
											<i class="fa fa-print" ></i>
										    </a>
										    '.$pago.'';
											}
											elseif($tipo == 'UG'){
											$formulario = '<div class="btn-group">
											  <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
											  <ul class="dropdown-menu pull-right">
												<li><a href="#" data-toggle="modal" data-target="#ginecologia_edit'.$id_ginecologia.'"><i class="fa fa-edit"></i> Editar</a></li>
												<li class="divider"></li>
												<li>'.$cita.'</li>																																				
											  </ul>
											</div>	<a href="../imprimir/ginecologica.php?id='.$url.'" class="btn btn-sm btn-primary" title="Imprimir">
											<i class="fa fa-print" ></i>
										    </a>
										    '.$pago.'';
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
																<h4 align="center" class="modal-title" id="myModalLabel">MODIFICAR CONSULTA GENERAL</h4>
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
								  <!--  Modals ****** ULTRASONOGRAFIA DE EMBARAZO ***** -->
										 <div class="modal fade" id="embarazo_edit<?php echo $embarazo; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												 <input type="hidden" name="embarazo" value="<?php echo $embarazo; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															
																<h5 align="center" class="modal-title" id="myModalLabel">MODIFICAR ULTRASONIDO DE MAMAS</h5>
															</div>
												<div class="modal-body">
													<div class="col-md-12">
													<center><label>Nombre: </label><?php echo $oPaciente->consultar('nombre'); ?></center>
													<input type="hidden" name="nombre"><br>																				
													</div>
												<div class="row">																																		   													
													<div class="col-md-6">													
													<input type= "text" class="form-control input-sm" name="solicitante" placeholder="Medico Solicitante" value="<?php echo $uem['solicitante']; ?>" autocomplete="off" required><br>																														
													</div>
													<div class="col-md-6">													
													<input type= "text" class="form-control input-sm" name="fur" placeholder="FUR" value="<?php echo $uem['fur']; ?>" autocomplete="off" required><br>																									
													</div>													
													<div class="col-md-6">													
													<input type= "text" class="form-control input-sm" name="saco" placeholder="Saco Gestacional" value="<?php echo $uem['saco']; ?>" autocomplete="off" required><br>																														
													</div>
													<div class="col-md-6">													
													<input type= "text" class="form-control input-sm" name="lcr" placeholder="LCR" value="<?php echo $uem['lcr']; ?>" autocomplete="off" required><br>																									
													</div>													
													<div class="col-md-12">
													<span class="input-group-addon">DIAMETROS:</span><br>					
													</div>
													<div class="col-md-3">													
													<input type= "text" class="form-control input-sm" name="dbp" placeholder="DBP" value="<?php echo $uem['dbp']; ?>" autocomplete="off" required><br>																														
													</div>
													<div class="col-md-3">													
													<input type= "text" class="form-control input-sm" name="lf" placeholder="LF" value="<?php echo $uem['lf']; ?>" autocomplete="off" required><br>																									
													</div>
													<div class="col-md-3">													
													<input type= "text" class="form-control input-sm" name="lh" placeholder="LH" value="<?php echo $uem['lh']; ?>" autocomplete="off" required><br>																									
													</div>
													<div class="col-md-3">													
													<input type= "text" class="form-control input-sm" name="lcf" placeholder="FCF" value="<?php echo $uem['lcf']; ?>" autocomplete="off" required><br>																									
													</div>													
													<div class="col-md-12">
													<span class="input-group-addon">LIQUIDO AMNIOTICO:</span><br>					
													</div>
													<div class="col-md-6">													
													<input type= "text" class="form-control input-sm" name="liquido" placeholder="INDICE DE LIQUIDO" value="<?php echo $uem['liquido']; ?>" autocomplete="off" required><br>																									
													</div>													
													<div class="col-md-12">
													<span class="input-group-addon">PLACENTA:</span><br>					
													</div>
													<div class="col-md-6">													
													<input type= "text" class="form-control input-sm" name="localizacion" placeholder="LOCALIZACIÓN" value="<?php echo $uem['localizacion']; ?>" autocomplete="off" required><br>																									
													</div>
													<div class="col-md-6">													
													<input type= "text" class="form-control input-sm" name="grado" placeholder="GRADO" value="<?php echo $uem['grado']; ?>" autocomplete="off" required><br>																									
													</div>
													<div class="col-md-12">													
													<input type= "text" class="form-control input-sm" name="observaciones" placeholder="OBSERVACIONES" value="<?php echo $uem['observaciones']; ?>" autocomplete="off" required>																									
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
								 <!--  Modals ****** ULTRASONOGRAFIA DE ABDOMINAL ***** -->
										 <div class="modal fade" id="abdominal_edit<?php echo $abdominal; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												 <input type="hidden" name="abdominal" value="<?php echo $abdominal; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															
																<h5 align="center" class="modal-title" id="myModalLabel">MODIFICAR ULTRASONIDO ABDOMINAL</h5>
															</div>
												<div class="modal-body">
													<div class="col-md-12">
													<center><label>Nombre: </label><?php echo $oPaciente->consultar('nombre'); ?></center>
													<input type="hidden" name="nombre"><br>																				
													</div>
												<div class="row">																																		   													
													<div class="col-md-6">
													<span class="input-group-addon">HIGADO:</span>
													<textarea class="form-control" name="higado" value="<?php echo $uabd['higado']; ?>" rows="2"><?php echo $uabd['higado']; ?></textarea><br>												
													<span class="input-group-addon">VESICULA BILIAR:</span>
													<textarea class="form-control" name="vesicula" value="<?php echo $uabd['vesicula']; ?>" rows="2"><?php echo $uabd['vesicula']; ?></textarea><br>
													<span class="input-group-addon">PANCREAS:</span>
													<textarea class="form-control" name="pancreas" value="<?php echo $uabd['pancreas']; ?>" rows="2"><?php echo $uabd['pancreas']; ?></textarea><br>
													<span class="input-group-addon">BAZO:</span>
													<textarea class="form-control" name="bazo" value="<?php echo $uabd['bazo']; ?>" rows="2"><?php echo $uabd['bazo']; ?></textarea><br>
													</div>
													<div class="col-md-6">																											
													<span class="input-group-addon">RIÑON DERECHO:</span>
													<textarea class="form-control" name="riñond" value="<?php echo $uabd['riñond']; ?>" rows="2"><?php echo $uabd['riñond']; ?></textarea><br>
													<span class="input-group-addon">RIÑON IZQUIERDO:</span>
													<textarea class="form-control" name="riñoni" value="<?php echo $uabd['riñoni']; ?>" rows="2"><?php echo $uabd['riñoni']; ?></textarea><br>	
													<span class="input-group-addon">VEJIGA:</span>
													<textarea class="form-control" name="vejiga" value="<?php echo $uabd['vejiga']; ?>" rows="2"><?php echo $uabd['vejiga']; ?></textarea><br>	
													<span class="input-group-addon">OBSERVACIONES:</span>
													<textarea class="form-control" name="observaciones" value="<?php echo $uabd['observaciones']; ?>" rows="2"><?php echo $uabd['observaciones']; ?></textarea><br>	
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
								  <!--  Modals ****** ULTRASONOGRAFIA DE GINECOLOGICA ***** -->
										 <div class="modal fade" id="ginecologia_edit<?php echo $ginecologia; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												 <input type="hidden" name="ginecologia" value="<?php echo $ginecologia; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															
																<h5 align="center" class="modal-title" id="myModalLabel">MODIFICAR ULTRASONOGRAFIA GINECOLOGICA</h5>
															</div>
												<div class="modal-body">
													<div class="col-md-12">
													<center><label>Nombre: </label><?php echo $oPaciente->consultar('nombre'); ?></center>
													<input type="hidden" name="nombre"><br>																				
													</div>
												<div class="row">
													<div class="col-md-12">
													<div class="input-group">
													  <span class="input-group-addon">Medico Solicitante</span>
													  	<input type= "text" class="form-control input-sm" name="solicitante" placeholder="Medico Solicitante" value="<?php echo $ug['solicitante']; ?>"  required>											
													</div><br>
																																											
													</div>
													<div class="col-md-6">
													<div class="input-group">
													  <span class="input-group-addon">UTRA</span>
													  <select class="form-control" name="opciones" autocomplete="off" required>
														<option value="pelvica" <?php if($ug['opciones']=='pelvica'){ echo 'selected'; } ?>>PELVICA</option>
														<option value="transvaginal" <?php if($ug['opciones']=='transvaginal'){ echo 'selected'; } ?>>TRANSVAGINAL</option>												
													</select>												
													</div><br>
													<span class="input-group-addon">UTERO:</span>
													<textarea class="form-control" name="utero" value="<?php echo $ug['utero']; ?>" rows="2" required><?php echo $ug['utero']; ?></textarea><br>												
													<span class="input-group-addon">ENDOMETRIO:</span>
													<textarea class="form-control" name="endometrio" value="<?php echo $ug['endometrio']; ?>" rows="2" required><?php echo $ug['endometrio']; ?></textarea><br>													
													</div>
													<div class="col-md-6">
													<span class="input-group-addon">ANEXOS:</span>
													<textarea class="form-control" name="anexo" value="<?php echo $ug['anexo']; ?>" rows="2" required><?php echo $ug['anexo']; ?></textarea><br>
													<span class="input-group-addon">FONDO DEL SACO DE DOUGLAS:</span>
													<textarea class="form-control" name="saco" value="<?php echo $ug['saco']; ?>" rows="2"><?php echo $ug['saco']; ?></textarea><br>
													<span class="input-group-addon">OBSERVACIONES:</span>
													<textarea class="form-control" name="observaciones" value="<?php echo $ug['observaciones']; ?>" rows="2"><?php echo $ug['observaciones']; ?></textarea><br>	
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