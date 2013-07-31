;(function($) {

	window.main = {
		vars: {},
		init: function(){

			var header = main.vars.header = $('#header'),
				mainNavigation = header.mainNavigation = $('.main-navigation', header);


			$('.share-popup-btn').on('click', function(){
				var url = $(this).attr('href');
				var width = 640;
				var height = 305;
				var left = ($(window).width() - width) / 2;
				var top = ($(window).height() - height) / 2;
				window.open(url, 'sharer', 'toolbar=0,status=0,width='+width+',height='+height+',left='+left+', top='+top);
				return false;
			});

			$('.print-btn').on('click', function(e){
				console.log('hello');
				e.preventDefault();
				window.print();
			});

			this.lightbox.init();
			this.ajaxPage.init();
			this.scroller.init();
			this.accordion.init();
		

			$(window).resize(this.resize);
			this.resize();

		},

		loaded: function(){
			$('body').addClass('loaded');
			this.equalHeight();
		},

		lightbox: {
			init: function(){
				if($.fn.accordion){
					$('.accordion').each(function(){
						var accordion = $(this),
							options = {
							//	easing: 'easeOutBounce',
							//	timeout: 5500,
								slideClass: 'item',
								slideWidth: 656,
								width: 810,
								height: 340
							};


						accordion.accordion(options);
					});
				}
			}
		},

		accordion: {
			init: function(){

			}
		},

		scroller: {
			init: function(){

				if($.fn.scroller){
					$('.scroller').each(function(){
						var scroller = $(this);
						var options = {};

						if(scroller.hasClass('gallery-scroller') || scroller.data('scroll-all') === true) options.scrollAll = true;
						if(scroller.data('auto-scroll') === true ) options.autoScroll = true;
						if(scroller.data('resize') === true ) options.resize = true;
						if(scroller.data('callback')) {
							scroller.bind('onChange', function(e, nextItem){
								var func = window[scroller.data('callback')];
								func($(this), nextItem);
							});
						}

						scroller.scroller(options);
					});
				}
			}
		},

		ajaxPage: {
			init: function(){
				main.ajaxPage.container = $('#ajax-page');
				$('.ajax-btn').on('click', function(e){
					e.preventDefault();
					main.ajaxPage.load($(this).attr('href'));
				});
			},
			load: function(url){

				var container = main.ajaxPage.container,
					regex = new RegExp('(\\?|\\&)ajax=.*?(?=(&|$))'),
		        	qstring = /\?.+$/;

			    if (regex.test(url)){
			        ajaxUrl = url.replace(regex, '$1ajax=true');
			    } else if (qstring.test(url)) {
			        ajaxUrl = url + '&ajax=true';
			    } else {
			        ajaxUrl =  url + '?ajax=true';
			    }
			    history.pushState(null, null, url);
			    $('html, body').animate({scrollTop: container.offset().top - 200}, 800, 'easeInOutQuad');
			    if($('.content', container).length == 0){

					loader = $('<div class="loader"></div>').hide();
					container.append(loader);
					
					container.delay(200).animate({height: loader.actual('outerHeight')}, function(){
						loader.fadeIn();

						$.get(ajaxUrl, function(data) {
							var content = $('<div class="content"></div>').hide();

							container.append(content);
							content.html(data);
							loader.fadeOut(function(){
								if($.fn.imagesLoaded){
									content.imagesLoaded(function(){
										main.resize();
										container.animate({'height': content.height()}, function(){
											container.css({'height': 'auto'});
											content.fadeIn();
										});
									});
								} else {
									container.animate({'height': content.actual('height')}, function(){
										container.css({'height': 'auto'});
										content.fadeIn();
										main.resize();
									});
								}
								
							});
						});
					});
				} else {
					var content = $('.content', container),
						loader = $('.loader', container);
					content.fadeOut(function(){
						loader.fadeIn();
						
						$.get(ajaxUrl, function(data) {
							content.html(data);
							loader.fadeOut(function(){
								if($.fn.imagesLoaded){
									content.imagesLoaded(function(){
										main.resize();
										container.animate({'height': content.height()}, function(){
											container.css({'height': 'auto'});
											content.fadeIn();
										});
									});
								} else {
									container.animate({'height': content.actual('height')}, function(){
										container.css({'height': 'auto'});
										content.fadeIn();
										main.resize();
									});
								}
								
							});
						});
					});
				}
			}
		},

		equalHeight: function(){
			if($('.equal-height').length !== 0){
		
				var currTallest = 0,
				currRowStart = 0,
				rowDivs = new Array(),
				topPos = 0;

				$('.equal-height').each(function() {

					var element = $(this);
					topPos = element.position().top;
					if (currRowStart != topPos) {

						for (i = 0 ; i < rowDivs.length ; i++) {
							rowDivs[i].height(currTallest);
						}

						rowDivs.length = 0;
						currRowStart = topPos;
						currTallest = element.height();
						rowDivs.push(element);

					} else {
						rowDivs.push(element);
						currTallest = (currTallest < element.height()) ? (element.height()) : (currTallest);
					}

					for (i = 0 ; i < rowDivs.length ; i++) {
						rowDivs[i].height(currTallest);
					}

				});
			}
		},

		resize: function(){
			var windowWidth = $(window).width(),
				mainNavigation = main.vars.header.mainNavigation;
			
			if(windowWidth <= 600 && mainNavigation.is(':visible')){
				mainNavigation.hide();
			} else if(windowWidth > 600 && !mainNavigation.is(':visible')) {
				mainNavigation.show();
			}
		},

		tabs: {
			init: function() {
				var container = main.tabs.container = $('.tabs'),
					content = main.tabs.content = $('.tab-content', container),
					navigationItems = main.tabs.navigationItems = $('.tab-navigation li', container);

				$('a', navigationItems).on('click', function(){
					main.tabs.goto($(this).data('id'));
				});
			},
			goto: function(id){
				var navigationItems = main.tabs.navigationItems,
					content = main.tabs.content;
				navigationItems.removeClass('current');
				$('a[data-id='+id+']').parent().addClass('current');

				$('.tab', content).hide();
				$('.tab[data-id='+id+']', content).fadeIn();


			}
		}
	}

	$(function(){
		main.init();
	});

	$(window).load(function(){
		main.loaded();
	});
})(jQuery);