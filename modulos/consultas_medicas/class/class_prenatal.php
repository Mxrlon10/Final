<?php
class Proceso_Prenatal{
#tabla Pacientes
	var $id;	
	var $nombre;
    var $direccion;			
	var $telefono;		
	var $estado;
	var $id_prenatal;
	var $id_consultorio;
	
#tabla prenatal
	var $opciones;		
	var $familiares;		
	var $personales;		
	var $ultimo;		
	var $parto;
#tabla prenatal_emb
	var $pesopre;
	var $tallapre;
	var	$fur;
	var $app;
	var $a;
	var $hemoglobina;
	var $rh;
	var $toxoplasmosis;
	var $glucosa;
	var $igm;
	var $igg;
	var $vdrl;
	var $ego;
	var $hiv;
	var $egh;
	var $citologoa;
	var $otrospre;
	var $vacinacion;
	
	function __construct($id,$nombre,$direccion,$telefono,$edad,$estado,$id_prenatal,$id_consultorio,
	                    #tabla prenatal
						$opciones,$familiares,$personales,$ultimo,$parto,
						#tabla prenatal_emb
						$pesopre,$tallapre,$fur,$app,$a,$hemoglobina,$rh,$toxoplasmosis,$glucosa,$igm,$igg,$vdrl,$ego,$hiv,$egh,
						$citologoa,$otrospre){
		$this->id=$id;			
		$this->nombre=$nombre;		
		$this->direccion=$direccion;	
		$this->telefono=$telefono;			
		$this->edad=$edad;			
		$this->estado=$estado;
		$this->id_prenatal=$id_prenatal;	
		$this->id_consultorio=$id_consultorio;
		#tabla prenatal
		$this->opciones=$opciones;	
		$this->familiares=$familiares;	
		$this->personales=$personales;	
		$this->ultimo=$ultimo;	
		$this->parto=$parto;
		#tabla prenatal_emb
		$this->pesopre=$pesopre;
		$this->tallapre=$tallapre;
		$this->fur=$fur;
		$this->app=$app;
		$this->a=$a;
		$this->hemoglobina=$hemoglobina;
		$this->rh=$rh;
		$this->toxoplasmosis=$toxoplasmosis;
		$this->glucosa=$glucosa;
		$this->igm=$igm;
		$this->igg=$igg;
		$this->vdrl=$vdrl;
		$this->ego=$ego;
		$this->hiv=$hiv;
		$this->egh=$egh;
		$this->citologoa=$citologoa;
		$this->otrospre=$otrospre;
		#$this->vacinacion=$vacinacion;			
	}
	
	function crear(){
		$id=$this->id;				
		$nombre=$this->nombre;		
		$direccion=$this->direccion;	
		$telefono=$this->telefono;		
		$edad=$this->edad;		
		$estado=$this->estado;
		$id_prenatal=$this->id_prenatal;	
		$id_consultorio=$this->id_consultorio;
		#tabla prenatal
		$opciones=$this->opciones;	
		$familiares=$this->familiares;	
		$personales=$this->personales;	
		$ultimo=$this->ultimo;	
		$parto=$this->parto;
		#tabla prenatal_emb
		$pesopre=$this->pesopre;
		$tallapre=$this->tallapre;
		$fur=$this->fur;
		$app=$this->app;
		$a=$this->a;
		$hemoglobina=$this->hemoglobina;
		$rh=$this->rh;
		$toxoplasmosis=$this->toxoplasmosis;
		$glucosa=$this->glucosa;
		$igm=$this->igm;
		$igg=$this->igg;
		$vdrl=$this->vdrl;
		$ego=$this->ego;
		$hiv=$this->hiv;
		$egh=$this->egh;
		$citologoa=$this->citologoa;
		$otrospre=$this->otrospre;
		$vacinacion=$this->vacinacion;
							
		mysql_query("INSERT INTO prenatal (id_paciente, nombre, opciones, familiares, personales, ultimo, parto, estado, consultorio) 
								  VALUES ('$id_prenatal','$nombre','$opciones','$familiares','$personales','$ultimo','$parto','$estado','$id_consultorio')");

		mysql_query("INSERT INTO prenatal_emb (id_paciente, pesopre, tallapre, fur, app, a, hemoglobina, rh, toxoplasmosis, glucosa, igm, 
													igg, vdrl, ego, hiv, egh, citologoa, otrospre, vacinacion, estado, consultorio) 
								  VALUES ('$id_prenatal','$pesopre','$tallapre','$fur','$app','$a','$hemoglobina','$rh','$toxoplasmosis','$glucosa','$igm',
												   '$igg','$vdrl','$ego','$hiv','$egh','$citologoa','$otrospre','$vacinacion','$estado','$id_consultorio')");	
						
			
	}
	
	function actualizar(){
		$id=$this->id;			
		$nombre=$this->nombre;		
		$direccion=$this->direccion;	
		$telefono=$this->telefono;		
		$estado=$this->estado;		
		
		mysql_query("UPDATE pacientes SET  
										nombre='$nombre',
										direccion='$direccion',
										telefono='$telefono',
										estado='$estado'
									WHERE id='$id'");
									
	}
}
?>