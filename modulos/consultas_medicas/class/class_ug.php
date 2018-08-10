<?php
class Proceso_Ginecologia{
	var $id;	
	var $id_ginecologia;	
	var $id_medico;	
	var $id_consultorio;	
	var $solicitante;	
	var $opciones;	
	var $utero;	
	var $endometrio;		
	var $anexo;		
	var $saco;		
	var $observaciones;
	var $fecha;
	var $hora;
	var $status;
	var $tipo;
	
	function __construct($id,$id_ginecologia,$id_medico,$id_consultorio,$solicitante,$opciones,$utero,$endometrio,$anexo,$saco,$observaciones,$fecha,$hora,$status,$tipo){
		$this->id=$id;						
		$this->id_ginecologia=$id_ginecologia;						
		$this->id_medico=$id_medico;						
		$this->id_consultorio=$id_consultorio;						
		$this->solicitante=$solicitante;						
		$this->opciones=$opciones;						
		$this->utero=$utero;						
		$this->endometrio=$endometrio;						
		$this->anexo=$anexo;						
		$this->saco=$saco;																	
		$this->observaciones=$observaciones;	
		$this->fecha=$fecha;	
		$this->hora=$hora;	
		$this->status=$status;	
		$this->tipo=$tipo;	
	}
	
	function crear(){
		$id=$this->id;						
		$id_ginecologia=$this->id_ginecologia;					
		$id_medico=$this->id_medico;					
		$id_consultorio=$this->id_consultorio;					
		$solicitante=$this->solicitante;					
		$opciones=$this->opciones;					
		$utero=$this->utero;					
		$endometrio=$this->endometrio;					
		$anexo=$this->anexo;					
		$saco=$this->saco;					
		$observaciones=$this->observaciones;						
		$fecha=$this->fecha;	
		$hora=$this->hora;	
		$status=$this->status;	
		$tipo=$this->tipo;

		mysql_query("INSERT INTO consultas_medicas (id_paciente, id_medico,consultorio,sintomas, diagnostico,tratamiento,observaciones,fecha,hora,status,tipo)	
							                VALUES ('$id_ginecologia','$id_medico','$id_consultorio','','','','','$fecha','$hora','$status','$tipo')");
					
		$cans=mysql_query("SELECT MAX(id) AS id FROM consultas_medicas WHERE id_paciente='$id_ginecologia'");
			if($dat=mysql_fetch_array($cans))
			$id_consulta =$dat['id'];
			{
				$xSQL="INSERT INTO ultra_ginecologica (id_paciente,id_medico,consultorio,solicitante,opciones,utero,endometrio,anexo,saco,observaciones,fecha,hora,status,id_consulta)	
							              VALUES ('$id_ginecologia','$id_medico','$id_consultorio','$solicitante','$opciones','$utero','$endometrio','$anexo','$saco','$observaciones','$fecha','$hora','$status','$id_consulta')";
				mysql_query($xSQL);				
			}
		mysql_query("Update citas_medicas Set consulta='CONSULTADO' Where id_paciente='$id_ginecologia'");					
	}
	
	function actualizar(){
		$id=$this->id;						
		#$id_paciente=$this->id_paciente;					
		#$id_medico=$this->id_medico;					
		$solicitante=$this->solicitante;					
		$opciones=$this->opciones;					
		$utero=$this->utero;					
		$endometrio=$this->endometrio;					
		$anexo=$this->anexo;					
		$saco=$this->saco;					
		$observaciones=$this->observaciones;				
				
		mysql_query("UPDATE ultra_ginecologica SET solicitante='$solicitante',
												  opciones='$opciones', 
												  utero='$utero', 
												  endometrio='$endometrio', 
												  anexo='$anexo', 
												  saco='$saco',  
												  observaciones='$observaciones' 
												WHERE id='$id'");
	}
}
?>