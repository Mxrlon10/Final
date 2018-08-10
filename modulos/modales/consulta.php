<!--  MUESTRA LA CONSULTA EN SI-->
<div class="modal fade" id="ver<?php echo $url; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form name="form1" method="post" action="">
		<input type="hidden" name="idcon" value="<?php echo $genconsul; ?>">
		<div class="modal-dialog" role="document" >
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>								<h4 align="center" class="modal-title" id="myModalLabel">DETALLE DE CONSULTA</h4>
				</div>
				<div class="panel-body">
					<div class="row">
					<div align="center">
                    <div class="btn-group">
                      <button type="button" onclick="imprimirx();" class="btn btn-success"><i class=" fa fa-print "></i> Imprimir</button>
                      <!--<button type="button" class="btn btn-default"><i class=" fa fa-list"></i> PDF</button>-->
                    </div>
	                </div><br>
					 <div id="imprimemex">
					 <div class="hidden">
					  <table  width="100%" style="border: 0px solid #660000; -moz-border-radius: 12px;-webkit-border-radius: 12px;padding: 10px;">               
		                 <tr>
		                    <td>
		                        <center>
		                        <img src="../../img/logo.jpg" width="100px" height="100px"><br>
		                        <!--<strong><?php echo $nombre_empresa; ?></strong><br>-->
		                        </center>                                                    
		                    </td>
		                    <td align="center">                     
		                       <div style="font-size: 16px;"><strong><em><?php echo $nombre_medico; ?></em></strong></div>
                                <div style="font-size: 12px;"><strong><?php echo $nombre_Consultorio; ?></strong></div>
                                    <strong>J.V.P.M 10606</strong><br>
                                Post-Grado Hospital Infantil de México Federico Gómez<br>459 780 3795                                                 
		                    </td>
		                    <!--<td>
		                        <center>
		                        <img src="../../img/logo_dos.png" width="75px" height="75px"><br>
		                        </center> 
		                    </td>-->
		                 </tr>                         
		              </table>
					 <hr/> 
					  <div style="font-size: 14px;" align="center">
			                     <strong>DETALLE DE CONSULTA GENERAL</strong><br>                              
			           </div>
			            <hr/> 
					 </div>
						<div class="col-md-12">
						   
						   <div style="font-size: 12px;">					
							<strong>PACIENTE: </strong><?php echo $nombre; ?><br>
			                <strong>DIRECCION: </strong><?php echo $direccion; ?><br>
			                <strong>TELEFONO: </strong><?php echo $telefono; ?><br>
			                <strong>FECHA: </strong><?php echo fecha($fecha); ?> ||  
			                <strong>HORA: </strong><?php echo date($hora); ?><br>
			                <strong>USUARIO: </strong><?php echo $cajero_nombre; ?><br>
			               </div>
			            </div>
			            <div class="col-md-12"><br>
			             <table  class="table table-striped table-bordered table-hover" width="100%"  style="font-size: 13px; border: 1px solid #660000; -moz-border-radius: 10px;-webkit-border-radius: 12px;padding: 10px;">               
		                 <tr>
		                    <td>  
			            <?php											
								$pa=mysql_query("SELECT * FROM consultas_medicas WHERE id='$url'");				
									while($roww=mysql_fetch_array($pa)){
										$oPaciente=new Consultar_Paciente($roww['id_paciente']);
										#$oPaciente=new Consultar_Paciente($row['id_paciente']);

						?>
						 <div style="font-size: 14px;">
						    <dl>
								<dt><strong>MOTIVO DE CONSULTA:</strong></dt>
								<dd><?php echo $roww['sintomas']; ?>.</dd><br>
								<dt><strong>EXAMEN FÍSICO:</strong></dt>
								<dd><?php echo $roww['observaciones']; ?>.</dd><br>
								<dt><strong>DIAGNOSTICO:</strong></dt>
								<dd><?php echo $roww['diagnostico']; ?>.</dd><br>
								<dt><strong>TRATAMIENTO:</strong></dt>
								<dd><?php echo $roww['tratamiento']; ?>.</dd>
							</dl>
						<?php } ?>
			            </div>
			               </td>
		                 </tr>                         
		              </table><br><br>
		              <div align="right">
                                    <strong>F._____________________________</strong><br>
                                            <?php echo $nombre_medico; ?><br>
                                </div> 
		              </div>
			            </div><!-- fin de iMprimir-->
					</div>
				</div> 
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>										 
			</div>
		</div>
	</form>
</div>
<!-- End Modals-->