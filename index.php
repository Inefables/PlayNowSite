<?php 

# Старт сессии
session_start(); 
# Старт буфера
ob_start(); 

// Подключение базы данных
function ConnectDB() {
	require $_SERVER['DOCUMENT_ROOT'].'/config/db.php';
}

// Подсчёт количества товаров в корзине и вывод
function GetCountOfProductsAtCart () {
	$countOfProducts = R::count( 'cart', 'id_user = ?', [$_SESSION['id']] );
	echo "<script> countOfProudctsAtCart(".$_SESSION['id'].",".$countOfProducts.") </script>";
}

ConnectDB();

include 'include/header.php';

$url = $_SERVER['REQUEST_URI'];
$url = explode('?', $url);
$url = $url[0];

switch ($url) {
	case '/login':
	include('pages/login.php');
	break;

	case '/register':
	include('pages/register.php');
	break;

	case '/profile':
	include('pages/profile.php');
	break;

	case '/logout':
	include('include/logout.php');
	break;

	case '/catalog':
	include('pages/catalog.php');
	break;
	
	case '/cart':
	include('pages/cart.php');
	break;

	case '/favorites':
	include('pages/favorites.php');
	break;

	default:
	include('pages/home.php');
	break;
}

GetCountOfProductsAtCart();
?>

