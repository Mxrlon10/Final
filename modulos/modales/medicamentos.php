<!--  MUESTRA LA CONSULTA EN SI-->
<div class="modal fade" id="med<?php echo $url; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form name="form1" method="post" action="">
		<input type="hidden" name="idcon" value="<?php echo $genconsul; ?>">
		<div class="modal-dialog" role="document" >
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>								<h4 align="center" class="modal-title" id="myModalLabel">DETALLE DE RECETA</h4>
				</div>
				<div class="panel-body">
					<div class="row">
					<div align="center">
                    <div class="btn-group">
                      <button type="button" onclick="imprimiry();" class="btn btn-success"><i class=" fa fa-print "></i> Imprimir</button>
                      <!--<button type="button" class="btn btn-default"><i class=" fa fa-list"></i> PDF</button>-->
                    </div>
	                </div><br>
					 <div id="imprimemey">
					 <div class="hidden">
					  <table  width="100%" style="border: 0px solid #660000; -moz-border-radius: 12px;-webkit-border-radius: 12px;padding: 10px; font-size:12px; font-family:Times New Roman;">               
		                 <tr>
		                    <td>
		                        <center>
		                        <img src="../../img/logo.jpg" width="130px" height="130px"><br>
		                        <!--<strong><?php echo $nombre_empresa; ?></strong><br>-->
		                        </center>                                                    
		                    </td>
		                    <td align="center">                     
		                       <div style="font-size: 18px;"><strong><em><?php echo $nombre_medico; ?></em></strong></div>
                                <div style="font-size: 14px;"><strong><?php echo $nombre_Consultorio; ?></strong></div>
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
					 </div>
			            <div class="col-md-12"><br>
			             <table class="table table-striped table-hover" width="95%" style="border: 1px solid #660000; -moz-border-radius: 12px;-webkit-border-radius: 12px;padding: 10px;">
						    <tr>
								<td colspan="3" align="left" class="text-danger" style="font-size: 12px;"><strong>Paciente:</strong> <?php echo $oPaciente->consultar('nombre'); ?></td>
								<td colspan="1" align="center" class="text-danger" style="font-size: 10px;"><strong>Fecha: <?php echo fecha($fecha); ?> </td>
							</tr>
						                <tr>
											   <td colspan="3" align="left" class="text-danger" style="font-size: 12px;"><strong>Edad:</strong> 	<?php echo CalculaEdad($oPaciente->consultar('edad')); ?> Años</td>
											   <td colspan="1" align="center" class="text-danger" style="font-size: 12px;"><strong>Peso: <?php echo consultar('peso','consultas_medicas',"id='".$url."'"); ?> </td>
									    </tr>
										<tr>
											   <!--<td colspan="4" align="left" class="text-danger" style="font-size: 13px;"><strong>Firma:________________________</strong></td>-->																			  										  
										</tr>                       	
										<?php											
												$pa=mysql_query("SELECT * FROM medicamentos WHERE consulta='$url'");				
													while($row=mysql_fetch_array($pa)){
														$oPaciente=new Consultar_Paciente($row['paciente']);
														#$oPaciente=new Consultar_Paciente($row['id_paciente']);
											?>		
										<tr>
												<td style="font-size: 13px;" width="20%"></td>
													<td colspan="3" style="font-size: 12px;"><br>
														 <ul>
															<l><strong><?php echo $row['med1']; ?></strong></li><br>
															<?php echo $row['indi1']; ?><br>
															
															<l><strong><?php echo $row['med2']; ?></strong></li><br>
															<?php echo $row['indi2']; ?><br>
														
															<l><strong><?php echo $row['med3']; ?></strong></li><br>
															<?php echo $row['indi3']; ?><br>
															
															<l><strong><?php echo $row['med4']; ?></strong></li><br>
															<?php echo $row['indi4']; ?><br>
															
															<l><strong><?php echo $row['med5']; ?></strong></li><br>
															<?php echo $row['indi5']; ?><br>
															
															<l><strong><?php echo $row['med6']; ?></strong></li><br>
															<?php echo $row['indi6']; ?><br>
															
															<l><strong><?php echo $row['med7']; ?></strong></li><br>
															<?php echo $row['indi7']; ?><br>
															
															<l><strong><?php echo $row['med8']; ?></strong></li><br>
															<?php echo $row['indi8']; ?><br>
															
															<l><strong><?php echo $row['med9']; ?></strong></li><br>
															<?php echo $row['indi9']; ?><br>
															
															<l><strong><?php echo $row['med10']; ?></strong></li><br>
															<?php echo $row['indi10']; ?><br>
															
															<l><strong><?php echo $row['med11']; ?></strong></li><br>
															<?php echo $row['indi11']; ?><br>
															
															<l><strong><?php echo $row['med12']; ?></strong></li><br>
															<?php echo $row['indi12']; ?><br>
															
															<l><strong><?php echo $row['med13']; ?></strong></li><br>
															<?php echo $row['indi13']; ?><br>
															
															<l><strong><?php echo $row['med14']; ?></strong></li><br>
															<?php echo $row['indi14']; ?><br>
															
															<l><strong><?php echo $row['med15']; ?></strong></li><br>
															<?php echo $row['indi15']; ?><br>
															
														</ul>
													</td>
										</tr> 
										<?php } ?>                   
						</table>
						<table class="table" width="95%" style="border: 0px solid #660000; -moz-border-radius: 12px;-webkit-border-radius: 12px;padding: 10px;">
						                  <tr>
											   <td colspan="4" align="center" class="text-danger" style="font-size: 12px;"><?php echo $dir_empresa; ?></td>
											</tr>
											<tr>
											   <td colspan="4" align="center" class="text-danger" style="font-size: 12px;"><?php echo $tel_empresa; ?> * <?php echo $pais_empresa; ?> * <?php echo $email; ?> </td>																			  										  
											</tr>                       	
						</table>   
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