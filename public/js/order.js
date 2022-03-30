$('body').on('click', '.add-to-cart-link', function(e) {
	e.preventDefault();
	var id = $(this).data('id')
	$.ajax({
		url: '/order/add',
		data: {id: id},
		type: 'GET',
		success: function(res) {
			showCart(res);
		},
		error: function() {
			alert('Ошибка добавления! Попробуйте позже, пожалуйста');
		}
	});
});

function showCart(order) {
	if ($.trim(order) == '<h3>Корзина пуста</h3>') {
		$('#order .modal-footer a, #order .modal-footer .btn-danger').css('display', 'none');
	} else {
		$('#order .modal-footer a, #order .modal-footer .btn-danger').css('display', 'inline-block');
	}
	$('#order .modal-body').html(order);
	$('#order').modal();
	if ($('.cart-sum').text()) {
		$('.simpleCart_total').html($('#order .cart-sum').text());
	} else {
		$('.simpleCart_total').text('Корзина пуста');
	}
}

function getCart() {
	$.ajax({
		url: '/order/show',
		type: 'GET',
		success: function (res) {
			showCart(res);
		},
		error: function() {
			alert('Ошибка! Попробуйте позже, пожалуйста');
		}
	});
}

$('#order .modal-body').on('click', '.del-item', function() {
	var id = $(this).data('id');
	$.ajax({
		url: '/order/delete',
		data: {id: id},
		type: 'GET',
		success: function(res) {
			showCart(res);
		},
		error: function() {
			alert('Ошибка удаления! Попробуйте позже, пожалуйста');
		}
	});
});

function clearCart()
{
	$.ajax({
		url: '/order/clear',
		type: 'GET',
		success: function (res) {
			showCart(res);
		},
		error: function() {
			alert('Ошибка! Попробуйте позже, пожалуйста');
		}
	});
}