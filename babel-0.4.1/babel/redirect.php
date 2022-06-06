<?php
error_reporting(0);
if(!isset($_GET["newurl"]) ){
	header("location: index.php");
}else{
	if(isset($_GET["newlang"]))	setcookie('usrlang',$_GET["newlang"],time()+86400*30,'/');
	header("location: ".$_GET["newurl"]);
}

