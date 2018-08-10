<?php
class Proceso_Abdominal{
	var $id;	
	var $id_abdominal;	
	var $id_medico;	
	var $id_consultorio;	
	var $higado;	
	var $vesicula;	
	var $pancreas;		
	var $bazo;		
	var $riñond;		
	var $riñoni;		
	var $vejiga;		
	var $observaciones;
	var $fecha;
	var $hora;
	var $status;
	var $tipo;
	
	function __construct($id,$id_abdominal,$id_medico,$id_consultorio,$higado,$vesicula,$pancreas,$bazo,$riñond,$riñoni,$vejiga,$observaciones,$fecha,$hora,$status,$tipo){
		$this->id=$id;						
		$this->id_abdominal=$id_abdominal;						
		$this->id_medico=$id_medico;						
		$this->id_consultorio=$id_consultorio;						
		$this->higado=$higado;						
		$this->vesicula=$vesicula;						
		$this->pancreas=$pancreas;											
		$this->bazo=$bazo;											
		$this->riñond=$riñond;											
		$this->riñoni=$riñoni;											
		$this->vejiga=$vejiga;											
		$this->observaciones=$observaciones;	
		$this->fecha=$fecha;	
		$this->hora=$hora;	
		$this->status=$status;	
		$this->tipo=$tipo;	
	}
	
	function crear(){
		$id=$this->id;						
		$id_abdominal=$this->id_abdominal;					
		$id_medico=$this->id_medico;					
		$id_consultorio=$this->id_consultorio;					
		$higado=$this->higado;					
		$vesicula=$this->vesicula;					
		$pancreas=$this->pancreas;					
		$bazo=$this->bazo;					
		$riñond=$this->riñond;					
		$riñoni=$this->riñoni;									
		$vejiga=$this->vejiga;									
		$observaciones=$this->observaciones;	
		$fecha=$this->fecha;	
		$hora=$this->hora;	
		$status=$this->status;	
		$tipo=$this->tipo;

		mysql_query("INSERT INTO consultas_medicas (id_paciente, id_medico,consultorio,sintomas, diagnostico,tratamiento,observaciones,fecha,hora,status,tipo)	
							                VALUES ('$id_abdominal','$id_medico','$id_consultorio','','','','','$fecha','$hora','$status','$tipo')");
			
		
		$cans=mysql_query("SELECT MAX(id) AS id FROM consultas_medicas WHERE id_paciente='$id_abdominal'");
			if($dat=mysql_fetch_array($cans))
			$id_consulta =$dat['id'];
			{
				$xSQL="INSERT INTO ultra_abdominal (id_paciente, id_medico,consultorio,higado,vesicula,pancreas,bazo,riñond,riñoni,vejiga,observaciones,fecha,hora,status,id_consulta)	
							              VALUES ('$id_abdominal','$id_medico','$id_consultorio','$higado','$vesicula','$pancreas','$bazo','$riñond','$riñoni','$vejiga','$observaciones','$fecha','$hora','$status','$id_consulta')";
				mysql_query($xSQL);
				
			}
		mysql_query("Update citas_medicas Set consulta='CONSULTADO' Where id_paciente='$id_abdominal'");
	}
	
	function actualizar(){
		$id=$this->id;						
		#$id_paciente=$this->id_paciente;					
		#$id_medico=$this->id_medico;					
		$higado=$this->higado;					
		$vesicula=$this->vesicula;					
		$pancreas=$this->pancreas;					
		$bazo=$this->bazo;					
		$riñond=$this->riñond;					
		$riñoni=$this->riñoni;									
		$vejiga=$this->vejiga;										
		$observaciones=$this->observaciones;				
				
		mysql_query("UPDATE ultra_abdominal SET higado='$higado',
												  vesicula='$vesicula', 
												  pancreas='$pancreas',  
												  bazo='$bazo',  
												  riñond='$riñond',  
												  riñoni='$riñoni',  
												  vejiga='$vejiga',  
												  observaciones='$observaciones' 
												WHERE id='$id'");
	}
}
?>