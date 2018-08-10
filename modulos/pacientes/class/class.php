<?php
class Proceso_Paciente{
	var $id;	
	#var $documento;
	var $nombre;
    var $direccion;			
    var $nomp;			
    var $nomm;			
	var $telefono;		
	var $edad;		
	var $sexo;		
	var $feccita;		
	var $refpor;	
	var $estado;
	var $id_consultorio;
	var $seguro;
	
	function __construct($id,$nombre,$direccion,$nomp,$nomm,$telefono,$edad,$sexo,$feccita,$refpor,$estado,$id_consultorio,$seguro){
		$this->id=$id;		
		#$this->documento=$documento;		
		$this->nombre=$nombre;		
		$this->direccion=$direccion;	
		$this->nomp=$nomp;	
		$this->nomm=$nomm;	
		$this->telefono=$telefono;
		$this->edad=$edad;	
		$this->sexo=$sexo;	
		$this->feccita=$feccita;	
		$this->refpor=$refpor;			
		$this->estado=$estado;	
		$this->id_consultorio=$id_consultorio;	
		$this->seguro=$seguro;	
	}
	
	function crear(){
		$id=$this->id;		
		#$documento=$this->documento;		
		$nombre=$this->nombre;		
		$direccion=$this->direccion;	
		$nomp=$this->nomp;	
		$nomm=$this->nomm;	
		$telefono=$this->telefono;	
		$edad=$this->edad;	
		$sexo=$this->sexo;	
		$feccita=$this->feccita;	
		$refpor=$this->refpor;	
		$estado=$this->estado;	
		$id_consultorio=$this->id_consultorio;	
		$seguro=$this->seguro;	
							
		mysql_query("INSERT INTO pacientes (nombre, direccion, nomp, nomm, telefono, edad, sexo, feccita, refpor, estado, consultorio, seguro) 
					VALUES ('$nombre','$direccion','$nomp','$nomm','$telefono','$edad','$sexo','$feccita','$refpor','$estado','$id_consultorio','$seguro')");
	}
	
	function actualizar(){
		$id=$this->id;		
		#$documento=$this->documento;		
		$nombre=$this->nombre;		
		$direccion=$this->direccion;	
		$nomp=$this->nomp;	
		$nomm=$this->nomm;	
		$telefono=$this->telefono;	
		$edad=$this->edad;	
		$sexo=$this->sexo;	
		$feccita=$this->feccita;	
		$refpor=$this->refpor;	
		$estado=$this->estado;			
		$seguro=$this->seguro;			
		
		mysql_query("UPDATE pacientes SET  
										nombre='$nombre',
										direccion='$direccion',
										nomp='$nomp',
										nomm='$nomm',
										telefono='$telefono',
										edad='$edad',
										sexo='$sexo',										
										feccita='$feccita',										
										refpor='$refpor',
										estado='$estado',
										seguro='$seguro'
									WHERE id='$id'");
									
		mysql_query("UPDATE pediatria SET  
										nombre='$nombre',										
										edad='$edad',
										estado='$estado'
									WHERE id_paciente='$id'");
	}
}
?>