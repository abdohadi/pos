$(document).ready(function () {

	// add product btn
	$('.add-product-btn').on('click', function(e) {
		e.preventDefault();
		
		var name = $(this).data('name'),
			 id = $(this).data('id'),
			 deleteUrl = $(this).data('delete-url'),
			 price = numberFormat($(this).data('price'));

		var html = 
		`<tr>
			<td>${name}</td>
			<td><input type="number" name="products[${id}][quantity]" class="form-control product-quantity" data-price="${price}" min="1" value="1"></td>
			<td class="product-price">${price}</td>
			<td>
				<button class="btn btn-danger btn-sm remove-product-btn" data-id="${id}" data-url="${deleteUrl}"><i class="fa fa-trash"></i></button>
			</td>
		</tr>`;

		$('.order-list').append(html);

		$(this).removeClass('btn-success').addClass('btn-default disabled');

		calculateTotal();
	});

	// disabled btn
	$('body').on('click', '.disabled', function(e) {
		e.preventDefault();
	});

	// remove product btn
	$('body').on('click', '.remove-product-btn', function(e) {
		e.preventDefault();

		removeProduct($(this));
		
		calculateTotal();

	});

	// product quantity
	$('body').on('change keyup', '.product-quantity', function() {
		var productPriceEl = $(this).closest('tr').find('.product-price');
		$(this).val($(this).val() != '' ? $(this).val() : 1);

		productPriceEl.text(numberFormat(parseFloat($(this).val()) * parseFloat($(this).data('price').replace(/,/g, ''))));
		
		calculateTotal();
	});


	// show order products
	$('.show-order-products-btn').on('click', function(e) {
		e.preventDefault();

				$('#order-products-list').empty();
		$('#loading').show();

		var url = $(this).data('url'),
			method = $(this).data('method');

		$.ajax({
			url: url,
			method: method,
			success: function(data) {
				$('#loading').hide();

				$('#order-products-list').append(data);
			}
		});
	});


	// print order
	$(document).on('click', '.print-btn', function() {
		$('#print-area').printThis();
	});


});//end of document ready


// calculate total price
function calculateTotal() {
	var price = 0;

	$('.order-list .product-price').each(function() {
		price += parseFloat($(this).text().replace(/,/g, ''));
	});

	$('.total-price').text(numberFormat(price));

	// handle add-order-btn
	if (price > 0) {
		$('#add-order-btn').removeClass('disabled');
	} else {
		$('#add-order-btn').addClass('disabled');
	}
}

// format numbers
function numberFormat(number) {
	var arrNum = number.toFixed(2).split('.');
	var intNum = arrNum[0];
	var decNum = arrNum[1];
	var numString = '';
	if (intNum > 999) {
		arr = intNum.toString().split('').reverse();
		arr.forEach((el, i, arr) => {
			numString = el + numString;
			if (i+1 == 3 || (i+1 == 6 && arr.length == 6)) {
			   numString = ',' + numString;
			}
		});
		return numString.concat('.', decNum);
	}
	return number.toFixed(2);
}

// Ajax request to detach a product from an order
function removeProduct(btnEl) {
	$.ajax({
		url: btnEl.data('url'),
		method: 'GET',
		success: function() {
			var id = btnEl.data('id');

			btnEl.closest('tr').remove();

			$('#product-' + id).removeClass('btn-default disabled').addClass('btn-success');
		}
	});
}