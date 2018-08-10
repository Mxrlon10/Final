<?php
class Proceso_Paciente{
	var $id;	
	#var $documento;
	var $nombre;
    var $direccion;			
	var $telefono;		
	var $sexo;		
	var $email;	
	var $estado;
	var $id_consultorio;
	var $especialidad;
	
	function __construct($id,$nombre,$direccion,$telefono,$sexo,$email,$estado,$id_consultorio,$especialidad){
		$this->id=$id;		
		#$this->documento=$documento;		
		$this->nombre=$nombre;		
		$this->direccion=$direccion;	
		$this->telefono=$telefono;			
		$this->sexo=$sexo;	
		$this->email=$email;			
		$this->estado=$estado;	
		$this->id_consultorio=$id_consultorio;
		$this->especialidad=$especialidad;		
	}
	
	function crear(){
		$id=$this->id;		
		#$documento=$this->documento;		
		$nombre=$this->nombre;		
		$direccion=$this->direccion;	
		$telefono=$this->telefono;				
		$sexo=$this->sexo;	
		$email=$this->email;	
		$estado=$this->estado;	
		$id_consultorio=$this->id_consultorio;
		$especialidad=$this->especialidad;		
							
		mysql_query("INSERT INTO medicos (nombre, direccion, telefono, sexo, email, estado, consultorio, especialidad) 
					VALUES ('$nombre','$direccion','$telefono','$sexo','$email','$estado','$id_consultorio','$especialidad')");
	}
	
	function actualizar(){
		$id=$this->id;		
		#$documento=$this->documento;		
		$nombre=$this->nombre;		
		$direccion=$this->direccion;	
		$telefono=$this->telefono;			
		$sexo=$this->sexo;	
		$email=$this->email;	
		$estado=$this->estado;
		$especialidad=$this->especialidad;			
		
		mysql_query("UPDATE medicos SET  
										nombre='$nombre',
										direccion='$direccion',
										telefono='$telefono',										
										sexo='$sexo',										
										email='$email',
										estado='$estado',
										especialidad='$especialidad'
									WHERE id='$id'");
											
	}
}
?>