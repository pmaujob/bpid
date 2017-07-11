<?php

require_once "funciones.php";
function autoload($clase)
{
   require_once "../modelo/" . $clase . ".php";
}
spl_autoload_register('autoload');


class ControladorArchivos{

    private $ruta_proyecto;
    private $nombre_archivo;
    private $nombre_real;
    private $numero_programa;
    private $numero_proyecto;
    private $mArchivos;
    private $archivo_tempo;


    public function asignar($num_programa,$num_proyecto,$archivo_tempo)
    {
       $this->ruta_proyecto="../archivos/proyectos/$num_proyecto";//carpeta 
       $this->nombre_archivo=tildes($archivo_tempo['name']);
       $this->nombre_real=$archivo_tempo['name'];
       $this->numero_programa=$num_programa;
       $this->numero_proyecto=$num_proyecto;
       $this->archivo_tempo=$archivo_tempo;
             

    }

    public function insertarArchivos()
  {
    
                    $this->mArchivos=new MArchivos();
                    return $this->mArchivos->ingresarArchivos(
                                                    $this->ruta_proyecto,
                                                    $this->nombre_archivo,
                                                    $this->nombre_real,
                                                    $this->numero_programa,
                                                    $this->numero_proyecto);
                
    
  }
  
 
public function moverArchivos()
{
  try 
  {
  if(!file_exists("$this->ruta_proyecto"))//si la carpeta del proceso no existe
          {
            mkdir($this->ruta_proyecto, 0777, true);
           }  //crea ruta_procso     
          // echo  $this->ruta_proyecto;
           $this->ruta_proyecto=$this->ruta_proyecto."/".$this->archivo_tempo['name'];
            move_uploaded_file($this->archivo_tempo['tmp_name'],$this->ruta_proyecto);


   }

   catch(Exception $e){

      print "Error Al subir Archivo".$e; 

   }           
}


}
 if(!empty($_POST['frm_num_programa']) && !empty($_POST['frm_num_proyecto']) && !empty($_FILES['frm_archivo'])){

        $num_programa=$_POST['frm_num_programa'];
        $num_proyecto=$_POST['frm_num_proyecto'];//numero de proyecto del XML
        $archivo_tempo=$_FILES['frm_archivo'];//es la variable de archivos temporales
        $archivos= new ControladorArchivos();
        $archivos->asignar($num_programa,$num_proyecto,$archivo_tempo);
        $archivos->moverArchivos();
        echo $archivos->insertarArchivos();
        
        
  }



?>