<?php 
	session_start();
	include_once "modulos/php_conexion.php";
	include_once "modulos/class_buscar.php";
	include_once "modulos/funciones.php";
	
	if($_SESSION['cod_user']){
	}else{
		header('Location: php_cerrar.php');
	}
	
	#$oUsuario=new Consultar_Usuario($_SESSION['cod_user']);
	#$Nombre=$oUsuario->consultar('nom');
	
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
		
	if(!empty($_GET['status'])){
			$nit=limpiar($_GET['status']);
			$cans=mysql_query("SELECT * FROM citas_medicas WHERE status='PROCESADO' and id='$nit'");
			if($dat=mysql_fetch_array($cans)){
				$xSQL="Update citas_medicas Set status='PENDIENTE' Where id='$nit'";
				mysql_query($xSQL);
				header('location:principal.php');
			}else{
				$xSQL="Update citas_medicas Set status='PROCESADO' Where id='$nit'";
				mysql_query($xSQL);
				header('location:principal.php');
			}
		}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $nombre_empresa; ?></title>	
	<link href="assets/css/bootstrap.css" rel="stylesheet" /><!--OK-->
    <link href="assets/css/calendar.css" rel="stylesheet">
	<link href="assets/css/font-awesome.css" rel="stylesheet" /><!--OK-->      
    <link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
     <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
	

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
                <a class="navbar-brand" href="modulos/usuarios/perfil.php"><?php echo $_SESSION['user_name']; ?></a> 
            </div>
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;">Consultorio: <?php echo $nombre_Consultorio; ?> :: Fecha de Acceso : <?php echo fecha(date('Y-m-d')); ?> &nbsp; <a href="php_cerrar.php" class="btn btn-danger square-btn-adjust">salir</a> </div>
        </nav>   
           <?php include_once "menu/m_principal.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">               
                 <div class="row">
               
			  <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-red set-icon">
                    <i class="fa fa-group"></i>
                </span>
                <div class="text-box" >
						<?php
							// primero conectamos siempre a la base de datos mysql
							$sql = "SELECT * FROM pacientes WHERE consultorio='$id_consultorio'";  // sentencia sql
							$result = mysql_query($sql);
							$numero = mysql_num_rows($result); // obtenemos el número de filas
							
							?>
                    <p class="main-text"> <?php echo "$numero" ?></p>
                    <p class="text-rocket"> Pacientes</p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-green set-icon">
                    <i class="fa fa-shopping-cart"></i>
                </span>
                <div class="text-box" >
					<?php
							// primero conectamos siempre a la base de datos mysql
							$sql = "SELECT * FROM consultas_medicas WHERE date_format(fecha,'%Y%m%d')=date_format(curdate(),'%Y%m%d') AND consultorio='$id_consultorio'";  // sentencia sql
							$result = mysql_query($sql);
							$numero = mysql_num_rows($result); // obtenemos el número de filas
							
							?>
                    <p class="main-text"> <?php echo "$numero" ?></p>
                    <p class="text-rocket"> Consultas</p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-brown set-icon">
                    <i class="fa fa-user"></i>
                </span>
                <div class="text-box" >
							<?php
							// primero conectamos siempre a la base de datos mysql
							$sql = "SELECT * FROM usuario";  // sentencia sql
							$result = mysql_query($sql);
							$numero = mysql_num_rows($result); // obtenemos el número de filas
							
							?>
                    <p class="main-text"> <?php echo "$numero" ?></p>
                    <p class="text-rocket"> Usuarios</p>
                </div>
             </div>
		     </div>
			 <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-blue set-icon">
                    <i class="fa fa-bell-o"></i>
                </span>
                <div class="text-box" >
							<?php
							// primero conectamos siempre a la base de datos mysql
							$sql = "SELECT * FROM citas_medicas WHERE consultorio='$id_consultorio' and status='PENDIENTE'";  // sentencia sql
							$result = mysql_query($sql);
							$numero = mysql_num_rows($result); // obtenemos el número de filas
							
							?>
                    <p class="main-text"> <?php echo "$numero" ?></p>
                    <p class="text-rocket"> Citas</p>
                </div>
             </div>
		     </div>
                    
			</div>
                 <!-- /. ROW  -->                                
               
				 <div class="panel-body">
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active"><a href="#dashboard" data-toggle="tab"><i class="glyphicon glyphicon-dashboard" ></i> DASHBOARD</a></li>
                                                              
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="dashboard">
									<br>
									<div class="col-md-6 col-sm-12 col-xs-12">              
									<div class="panel panel-primary">
										<div class="panel-heading">
										   Ultimos Pacientes Registrados
										</div>
										<div class="panel-body">
											<div class="table-responsive">
												<table class="table table-striped" style="font-size:12px; font-family:Times New Roman;">
													<thead>
														<tr>
															<th>#</th>
															<th>NOMBRE</th>
															<th>TELEFONO</th>                                           
														</tr>
													</thead>
													<tbody>
													<?php 
															if(!empty($_POST['buscar'])){
																$buscar=limpiar($_POST['buscar']);
																$pame=mysql_query("SELECT * FROM pacientes WHERE consultorio='$id_consultorio' and nombre LIKE '%$buscar%' ORDER BY id");	
															}else{
																$pame=mysql_query("SELECT * FROM pacientes WHERE consultorio='$id_consultorio' ORDER BY id DESC LIMIT 5");		
															}		
															while($row=mysql_fetch_array($pame)){
															$url=$row['id'];
														?>
														<tr>
															<td><?php echo $row['id']; ?></td>
															<td>
															<i class="fa fa-user fa-2x"></i>
															<a href="modulos/perfil_paciente/index.php?id=<?php echo $url; ?>" title="Valorar Alumno">
																<?php echo $row['nombre']; ?>
															</a>
															<td><?php echo $row['telefono']; ?></td>                                            
														</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>                   
								</div>
									<div class="col-md-6 col-sm-12 col-xs-12">              
										<div class="panel panel-primary">
											<div class="panel-heading">
											   Citas para Hoy
											</div>
											<div class="panel-body">
												<div class="table-responsive">
													<table class="table table-striped" style="font-size:12px; font-family:Times New Roman;">
														<thead>
															<tr> 
																<th>#</th>                                          
																<th>PACIENTE</th>                                                                                    
																<th>STATUS</th>                                           
															</tr>
														</thead>
														<tbody>
														<?php 
																if(!empty($_POST['buscar'])){
																	$buscar=limpiar($_POST['buscar']);
																	$pame=mysql_query("SELECT * FROM citas_medicas WHERE consultorio='$id_consultorio' and nombre LIKE '%$buscar%' ORDER BY id");	
																}else{
																	$pame=mysql_query("SELECT * FROM citas_medicas WHERE date_format(fechai,'%Y%m%d')=date_format(curdate(),'%Y%m%d') AND consultorio='$id_consultorio' and status='PENDIENTE' ORDER BY id ASC");		
																}		
																while($row=mysql_fetch_array($pame)){
																$url=$row['id'];
																/*if($row['status']=='PENDIENTE'){
																		$status='PENDIENTE';
																	}																								
																	elseif($row['status']=='PROCESADO'){
																		$status='PROCESADO';
																	}*/
																	$oPaciente=new Consultar_Paciente($row['id_paciente']);
																	$url=$row['id'];
															?>
															<tr>                                           
																<td><?php echo $row['id']; ?></td>                                                                                     
																<td><?php echo $oPaciente->consultar('nombre'); ?></td>                                                                                     
																<td><?php echo status($row['status']); ?></td>                                            
															</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>                   
									</div>                                  
								</div>
                            </div>
                        </div>               
                </div>
                 <!-- /. ROW  -->                                
         
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    <script type="text/javascript" src="assets/js/es-ES.js"></script>
	<script src="assets/js/jquery-1.10.2.js"></script><!--OK-->
    <script src="assets/js/moment.js"></script>
    <script src="assets/js/bootstrap.min.js"></script><!--OK-->
    <script src="assets/js/bootstrap-datetimepicker.js"></script>
    <script src="assets/js/underscore-min.js"></script>
    <script src="assets/js/calendar.js"></script>
	<script src="assets/js/bootstrap-datetimepicker.es.js"></script>
   <script type="text/javascript">
        (function($){
                //creamos la fecha actual
                var date = new Date();
                var yyyy = date.getFullYear().toString();
                var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
                var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();

                //establecemos los valores del calendario
                var options = {
                        modal: '#events-modal', // definimos que los eventos se mostraran en ventana modal
                        modal_type:'iframe',    // dentro de un iframe

                        events_source: '<?=$base_url?>obtener_eventos.php', //obtenemos los eventos de la base de datos

                        view: 'month',             // mostramos el calendario en el mes
                        day: yyyy+"-"+mm+"-"+dd,   // y dia actual

                        language: 'es-ES', // definimos el idioma por defecto
                        tmpl_path: '<?=$base_url?>tmpls/', //Template de nuestro calendario
                        tmpl_cache: false,

                        time_start: '08:00', // Hora de inicio
                        time_end: '22:00',   // y Hora final de cada dia
                        time_split: '15',    // intervalo de tiempo entre las hora, en este caso son 15 minutos

                        width: '100%', // Definimos un ancho del 100% a nuestro calendario

                        onAfterEventsLoad: function(events)
                        {
                                if(!events)
                                {
                                        return;
                                }
                                var list = $('#eventlist');
                                list.html('');

                                $.each(events, function(key, val)
                                {
                                        $(document.createElement('li'))
                                                .html('<a href="' + val.url + '">' + val.title + '</a>')
                                                .appendTo(list);
                                });
                        },
                        onAfterViewLoad: function(view)
                        {
                                $('.page-header h2').text(this.getTitle());
                                $('.btn-group button').removeClass('active');
                                $('button[data-calendar-view="' + view + '"]').addClass('active');
                        },
                        classes: {
                                months: {
                                        general: 'label'
                                }
                        }
                };

                var calendar = $('#calendar').calendar(options); // id del div donde se mostrara el calendario

                $('.btn-group button[data-calendar-nav]').each(function()
                {
                        var $this = $(this);
                        $this.click(function()
                        {
                                calendar.navigate($this.data('calendar-nav'));
                        });
                });

                $('.btn-group button[data-calendar-view]').each(function()
                {
                        var $this = $(this);
                        $this.click(function()
                        {
                                calendar.view($this.data('calendar-view'));
                        });
                });

                $('#first_day').change(function()
                {
                        var value = $(this).val();
                        value = value.length ? parseInt(value) : null;
                        calendar.setOptions({first_day: value});
                        calendar.view();
                });
        }(jQuery));
    </script>
<div class="modal fade" id="add_evento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel" align="center">Nuevo evento</h4>
      </div>
      <div class="modal-body">
        <form action="" method="post">
        <input type="hidden" name="url" value="<?=$base_url?>descripcion_evento.php?id=<?=$id_evento?>">
					 <label for="title">Título</label>
                    <input type="text" required autocomplete="off" name="title" class="form-control" id="title" placeholder="Introduce un título">
                    <br>
					<div class="col-md-6">
						<label for="from">Inicio</label>
                    <div class='input-group date' id='from'>
                        <input type='text' id="from" name="from" class="form-control" readonly />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </div>
                    <br>
					</div>
					<div class="col-md-6">
					<label for="to">Final</label>
                    <div class='input-group date' id='to'>
                        <input type='text' name="to" id="to" class="form-control" readonly />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </div>
                    <br>					
					</div>                                    
                    <label for="tipo">Tipo de evento</label>
                    <select class="form-control" name="class" id="tipo">
                        <option value="event-info">Informacion</option>
                        <option value="event-success">Exito</option>
                        <option value="event-important">Importantante</option>
                        <option value="event-warning">Advertencia</option>
                        <option value="event-special">Especial</option>
                    </select>
                    <br>                
                    <label for="body">Evento</label>
                    <textarea id="body" name="event" required class="form-control" rows="3"></textarea>

    <script type="text/javascript">
        $(function () {
            $('#from').datetimepicker({
                language: 'es',
                minDate: new Date()
            });
            $('#to').datetimepicker({
                language: 'es',
                minDate: new Date()
            });

        });
    </script>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
          <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Agregar</button>
        </form>
    </div>
  </div>
</div>
</div>
</body>
</html>
