<?php
class Proceso_Cita{
	var $id;	
	var $id_paciente;	
	var $id_medico;	
	var $id_consultorio;	
	var $fechai;		
	var $tipo;
	var $fecha;	
	var $hora;
	var $horario;
	var $status;
	var $consulta;
	
	function __construct($id,$id_paciente,$id_medico,$id_consultorio,$fechai,$tipo,$fecha,$hora,$horario,$status,$consulta){
		$this->id=$id;						
		$this->id_paciente=$id_paciente;						
		$this->id_medico=$id_medico;						
		$this->id_consultorio=$id_consultorio;						
		$this->fechai=$fechai;																												
		$this->tipo=$tipo;	
		$this->fecha=$fecha;	
		$this->hora=$hora;
		$this->horario=$horario;
		$this->status=$status;	
		$this->consulta=$consulta;	
	}
	
	function crear(){
		$id=$this->id;						
		$id_paciente=$this->id_paciente;					
		$id_medico=$this->id_medico;					
		$id_consultorio=$this->id_consultorio;					
		$fechai=$this->fechai;																						
		$tipo=$this->tipo;	
		$fecha=$this->fecha;	
		$hora=$this->hora;
		$horario=$this->horario;
		$status=$this->status;	
		$consulta=$this->consulta;	
							
		mysql_query("INSERT INTO citas_medicas (id_paciente, id_medico, consultorio, fechai, tipo, fecha, hora, horario, status, consulta)	
							VALUES ('$id_paciente','$id_medico','$id_consultorio','$fechai','$tipo','$fecha','$hora','$horario','$status','$consulta')");
	}
	
	function actualizar(){
		$id=$this->id;										
		$fechai=$this->fechai;
		$tipo=$this->tipo;	
		$horario=$this->horario;																	
		mysql_query("UPDATE citas_medicas SET fechai='$fechai',
											   tipo='$tipo',
											   horario='$horario' 
											   WHERE id='$id'");
	}
}
?>