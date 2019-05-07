		function removeItem(n){
			$('#cart').css('background-color', 'white').css('color','black');
			$.ajax({
				url: 'removeFromCart.php',
				type: 'post',
				data: {
					'id' : n
				},
				success: function( data, textStatus, jQxhr ){
					$('#cart').css('background-color', 'blue').css('color','white');
					var price = $('#p'+n).html().substring(1);
					if($('#n'+n).html()==0)
						return;
					var number = $('#n'+n).html()-1;
					var total = ($('#total').html().substring(1));
					$('#c'+n).html(('$'+price*number).substr(0,7));
					$('#n'+n).html(number);
					$('#total').html(('$'+(total-price)).substr(0,7));
				},
				error: function( jqXhr, textStatus, errorThrown ){
					$('#cart').css('background-color', 'red');
					console.log(errorThrown );
				}
			});
		}
				
		function addToCart(n){
			$('#add'+n).css('background-color', 'white').css('color','black');
			$.ajax({
				url: 'addToCart.php',
				type: 'post',
				data: {
					'id' : n
				},
				success: function( data, textStatus, jQxhr ){
					$('#add'+n).css('background-color', 'blue').css('color','white');
				},
				error: function( jqXhr, textStatus, errorThrown ){
					$('#add'+n).css('background-color', 'red');
					console.log(errorThrown );
				}
			});
		}