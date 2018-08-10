<?php
class Proceso_Prostata{
	var $id;	
	var $id_prostata;	
	var $id_medico;	
	var $id_consultorio;	
	var $vejiga;	
	var $prostata;	
	var $conclusion;		
	var $fecha;
	var $hora;
	var $status;
	var $tipo;
	
	function __construct($id,$id_prostata,$id_medico,$id_consultorio,$vejiga,$prostata,$conclusion,$fecha,$hora,$status,$tipo){
		$this->id=$id;						
		$this->id_prostata=$id_prostata;						
		$this->id_medico=$id_medico;						
		$this->id_consultorio=$id_consultorio;						
		$this->vejiga=$vejiga;						
		$this->prostata=$prostata;						
		$this->conclusion=$conclusion;											
		$this->fecha=$fecha;	
		$this->hora=$hora;	
		$this->status=$status;	
		$this->tipo=$tipo;	
	}
	
	function crear(){
		$id=$this->id;						
		$id_prostata=$this->id_prostata;					
		$id_medico=$this->id_medico;					
		$id_consultorio=$this->id_consultorio;					
		$vejiga=$this->vejiga;					
		$prostata=$this->prostata;					
		$conclusion=$this->conclusion;										
		$fecha=$this->fecha;	
		$hora=$this->hora;	
		$status=$this->status;	
		$tipo=$this->tipo;	
		
		mysql_query("INSERT INTO consultas_medicas (id_paciente, id_medico,consultorio,sintomas, diagnostico,tratamiento,observaciones,fecha,hora,status,tipo)	
							                VALUES ('$id_prostata','$id_medico','$id_consultorio','','','','','$fecha','$hora','$status','$tipo')");
					
		$cans=mysql_query("SELECT MAX(id) AS id FROM consultas_medicas WHERE id_paciente='$id_prostata'");
			if($dat=mysql_fetch_array($cans))
			$id_consulta =$dat['id'];
			{
				$xSQL="INSERT INTO ultra_prostata (id_paciente, id_medico,consultorio,vejiga, prostata,conclusion,fecha,hora,status,id_consulta)	
							              VALUES ('$id_prostata','$id_medico','$id_consultorio','$vejiga','$prostata','$conclusion','$fecha','$hora','$status','$id_consulta')";
				mysql_query($xSQL);				
			}
		mysql_query("Update citas_medicas Set consulta='CONSULTADO' Where id_paciente='$id_prostata'");						
			
	}
	
	function actualizar(){
		$id=$this->id;						
		#$id_paciente=$this->id_paciente;					
		#$id_medico=$this->id_medico;					
		$vejiga=$this->vejiga;					
		$prostata=$this->prostata;					
		$conclusion=$this->conclusion;									
						
				
		mysql_query("UPDATE ultra_prostata SET vejiga='$vejiga',
												  prostata='$prostata', 
												  conclusion='$conclusion' 
												WHERE id='$id'");
	}
}
?>