<?php
class Proceso_Embarazo{
	var $id;	
	var $id_embarazo;	
	var $id_medico;	
	var $id_consultorio;	
	var $solicitante;	
	var $fur;			
	var $saco;			
	var $lcr;			
	var $dbp;			
	var $lf;			
	var $lh;			
	var $lcf;			
	var $liquido;			
	var $localizacion;			
	var $grado;			
	var $observaciones;			
	var $fecha;
	var $hora;
	var $status;
	var $tipo;
	
	function __construct($id,$id_embarazo,$id_medico,$id_consultorio,$solicitante,$fur,$saco,$lcr,$dbp,$lf,$lh,$lcf,$liquido,$localizacion,$grado,$observaciones,$fecha,$hora,$status,$tipo){
		$this->id=$id;						
		$this->id_embarazo=$id_embarazo;						
		$this->id_medico=$id_medico;						
		$this->id_consultorio=$id_consultorio;						
		$this->solicitante=$solicitante;						
		$this->fur=$fur;
		$this->saco=$saco;		
		$this->lcr=$lcr;		
		$this->dbp=$dbp;		
		$this->lf=$lf;		
		$this->lh=$lh;		
		$this->lcf=$lcf;		
		$this->liquido=$liquido;		
		$this->localizacion=$localizacion;		
		$this->grado=$grado;		
		$this->observaciones=$observaciones;		
		$this->fecha=$fecha;	
		$this->hora=$hora;	
		$this->status=$status;	
		$this->tipo=$tipo;	
	}
	
	function crear(){
		$id=$this->id;						
		$id_embarazo=$this->id_embarazo;					
		$id_medico=$this->id_medico;					
		$id_consultorio=$this->id_consultorio;					
		$solicitante=$this->solicitante;					
		$fur=$this->fur;															
		$saco=$this->saco;															
		$lcr=$this->lcr;															
		$dbp=$this->dbp;															
		$lf=$this->lf;															
		$lh=$this->lf;															
		$lcf=$this->lcf;															
		$liquido=$this->liquido;															
		$localizacion=$this->localizacion;															
		$grado=$this->grado;															
		$observaciones=$this->observaciones;															
		$fecha=$this->fecha;	
		$hora=$this->hora;	
		$status=$this->status;	
		$tipo=$this->tipo;	
							
		
		mysql_query("INSERT INTO consultas_medicas (id_paciente, id_medico,consultorio,sintomas, diagnostico,tratamiento,observaciones,fecha,hora,status,tipo)	
							                VALUES ('$id_embarazo','$id_medico','$id_consultorio','','','','','$fecha','$hora','$status','$tipo')");
			
		
		$cans=mysql_query("SELECT MAX(id) AS id FROM consultas_medicas WHERE id_paciente='$id_embarazo'");
			if($dat=mysql_fetch_array($cans))
			$id_consulta =$dat['id'];
			{
				$xSQL="INSERT INTO ultra_embarazo (id_paciente, id_medico,consultorio,solicitante,fur,saco,lcr,dbp,lf,lh,lcf,liquido,localizacion,grado,observaciones,fecha,hora,status,id_consulta)	
							               VALUES ('$id_embarazo','$id_medico','$id_consultorio','$solicitante','$fur','$saco','$lcr','$dbp','$lf','$lh','$lcf','$liquido','$localizacion','$grado','$observaciones','$fecha','$hora','$status','$id_consulta')";
				mysql_query($xSQL);
				
			}
		mysql_query("Update citas_medicas Set consulta='CONSULTADO' Where id_paciente='$id_embarazo'");
	}
	
	function actualizar(){
		$id=$this->id;						
		#$id_paciente=$this->id_paciente;					
		#$id_medico=$this->id_medico;					
		$informe=$this->informe;					
		$dx=$this->dx;									
		mysql_query("UPDATE ultra_mamas SET solicitante='$solicitante',
												  fur='$fur', 
												WHERE id='$id'");
	}
}
?>