<?php
class Proceso_Pediatria{
	var $id;	
	#var $documento;
	var $nombre;
    var $direccion;			
	var $telefono;		
	var $edad;		
	var $lugar;		
	var $padre;		
	var $madre;		
	var $sexo;		
	var $obstetra;	
	var $referido;	
	var $estado;
	var $id_consultorio;
#tabla pediatria_hf
	var $padrehf;
	var $edadpdre;
	var	$madrehf;
	var $edadmdre;
	var $hermanohf;
	var $edadhno;
	var $hermanahf;
	var $edadhna;
	var $tuberculosis;
	var $diabetes;
	var $alergia;
	var $convulsioneshf;
	var $congenicas;
	var $otroshf;
#tabla pediatria_drllo
	var $termino;
	var $parto;
	var $rh;
	var $con_nac;
	var $peso_nac;
	var $talla_nac;
	var $con_semana;
	var $alimentacion;
	var $cianosis;
	var $sento;
	var $paro;
	var $convulsiones;
	var $camino;
	var $palabras;
	var $ictericia;
	var $diente;
	var $fraces;
	var $apga;
	var $vesical;
	var $instestinos;										
#tabla pediatria_alim
	var $pecho;
	var $formula;
	var $vitaminas;
	var $suaves;
	var $dieta;
	var $habitos;
	var $vomitos;
	var $colicos;
#tabla pediatria_enf
	var $tosferina;
	var $apendicitis;
	var $sarampion;
	var $reumatica;
	var $rubeola;
	var $otitis;
	var $paperas;
	var $irs;
	var $varicela;
	var $amigdalitis;
	var $escarlatina;
	var $convulsionesx;
	var $difteria;
	var $constipacion;
	var $operaciones;
	var $diarrea;
	var $amebiasis;
	var $otrosenf;
	
	function __construct($id,$nombre,$direccion,$telefono,$edad,$lugar,$padre,$madre,$sexo,$obstetra,$referido,$estado,$id_consultorio,
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
						$amebiasis,$otrosenf){
		$this->id=$id;		
		#$this->documento=$documento;	
		$this->nombre=$nombre;		
		$this->direccion=$direccion;	
		$this->telefono=$telefono;
		$this->edad=$edad;	
		$this->lugar=$lugar;	
		$this->padre=$padre;	
		$this->madre=$madre;	
		$this->sexo=$sexo;	
		$this->obstetra=$obstetra;			
		$this->referido=$referido;			
		$this->estado=$estado;	
		$this->id_consultorio=$id_consultorio;
		#tabla pediatria_hf
		$this->padrehf=$padrehf;
		$this->edadpdre=$edadpdre;
		$this->madrehf=$madrehf;
		$this->edadmdre=$edadmdre;
		$this->hermanohf=$hermanohf;
		$this->edadhno=$edadhno;
		$this->hermanahf=$hermanahf;
		$this->edadhna=$edadhna;
		$this->tuberculosis=$tuberculosis;
		$this->diabetes=$diabetes;
		$this->alergia=$alergia;
		$this->convulsioneshf=$convulsioneshf;
		$this->congenicas=$congenicas;
		$this->otroshf=$otroshf;
		#tabla pediatria_drllo
		$this->termino=$termino;
		$this->parto=$parto;
		$this->rh=$rh;
		$this->con_nac=$con_nac;
		$this->peso_nac=$peso_nac;
		$this->talla_nac=$talla_nac;
		$this->con_semana=$con_semana;
		$this->alimentacion=$alimentacion;
		$this->cianosis=$cianosis;
		$this->sento=$sento;
		$this->paro=$paro;
		$this->convulsiones=$convulsiones;
		$this->camino=$camino;
		$this->palabras=$palabras;
		$this->ictericia=$ictericia;
		$this->diente=$diente;
		$this->fraces=$fraces;
		$this->apga=$apga;
		$this->vesical=$vesical;
		$this->instestinos=$instestinos;										
		#tabla pediatria_alim
		$this->pecho=$pecho;
		$this->formula=$formula;
		$this->vitaminas=$vitaminas;
		$this->suaves=$suaves;
		$this->dieta=$dieta;
		$this->habitos=$habitos;
		$this->vomitos=$vomitos;
		$this->colicos=$colicos;
		#tabla pediatria_enf
		$this->tosferina=$tosferina;
		$this->apendicitis=$apendicitis;
		$this->sarampion=$sarampion;
		$this->reumatica=$reumatica;
		$this->rubeola=$rubeola;
		$this->otitis=$otitis;
		$this->paperas=$paperas;
		$this->irs=$irs;
		$this->varicela=$varicela;
		$this->amigdalitis=$amigdalitis;
		$this->escarlatina=$escarlatina;
		$this->convulsionesx=$convulsionesx;
		$this->difteria=$difteria;
		$this->constipacion=$constipacion;
		$this->operaciones=$operaciones;
		$this->diarrea=$diarrea;
		$this->amebiasis=$amebiasis;
		$this->otrosenf=$otrosenf;
	}
	
	function crear(){
		$id=$this->id;		
		#$documento=$this->documento;		
		$nombre=$this->nombre;		
		$direccion=$this->direccion;	
		$telefono=$this->telefono;	
		$edad=$this->edad;	
		$lugar=$this->lugar;	
		$padre=$this->padre;	
		$madre=$this->madre;	
		$sexo=$this->sexo;	
		$obstetra=$this->obstetra;	
		$referido=$this->referido;	
		$estado=$this->estado;	
		$id_consultorio=$this->id_consultorio;
		#tabla pediatria_hf
		$padrehf=$this->padrehf;
		$edadpdre=$this->edadpdre;
		$madrehf=$this->madrehf;
		$edadmdre=$this->edadmdre;
		$hermanohf=$this->hermanohf;
		$edadhno=$this->edadhno;
		$hermanahf=$this->hermanahf;
		$edadhna=$this->edadhna;
		$tuberculosis=$this->tuberculosis;
		$diabetes=$this->diabetes;
		$alergia=$this->alergia;
		$convulsioneshf=$this->convulsioneshf;
		$congenicas=$this->congenicas;
		$otroshf=$this->otroshf;
		#tabla pediatria_drllo
		$termino=$this->termino;
		$parto=$this->parto;
		$rh=$this->rh;
		$con_nac=$this->con_nac;
		$peso_nac=$this->peso_nac;
		$talla_nac=$this->talla_nac;
		$con_semana=$this->con_semana;
		$alimentacion=$this->alimentacion;
		$cianosis=$this->cianosis;
		$sento=$this->sento;
		$paro=$this->paro;
		$convulsiones=$this->convulsiones;
		$camino=$this->camino;
		$palabras=$this->palabras;
		$ictericia=$this->ictericia;
		$diente=$this->diente;
		$fraces=$this->fraces;
		$apga=$this->apga;
		$vesical=$this->vesical;
		$instestinos=$this->instestinos;
		#tabla pediatria_alim
		$pecho=$this->pecho;
		$formula=$this->formula;
		$vitaminas=$this->vitaminas;
		$suaves=$this->suaves;
		$dieta=$this->dieta;
		$habitos=$this->habitos;
		$vomitos=$this->vomitos;
		$colicos=$this->colicos;
		#tabla pediatria_enf
		$tosferina=$this->tosferina;
		$apendicitis=$this->apendicitis;
		$sarampion=$this->sarampion;
		$reumatica=$this->reumatica;
		$rubeola=$this->rubeola;
		$otitis=$this->otitis;
		$paperas=$this->paperas;
		$irs=$this->irs;
		$varicela=$this->varicela;
		$amigdalitis=$this->amigdalitis;
		$escarlatina=$this->escarlatina;
		$convulsionesx=$this->convulsionesx;
		$difteria=$this->difteria;
		$constipacion=$this->constipacion;
		$operaciones=$this->operaciones;
		$diarrea=$this->diarrea;
		$amebiasis=$this->amebiasis;
		$otrosenf=$this->otrosenf;

		mysql_query("INSERT INTO pacientes (nombre, direccion, telefono, edad, sexo, email, estado, consultorio) 
					VALUES ('$nombre','$direccion','$telefono','$edad','$sexo','','$estado','$id_consultorio')");
		
		$cans=mysql_query("SELECT MAX(id) AS id FROM pacientes");
			if($dat=mysql_fetch_array($cans))
			$id_paciente =$dat['id'];
			{
				$xSQL="INSERT INTO pediatria (id_paciente,nombre, edad, lugar, padre, madre,  sexo, obstetra, referido, estado, consultorio) 
					VALUES ('$id_paciente','$nombre','$edad','$lugar','$padre','$madre','$sexo','$obstetra','$referido','$estado','$id_consultorio')";
				mysql_query($xSQL);
				
				$hfSQL="INSERT INTO pediatria_hf (id_paciente, padrehf, edadpdre, madrehf, edadmdre, hermanohf, edadhno, hermanahf, edadhna, tuberculosis, diabetes, 
													alergia, convulsioneshf, congenicas, otroshf, consultorio) 
						VALUES ('$id_paciente','$padrehf','$edadpdre','$madrehf','$edadmdre','$hermanohf','$edadhno','$hermanahf','$edadhna','$tuberculosis','$diabetes',
												   '$alergia','$convulsioneshf','$congenicas','$otroshf','$id_consultorio')";
				mysql_query($hfSQL);
				
				$drlloSQL="INSERT INTO pediatria_drllo (id_paciente, termino, parto, rh, con_nac, peso_nac, talla_nac, con_semana, alimentacion, cianosis, sento, 
													paro, convulsiones, camino, palabras, ictericia, diente, fraces, apga, vesical,	instestinos, consultorio) 
						VALUES ('$id_paciente','$termino','$parto','$rh','$con_nac','$peso_nac','$talla_nac','$con_semana','$alimentacion','$cianosis','$sento',
													'$paro','$convulsiones','$camino','$palabras','$ictericia','$diente','$fraces','$apga','$vesical','$instestinos','$id_consultorio')";
				mysql_query($drlloSQL);
				
				$alimSQL="INSERT INTO pediatria_alim (id_paciente, pecho, formula, vitaminas, suaves, dieta, habitos, vomitos, colicos, consultorio) 
											  VALUES ('$id_paciente','$pecho','$formula','$vitaminas','$suaves','$dieta','$habitos','$vomitos','$colicos','$id_consultorio')";
				mysql_query($alimSQL);
				
				$enfSQL="INSERT INTO pediatria_enf (id_paciente, tosferina, apendicitis, sarampion, reumatica, rubeola, otitis, paperas, irs, varicela, amigdalitis,
													escarlatina, convulsionesx, difteria, constipacion, operaciones, diarrea, amebiasis, otrosenf, consultorio) 
										   VALUES ('$id_paciente','$tosferina','$apendicitis','$sarampion','$reumatica','$rubeola','$otitis','$paperas','$irs','$varicela','$amigdalitis',
													'$escarlatina','$convulsionesx','$difteria','$constipacion','$operaciones','$diarrea','$amebiasis','$otrosenf','$id_consultorio')";
				mysql_query($enfSQL);
				
			}
		
	}
	
	function actualizar(){
		$id=$this->id;		
		#$documento=$this->documento;		
		$nombre=$this->nombre;		
		$direccion=$this->direccion;	
		$telefono=$this->telefono;	
		$edad=$this->edad;	
		$sexo=$this->sexo;	
		$email=$this->email;	
		$estado=$this->estado;		
		
		mysql_query("UPDATE pacientes SET  
										nombre='$nombre',
										direccion='$direccion',
										telefono='$telefono',
										edad='$edad',
										sexo='$sexo',										
										email='$email',
										estado='$estado'
									WHERE id='$id'");
											
	}
}
?>