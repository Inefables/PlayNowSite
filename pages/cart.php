<?php 

// Вывод количества продуктов в корзине
function countOfProductsAtCart()
{
	echo R::count('cart', 'id_user = ?', [$_SESSION['id']]);
}

// Получить все продукты с корзины пользователя
function GetAllProductsFromUserCart()
{
	$productIds = array();
	$sum = 0;

	if (empty($_SESSION['id'])) {
		$new_url = '/login';
		header('Location: '.$new_url);
		exit();
	} 
	else {
		//Получение добавленных товаров в корзину
		$productsAtCart = R::getAll( 'select * from cart WHERE id_user  = ?', [$_SESSION['id']] );
		foreach ($productsAtCart as $key) {
			array_push($productIds, $key['id_product']);
		}
	
		$productsAtCart = R::getAll( 'select * from products WHERE id IN ('.R::genSlots( $productIds ).')', $productIds );

		foreach ($productsAtCart as $product) {
			//Подсчет итого
			$sum+= $product["price"];
			//Получение названия жанра
			$genre = R::findOne('genres', 'id_genre = ?', [$product["id_genre"]]);
			//Получение наименования издателя
			$publisher = R::findOne('publishers', 'id_publisher = ?', [$product["id_publisher"]]);
			//Получение наименования разработчика
			$developer = R::findOne('developers', 'id_developer = ?', [$product["id_developer"]]);
			//Получение наименования сервиса активации
			$activation_service = R::findOne('activation_services', 'id_activation_service = ?', [$product["id_activation_service"]]);
			
			// Вывод всей информации о продукте
			echo '
			<div class="card mb-3">
				<div class="row g-0">
					<div class="col-md-4">
						<img src="../'.$product["image_name"].'" class="card-img-top">
					</div>
					<div class="col-md-8 bg-dark cart-card-right-border">
						<div class="card-body" style="color: white;">
							<h3 class="card-title">'.$product["name"].'</h3>
							<p class="card-text">Жанр: '.$genre["name"].'</p>
							<p class="card-text">Издатель: '.$publisher["name"].'</p>
							<p class="card-text">Разработчик: '.$developer["name"].'</p>
							<p class="card-text">Сервис активации: '.$activation_service["name"].'</p>
							<span class="card-text text-warning h1">'.$product["price"].' руб.</span>
						</div>
					</div>
				</div>
			</div>
			';
		}
		echo '<script> 
		setSumForPay('.$sum.'); 
		</script>
		';
	}
	
}

 ?>

<div class="container tt-milks-ff">
	<h1>Мой заказ: <span class="text-secondary">
		<?php countOfProductsAtCart(); ?> ИГР
		</span></h1>
	<form method="POST">
		<div class="row justify-content-between">
			<div class="col-9">
				<div class="row row-cols-1 row-cols-md-1 g-0">
					<?php GetAllProductsFromUserCart();?>
				</div>
			</div>

			<div class="col-3">
				<div class="card text-white bg-dark mb-3 text-align-center" style="max-width: 15rem;">
					<div id="sumCard" class="card-header">ИТОГО <span id="sumForPay" class="text-warning"></span>руб.</div>
						<div class="card-body">
							<button class="btn btn-warning">ОФОРМИТЬ ЗАКАЗ</button>
						</div>
					</div>
				</div>
			</div>
	</form>
</div>

<script type="text/javascript" src="../js/cart.js"></script>