<!-- /. NAV TOP  -->
                <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				<li class="text-center">
                    <?php
						if (file_exists("../../img/usuario/".$_SESSION['cod_user'].".jpg")){
						echo '<img src="../../img/usuario/'.$_SESSION['cod_user'].'.jpg" class="user-image img-responsive"/>';
						}else{
						echo '<img src="../../img/usuario/default.png" class="user-image img-responsive"/>';
						}
					?>
                    <!--<img src="assets/img/find_user.png" class="user-image img-responsive"/>-->
					</li>
				
					
                    <li>
                        <a  href="../../principal.php"><i class="fa fa-home fa-3x"></i> Inicio</a>
                    </li>
                   <li>
                        <a class="active-menu" href="../pacientes/index.php"><i class="fa fa-user fa-3x"></i> Pacientes</a>
                    </li>
					<li>
                        <a  href="../citas_medicas/index.php"><i class="fa fa-edit fa-3x"></i> Citas Medicas</a>
                    </li>	
                      
                    <li>
                        <a  href="../consultas_medicas/index.php"><i class="fa fa-qrcode fa-3x"></i> Consultas Medicas</a>
                    </li>					
                    <li>
                        <a  href="../expedientes/index.php"><i class="fa fa-bar-chart-o fa-3x"></i> Expedientes </a>
                    </li>				
					
					                   
                    <li>
                        <a href="#"><i class="fa fa-cog fa-3x"></i> Administración<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../empresa/index.php"> Empresa</a>
                            </li>
							<li>
                                <a href="../cargos/index.php"> Cargos</a>
                            </li>
                            <li>
                                <a href="../usuarios/index.php"> Usuarios</a>
                            </li>
                            <li>
                                <a href="../medicos/index.php"> Médicos</a>
                            </li>
							<li>
                                <a href="../consultorios/index.php"> Consultorio</a>
                            </li>
							<li>
                                <a href="../expedientes/index.php">  Expedientes</a>
                            </li>
                            <!--<li>
                                <a href="#"> Localidad<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="../departamentos/index.php"> Estado</a>
                                    </li>
                                    <li>
                                        <a href="../municipios/index.php"> Ciudad</a>
                                    </li>                                   
                               </ul>                              
                            </li>-->
                        </ul>
						 <li>
							   <a href="#"><i class="fa fa-cloud-download fa-2x"></i> Mantenimiento de Datos<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="../../modulos/backup/backup.php"> Respaldo de Datos</a>
									</li>
									<li>
										<a href="../../modulos/backup/restore.php">Restauraración de Datos</a>
									</li>
								</ul>
							</li>
                      </li>                   
                </ul>
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->