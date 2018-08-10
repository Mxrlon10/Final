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
				<div class="panel-body">                                              
<?php if(permiso($_SESSION['cod_user'],'1')==TRUE){ ?>
				
					
            <div class="row">
				<div align="center">
                    <div class="btn-group">
                      <button type="button" onclick="imprimir();" class="btn btn-default"><i class=" fa fa-print "></i> Imprimir</button>
                    </div>
                </div><br>
                <div class="col-md-12">
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
                    <td align="center">                     
                        <div style="font-size: 20px;"><strong><em><?php echo $nombre_medico; ?></em></strong></div>
                        <div style="font-size: 14px;"><strong><?php echo $nombre_Consultorio; ?></strong></div>
                                    
                        <!--<strong><?php echo $nombre_empresa; ?></strong><br>-->                                                 
                    </td>
                    <!--<td>
                        <center>
                        <img src="../../img/logo_dos.png" width="75px" height="75px"><br>
                        </center> 
                    </td>-->
                 </tr>                         
                </table>
                </div> 
				<table class="table table-striped table-bordered table-hover" rules="all" border="1" style="font-size:10px; font-family:Times New Roman;">
									<thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>NOMBRE</th>
                                            <th>DIRECCION</th>
                                            
                                            <th>TELEFONO</th>                                           
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
											$numero=1;
											$editar=0; 											
											$pame=mysql_query("SELECT * FROM pacientes WHERE consultorio='$id_consultorio' ORDER BY nombre");													
											while($row=mysql_fetch_array($pame)){
											$url=$row['id'];
											$id_expediente=$row['id'];
											$edad=$row['edad'];
										?>
                                        <tr class="odd gradeX">
                                            <td align="center"> <?php echo $numero++; ?></td>
                                            <td> <?php echo $row['nombre']; ?></td>
                                            <td><?php echo $row['direccion']; ?></td>
                                            
                                            <td align="center"><?php echo $row['telefono']; ?></td>                                           
                                            							
	                                      </tr> 
											<?php } ?>
                                    </tbody>									
                                </table>
                   
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
	 $('#form_date2').datetimepicker({
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
         <!-- CUSTOM SCRIPTS -->
    <script src="../../assets/js/custom.js"></script>
</body>
</html>