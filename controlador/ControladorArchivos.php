<?php

require_once "funciones.php";
include_once '../librerias/SessionVars.php';

$sess=new SessionVars();
$sess->init();
if($sess->exist() && $sess->varExist('cedula'))
{
function autoload($clase)
{
   require_once "../modelo/" . $clase . ".php";
}
spl_autoload_register('autoload');


class ControladorArchivos{

    private $rutaProyecto;
    private $nombreArchivo;
    private $nombreReal;
    private $numeroPrograma;
    private $numeroProyecto;
    private $mArchivos;
    private $archivoTempo;
    private $codigoControl;


    public function asignar($num_programa,$num_proyecto,$archivoTempo)
    {
       $this->rutaProyecto="../archivos/proyectos/$num_proyecto";//carpeta 
       $this->nombreArchivo=tildes($archivoTempo['name']);
       $this->nombreReal=$archivoTempo['name'];
       $this->numeroPrograma=$num_programa;
       $this->numeroProyecto=$num_proyecto;
       $this->archivoTempo=$archivoTempo;
       $this->codigoControl=sha1_file($archivoTempo['tmp_name']);
             

    }

    public function insertarArchivos()
  {
    
                    $this->mArchivos=new MArchivos();
                    return $this->mArchivos->ingresarArchivos(
                                                    $this->rutaProyecto,
                                                    $this->nombreArchivo,
                                                    $this->nombreReal,
                                                    $this->numeroPrograma,
                                                    $this->numeroProyecto,
                                                    $this->codigoControl);
                
    
  }
  
 
public function moverArchivos()
{
  try 
  {
  if(!file_exists("$this->rutaProyecto"))//si la carpeta del proceso no existe
          {
            mkdir($this->rutaProyecto, 0777, true);
           }  //crea ruta_procso     
          // echo  $this->rutaProyecto;
           $this->rutaProyecto=$this->rutaProyecto."/".$this->archivoTempo['name'];
            move_uploaded_file($this->archivoTempo['tmp_name'],$this->rutaProyecto);


   }

   catch(Exception $e){

      print "Error Al subir Archivo".$e; 

   }           
}


}

 if(!empty($_POST['frm_num_programa']) && !empty($_POST['frm_num_proyecto']) && !empty($_FILES['frm_archivo'])){

        $num_programa=$_POST['frm_num_programa'];
        $num_proyecto=$_POST['frm_num_proyecto'];//numero de proyecto del XML
        $archivoTempo=$_FILES['frm_archivo'];//es la variable de archivos temporales
        $archivos= new ControladorArchivos();
        $archivos->asignar($num_programa,$num_proyecto,$archivoTempo);
        $archivos->moverArchivos();
        echo $archivos->insertarArchivos();
       
      }

?>
 <?php
}
else {
    header('http://'.$_SERVER['SERVER_NAME']);
}
?>