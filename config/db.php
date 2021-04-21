<?php 
/*Подключение библиотеки ReadBeanPHP*/
require $_SERVER['DOCUMENT_ROOT'].'/libs/rb.php';

R::setup( 'mysql:host=127.0.0.1;dbname=db_playnow','root', ''); 

if ( !R::testConnection() )
{
	exit ('Нет соединения с базой данных');
}

function ShowError($errors)
{
	return array_shift($errors);
}

?>