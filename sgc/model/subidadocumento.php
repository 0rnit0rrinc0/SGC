<?php 

print_r($_FILES);


/* $nombre=$_FILES['archivo']['name'];
$guardado=$_FILES['archivo']['tmp_name'];

if(!file_exists('../documentosEntrega')){
	mkdir('../documentosEntrega',0777,true);
	if(file_exists('../documentosEntrega')){
		if(move_uploaded_file($guardado, '../documentosEntrega'.$nombre)){
			echo "Archivo guardado con exito";
		}else{
			echo "Archivo no se pudo guardar";
		}
	}
}else{
	if(move_uploaded_file($guardado, '../documentosEntrega'.$nombre)){
		echo "Archivo guardado con exito";
	}else{
		echo "Archivo no se pudo guardar";
	}
} */

?>