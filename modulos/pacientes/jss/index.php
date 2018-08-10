<?php 
	session_start();
	include_once "../php_conexion.php";
	include_once "class/class.php";
	include_once "class/class_pediatria.php";
	include_once "../funciones.php";
	include_once "../class_buscar.php";
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
	
	$oPersona=new Consultar_Cajero($usu);
	$cajero_nombre=$oPersona->consultar('nom');
	$fecha=date('Y-m-d');
	$hora=date('H:i:s');
	
	######### TRAEMOS LOS DATOS DE LA EMPRESA #############
		$pa=mysql_query("SELECT * FROM empresa WHERE id=1");				
        if($row=mysql_fetch_array($pa)){
			$nombre_empresa=$row['empresa'];
		}
	
	if(!empty($_GET['del'])){
		$id=$_GET['del'];
		mysql_query("DELETE FROM pacientes WHERE id='$id'");
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
           <?php include_once "../../menu/m_pacientes.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">
				<div class="panel-body">                                              
<?php if(permiso($_SESSION['cod_user'],'1')==TRUE){ ?>
				  <!--  Modals-->
								 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<form name="form1" method="post" action="">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													
														<h3 align="center" class="modal-title" id="myModalLabel">Nuevo Paciente</h3>
													</div>
										<div class="panel-body">
										<div class="row">											
											<div class="col-md-12">
											<br>
											<input class="form-control" title="Se necesita un nombre"  name="nombre" placeholder="Nombre Completo" autocomplete="off" required><br>
											<input class="form-control" title="Se necesita una Direccion" name="direccion" placeholder="Procedencia"  autocomplete="off" required><br>	
											</div>
											<div class="col-md-6">																																																																																										
												<input class="form-control" name="telefono" title="Se necesita un Telefono" data-mask="9999-9999" placeholder="Telefono" autocomplete="off" required><br>
												<div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
													<input class="form-control" size="16" type="text" placeholder="Fecha de Nacimiento" onfocus="(this.type='')"  name="edad" required>
													<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
													<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
												</div><br>
												<select class="form-control" name="sexo" autocomplete="off" required>
													<option value="" selected disabled>--SEXO--</option>
													<option value="m">Masculino</option>
													<option value="f">Femenino</option>													
												</select><br>	
											</div>
											<div class="col-md-6">
												<!--<input class="form-control" name="edad" title="Se necesita una Edad" pattern="^[0-9.!#$%&'*+/=?^_`{|}~-]*$" placeholder="Edad" autocomplete="off" required><br>
												<input placeholder="Fecha de Nacimiento" type="text" onfocus="(this.type='date')"  class="form-control" name="edad" min="1"  autocomplete="off" required><br>-->												
												<input type="hidden" id="dtp_input2" name="edad" />   																							
												<input class="form-control" name="email" placeholder="Email" autocomplete="off"><br>																							 
												<select class="form-control" name="estado" placeholder="Estado" autocomplete="off" required>						
													<option value="s">Activo</option>
													<option value="n">No Activo</option>													
												</select>
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
								 <div class="modal fade" id="pediatria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<form name="form1" method="post" action="">
											<div class="modal-dialog">
												<div class="modal-content">
													<!--<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													
														<h3 align="center" class="modal-title" id="myModalLabel">Expedinte Clinico</h3>
													</div>-->
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
															<br>
															<input class="form-control" title="Se necesita un nombre"  name="nombrep" placeholder="Nombre Completo" autocomplete="off" required><br>
															<input class="form-control" title="Se necesita una Direccion" name="direccion" placeholder="Procedencia"  autocomplete="off" required><br>	
															</div>
															<div class="col-md-6">																																																																																										
															<input class="form-control" name="telefono" title="Se necesita un Telefono" data-mask="9999-9999" placeholder="Telefono" autocomplete="off" required><br>												
															<select class="form-control" name="sexo" autocomplete="off" required>
																	<option value="" selected disabled>--SEXO--</option>
																	<option value="m">Masculino</option>
																	<option value="f">Femenino</option>													
																</select><br>												
															</div>											
															<div class="col-md-6">
																<!--<input class="form-control" name="edad" title="Se necesita una Edad" pattern="^[0-9.!#$%&'*+/=?^_`{|}~-]*$" placeholder="Edad" autocomplete="off" required><br>
																<input placeholder="Fecha de Nacimiento" type="text" onfocus="(this.type='date')"  class="form-control" name="edad" min="1"  autocomplete="off" required><br>-->												
																<!--<input type="hidden" id="dtp_input2" name="edad" />-->   																							
																<input class="form-control" name="obstetra" placeholder="Obstetra" autocomplete="off"><br>																							 
														
																<div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input3" data-link-format="yyyy-mm-dd">
																	<input class="form-control" size="16" type="text" placeholder="Fecha de Nacimiento" onfocus="(this.type='')"  name="edadp" required>
																	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
																	<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
																</div>
																<input type="hidden" id="dtp_input3" name="edadp" /><br>
															</div>
															<div class="col-md-12">
																<input class="form-control" title="Se necesita Lugar de Nacimiento"  name="lugar" placeholder="Lugar de Nacimiento" autocomplete="off" required><br>
																<input class="form-control" title="Se necesita una Nombre" name="madre" placeholder="Nombre de la Madre"  autocomplete="off" required><br>	
																<input class="form-control" title="Se necesita una Nombre" name="padre" placeholder="Nombre del Padre"  autocomplete="off" required><br>	
																	
															</div>
															<div class="col-md-6">
															<select class="form-control" name="estado" placeholder="Estado" autocomplete="off" required>						
																	<option value="s">Activo</option>
																	<option value="n">No Activo</option>													
																</select><br>
															</div>
															<div class="col-md-6">
															<input class="form-control" title="Se necesita una Nombre" name="referido" placeholder="Referdido Por"  autocomplete="off" required><br>
															</div>                                
													</div>
													<div class="tab-pane fade" id="familia">
															<br>
															<div class="col-md-8">
															<input class="form-control" title="Se necesita una Nombre" name="padrehf" placeholder="Padre"  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" type="number" title="Se necesita una edad" name="edadpdre" placeholder="Edad"  autocomplete="off" required><br>
															</div>
															<div class="col-md-8">
															<input class="form-control" title="Se necesita una Nombre" name="madrehf" placeholder="Madre"  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" type="number" title="Se necesita una edad" name="edadmdre" placeholder="Edad"  autocomplete="off" required><br>
															</div>
															<div class="col-md-8">
															<input class="form-control" title="Se necesita una Nombre" name="hermanohf" placeholder="Hermano"  autocomplete="off"><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" type="number" title="Se necesita una edad" name="edadhno" placeholder="Edad"  autocomplete="off"><br>
															</div>
															<div class="col-md-8">
															<input class="form-control" title="Se necesita una Nombre" name="hermanahf" placeholder="Hermana"  autocomplete="off"><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" type="number" title="Se necesita una edad" name="edadhna" placeholder="Edad"  autocomplete="off"><br>
															</div>
															<div class="col-md-6">
															<select class="form-control" name="tuberculosis" autocomplete="off" required>
																	<option value="" selected disabled>--TUBERCULOSIS--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control" name="diabetes" autocomplete="off" required>
																	<option value="" selected disabled>--DEABETES--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control" name="alergia" autocomplete="off" required>
																	<option value="" selected disabled>--ALERGIA--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control" name="convulsioneshf" autocomplete="off" required>
																	<option value="" selected disabled>--CONVULSIONES--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control" name="congenicas" autocomplete="off" required>
																	<option value="" selected disabled>--ANOMALIAS CONGENICAS--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<input class="form-control" title="Se necesita" name="otroshf" placeholder="Otros"  autocomplete="off"><br>
															</div>
													</div>
													<div class="tab-pane fade" id="desarrollo">
														<br>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="termino" placeholder="Termino"  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="parto" placeholder="Parto"  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="rh" placeholder="Grupo Rh"  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="con_nac" placeholder="Cond. Nac."  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="peso_nac" placeholder="Peso al Nac."  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="talla_nac" placeholder="Talla al Nac."  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="con_semana" placeholder="Condicion 1. semana"  autocomplete="off" required><br>
															</div>
															<div class="col-md-8">
															<input class="form-control" title="Se necesita" name="alimentacion" placeholder="Alimentacion"  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="cianosis" placeholder="Cianosis"  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="sento" placeholder="Se Sentó"  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="paro" placeholder="Se Paró"  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="convulsiones" placeholder="Convulsiones"  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="camino" placeholder="Caminó"  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="palabras" placeholder="Primeras Palabras"  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="ictericia" placeholder="Ictericia"  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="diente" placeholder="Primer Diente"  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="fraces" placeholder="Fraces Cortas"  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="apga" placeholder="Apga-2"  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="vesical" placeholder="Control Vesical"  autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se necesita" name="instestinos" placeholder="Control Instestinos"  autocomplete="off" required><br>
															</div>
													</div>
													<div class="tab-pane fade" id="alimentacion">
															<br>
															<div class="col-md-6">
															<input class="form-control" title="Se necesita" name="pecho" placeholder="Pecho"  autocomplete="off" required><br>
															</div>
															<div class="col-md-6">
															<input class="form-control" title="Se necesita" name="formula" placeholder="Formula"  autocomplete="off" required><br>
															</div>
															<div class="col-md-6">
															<input class="form-control" title="Se necesita" name="vitaminas" placeholder="Vitaminas"  autocomplete="off" required><br>
															</div>
															<div class="col-md-6">
															<input class="form-control" title="Se necesita" name="suaves" placeholder="Alimentos suaves"  autocomplete="off" required><br>
															</div>
															<div class="col-md-6">
															<input class="form-control" title="Se necesita" name="dieta" placeholder="Dieta actual"  autocomplete="off" required><br>
															</div>
															<div class="col-md-6">
															<input class="form-control" title="Se necesita" name="habitos" placeholder="Hábitos alimenticios"  autocomplete="off" required><br>
															</div>
															<div class="col-md-6">
															<input class="form-control" title="Se necesita" name="vomitos" placeholder="Vómitos"  autocomplete="off" required><br>
															</div>
															<div class="col-md-6">
															<input class="form-control" title="Se necesita" name="colicos" placeholder="Cólicos"  autocomplete="off" required><br>
															</div> 
													</div>
													<div class="tab-pane fade" id="enfermedades">
															<br>
															<div class="col-md-6">
															<select class="form-control input-sm" name="tosferina" autocomplete="off" required>
																	<option value="" selected disabled>--TOSFERINA--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control input-sm" name="apendicitis" autocomplete="off" required>
																	<option value="" selected disabled>--APENDICITIS--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control input-sm" name="sarampion" autocomplete="off" required>
																	<option value="" selected disabled>--SARAMPION--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control input-sm" name="reumatica" autocomplete="off" required>
																	<option value="" selected disabled>--FIEBRE REUMATICA--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control input-sm" name="rubeola" autocomplete="off" required>
																	<option value="" selected disabled>--RUBEOLA--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control input-sm" name="otitis" autocomplete="off" required>
																	<option value="" selected disabled>--OTITIS--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control input-sm" name="paperas" autocomplete="off" required>
																	<option value="" selected disabled>--PAPERAS--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control input-sm" name="irs" autocomplete="off" required>
																	<option value="" selected disabled>--IRS--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control input-sm" name="varicela" autocomplete="off" required>
																	<option value="" selected disabled>--VARICELA--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control input-sm" name="amigdalitis" autocomplete="off" required>
																	<option value="" selected disabled>--AMIGDALITIS--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control input-sm" name="escarlatina" autocomplete="off" required>
																	<option value="" selected disabled>--ESCARLATINA--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control input-sm" name="convulsionesx" autocomplete="off" required>
																	<option value="" selected disabled>--CONVULSIONES--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control input-sm" name="difteria" autocomplete="off" required>
																	<option value="" selected disabled>--DIFTERIA--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control input-sm" name="constipacion" autocomplete="off" required>
																	<option value="" selected disabled>--CONSTIPACION--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control input-sm" name="operaciones" autocomplete="off" required>
																	<option value="" selected disabled>--OPERACIONES--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>
															<div class="col-md-6">
															<select class="form-control input-sm" name="diarrea" autocomplete="off" required>
																	<option value="" selected disabled>--DIARREA--</option>
																	<option value="s">SI</option>
																	<option value="n">NO</option>													
															</select><br>
															</div>														
															<div class="col-md-6">
															<input class="form-control input-sm" title="Se necesita" name="amebiasis" placeholder="Amebiasis"  autocomplete="off" required><br>
															</div>
															<div class="col-md-6">
															<input class="form-control input-sm" title="Se necesita" name="otrosenf" placeholder="Otros"  autocomplete="off" required><br>
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
						
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
							PACIENTES
							<ul class="nav pull-right">								
							<div class="btn-group">
								  <button type="button" class="btn btn-default btn-xs dropdown-toggle"
										  data-toggle="dropdown">
									<i class="fa fa-plus"> </i> <strong>Nuevo</strong><span class="caret"></span>
								  </button>
								 
								  <ul class="dropdown-menu pull-right" role="menu">
									<li><a href="#" data-toggle="modal" data-target="#myModal" title="Agregar Paciente" title="Agregar">Paciente</a></li>
									<li class="divider"></li>
									<li><a href="#" data-toggle="modal" data-target="#pediatria" title="Agregar">Pediatria</a></li>
									<li class="divider"></li>
									<li><a href="#" data-toggle="modal" data-target="#prenatal" title="Agregar">Prenatal</a></li>
								  </ul>
								</div>
							</ul>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
								<?php 
									if(!empty($_POST['nombre'])){ 
										#$documento=limpiar($_POST['documento']);		
										$nombre=limpiar($_POST['nombre']);		
										$direccion=limpiar($_POST['direccion']);
										$telefono=limpiar($_POST['telefono']);
										$edad=limpiar($_POST['edad']);			
										$sexo=limpiar($_POST['sexo']);															
										$email=limpiar($_POST['email']);															
										$estado=limpiar($_POST['estado']);										
																	
										if(empty($_POST['id'])){
											$oPaciente=new Proceso_Paciente('',$nombre,$direccion,$telefono,$edad,$sexo,$email,$estado,$id_consultorio);
											$oPaciente->crear();
											echo mensajes('Paciente "'.$nombre.'" Creado con Exito','verde');
										}else{
											$id=limpiar($_POST['id']);
											$oPaciente=new Proceso_Paciente($id,$nombre,$direccion,$telefono,$edad,$sexo,$email,$estado,$id_consultorio);
											$oPaciente->actualizar();
											echo mensajes('Paciente "'.$nombre.'" Actualizado con Exito','verde');
										}
									}
									if(!empty($_POST['sangre']) and !empty($_POST['vih']) and !empty($_POST['id'])){
											$id=limpiar($_POST['id']);
											$sangre=limpiar($_POST['sangre']);						
											$vih=limpiar($_POST['vih']);
											$peso=limpiar($_POST['peso']);					
											$talla=limpiar($_POST['talla']);
											$alergia=limpiar($_POST['alergia']);				
											$medicamento=limpiar($_POST['medicamento']);
											$enfermedad=limpiar($_POST['enfermedad']);												
											mysql_query("UPDATE pacientes SET sangre='$sangre',
																			vih='$vih',
																			peso='$peso',
																			talla='$talla',
																			alergia='$alergia',
																			medicamento='$medicamento',
																			enfermedad='$enfermedad'																			
																	WHERE id=$id
											");	
											echo mensajes('Expedinte Registrado con Exito','verde');
									}
									if(!empty($_POST['nombrep'])){ 
										#$documento=limpiar($_POST['documento']);		
										$nombre=limpiar($_POST['nombrep']);		
										$direccion=limpiar($_POST['direccion']);
										$telefono=limpiar($_POST['telefono']);
										$edad=limpiar($_POST['edadp']);			
										$lugar=limpiar($_POST['lugar']);			
										$padre=limpiar($_POST['padre']);			
										$madre=limpiar($_POST['madre']);			
										$sexo=limpiar($_POST['sexo']);															
										$obstetra=limpiar($_POST['obstetra']);															
										$referido=limpiar($_POST['referido']);															
										$estado=limpiar($_POST['estado']);										
										#tabla pediatria_hf
										$padrehf=limpiar($_POST['padrehf']);
										$edadpdre=limpiar($_POST['edadpdre']);
										$madrehf=limpiar($_POST['madrehf']);
										$edadmdre=limpiar($_POST['edadmdre']);
										$hermanohf=limpiar($_POST['hermanohf']);
										$edadhno=limpiar($_POST['edadhno']);
										$hermanahf=limpiar($_POST['hermanahf']);
										$edadhna=limpiar($_POST['edadhna']);
										$tuberculosis=limpiar($_POST['tuberculosis']);
										$diabetes=limpiar($_POST['diabetes']);
										$alergia=limpiar($_POST['alergia']);
										$convulsioneshf=limpiar($_POST['convulsioneshf']);
										$congenicas=limpiar($_POST['congenicas']);
										$otroshf=limpiar($_POST['otroshf']);
										#tabla pediatria_drllo
										$termino=limpiar($_POST['termino']);
										$parto=limpiar($_POST['parto']);
										$rh=limpiar($_POST['rh']);
										$con_nac=limpiar($_POST['con_nac']);
										$peso_nac=limpiar($_POST['peso_nac']);
										$talla_nac=limpiar($_POST['talla_nac']);
										$con_semana=limpiar($_POST['con_semana']);
										$alimentacion=limpiar($_POST['alimentacion']);
										$cianosis=limpiar($_POST['cianosis']);
										$sento=limpiar($_POST['sento']);
										$paro=limpiar($_POST['paro']);
										$convulsiones=limpiar($_POST['convulsiones']);
										$camino=limpiar($_POST['camino']);
										$palabras=limpiar($_POST['palabras']);
										$ictericia=limpiar($_POST['ictericia']);
										$diente=limpiar($_POST['diente']);
										$fraces=limpiar($_POST['fraces']);
										$apga=limpiar($_POST['apga']);
										$vesical=limpiar($_POST['vesical']);
										$instestinos=limpiar($_POST['instestinos']);
										#tabla pediatria_alim
										$pecho=limpiar($_POST['pecho']);
										$formula=limpiar($_POST['formula']);
										$vitaminas=limpiar($_POST['vitaminas']);
										$suaves=limpiar($_POST['suaves']);
										$dieta=limpiar($_POST['dieta']);
										$habitos=limpiar($_POST['habitos']);
										$vomitos=limpiar($_POST['vomitos']);
										$colicos=limpiar($_POST['colicos']);
										#tabla pediatria_enf
										$tosferina=limpiar($_POST['tosferina']);
										$apendicitis=limpiar($_POST['apendicitis']);
										$sarampion=limpiar($_POST['sarampion']);
										$reumatica=limpiar($_POST['reumatica']);
										$rubeola=limpiar($_POST['rubeola']);
										$otitis=limpiar($_POST['otitis']);
										$paperas=limpiar($_POST['paperas']);
										$irs=limpiar($_POST['irs']);
										$varicela=limpiar($_POST['varicela']);
										$amigdalitis=limpiar($_POST['amigdalitis']);
										$escarlatina=limpiar($_POST['escarlatina']);
										$convulsionesx=limpiar($_POST['convulsionesx']);
										$difteria=limpiar($_POST['difteria']);
										$constipacion=limpiar($_POST['constipacion']);
										$operaciones=limpiar($_POST['operaciones']);
										$diarrea=limpiar($_POST['diarrea']);
										$amebiasis=limpiar($_POST['amebiasis']);
										$otrosenf=limpiar($_POST['otrosenf']);		
										if(empty($_POST['id'])){
											$oPaciente=new Proceso_Pediatria('',$nombre,$direccion,$telefono,$edad,$lugar,$madre,$padre,$sexo,$obstetra,$referido,$estado,$id_consultorio,
																				#tabla pediatria_hf
																			   $padrehf,$edadpdre,$madrehf,$edadmdre,$hermanohf,$edadhno,$hermanahf,$edadhna,
																			   $tuberculosis,$diabetes,$alergia,$convulsioneshf,$congenicas,$otroshf,
																			   #tabla pediatria_drllo
																			   $termino,$parto,$rh,$con_nac,$peso_nac,$talla_nac,$con_semana,$alimentacion,
																			   $cianosis,$sento,$paro,$convulsiones,$camino,$palabras,$ictericia,$diente,
																			   $fraces,$apga,$vesical,$instestinos,																			   
																			   #tabla pediatria_alim
																			   $pecho,$formula,$vitaminas,$suaves,$dieta,$habitos,$vomitos,$colicos,
																			   #tabla pediatria_enf
																			   $tosferina,$apendicitis,$sarampion,$reumatica,$rubeola,$otitis,$paperas,$irs,$varicela,
																			   $amigdalitis,$escarlatina,$convulsionesx,$difteria,$constipacion,$operaciones,$diarrea,
																			   $amebiasis,$otrosenf);
											$oPaciente->crear();
											echo mensajes('Paciente "'.$nombre.'" Creado con Exito','verde');
										}else{
											$id=limpiar($_POST['id']);
											$oPaciente=new Proceso_Pediatria($id,$nombre,$direccion,$telefono,$edad,$lugar,$madre,$padre,$sexo,$obstetra,$referido,$estado,$id_consultorio);
											$oPaciente->actualizar();
											echo mensajes('Paciente "'.$nombre.'" Actualizado con Exito','verde');
										}
										
									}
									
									#EDICION DE EXPEDIENTE
										if(!empty($_POST['lugar']) and !empty($_POST['madre']) and !empty($_POST['id'])){																																				
											$id=limpiar($_POST['id']);	
											$lugar=limpiar($_POST['lugar']);			
											$padre=limpiar($_POST['padre']);			
											$madre=limpiar($_POST['madre']);																	
											$obstetra=limpiar($_POST['obstetra']);															
											$referido=limpiar($_POST['referido']);															
											$estado=limpiar($_POST['estado']);										
											mysql_query("UPDATE pediatria SET lugar='$lugar',
													                             padre='$padre',
													                             madre='$madre',
													                             obstetra='$obstetra',
													                             referido='$referido',
												                                 estado='$estado'												                                											                                 																			
																	        WHERE id_paciente=$id");

											echo mensajes('Espediente Personal Actualizado con Exito','verde');
									}

									#EDICION DE DATOS FAMILIARES
										if(!empty($_POST['padrehf']) and !empty($_POST['edadpdre']) and !empty($_POST['id'])){
											$id=limpiar($_POST['id']);											
											$padrehf=limpiar($_POST['padrehf']);
											$edadpdre=limpiar($_POST['edadpdre']);
											$madrehf=limpiar($_POST['madrehf']);
											$edadmdre=limpiar($_POST['edadmdre']);
											$hermanohf=limpiar($_POST['hermanohf']);
											$edadhno=limpiar($_POST['edadhno']);
											$hermanahf=limpiar($_POST['hermanahf']);
											$edadhna=limpiar($_POST['edadhna']);
											$tuberculosis=limpiar($_POST['tuberculosis']);
											$diabetes=limpiar($_POST['diabetes']);
											$alergia=limpiar($_POST['alergia']);
											$convulsioneshf=limpiar($_POST['convulsioneshf']);
											$congenicas=limpiar($_POST['congenicas']);
											$otroshf=limpiar($_POST['otroshf']);											
											mysql_query("UPDATE pediatria_hf SET padrehf='$padrehf',
													                             edadpdre='$edadpdre',
													                             madrehf='$madrehf',
													                             edadmdre='$edadmdre',
													                             hermanohf='$hermanohf',
												                                 edadhno='$edadhno',
												                                 hermanahf='$hermanahf',
												                                 edadhna='$edadhna',
												                                 tuberculosis='$tuberculosis',
												                                 diabetes='$diabetes',
												                                 alergia='$alergia',
												                                 convulsioneshf='$convulsioneshf',
												                                 congenicas='$congenicas',
												                                 otroshf='$otroshf'																			
																	        WHERE id_paciente=$id");

											echo mensajes('Datos Familiares Actualizado con Exito','verde');
									}
									#EDICION DE DATOS DESARROLLO
										if(!empty($_POST['termino']) and !empty($_POST['parto']) and !empty($_POST['id'])){
											$id=limpiar($_POST['id']);											
											$termino=limpiar($_POST['termino']);
											$parto=limpiar($_POST['parto']);
											$rh=limpiar($_POST['rh']);
											$con_nac=limpiar($_POST['con_nac']);
											$peso_nac=limpiar($_POST['peso_nac']);
											$talla_nac=limpiar($_POST['talla_nac']);
											$con_semana=limpiar($_POST['con_semana']);
											$alimentacion=limpiar($_POST['alimentacion']);
											$cianosis=limpiar($_POST['cianosis']);
											$sento=limpiar($_POST['sento']);
											$paro=limpiar($_POST['paro']);
											$convulsiones=limpiar($_POST['convulsiones']);
											$camino=limpiar($_POST['camino']);
											$palabras=limpiar($_POST['palabras']);
											$ictericia=limpiar($_POST['ictericia']);
											$diente=limpiar($_POST['diente']);
											$fraces=limpiar($_POST['fraces']);
											$apga=limpiar($_POST['apga']);
											$vesical=limpiar($_POST['vesical']);
											$instestinos=limpiar($_POST['instestinos']);										
											mysql_query("UPDATE pediatria_drllo SET termino='$termino',
													                             parto='$parto',
													                             rh='$rh',
													                             con_nac='$con_nac',
													                             peso_nac='$peso_nac',
												                                 talla_nac='$talla_nac',
												                                 con_semana='$con_semana',
												                                 alimentacion='$alimentacion',
												                                 cianosis='$cianosis',
												                                 sento='$sento',
												                                 paro='$paro',
												                                 convulsiones='$convulsiones',
												                                 camino='$camino',
												                                 palabras='$palabras',
												                                 ictericia='$ictericia',
												                                 diente='$diente',
												                                 fraces='$fraces',
												                                 apga='$apga',
												                                 vesical='$vesical',
												                                 instestinos='$instestinos'																			
																	        WHERE id_paciente=$id");

											echo mensajes('Datos de Desarrollo Actualizado con Exito','verde');
									}
									#EDICION DE DATOS ALIMENTACION
										if(!empty($_POST['pecho']) and !empty($_POST['formula']) and !empty($_POST['id'])){
											$id=limpiar($_POST['id']);											
											$pecho=limpiar($_POST['pecho']);
											$formula=limpiar($_POST['formula']);
											$vitaminas=limpiar($_POST['vitaminas']);
											$suaves=limpiar($_POST['suaves']);
											$dieta=limpiar($_POST['dieta']);
											$habitos=limpiar($_POST['habitos']);
											$vomitos=limpiar($_POST['vomitos']);
											$colicos=limpiar($_POST['colicos']);									
											mysql_query("UPDATE pediatria_alim SET pecho='$pecho',
													                             formula='$formula',
													                             vitaminas='$vitaminas',
													                             suaves='$suaves',
													                             dieta='$dieta',
												                                 habitos='$habitos',
												                                 vomitos='$vomitos',
												                                 colicos='$colicos'												                                 																			
																	        WHERE id_paciente=$id");

											echo mensajes('Datos de Alimentación Actualizado con Exito','verde');
									}
									#EDICION DE DATOS ENFERMEDADES
										if(!empty($_POST['tosferina']) and !empty($_POST['apendicitis']) and !empty($_POST['id'])){
											$id=limpiar($_POST['id']);											
											$tosferina=limpiar($_POST['tosferina']);
											$apendicitis=limpiar($_POST['apendicitis']);
											$sarampion=limpiar($_POST['sarampion']);
											$reumatica=limpiar($_POST['reumatica']);
											$rubeola=limpiar($_POST['rubeola']);
											$otitis=limpiar($_POST['otitis']);
											$paperas=limpiar($_POST['paperas']);
											$irs=limpiar($_POST['irs']);
											$varicela=limpiar($_POST['varicela']);
											$amigdalitis=limpiar($_POST['amigdalitis']);
											$escarlatina=limpiar($_POST['escarlatina']);
											$convulsionesx=limpiar($_POST['convulsionesx']);
											$difteria=limpiar($_POST['difteria']);
											$constipacion=limpiar($_POST['constipacion']);
											$operaciones=limpiar($_POST['operaciones']);
											$diarrea=limpiar($_POST['diarrea']);
											$amebiasis=limpiar($_POST['amebiasis']);
											$otrosenf=limpiar($_POST['otrosenf']);											
											mysql_query("UPDATE pediatria_enf SET tosferina='$tosferina',
													                             apendicitis='$apendicitis',
													                             sarampion='$sarampion',
													                             reumatica='$reumatica',
													                             rubeola='$rubeola',
												                                 otitis='$otitis',
												                                 paperas='$paperas',
												                                 irs='$irs',
												                                 varicela='$varicela',
												                                 amigdalitis='$amigdalitis',
												                                 escarlatina='$escarlatina',
												                                 convulsionesx='$convulsionesx',
												                                 difteria='$difteria',
												                                 constipacion='$constipacion',
												                                 operaciones='$operaciones',
												                                 diarrea='$diarrea',
												                                 amebiasis='$amebiasis',
												                                 otrosenf='$otrosenf'												                                 																		
																	        WHERE id_paciente=$id");

											echo mensajes('Datos de Enfermedades Actualizado con Exito','verde');
									}
									#EDICION DE ANTECEDENTES EMBARAZO
										if(!empty($_POST['familiares']) and !empty($_POST['personales']) and !empty($_POST['id'])){																																				
											$id=limpiar($_POST['id']);																												
											$familiares=limpiar($_POST['familiares']);																												
											$personales=limpiar($_POST['personales']);																												
											$ultimo=limpiar($_POST['ultimo']);																												
											$parto=limpiar($_POST['parto']);									
											mysql_query("UPDATE prenatal SET familiares='$familiares',
													                             personales='$personales',
													                             ultimo='$ultimo',
													                             parto='$parto'													                             											                                											                                 																			
																	        WHERE id_paciente=$id");

											echo mensajes('Espediente Personal Actualizado con Exito','verde');
									}

									#EDICION DE DATOS PRENATAL EMB
										if(!empty($_POST['pesopre']) and !empty($_POST['tallapre']) and !empty($_POST['id'])){
											$id=limpiar($_POST['id']);
											$pesopre=limpiar($_POST['pesopre']);
											$tallapre=limpiar($_POST['tallapre']);
											$fur=limpiar($_POST['fur']);
											$app=limpiar($_POST['app']);
											$a=limpiar($_POST['a']);
											$hemoglobina=limpiar($_POST['hemoglobina']);
											$rh=limpiar($_POST['rh']);
											$toxoplasmosis=limpiar($_POST['toxoplasmosis']);
											$glucosa=limpiar($_POST['glucosa']);
											$igm=limpiar($_POST['igm']);
											$igg=limpiar($_POST['igg']);
											$vdrl=limpiar($_POST['vdrl']);
											$ego=limpiar($_POST['ego']);
											$hiv=limpiar($_POST['hiv']);
											$egh=limpiar($_POST['egh']);
											$citologoa=limpiar($_POST['citologoa']);
											$otrospre=limpiar($_POST['otrospre']);
											$vacinacion=limpiar($_POST['vacinacion']);									
											mysql_query("UPDATE prenatal_emb SET pesopre='$pesopre',
													                             tallapre='$tallapre',
													                             fur='$fur',
													                             app='$app',
													                             a='$a',
												                                 hemoglobina='$hemoglobina',
												                                 rh='$rh',
												                                 toxoplasmosis='$toxoplasmosis',
												                                 glucosa='$glucosa',
												                                 igm='$igm',
												                                 igg='$igg',
												                                 vdrl='$vdrl',
												                                 ego='$ego',
												                                 hiv='$hiv',
												                                 egh='$egh',
												                                 citologoa='$citologoa',
												                                 otrospre='$otrospre',
												                                 vacinacion='$vacinacion'												                                 																		
																	        WHERE id_paciente=$id");

											echo mensajes('Datos de Emabarazo Actualizado con Exito','verde');
									}

								?>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    
									<thead>
                                        <tr>
                                            <th>NOMBRE</th>
                                            <th>DIRECCION</th>
                                            <th>EDAD</th>
                                            <th>TELEFONO</th>                                           
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
											$editar=0; 											
											$pame=mysql_query("SELECT * FROM pacientes WHERE consultorio='$id_consultorio' ORDER BY nombre");													
											while($row=mysql_fetch_array($pame)){
											$url=$row['id'];
											$id_expediente=$row['id'];
											$edad=$row['edad'];	
											if (CalculaEdad($row['edad']) < 10)
											{
												$editar='<div class="btn-group">
														  <button data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle"><i class="glyphicon glyphicon-align-justify"></i> <span class="caret"></span></button>
														  <ul class="dropdown-menu pull-right">														   
															<li><a  href="#" data-toggle="modal" data-target="#expediente'.$id_expediente.'"><i class="fa fa-edit"></i> Expedinte</a></li>															
															<li><a  href="#" data-toggle="modal" data-target="#familia'.$url.'"><i class="fa fa-edit"></i> Famila</a></li>															
															<li><a  href="#" data-toggle="modal" data-target="#desarrollo'.$id_expediente.'"><i class="fa fa-edit"></i> Desarrollo</a></li>															
															<li><a  href="#" data-toggle="modal" data-target="#alimentacion'.$id_expediente.'"><i class="fa fa-edit"></i> Alimentacion</a></li>															
															<li><a  href="#" data-toggle="modal" data-target="#enfermedades'.$id_expediente.'"><i class="fa fa-edit"></i> Enfermedades</a></li>																																																
														  </ul>
														</div>';
											}
											else {
												$editar='';
											}
											if ($row['control'] == 'prenatal')
											{
												$editarpre='<div class="btn-group">
														  <button data-toggle="dropdown" class="btn btn-success btn-sm dropdown-toggle"><i class="glyphicon glyphicon-align-justify"></i> <span class="caret"></span></button>
														  <ul class="dropdown-menu pull-right">														   
															<li><a  href="#" data-toggle="modal" data-target="#antecedentespre'.$url.'"><i class="fa fa-edit"></i> Antecedentes</a></li>															
															<li><a  href="#" data-toggle="modal" data-target="#emabarazopre'.$url.'"><i class="fa fa-edit"></i> Emabarazo Actual</a></li>		
														 </ul>
														</div>';
											}
											else {
												$editarpre='';
											}
										?>
                                        <tr class="odd gradeX">
                                            <td><i class="fa fa-user fa-2x"></i> <?php echo $row['nombre']; ?></td>
                                            <td><?php echo $row['direccion']; ?></td>
                                            <td><?php echo CalculaEdad($row['edad']); ?></td>
                                            <td><?php echo $row['telefono']; ?></td>                                           
                                            <td class="center">
                                            <div class="btn-group">
											  <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
											  <ul class="dropdown-menu pull-right">
												<li><a  href="../perfil_paciente/index.php?id=<?php echo $url; ?>"><i class="fa fa-user"></i> Perfil</a></li>
												<li class="divider"></li>
												<li><a href="#" data-toggle="modal" data-target="#cuadro<?php echo $row['id']; ?>"><i class="fa fa-list"></i> Ant. Personales</a></li>
												<li class="divider"></li>
												<li><a  href="../historial_medico/index.php?id=<?php echo $url; ?>"><i class="fa fa-list-alt"></i> Historial</a></li>
												<li class="divider"></li>
												<li><a  href="#" data-toggle="modal" data-target="#actualizar<?php echo $row['id']; ?>"><i class="fa fa-edit"></i> Editar</a></li>
												<!--<li class="divider"></li>
												<li><a href="#" data-toggle="modal" data-target="#eliminar<?php echo $row['id']; ?>" ><i class="fa fa-pencil"></i> Eliminar</a></li>-->																																				
											  </ul>
											</div>			
												<?php echo $editar; ?>
												<?php echo $editarpre; ?>																			
											</td>
											
									    <!--  Modals-->
										 <div class="modal fade" id="actualizar<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															
																<h3 align="center" class="modal-title" id="myModalLabel">Actualizar</h3>
															</div>
										<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
											<br>
											<div class="input-group">
												  <span class="input-group-addon">Nombre</span>
												  <input class="form-control" title="Se necesita un nombre"  name="nombre" placeholder="Nombre Completo" value="<?php echo $row['nombre']; ?>" autocomplete="off" required><br>											
											</div><br>
											<div class="input-group">
												  <span class="input-group-addon">Direccion</span>
												  <input class="form-control" title="Se necesita un nombre"  name="direccion" placeholder="Dirección" value="<?php echo $row['direccion']; ?>" autocomplete="off" required><br>											
											</div><br>											
											</div>
											<div class="col-md-6">																			
												<div class="input-group">
												  <span class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></span>
												 <input class="form-control" name="telefono" data-mask="9999-9999" autocomplete="off" required value="<?php echo $row['telefono']; ?>"><br>
												</div><br>
												<div class="input-group date form_date" data-link-format="yyyy-mm-dd">
													 <span class="input-group-addon">Nac.</span>
													<input type="text" class="form-control" name="edad" autocomplete="off" required min="1" value="<?php echo $row['edad']; ?>" readonly><br>
													<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
													<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
												</div><br>
											</div>
											<div class="col-md-6">																																		
												<div class="input-group">
												  <span class="input-group-addon">Sexo</span>
												  <select class="form-control" name="sexo" autocomplete="off" required>
													<option value="m" <?php if($row['sexo']=='m'){ echo 'selected'; } ?>>Masculino</option>
													<option value="f" <?php if($row['sexo']=='f'){ echo 'selected'; } ?>>Femenino</option>												
												</select>												
												</div><br>
												<div class="input-group">
												  <span class="input-group-addon">@</span>
												  <input class="form-control" name="email" autocomplete="off" value="<?php echo $row['email']; ?>"><br>												
												</div><br>
												<div class="input-group">
												  <span class="input-group-addon">Estado</span>
												  <select class="form-control" name="estado" autocomplete="off" required>
													<option value="s" <?php if($row['estado']=='s'){ echo 'selected'; } ?>>Activo</option>
													<option value="n" <?php if($row['estado']=='n'){ echo 'selected'; } ?>>No Activo</option>													
												</select>												
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
								 <div class="modal fade" id="cuadro<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<form name="form1" method="post" action="">
										<input type="hidden" value="<?php echo $row['id']; ?>" name="id">
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
											<div class="alert alert-info" align="center"><strong><?php echo $row['nombre']; ?></strong></div>
											<input type="hidden" name="nombre">															
											</div>
											<div class="col-md-6">
												<div class="input-group">
												  <span class="input-group-addon">Sangre</span>
												  <select class="form-control" name="sangre" value="<?php echo $row['sangre']; ?>" autocomplete="off" required>
													<option value="" selected disabled>---SELECCIONE---</option>
													<option value="AME" <?php if ($row['sangre']=="AME") echo 'selected'; ?>>A RH-</option>
													<option value="AMA" <?php if ($row['sangre']=="AMA") echo 'selected';?>>A RH+</option>
													<option value="ABME" <?php if ($row['sangre']=="ABME") echo 'selected'; ?>>AB RH-</option>
													<option value="ABMA" <?php if ($row['sangre']=="ABMA") echo 'selected'; ?>>AB RH+</option>
													<option value="BME" <?php if ($row['sangre']=="BME") echo 'selected'; ?>>B RH-</option>
													<option value="BMA" <?php if ($row['sangre']=="BMA") echo 'selected'; ?>>B RH+</option>
													<option value="OME" <?php if ($row['sangre']=="OME") echo 'selected'; ?>>O RH-</option>
													<option value="OMA" <?php if ($row['sangre']=="OMA") echo 'selected'; ?>>O RH+</option>		
												</select>
												</div><br>
												<div class="input-group">
												  <span class="input-group-addon">VIH</span>
												  <select class="form-control" name="vih" autocomplete="off" required>
													<option value="" selected disabled>---SELECCIONE---</option>
													<option value="p" <?php if($row['vih']=='p'){ echo 'selected'; } ?>>Positivo</option>
													<option value="n" <?php if($row['vih']=='n'){ echo 'selected'; } ?>>Negativo</option>																									
												</select>
												</div><br>
												<div class="input-group">
												  <span class="input-group-addon">Peso</span>
												 <input class="form-control" name="peso" value="<?php echo $row['peso']; ?>" autocomplete="off" required><br>
												</div><br>
												<div class="input-group">
												  <span class="input-group-addon">Talla</span>
												  <input class="form-control" name="talla" value="<?php echo $row['talla']; ?>" autocomplete="off" required><br>
												</div><br>
												<span class="input-group-addon">Alergico:</span>
                                                <textarea class="form-control" name="alergia"  value="<?php echo $row['alergia']; ?>" rows="3"><?php echo $row['alergia']; ?></textarea><br>																
											</div>
											<div class="col-md-6">
												<br>
												<span class="input-group-addon">Medicamentos Actualmente:</span>
                                                <textarea class="form-control" name="medicamento" value="<?php echo $row['medicamento']; ?>"  rows="3"><?php echo $row['medicamento']; ?></textarea><br>
												<span class="input-group-addon">Enfermedad que Tiene:</span>
                                                <textarea class="form-control" name="enfermedad" value="<?php echo $row['enfermedad']; ?>"  rows="3"><?php echo $row['enfermedad']; ?></textarea><br>
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
					 <!-- Modal -->           			
							<div class="modal fade" id="eliminar<?php echo $url; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<form name="contado" action="index.php?del=<?php echo $url; ?>" method="get">
									<input type="hidden" name="id" value="<?php echo $url; ?>">
										<div class="modal-dialog">
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
																	una vez Eliminado el paciente [ <?php echo $row['nombre']; ?> ]<br> 
																	no podran ser Recuperados sus datos.<br>
																	No recomendamos esta accion, sino la de "Activo" o No Activo, porque de este
																	depende mucha informcion en el Almacen de datos.
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
										</div>
									</form>
							</div>
						<!-- End Modals-->
						<!-- Modal -->           			
							<div class="modal fade" id="familia<?php echo $url; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<form name="form2" method="post" action="">
									<input type="hidden" name="id" value="<?php echo $url; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>													
													<h3 align="center" class="modal-title" id="myModalLabel"><?php echo $row['nombre']; ?> [FAMILIA]</h3>
												</div>
													<?php if(permiso($_SESSION['cod_user'],'3')==TRUE){ ?>
													<div class="panel-body">
													<?php
													$hf=mysql_query("SELECT * FROM pediatria_hf WHERE consultorio='$id_consultorio' AND id_paciente=$url");
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
						<!-- Modal -->           			
							<div class="modal fade" id="desarrollo<?php echo $url; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<form name="form2" method="post" action="">
									<input type="hidden" name="id" value="<?php echo $url; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>													
													<h4 align="center" class="modal-title" id="myModalLabel"><?php echo $row['nombre']; ?> [DESARROLLO]</h4>
												</div>
													<?php if(permiso($_SESSION['cod_user'],'3')==TRUE){ ?>
													<div class="panel-body">
													<?php
													$hd=mysql_query("SELECT * FROM pediatria_drllo WHERE consultorio='$id_consultorio' AND id_paciente=$url");
													if($rowd=mysql_fetch_array($hd)){
																																																		
													}		
													
													?>
														<br>
														<div class="col-md-4">
															<input class="form-control" title="Termino" name="termino" placeholder="Termino" value="<?php echo $rowd['termino']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Parto" name="parto" placeholder="Parto" value="<?php echo $rowd['parto']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Grupo Rh" name="rh" placeholder="Grupo Rh" value="<?php echo $rowd['rh']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Cond. Nac." name="con_nac" placeholder="Cond. Nac." value="<?php echo $rowd['con_nac']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Peso al Nac." name="peso_nac" placeholder="Peso al Nac." value="<?php echo $rowd['peso_nac']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Talla al Nac." name="talla_nac" placeholder="Talla al Nac." value="<?php echo $rowd['talla_nac']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Condicion 1. semana" name="con_semana" placeholder="Condicion 1. semana" value="<?php echo $rowd['con_semana']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-8">
															<input class="form-control" title="Alimentacion" name="alimentacion" placeholder="Alimentacion" value="<?php echo $rowd['alimentacion']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Cianosis" name="cianosis" placeholder="Cianosis" value="<?php echo $rowd['cianosis']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se Sentó" name="sento" placeholder="Se Sentó" value="<?php echo $rowd['sento']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Se Paró" name="paro" placeholder="Se Paró" value="<?php echo $rowd['paro']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Convulsiones" name="convulsiones" placeholder="Convulsiones" value="<?php echo $rowd['convulsiones']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Caminó" name="camino" placeholder="Caminó" value="<?php echo $rowd['camino']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Primeras Palabras" name="palabras" placeholder="Primeras Palabras" value="<?php echo $rowd['palabras']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Ictericia" name="ictericia" placeholder="Ictericia" value="<?php echo $rowd['ictericia']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Primer Diente" name="diente" placeholder="Primer Diente" value="<?php echo $rowd['diente']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Fraces Cortas" name="fraces" placeholder="Fraces Cortas" value="<?php echo $rowd['fraces']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Apga-2" name="apga" placeholder="Apga-2" value="<?php echo $rowd['apga']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Control Vesical" name="vesical" placeholder="Control Vesical" value="<?php echo $rowd['vesical']; ?>" autocomplete="off" required><br>
															</div>
															<div class="col-md-4">
															<input class="form-control" title="Control Instestinos" name="instestinos" placeholder="Control Instestinos" value="<?php echo $rowd['instestinos']; ?>" autocomplete="off" required><br>
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
						<!-- Modal -->           			
							<div class="modal fade" id="alimentacion<?php echo $url; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<form name="form2" method="post" action="">
									<input type="hidden" name="id" value="<?php echo $url; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>													
													<h4 align="center" class="modal-title" id="myModalLabel"><?php echo $row['nombre']; ?> [ALIMENTACION]</h4>
												</div>
													<?php if(permiso($_SESSION['cod_user'],'3')==TRUE){ ?>
													<div class="panel-body">
													<?php
													$ha=mysql_query("SELECT * FROM pediatria_alim WHERE consultorio='$id_consultorio' AND id_paciente=$url");
													if($rowa=mysql_fetch_array($ha)){
																																																		
													}		
													
													?>
														<br>
														<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Pecho:</span>
															<input class="form-control"  name="pecho"  value="<?php echo $rowa['pecho']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Formula:</span>
															<input class="form-control" name="formula"  value="<?php echo $rowa['formula']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Vitaminas:</span>
															<input class="form-control"  name="vitaminas"  value="<?php echo $rowa['vitaminas']; ?>"  autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Alim. Suaves:</span>
															<input class="form-control"  name="suaves"  value="<?php echo $rowa['suaves']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Dieta:</span>
															<input class="form-control"  name="dieta"  value="<?php echo $rowa['dieta']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Hab. alim.:</span>
															<input class="form-control"  name="habitos"  value="<?php echo $rowa['habitos']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Vomitos:</span>
															<input class="form-control"  name="vomitos"  value="<?php echo $rowa['vomitos']; ?>" autocomplete="off" required><br>
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															 <span class="input-group-addon">Cólicos:</span>
															<input class="form-control"  name="colicos"  value="<?php echo $rowa['colicos']; ?>" autocomplete="off" required><br>
															</div><br>
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
						<!-- Modal -->           			
							<div class="modal fade" id="enfermedades<?php echo $url; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<form name="form2" method="post" action="">
									<input type="hidden" name="id" value="<?php echo $url; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>													
													<h4 align="center" class="modal-title" id="myModalLabel"><?php echo $row['nombre']; ?> [ENFERMEDADES]</h4>
												</div>
													<?php if(permiso($_SESSION['cod_user'],'3')==TRUE){ ?>
													<div class="panel-body">
													<?php
													$henf=mysql_query("SELECT * FROM pediatria_enf WHERE consultorio='$id_consultorio' AND id_paciente=$url");
													if($rowenf=mysql_fetch_array($henf)){
																																																		
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
						<!-- Modal -->           			
							<div class="modal fade" id="antecedentespre<?php echo $url; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<form name="form2" method="post" action="">
									<input type="hidden" name="id" value="<?php echo $url; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>													
													<h4 align="center" class="modal-title" id="myModalLabel"><?php echo $row['nombre']; ?> [ANTECEDENTES]</h4>
												</div>
													<?php if(permiso($_SESSION['cod_user'],'3')==TRUE){ ?>
													<div class="panel-body">
													<?php
													$hpre=mysql_query("SELECT * FROM prenatal WHERE consultorio='$id_consultorio' AND id_paciente=$url");
													if($rowp=mysql_fetch_array($hpre)){
																																																		
													}		
													
													?>
														<br>
														<div class="col-md-6">
															<span class="input-group-addon">ANTECEDENTES FAMILIARES:</span>
															<textarea class="form-control" name="familiares" value="<?php echo $rowp['familiares']; ?>" rows="3" required><?php echo $rowp['familiares']; ?></textarea><br>
															</div>
															<div class="col-md-6">
															<span class="input-group-addon">ANTECEDENTES PERSONALES:</span>
															<textarea class="form-control" name="personales" value="<?php echo $rowp['personales']; ?>" rows="3" required><?php echo $rowp['personales']; ?></textarea><br>
															</div>
															<div class="col-md-6">
															<div class="input-group date form_date" data-link-format="yyyy-mm-dd">
																 <span class="input-group-addon">Ult.Parto.</span>
																<input type="text" class="form-control" name="ultimo" autocomplete="off" required min="1" value="<?php echo $rowp['ultimo']; ?>" readonly><br>
																<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
															</div><br>															
															</div>
															<div class="col-md-6">
															<select class="form-control input-sm" name="parto" autocomplete="off" required>
																	<option value="vaginal" <?php if($rowp['parto']=='vaginal'){ echo 'selected'; } ?>>VAGINAL</option>
													      			<option value="cesarea" <?php if($rowp['parto']=='cesarea'){ echo 'selected'; } ?>>CESAREA</option>
													      			<option value="aborto" <?php if($rowp['parto']=='oborto'){ echo 'selected'; } ?>>ABORTO</option>																														
															</select><br>
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
						<!-- Modal -->           			
							<div class="modal fade" id="emabarazopre<?php echo $url; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<form name="form2" method="post" action="">
									<input type="hidden" name="id" value="<?php echo $url; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>													
													<h4 align="center" class="modal-title" id="myModalLabel"><?php echo $row['nombre']; ?> [EMBARAZO ACTUAL]</h4>
												</div>
													<?php if(permiso($_SESSION['cod_user'],'3')==TRUE){ ?>
													<div class="panel-body">
													<?php
													$hemb=mysql_query("SELECT * FROM prenatal_emb WHERE consultorio='$id_consultorio' AND id_paciente=$url");
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
						 <!-- Modal -->           			
							<div class="modal fade" id="expediente<?php echo $id_expediente; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<form name="form2" method="post" action="">
										<input type="hidden" value="<?php echo $id_expediente; ?>" name="id">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													
														<h4 align="center" class="modal-title" id="myModalLabel"><?php echo $row['nombre']; ?></h4>
													</div>
										<?php if(permiso($_SESSION['cod_user'],'3')==TRUE){ ?>
										<div class="panel-body">
										<div class="row">
										<?php
										$sqlz=mysql_query("SELECT * FROM pediatria WHERE consultorio='$id_consultorio' AND id_paciente=$id_expediente");
										if($rowz=mysql_fetch_array($sqlz)){
																																															
										}		
										
										?>
										                	<div class="col-md-12">
															<br>																																																																																	
															<div class="input-group">
															  <span class="input-group-addon">Obstetra:</span>
																<input class="form-control" name="obstetra" value="<?php echo $rowz['obstetra']; ?>" autocomplete="off"><br>																							 
															</div><br>
															<div class="input-group">
															  <span class="input-group-addon">Lugar Nac.:</span>																					
																<input class="form-control"  name="lugar"  value="<?php echo $rowz['lugar']; ?>" autocomplete="off" required><br>
															</div><br>
															<div class="input-group">
															  <span class="input-group-addon">Nombre de Madre:</span>	
																<input class="form-control"  name="madre"   value="<?php echo $rowz['padre']; ?>" autocomplete="off" required><br>	
															</div><br>
															<div class="input-group">
															  <span class="input-group-addon">Nombre de Padre:</span>
																<input class="form-control"  name="padre"   value="<?php echo $rowz['madre']; ?>"autocomplete="off" required><br>		
															</div><br>
															</div>
															<div class="col-md-6">
															<div class="input-group">
															  <span class="input-group-addon">Estado:</span>
															<select class="form-control" name="estado" placeholder="Estado" autocomplete="off" required>						
																	<option value="s" <?php if($rowz['estado']=='s'){ echo 'selected'; } ?>>Activo</option>
													      			<option value="n" <?php if($rowz['estado']=='n'){ echo 'selected'; } ?>>No Activo</option>													
																</select><br>
															</div>
															</div><br>
															<div class="col-md-6">
															<div class="input-group">
															  <span class="input-group-addon">Ref.:</span>
															<input class="form-control" name="referido" placeholder="Referdido Por" value="<?php echo $rowz['referido']; ?>" autocomplete="off" required><br>
															</div><br>              			                         
                                       
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
						
                                        </tr> 
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
         <!-- CUSTOM SCRIPTS -->
    <script src="../../assets/js/custom.js"></script>
	 <script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('.form_time').datetimepicker({
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
</script>	       
</body>
</html>