;(function($) {

	window.main = {
		vars: {},
		init: function(){

			var header = main.vars.header = $('#header'),
				mainNavigation = header.mainNavigation = $('.main-navigation', header);


			$('.share-popup-btn').on('click', function(){
				var url = $(this).attr('href'),
					width = 640,
					height = 305,
					left = ($(window).width() - width) / 2,
					top = ($(window).height() - height) / 2;
				window.open(url, 'sharer', 'toolbar=0,status=0,width='+width+',height='+height+',left='+left+', top='+top);
				return false;
			});

			$('.print-btn').on('click', function(e){
				e.preventDefault();
				window.print();
			});

			
			this.lightbox.init();
			this.ajaxPage.init();
			this.scroller.init();
			this.accordion.init();
			this.facebook.init();
		

			$(window).resize(this.resize);
			this.resize();

		},

		loaded: function(){
			$('body').addClass('loaded');
			FB.Canvas.setSize( {height: $(window).height()});
			this.equalHeight();
		},

		lightbox: {
			init: function(){
				var container = main.lightbox.container = $('#lightbox'),
					overlay = main.lightbox.overlay = $('.overlay', container),
					content = main.lightbox.content = $('.content', container),
					loader = main.lightbox.loader = $('.loader', container);

				$('.lightbox-btn').on('click', main.lightbox.open);
				overlay.on('click', main.lightbox.close);
				$(document).on('click', '#lightbox .close-btn', main.lightbox.close);
			},
			open: function(e){
				e.preventDefault();
				main.lightbox.load($(this).attr('href'));
			},
			load: function(url){
				var container = main.lightbox.container,
					overlay = main.lightbox.overlay,
					content = main.lightbox.content,
					loader = main.lightbox.loader,
					documentHeight = $(document).height(),
					windowHeight = $(window).height(),
					scrollTop = $(window).scrollTop(),
					ajaxUrl = main.addToUrl(url, 'ajax'),
					ajaxUrl = main.addToUrl(ajaxUrl, 'lightbox');

				container.height(documentHeight);
				container.show();
				loader.fadeIn();
				content.hide();
				overlay.fadeIn('slow', function(){
					
					$.get(ajaxUrl, function(data) {
						content.html(data)
						loader.fadeOut(function(){
							
							if($.fn.imagesLoaded){
								content.imagesLoaded(function(){
									var top = scrollTop + (windowHeight - content.height()) / 2;
									if(top + content.height() > documentHeight - 60){
										top = documentHeight - content.height() - 60;
									}
									content.animate({top: top}, function(){
										content.fadeIn();
									});
								});
							} else {
								var top = scrollTop + (windowHeight - content.height()) / 2;
								if(top + content.height() > documentHeight - 60){
									top = documentHeight - content.height() - 60;
								}
								container.animate({top: top}, function(){
									content.fadeIn();
								});
							}	
						});	
						
					});
				});	

			},
			close: function(){
				var container = main.lightbox.container,
					overlay = main.lightbox.overlay,
					content = main.lightbox.content;

				content.fadeOut(function(){
					overlay.fadeOut(function(){
						container.hide();
					});
					content.html();
				});
			}
		},

		accordion: {
			init: function(){
				if($.fn.accordion){
					$('.accordion').each(function(){
						var accordion = $(this),
							width = accordion.width(),
							totalItems = accordion.children().size(),
							tabWidth = (accordion.data('tab-width')) ? accordion.data('tab-width') : 32
							resizeChildren = (accordion.data('resize-children')) ? accordion.data('resize-children') : true,
							options = {
							//	easing: 'easeOutBounce',
							//	timeout: 5500,
								slideClass: 'item',
								tabWidth: tabWidth,
								width: width,
								height: 330,
								animationComplete: function(){
									var item = $(this);
									item.addClass(options.slideClass + '-opened')
								},
								animationStart: function(){
									var slideClass = options.slideClass;
									accordion.addClass('opened');
									$('.'+ slideClass, accordion).removeClass(slideClass + '-opened');
								},
								close: function(){
									var slideClass = options.slideClass;
									$('.'+ slideClass, accordion).removeClass(slideClass + '-opened');
								},
								closed: function(){
									accordion.removeClass('opened');
								}
							};

						accordion.accordion(options);

						$(window).on('load', function(){
							setTimeout(function(){
								$('.item.current', accordion).trigger('click');					
							}, 1000);
						});

					});
				}
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

		facebook: {
			init: function(){
				$.ajaxSetup({ cache: true });
				$.getScript('//connect.facebook.net/en_UK/all.js', function(){
					FB.init({
						appId: '579639135402354',
						channelUrl: '//lrfb.occam-dm.com/channel.php',
						status: true,
						xfbml: true,
						oauth: true,
						frictionlessRequests: true
					});
					main.facebook.ready();
				});
			},
			ready: function(){
				// ///DELETE
				//FB.getLoginStatus(function(response) {
				//	if (response.status === 'connected') {
					//	FB.api('/me/permissions', 'delete');
					//	FB.logout();
				//	}
				//});
	
				$('.send-to-friends-btn').on('click', function(){
					
					FB.ui({
						method: 'send',
						link: 'http://www.landrover.co.uk/'
					});
				});

				$('.share-btn').on('click', function(){
					var url = $(this).data('url'),
						name = $(this).data('name'),
						image = $(this).data('image'),
						caption = $(this).data('caption'),
						description = $(this).data('description');
						
					FB.ui({
						method: 'feed',
						link: url,
						name: name,
						description: description,
						picture: image,
						caption: caption
					}, function(response){

					});
				});

				FB.Canvas.setAutoGrow();

				main.competition.init();
				main.notification.init();
				main.youtube.init();
			},
			checkPermissions: function(permissions, callback){
				FB.api('/me/permissions', function(response){
					var enabledPermissions = response.data[0],
						authorized = false;
					for(var i in permissions){
						var permission = permissions[i];
						if(enabledPermissions[permission]){
							authorized = true;
						} 
					}

					callback(authorized);
				});
			},

			setCanvasHeight: function(){
				FB.Canvas.setSize( {height: $(window).height()});
			}
		},

		competition: {
			init: function(){
				var form = main.competition.form = $('.competition'),
					email = main.competition.email = {
						field: $('#field_1_3', form),
						input: $('#input_1_3', form)
					},
					name = main.competition.name = {
						field: $('#field_1_6', form),
						input: {
							firstName: $('#input_1_6_3', form),
							lastName: $('#input_1_6_6', form)
						}
					},
					facebook = main.competition.facebook = {
						input: $('#input_1_4', form)
					},
					accessToken = main.competition.accessToken = {
						input: $('#input_1_5', form)
					},
					permissions = main.competition.permissions = ['email'];
				if(form.length > 0){	
					FB.getLoginStatus(function(loginResponse) {
						if (loginResponse.status === 'connected') {
							main.facebook.checkPermissions(permissions, function(authorized){

								if(authorized){
									FB.api('/me', function(response){
										email.input.val(response.email);
										name.input.firstName.val(response.first_name);
										name.input.lastName.val(response.last_name);
										accessToken.input.val(loginResponse.authResponse.accessToken);
									});
								}
							});
						} else {
							if(form.parent().hasClass('gform_validation_error')){
								email.field.show();	
								name.field.show();
							}
						}
					});
					form.on('submit', main.competition.submit);
				}
			},

			submit: function(){
				var form = main.competition.form,
					email = main.competition.email,
					name = main.competition.name,
					facebook = main.competition.facebook,
					accessToken = main.competition.accessToken,
					permissions = main.competition.permission;


				if(email.input.val()){
					return true;
				} else {
					FB.getLoginStatus(function(loginResponse) {
						
						if (loginResponse.status === 'connected') {
							main.facebook.checkPermissions(permissions, function(authorized){
								
								if(authorized){
									FB.api('/me', function(response){
										email.input.val(response.email);
										name.input.firstName.val(response.first_name);
										name.input.lastName.val(response.last_name);
										facebook.input.val('1');
										accessToken.input.val(loginResponse.authResponse.accessToken);
										form.submit();
									});
								} else {
									main.competition.authorize();
								}
							});
						} else if (loginResponse.status === 'not_authorized') {
							main.competition.login();
						} else {
							main.competition.login();
						}
					});

					return false;
				}
			},


			login: function(){
				form = main.competition.form,
				email = main.competition.email,
				name = main.competition.name;

				FB.login(function(response){
					if(response.status === 'connected'){
						form.submit();
					} else {
						alert('If you would not like to login with Facebook, please enter your email address');
						email.field.show();
						name.field.show();
					}
				}, {scope: main.competition.permissions.join(',')});
			},
			
			authorize: function(){
				FB.ui({
					method: 'oauth',
					scope: main.competition.permissions.join(',')
				}, function(response){
					if(response){
						main.competition.form.submit();
					}
				});
			}
		},

		notification: {
			init: function(){
				var form = main.notification.form = $('.notification'),
					email = main.notification.email = {
						input: $('#input_2_1', form)
					},
					accessToken = main.notification.accessToken = {
						input: $('#input_2_2', form)
					},
					userId = main.notification.userId = {
						input: $('#input_2_3', form)
					},
					permissions = main.notification.permissions = ['email'];
				
				if(form.length > 0){		
					FB.getLoginStatus(function(loginResponse) {
						if (loginResponse.status === 'connected') {
							main.facebook.checkPermissions(permissions, function(authorized){
								if(authorized){
									FB.api('/me', function(response){
										email.input.val(response.email);
										accessToken.input.val(loginResponse.authResponse.accessToken);
										userId.input.val(response.id);
									});
								}
							});
						}
					});
					form.on('submit', main.notification.submit);
				}
			},

			submit: function(){
				var form = main.notification.form,
					email = main.notification.email,
					accessToken = main.notification.accessToken,
					userId = main.notification.userId,
					permissions = main.notification.permissions;

				if(email.input.val()){
					return true;
				} else {
					FB.getLoginStatus(function(loginResponse) {
						
						if (loginResponse.status === 'connected') {
							main.facebook.checkPermissions(permissions, function(authorized){
								
								if(authorized){
									FB.api('/me', function(response){
										email.input.val(response.email);
										accessToken.input.val(loginResponse.authResponse.accessToken);
										userId.input.val(response.id);
										form.submit();
									});
								} else {
									main.notification.authorize();
								}
							});
						} else if (loginResponse.status === 'not_authorized') {
							main.notification.login();
						} else {
							main.notification.login();
						}
					});

					return false;
				}
			},

			login: function(){
				FB.login(function(response){
					if(response.status === 'connected'){
						main.notification.form.submit();
					}
				}, {scope: main.notification.permissions.join(',')});
			},
			
			authorize: function(){
				FB.ui({
					method: 'oauth',
					scope: main.notification.permissions.join(','),

				}, function(response){
					if(response){
						main.notification.form.submit();
					}
				});
			}
		},


		youtube: {
			init: function(){

				var video = main.youtube.video = $('#youtube-video'),
					overlay = main.youtube.overlay = video.parent().find('.overlay');
					player = main.youtube.player = {},
					main.youtube.authorized = false;

				

				if(video.length > 0){

					FB.getLoginStatus(function(loginResponse) {
						if (loginResponse.status === 'connected') {
							main.facebook.checkPermissions(main.notification.permissions, function(authorized){
								main.youtube.authorized = authorized;
							});
						}
					});

					main.youtube.player = new YT.Player('youtube-video', {
						videoId: video.data('video-id'),
						events: {
							'onReady': main.youtube.onPlayerReady,
							'onStateChange': main.youtube.onPlayerStateChange
						}
					});
				}
			},
			onPlayerReady: function(event){
				main.youtube.player.playVideo();
			},
			onPlayerStateChange: function(event){
				if(event.data === 0 && !main.youtube.authorized){
					main.youtube.overlay.fadeIn();
				}
			}
		},

		ajaxPage: {
			init: function(){
				var container = main.ajaxPage.container = $('#ajax-page'),
					//currUrl = main.ajaxPage.currUrl = window.location.href;
					pageUrl = main.ajaxPage.pageUrl = window.location.href;
				
				$('.ajax-btn').on('click', function(e){
					main.ajaxPage.load($(this).attr('href'));
					return false;
				});

				$(document).on('click', '#ajax-page .close-btn', function(){
					main.ajaxPage.close();
				});

			},
			load: function(url){

				var container = main.ajaxPage.container,
					ajaxUrl = main.addToUrl(url, 'ajax');

				
				//container.slideDown(2000);
			    if($('.content', container).length == 0){
			    	container.show();
			    	loader = $('<div class="loader"></div>');
					loader.hide();
					container.html(loader);

					container.animate({height: loader.actual('outerHeight')}, function(){
						loader.fadeIn();

						$.get(ajaxUrl, function(data) {
							var content = $('<div class="content"></div>');
							content.hide();
							container.append(content);
							content.html(data);
							loader.fadeOut(function(){
								if($.fn.imagesLoaded){
									content.imagesLoaded(function(){
										container.animate({'height': content.height()}, function(){
											container.css({'height': 'auto'});
											content.fadeIn();
											container.slideDown('slow');
											main.facebook.setCanvasHeight();
										});
									});
								} else {
									container.animate({'height': content.actual('height')}, function(){
										container.css({'height': 'auto'});
										content.fadeIn();
										main.facebook.setCanvasHeight();
									});
								}	
							});

						});
					});
				} else {
					var content = $('.content', container),
						loader = $('<div class="loader"></div>').hide();
					container.prepend(loader);
					content.fadeTo(300, 0, function(){
						loader.fadeIn();
						$.get(ajaxUrl, function(data) {
							content.html(data);
							loader.fadeOut(function(){
								container.animate({'height': content.actual('height')}, function(){
									content.fadeTo(300, 1);
									container.css({'height': 'auto'});
									main.facebook.setCanvasHeight();
								});
							});
						});
					});
				}

				//main.ajaxPage.currUrl = url;
			}, 
			close: function(){
				var container = main.ajaxPage.container;

				container.slideUp(function(){
					container.html('');
				});

				//if(Modernizr.history) history.pushState(null, null, main.ajaxPage.pageUrl);
			}
		},

		addToUrl: function(url, query){
			var regex = new RegExp('(\\?|\\&)'+query+'=.*?(?=(&|$))'),
		        qstring = /\?.+$/;

			if (regex.test(url)){
		        url = url.replace(regex, '$1'+query+'=true');
		    } else if (qstring.test(url)) {
		        url = url + '&'+query+'=true';
		    } else {
		        url =  url + '?'+query+'=true';
		    }

		    return url;		
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