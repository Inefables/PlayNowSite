// Маска для поля для ввода номера телефона
jQuery(document).ready(function(){
	$(".phone").mask("8(999)999-99-99");
});


function cartButtonToggle(productId) {
	// var btn = document.getElementsByName('id');
	var div = document.getElementById(productId);
	var btn = div.getElementsByTagName("button");

	if (btn[0].innerHTML == "В КОРЗИНУ") {
		btn[0].innerHTML = "ДОБАВЛЕНО";
	}
	else {
		btn[0].innerHTML = "В КОРЗИНУ";
	}
}

function countOfProudctsAtCart(userId, countOfProducts) {
	var badge = document.getElementById('cartBadge');
	badge.innerHTML = countOfProducts;
}

// Отключаем обновление страницы в каталоге 
// при добавлении товара в корзину
document.getElementById('catalog').submit(function (e) {
	e.preventDefault();
});

