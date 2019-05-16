(function(){

    $('.fancybox').fancybox({
        helpers : {
            overlay : {
                locked: false //Вот этот параметр
            }
        }
    });

    $(".myphone").mask("+7(999) 999-99-99");

    // usermenu hover parent
    //$('.dropcat_2').hover(function(){
    //    $(this).prev().addClass('dropcat__link_active');
    //}, function(){
    //    $(this).prev().removeClass('dropcat__link_active');
    //});
    // usermenu hover parent end

    // login-tabs
    $(".tab_item").not(":first").hide();
    $(".login-tabs .tab").click(function() {
        $(".login-tabs .tab").removeClass("active").eq($(this).index()).addClass("active");
        $(".tab_item").hide().eq($(this).index()).fadeIn()
    }).eq(0).addClass("active");
    // login-tabs end

    // toggle cats
    var toggleBtn    = $('.top-cats__title');
    var toggleBtnBef = $('.top-cats__bef');
    var DropCat      = $('.dropcat');

    toggleBtn.on('click', function(e){
        e.preventDefault();
        $(this).next().stop().slideToggle();
    });
    toggleBtnBef.on('click', function(e){
        e.preventDefault();
        DropCat.stop().slideToggle();
    });
    // toggle cats end

    // slider akcii
    $('.slider-akcii__list').lightSlider({
        item  : 1,
        pager : false,
        loop: true,
        auto: true,
        pause: 7000
    });
    // slider akcii end

    // usermenu toggle
    $('.topbar-left__profile').on('click', function(e){
        e.preventDefault();
        $(this).next('.usermenu-down').stop().slideToggle();
    });
    // usermenu toggle end

    // xsmenu
    $('.top-menu_xs').on('click', function(e){
        e.preventDefault();
        $(this).next().stop().slideToggle();
    });
    // xsmenu end

    // products-box_new slider
    $('.products-box_new, .products-box_lider').lightSlider({
        item  : 5,
        pager : false,
        responsive : [
            {
                breakpoint:1200,
                settings: {
                    item:4,
                    slideMove:1,
                    slideMargin:6
                }
            },
            {
                breakpoint:992,
                settings: {
                    item:3,
                    slideMove:1
                }
            },
            {
                breakpoint:768,
                settings: {
                    item:2,
                    slideMove:1
                }
            },
            {
                breakpoint:480,
                settings: {
                    item:1,
                    slideMove:1
                }
            }
        ]
    });
    // products-box_new slider end

        // sidebar accardeon
    $('.sidebar-params-item__title').on('click', function(e){
        e.preventDefault();
        $(this).next('.sidebar-params-body').stop().slideToggle();
    });
    // sidebar accardeon end

    // form styler
    // $('input, select').styler();
    // form styler end

    // tooltip
    $( document ).tooltip();
    // tooltip end

    // page cat addvart anim
    var topCart = $('.top-cart');
    var catProductAdd = $('.cat-product-item__btns a');

    catProductAdd.on('click', function(e){
        e.preventDefault();
        topCart.addClass('top-cart_buth');
        setTimeout(function(){
            topCart.removeClass('top-cart_buth');
        }, 1000);
    });
    // page cat addvart anim end

    // product img zoom
    $(".product-img__img img");
    // product img zoom end

    // product img gallery
    $('.product-gallery').lightSlider({
        item  : 4,
        pager : false
    });

    // click to img top
    var galleryMiniImg = $('.product-gallery__link');
    var galleryMainImg = $('.product-mainimg');
    var galleryLinkImg = $('.product-img__img a');

    galleryMiniImg.on('click', function(e) {
        e.preventDefault();
        var largeImg = $(this).attr('data-img');
        var smallImg = $(this).children().attr('src');
        // console.log(largeImg);
        // console.log(smallImg);
        galleryMainImg.attr('src', smallImg);
        galleryMainImg.attr('data-zoom-image', largeImg);
        galleryLinkImg.attr('href', largeImg);
    });

    // product img gallery end

    // product bottom tabs
    $(".product-bottom-tabs .product-bottom-tabs__tab-item").not(":first").hide();
    $(".product-bottom-tabs .product-bottom-tabs__tab").click(function() {
        $(".product-bottom-tabs .product-bottom-tabs__tab").removeClass("active").eq($(this).index()).addClass("active");
        $(".product-bottom-tabs .product-bottom-tabs__tab-item").hide().eq($(this).index()).fadeIn()
    }).eq(0).addClass("active");
    // product bottom tabs end

    $('#callback').click(function(event) {
        event.preventDefault();
        var object = $(this);
        var name = object.prev().prev().val();
        var phone = object.prev().val();

        //alert(name + phone);

        $.post("/callback/", {name: name, phone: phone})
            .done(function(ajax) {
                if (ajax.response == 'success') {
                    //object.prev().prev().prev().addClass('success');
                    $('#callback-msg').html(ajax.result);
                    setTimeout(function(){
                        $.fancybox.close();
                        $('#callback-msg').html('');
                    }, 2000);
                    
                } else if (ajax.response == 'error') {
                    //object.prev().prev().prev().addClass('error');
                    $('#callback-msg').html(ajax.result);
                }
                object.prev().prev().val(''); object.prev().val('');
            }, 'json');
            
    });

    $('.shopping-cart').click(function(event) {
        event.preventDefault();
        var object = $(this);
        if (object.attr('disabled') == 'disabled') return;
        object.attr('disabled', 'disabled');
        var objectId = object.attr('data-id');
        var objectQty = object.attr('data-qty');
        if (objectId) {
            if (!objectQty) objectQty = 0;
                $.get("/shopbag/?json", {product_id: objectId, qty: objectQty, action: 'append'})
                    .done(function(ajax) {
                        //alert(print_r(ajax));
                        if (ajax.response == 'success') {
                            if (ajax.result == 'full') {
                                object.parent().append('<p class="shopping-cart__anim">Добавлено в корзину!</p>')
                                    .promise().done(function() {
                                        $('.top-cart__count').html(ajax.shopbag.qty);
                                        $('.top-cart__price').html(ajax.shopbag.total_sum_withDiscount);
                                        object.parent().children(":last-child").fadeIn(600, function() {
                                            setTimeout(function() {
                                                object.parent().children(":last-child")
                                                    .fadeOut(600, function() {
                                                        $(this).remove();
                                                        object.removeAttr('disabled');
                                                    });
                                            }, 2500);
                                        });
                                    });
                            }
                        }

                    }, 'json');
        }
    });
    var timeout = true;
    $('.counter .counter__plus').click(function(event) { event.preventDefault(); if (!timeout) return; timeout = false;
         $('#counted').fadeIn(600);
            var object = $(this);
            var price = object.prev().attr('data-price');
            var id = object.prev().attr('data-id');
            var from = parseInt($('#total_sum'+id).html());
            var to = from + parseInt(price);
            var qty = parseInt(object.prev().val())+1;
             object.prev().attr('value', qty);
             object.parent().next().attr('data-qty', qty).attr('value', qty);
             $('#qty'+id).attr('data-qty', qty);
                number_to("total_sum"+id,from,to,400);
            setTimeout(function() { timeout = true; }, 550);
    });

    $('.counter .counter__minus').click(function(event) { event.preventDefault(); if (!timeout) return; timeout = false;
         $('#counted').fadeIn(600);
        var object = $(this);
            if ((parseInt(object.next().val()) - 1) < 1) {timeout = true; return;}
        var price = object.next().attr('data-price');
        var id = object.next().attr('data-id');
        var from = parseInt($('#total_sum'+id).html());
        var to = from - parseInt(price);
        var qty = parseInt(object.next().val())-1;
        if (qty < 3) {timeout = true; return;}
         object.next().attr('value', qty);
         object.parent().next().attr('data-qty', qty).attr('value', qty);
         $('#qty'+id).attr('data-qty', qty);
            number_to("total_sum"+id,from,to,400);
        setTimeout(function() { timeout = true; }, 550);
    });
	
	//### GENESIS ###//
	
	$('#auth').click(function(e){
		e.preventDefault();
		var button = $(this);
		var login = $(this).parent().prev().prev().val();
		var passw = $(this).parent().prev().val();
		var check = $(this).parent().children(":first-child").children(":first-child").is(':checked');
	
		button.prev().prepend('<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
		button.attr("disabled", "disabled");
		button.html("Подождите...");
		
		$.post("/login.php?ajax", {login: login, password: passw, remember_me: check})
			.done(function(response) { 
				if (response.response == 'success') {
					window.location.reload();
				} else {
					$('#authMessage').fadeOut(400, function(){
						$(this).html(response.response).fadeIn(400, function(){
							button.prev().children(":first-child").remove();
							button.removeAttr("disabled");
							button.html("Войти");
						});
					});
				}
			}, 'json')
			.fail(function(response) {
				//alert(response);
				//alert(print_r(response));
			});
	});
	
	$('#reg').click(function(e){
		e.preventDefault();
		var button = $(this);
		var email = $(this).parent()
						.prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().val();
		var login = $(this).parent()
						.prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().val();
		var phone = $(this).parent()
						.prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().val();
		var passw = $(this).parent()
						.prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().prev().val();
		var passw2 = $(this).parent()
						.prev().prev().prev().prev().prev().prev().prev().prev().prev().val();
		var name = $(this).parent()
						.prev().prev().prev().prev().prev().prev().prev().val();
		var surname = $(this).parent()
						.prev().prev().prev().prev().prev().val();
		var middle = $(this).parent()
						.prev().prev().prev().val();
		var address = $(this).parent()
						.prev().val();
	
		button.parent().prepend('<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>');
		button.attr("disabled", "disabled");
		button.html("Подождите...");
		
		$.post("/login.php?ajax&reg", {login: login, passw: passw, passw2: passw2, email: email, phone: phone, name: name, surname: surname, middle: middle, address: address})
			.done(function(response) { 
				if (response.response == 'success') {
					window.location.reload();
				} else {
					$('#regMessage').fadeOut(400, function(){
						$(this).html(response.response).fadeIn(400, function(){
							button.parent().children(":first-child").remove();
							button.removeAttr("disabled");
							button.html("Зарегистрироваться");
						});
					});
				}
			}, 'json')
			.fail(function(response) {
				//alert(response);
				//alert(print_r(response));
			});
	});
	
	function number_to(id,from,to,duration) {
		var element = document.getElementById(id);
		var start = new Date().getTime();

		setTimeout(function() {
			var now = (new Date().getTime()) - start;
			var progress = now / duration;
			var result = Math.floor((to - from) * progress + from);
			element.innerHTML = progress < 1 ? result : to;
			if (progress < 1) setTimeout(arguments.callee, 1);
			//timeout = true;
		}, 1);
	}

	function print_r(arr, level) {
		var print_red_text = "";
		if(!level) level = 0;
		var level_padding = "";
		for(var j=0; j<level+1; j++) level_padding += "    ";
		if(typeof(arr) == 'object') {
			for(var item in arr) {
				var value = arr[item];
				if(typeof(value) == 'object') {
					print_red_text += level_padding + "'" + item + "' :\n";
					print_red_text += print_r(value,level+1);
				}
				else
					print_red_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}

		else  print_red_text = "===>"+arr+"<===("+typeof(arr)+")";
		return print_red_text;
	}


}());