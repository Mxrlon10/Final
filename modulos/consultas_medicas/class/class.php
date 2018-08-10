<?php
class Proceso_Consulta{
	var $id;	
	var $id_general;	
	var $id_medico;	
	var $id_consultorio;	
	var $consulta;	
		
	var $tratamiento;		
	var $observaciones;
	
	var $ant_per;
	var $ant_fm;
	var $peso;
	var $talla;
	var $ta;
	var $sc;
	var $pc;
	var $exlab;
	
	var $fecha;
	var $hora;
	var $status;
	var $tipo;
	var $med1;
	var $indi1;
	var $med2;
	var $indi2;
	var $med3;
	var $indi3;
	var $med4;
	var $indi4;
	var $med5;
	var $indi5;
	var $med6;
	var $indi6;
	var $med7;
	var $indi7;
	var $med8;
	var $indi8;
	var $med9;
	var $indi9;
	var $med10;
	var $indi10;
	var $med11;
	var $indi11;
	var $med12;
	var $indi12;
	var $med13;
	var $indi13;
	var $med14;
	var $indi14;
	var $med15;
	var $indi15;
	
	function __construct($id,$id_general,$id_medico,$id_consultorio,$consulta,$tratamiento,$observaciones,$fecha,$hora,$status,$tipo,
						 $ant_per,$ant_fm,$peso,$talla,$ta,$sc,$pc,$exlab,
						 $med1,$indi1,$med2,$indi2,$med3,$indi3,$med4,$indi4,$med5,$indi5,$med6,$indi6,$med7,$indi7,$med8,$indi8,$med9,$indi9,$med10,$indi10,
						 $med11,$indi11,$med12,$indi12,$med13,$indi13,$med14,$indi14,$med15,$indi15){
		$this->id=$id;						
		$this->id_general=$id_general;						
		$this->id_medico=$id_medico;						
		$this->id_consultorio=$id_consultorio;						
		$this->consulta=$consulta;						
								
		$this->tratamiento=$tratamiento;											
		$this->observaciones=$observaciones;
		
		$this->ant_per=$ant_per;
		$this->ant_fm=$ant_fm;
		$this->peso=$peso;
		$this->talla=$talla;
		$this->ta=$ta;
		$this->sc=$sc;
		$this->pc=$pc;
		$this->exlab=$exlab;
		
		$this->fecha=$fecha;	
		$this->hora=$hora;	
		$this->status=$status;
		$this->tipo=$tipo;
		$this->med1=$med1;
		$this->indi1=$indi1;
		$this->med2=$med2;
		$this->indi2=$indi2;
		$this->med3=$med3;
		$this->indi3=$indi3;
		$this->med4=$med4;
		$this->indi4=$indi4;
		$this->med5=$med5;
		$this->indi5=$indi5;
		$this->med6=$med6;
		$this->indi6=$indi6;
		$this->med7=$med7;
		$this->indi7=$indi7;
		$this->med8=$med8;
		$this->indi8=$indi8;
		$this->med9=$med9;
		$this->indi9=$indi9;
		$this->med10=$med10;
		$this->indi10=$indi10;
		$this->med11=$med11;
		$this->indi11=$indi11;
		$this->med12=$med12;
		$this->indi12=$indi12;
		$this->med13=$med13;
		$this->indi13=$indi13;
		$this->med14=$med14;
		$this->indi14=$indi14;
		$this->med15=$med15;
		$this->indi15=$indi15;		
	}
	
	function crear(){
		$id=$this->id;						
		$id_general=$this->id_general;					
		$id_medico=$this->id_medico;					
		$id_consultorio=$this->id_consultorio;					
		$consulta=$this->consulta;					
							
		$tratamiento=$this->tratamiento;									
		$observaciones=$this->observaciones;
		
		$ant_per=$this->ant_per;	
		$ant_fm=$this->ant_fm;	
		$peso=$this->peso;	
		$talla=$this->talla;	
		$ta=$this->ta;	
		$sc=$this->sc;	
		$pc=$this->pc;	
		$exlab=$this->exlab;
		
		$fecha=$this->fecha;	
		$hora=$this->hora;	
		$status=$this->status;
		$tipo=$this->tipo;
		$med1=$this->med1;
		$indi1=$this->indi1;	
		$med2=$this->med2;
		$indi2=$this->indi2;	
		$med3=$this->med3;
		$indi3=$this->indi3;	
		$med4=$this->med4;
		$indi4=$this->indi4;	
		$med5=$this->med5;
		$indi5=$this->indi5;	
		$med6=$this->med6;
		$indi6=$this->indi6;	
		$med7=$this->med7;
		$indi7=$this->indi7;	
		$med8=$this->med8;
		$indi8=$this->indi8;	
		$med9=$this->med9;
		$indi9=$this->indi9;	
		$med10=$this->med10;
		$indi10=$this->indi10;
		$med11=$this->med11;
		$indi11=$this->indi11;	
		$med12=$this->med12;
		$indi12=$this->indi12;	
		$med13=$this->med13;
		$indi13=$this->indi13;	
		$med14=$this->med14;
		$indi14=$this->indi14;	
		$med15=$this->med15;
		$indi15=$this->indi15;		
							
		mysql_query("INSERT INTO consultas_medicas (id_paciente, id_medico,consultorio,sintomas, diagnostico,tratamiento,observaciones,fecha,hora,status,tipo,ant_per,ant_fm,peso,talla,ta,sc,pc,exlab,vista)	
							              VALUES ('$id_general','$id_medico','$id_consultorio','$consulta','QUITAR','$tratamiento','$observaciones','$fecha','$hora','$status','$tipo','$ant_per','$ant_fm','$peso','$talla','$ta','$sc','$pc','$exlab','s')");
		mysql_query("Update citas_medicas Set consulta='CONSULTADO' Where id_paciente='$id_general'");
		$cans=mysql_query("SELECT MAX(id) AS id FROM consultas_medicas");
			if($dat=mysql_fetch_array($cans))
			$id_consulta =$dat['id'];
			{
				$xSQL="INSERT INTO medicamentos (consulta,paciente,med1,indi1,med2,indi2,med3,indi3,med4,indi4,med5,indi5,med6,indi6,med7,indi7,med8,indi8,med9,indi9,med10,indi10,
												med11,indi11,med12,indi12,med13,indi13,med14,indi14,med15,indi15,fecha,consultorio)	
			                        VALUES ('$id_consulta','$id_general','$med1','$indi1','$med2','$indi2','$med3','$indi3','$med4','$indi4','$med5','$indi5','$med6','$indi6','$med7','$indi7','$med8','$indi8','$med9','$indi9','$med10','$indi10','$med11','$indi11','$med12','$indi12','$med13','$indi13','$med14','$indi14','$med15','$indi15','$fecha','$id_consultorio')";
				mysql_query($xSQL);
			}		
	}
	
	function actualizar(){
		$id=$this->id;										
		$consulta=$this->consulta;					
		$examenes=$this->examenes;					
		$tratamiento=$this->tratamiento;									
		$observaciones=$this->observaciones;
		
		$ant_per=$this->ant_per;	
		$ant_fm=$this->ant_fm;	
		$peso=$this->peso;	
		$talla=$this->talla;	
		$ta=$this->ta;	
		$sc=$this->sc;	
		$pc=$this->pc;	
		$exlab=$this->exlab;
				
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
												WHERE id='$id'");
	}
}
?>