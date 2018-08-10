<?php
    date_default_timezone_set("America/El_Salvador"); // Definimos nuestra zona horaria

    include '../modulos/funciones.php'; // incluimos el archivo de funciones
    include '../modulos/php_conexion.php';    // incluimos el archivo de configuracion

    $im=$conexion->query("SELECT MAX(id) AS id FROM eventos"); // Aqui buscamos el id con el mayor valor
    $row = $im->fetch_row();                                   // lo traemos
    $id = trim($row[0]);                                       // y guardamos en la variable $id
    $id_evento = $id+1;                                        // luego creamos la variable $id_evento que guardara la variable $id sumandole 1, esta variable se usa para guardar el link en la base de datos y tenga su id


if (isset($_POST['from'])) { // Verificamos si se ha enviado el campo con name from

    if ($_POST['from']!="" AND $_POST['to']!="") { // Si se ha enviado verificamos que no vengan vacios

        $inicio = _formatear($_POST['from']); // Recibimos el fecha de inicio y la fecha final desde el form
        $final  = _formatear($_POST['to']);   // y la formateamos con la funcion _formatear

        $titulo = evaluar($_POST['title']);   // Recibimos los demas datos desde el form
        $body   = evaluar($_POST['event']);   // y con la funcion evaluar
        $clase  = evaluar($_POST['class']);   // reemplazamos los caracteres con permitidos
        $link   = evaluar($_POST['url']);     // en los string

        $query="INSERT INTO eventos VALUES(null,'$titulo','$body','$link','$clase','$inicio','$final')";
        $conexion->query($query); // Ejecutamos nuestra sentencia sql

        header("Location:$base_url"); // redireccionamos a nuestra calendario

    }
}

 ?>

<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="utf-8">
        <title>Calendario</title>
		<link href="../assets/css/bootstrap.css" rel="stylesheet" /><!--OK-->
        <link href="../assets/css/calendar.css" rel="stylesheet">
		<link href="../assets/css/font-awesome.css" rel="stylesheet" /><!--OK-->      
        <link href="../assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />     
</head>
<body style="background: white;">

        <div class="container">

                <div class="row">
                        <div class="page-header"><h2></h2></div>
                                <div class="pull-left form-inline"><br>
                                        <div class="btn-group">
                                            <button class="btn btn-primary" data-calendar-nav="prev"><< Anterior</button>
                                            <button class="btn" data-calendar-nav="today">Hoy</button>
                                            <button class="btn btn-primary" data-calendar-nav="next">Siguiente >></button>
                                        </div>
                                        <div class="btn-group">
                                            <button class="btn btn-warning" data-calendar-view="year">Año</button>
                                            <button class="btn btn-warning active" data-calendar-view="month">Mes</button>
                                            <button class="btn btn-warning" data-calendar-view="week">Semana</button>
                                            <button class="btn btn-warning" data-calendar-view="day">Dia</button>
                                        </div>

                                </div>
                                    <div class="pull-right form-inline"><br>
                                        <button class="btn btn-info" data-toggle='modal' data-target='#add_evento'>Añadir Evento</button>
                                    </div>

                </div><hr>

                <div class="row">
                        <div id="calendar"></div> <!-- Aqui se mostrara nuestro calendario -->
                        <br><br>
                </div>

                <!--ventana modal para el calendario-->
                <div class="modal fade" id="events-modal">
                    <div class="modal-dialog">
                            <div class="modal-content">
                                    <div class="modal-body" style="height: 400px">
                                        <p>One fine body&hellip;</p>
                                    </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
        </div>
	<script type="text/javascript" src="../assets/js/es-ES.js"></script>
	<script src="../assets/js/jquery-1.10.2.js"></script><!--OK-->
    <script src="../assets/js/moment.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script><!--OK-->
    <script src="../assets/js/bootstrap-datetimepicker.js"></script>
    <script src="../assets/js/underscore-min.js"></script>
    <script src="../assets/js/calendar.js"></script>
	<script src="../assets/js/bootstrap-datetimepicker.es.js"></script>
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
        <h4 class="modal-title" id="myModalLabel">Agregar nuevo evento</h4>
      </div>
      <div class="modal-body">
        <form action="" method="post">
        <input type="hidden" name="url" value="<?=$base_url?>descripcion_evento.php?id=<?=$id_evento?>">
                    <label for="from">Inicio</label>
                    <div class='input-group date' id='from'>
                        <input type='text' id="from" name="from" class="form-control" readonly />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </div>

                    <br>

                    <label for="to">Final</label>
                    <div class='input-group date' id='to'>
                        <input type='text' name="to" id="to" class="form-control" readonly />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </div>

                    <br>

                    <label for="tipo">Tipo de evento</label>
                    <select class="form-control" name="class" id="tipo">
                        <option value="event-info">Informacion</option>
                        <option value="event-success">Exito</option>
                        <option value="event-important">Importantante</option>
                        <option value="event-warning">Advertencia</option>
                        <option value="event-special">Especial</option>
                    </select>

                    <br>


                    <label for="title">Título</label>
                    <input type="text" required autocomplete="off" name="title" class="form-control" id="title" placeholder="Introduce un título">

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
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
          <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Agregar</button>
        </form>
    </div>
  </div>
</div>
</div>
</body>
</html>