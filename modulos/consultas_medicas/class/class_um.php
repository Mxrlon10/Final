<?php
class Proceso_Mamas{
	var $id;	
	var $id_mamas;	
	var $id_medico;	
	var $id_consultorio;	
	var $informe;	
	var $dx;			
	var $fecha;
	var $hora;
	var $status;
	var $tipo;
	
	function __construct($id,$id_mamas,$id_medico,$id_consultorio,$informe,$dx,$fecha,$hora,$status,$tipo){
		$this->id=$id;						
		$this->id_mamas=$id_mamas;						
		$this->id_medico=$id_medico;						
		$this->id_consultorio=$id_consultorio;						
		$this->informe=$informe;						
		$this->dx=$dx;						
		$this->fecha=$fecha;	
		$this->hora=$hora;	
		$this->status=$status;	
		$this->tipo=$tipo;	
	}
	
	function crear(){
		$id=$this->id;						
		$id_mamas=$this->id_mamas;					
		$id_medico=$this->id_medico;					
		$id_consultorio=$this->id_consultorio;					
		$informe=$this->informe;					
		$dx=$this->dx;															
		$fecha=$this->fecha;	
		$hora=$this->hora;	
		$status=$this->status;	
		$tipo=$this->tipo;

		mysql_query("INSERT INTO consultas_medicas (id_paciente, id_medico,consultorio,sintomas, diagnostico,tratamiento,observaciones,fecha,hora,status,tipo)	
							                VALUES ('$id_mamas','$id_medico','$id_consultorio','','','','','$fecha','$hora','$status','$tipo')");
					
		$cans=mysql_query("SELECT MAX(id) AS id FROM consultas_medicas WHERE id_paciente='$id_mamas'");
			if($dat=mysql_fetch_array($cans))
			$id_consulta =$dat['id'];
			{
				$xSQL="INSERT INTO ultra_mamas (id_paciente, id_medico,consultorio,informe,dx,fecha,hora,status,id_consulta)	
							          VALUES ('$id_mamas','$id_medico','$id_consultorio','$informe','$dx','$fecha','$hora','$status','$id_consulta')";
				mysql_query($xSQL);				
			}
		mysql_query("Update citas_medicas Set consulta='CONSULTADO' Where id_paciente='$id_mamas'");					
	}
	
	function actualizar(){
		$id=$this->id;						
		#$id_paciente=$this->id_paciente;					
		#$id_medico=$this->id_medico;					
		$informe=$this->informe;					
		$dx=$this->dx;									
		mysql_query("UPDATE ultra_mamas SET informe='$informe',
												  dx='$dx', 
												WHERE id='$id'");
	}
}
?>