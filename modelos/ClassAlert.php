<?php

class ClassAlert
{ 

private $title;
private $message;
private $color;

//Instancias de clase, parametros de la alerta

public function __construct($title , $message, $color){

//recibe los parametros que poseen los objetos

$this->title = $title;  //las misma clase accediendo a sus instancias  	
$this->message = $message;
$this->color = $color;

}

public function Show_Alert()
{

//alerta generate

$all  = "<div class='alert alert-".$this->color." alert-dismissible fade show' role='alert'>";
$all .= "<strong>".$this->title."</strong>";
$all .= $this->message;
$all .= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
$all .= "<span aria-hidden='true'>&times;</span>";
$all .= "</button></div>";
   
return $all; 

}

}


?>
