<?php 

// Добавить продукт в корзину
function AddProductToCart($productID)
{
	$productAtCart = R::find('cart', 'id_product = :id_product AND id_user = :id_user', array(
		':id_product' => $productID,
		':id_user' => $_SESSION['id']
	));

	if ($productAtCart) {
		$new_url = '/cart';
		header('Location: '.$new_url);
		exit();
	}
	else {
		$cart = R::dispense('cart');
		$cart->id_user = $_SESSION['id'];
		$cart->id_product = $productID;
		if (!R::store($cart)) {
				echo "<script> alert('Произошла ошибка при добавлении игры в корзину!') </script>";
			}
	}
	
}

// Получить и вывести все продукты магазина
function GetAllProducts()
{
	$products = R::getAll( 'select * from products' );

	foreach ($products as $product) {
		echo '
		<div class="col">
			<div class="card w-100 h-100">
				<img src="../'.$product["image_name"].'" class="card-img-top">
				<div class="card-body" id="'.$product["id"].'">
					<h4 class="card-title">'.$product["name"].'</h4>
					<p class="card-text">'.$product["price"].' руб.</p>
					<button class="btn btn-warning btn-sm" name="id" 
					value="'.$product["id"].'" 
					>В КОРЗИНУ</button>
				</div>
			</div>
		</div>
		';
	}
}

// Проверка нажатия кнопки "В корзину", авторизован ли пользователь, и передача id продукта 
// для добавления продукта в корзину
function IsAddToCartButtonPressed()
{
	if (isset($_POST['id'])) {
		if (!empty($_SESSION['id'])) {
			AddProductToCart($_POST['id']);
		} 
		else {
			$new_url = '/login';
			header('Location: '.$new_url);
			exit();
		}
	}
}

// Если товар уже есть в корзине, то меняет кнопку на "ДОБАВЛЕНО", которая ведет в корзину
function SwitchAddToCartButtonText () 
{
	$productsAtCart = R::getAll( 'select * from cart WHERE id_user = ?', [$_SESSION['id']]);
	foreach ($productsAtCart as $product) {
		echo "<script> cartButtonToggle(".$product['id_product'].") </script>";
	}
}

 ?>
 
<div class="container tt-milks-ff">
	<h1>Каталог игр</h1>
	<form method="POST">
		<div class="row row-cols-1 row-cols-md-4 g-4">
				<?php GetAllProducts();?>
		</div>
	</form>
</div>

<script type="text/javascript" src="../js/mainScript.js"></script>

<?php 
IsAddToCartButtonPressed();
SwitchAddToCartButtonText();
?>