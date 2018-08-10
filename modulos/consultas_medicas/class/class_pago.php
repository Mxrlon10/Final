<?php
class Proceso_Pago{
	var $id;	
	var $id_gen_pago;	
	var $concepto;	
	var $factura;	
	var $clase;	
	var $valor;	
	var $tipo;		
	var $fecha;
	var $hora;
	var $status;
	var $usu;
	var $id_consultorio;
	
	
	function __construct($id,$id_gen_pago,$concepto,$factura,$clase,$valor,$tipo,$fecha,$hora,$status,$usu,$id_consultorio){
		$this->id=$id;						
		$this->id_gen_pago=$id_gen_pago;						
		$this->concepto=$concepto;						
		$this->factura=$factura;						
		$this->clase=$clase;						
		$this->valor=$valor;						
		$this->tipo=$tipo;												
		$this->fecha=$fecha;	
		$this->hora=$hora;	
		$this->status=$status;
		$this->usu=$usu;
		$this->id_consultorio=$id_consultorio;
	}
	
	function crear(){
		$id=$this->id;						
		$id_gen_pago=$this->id_gen_pago;					
		$concepto=$this->concepto;					
		$factura=$this->factura;					
		$clase=$this->clase;					
		$valor=$this->valor;					
		$tipo=$this->tipo;										
		$fecha=$this->fecha;	
		$hora=$this->hora;	
		$status=$this->status;
		$usu=$this->usu;
		$id_consultorio=$this->id_consultorio;	
							
		mysql_query("INSERT INTO factura (factura,valor,fecha,estado,consultorio,usu) VALUE ('$factura','$valor','$fecha','s','$id_consultorio','$usu')");
		
		$mensaje='Operacion al Contado';
		mysql_query("INSERT INTO resumen (paciente,concepto,factura,clase,valor,tipo,fecha,hora,status,usu,consultorio,estado) VALUE ('$id_gen_pago','$concepto','$factura','$clase','$valor','$tipo','$fecha','$hora','$status','$usu','$id_consultorio','s')");
		#mysql_query("INSERT INTO resumen (concepto,clase,valor,tipo,fecha,hora,usu,estado) VALUE ('$mensaje','DESPERDICIO','$neto_full','DESPERDICIO','$fecha','$hora','$usu','s')");
		$detalle_sql="INSERT INTO detalle (factura, codigo, nombre, valor, importe, tipo, fecha, consultorio)
							       VALUES ('$factura','$id_gen_pago','','$valor','$valor','CONSULTA','$fecha','$id_consultorio')";
					                mysql_query($detalle_sql);	

		mysql_query("Update citas_medicas Set status='PROCESADO' Where id_paciente='$id_gen_pago'");	
		mysql_query("Update consultas_medicas  Set status='PROCESADO' Where id_paciente='$id_gen_pago'");
	}
	
	function actualizar(){
		$id=$this->id;										
		$consulta=$this->consulta;					
		$examenes=$this->examenes;					
		$tratamiento=$this->tratamiento;									
		$observaciones=$this->observaciones;				
				
		mysql_query("UPDATE consultas_medicas SET sintomas='$consulta',
												  diagnostico='$examenes', 
												  tratamiento='$tratamiento',  
												  observaciones='$observaciones' 
												WHERE id='$id'");
	}
}
?>