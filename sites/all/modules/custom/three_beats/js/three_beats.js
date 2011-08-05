
Drupal.three_beats = Drupal.three_beats || {};
Drupal.three_beats.ViewsCache  = Drupal.three_beats.ViewsCache || [];
Drupal.behaviors.three_beats = function(context) {

	$("#facebook-posts").click(function() {

		if(this.checked)
			{var facebook_posting = 'on'; }
		else
			{var facebook_posting = 'off';}

		$.ajax({
		type: 'GET',
		url: '/facebook_posting/'+facebook_posting,
		dataType: 'json',
		success: function(data){},
		data: {},
		async: false
	});
	});


    $("#beats-form-rating").submit(function() {
        var rating = $("#rating_value").val();
        if(rating == "0") {
            alert("Please Set Your Rating");
            return false;
        }

        var comment = $.trim($("#beats_comment_textbox").val());
        if(comment.length < 1 || comment == "Leave your Comment here...") {
            alert("Please Set Your Comment");
            return false;
        }
    });

    $("#beats_button_m2").click(function() {
     $('.buttun').each(function(){
     	$(this).removeClass('activetub');
     })
         $(this).addClass('activetub');
      $("#rating_value").val("-2");
      return false;
    });

    $("#beats_button_m1").click(function() {
     $('.buttun').each(function(){
     	$(this).removeClass('activetub');
     })
         $(this).addClass('activetub');
      $("#rating_value").val("-1");
      return false;
    });

    $("#beats_button_p1").click(function() {
     $('.buttun').each(function(){
     	$(this).removeClass('activetub');
     })
           $(this).addClass('activetub');
      $("#rating_value").val("1");
      return false;
    });

    $("#beats_button_p2").click(function() {
     $('.buttun').each(function(){
     	$(this).removeClass('activetub');
     })
     	$(this).addClass('activetub');
      $("#rating_value").val("2");
      return false;
    });

	$('#edit-keys-wrapper #edit-keys').each(function(){
	  $(this).focus(function() {
	    if($(this).val() == 'Type a Celebrity\'s Name') {
	      $(this).val('');
      }});
    });

    $('#edit-keys-wrapper #edit-keys').each(function(){
	  $(this).blur(function() {
      if($(this).val().length < 1){
        $(this).val('Type a Celebrity\'s Name');
      }});
    });

	$('.form-textarea').focus(function() {
	  $(this).each(function(){
	    if($(this).val() == 'Leave your Comment here...') {
	      $(this).val('');
      }});
    });

	    $("#beats_comment_textbox").keypress(function(){
        var key = $(this).val().length;
        if(key > 175) {
        	$(this).val($(this).val().substr(0, 175));
			}
	    });

	$('.top-10-rating-gainers').each(function () {
      var height_dif = $(this).parent().height() - $(this).height();
	if(height_dif < 0){
	  height_dif = - height_dif;
	  $(this).css('margin-top', height_dif);
	  $(this).css('position', 'relative');
	}
	else{
	$(this).css('margin-top', height_dif + 1);
	$(this).css('position', 'relative');
	}
    });

	jQuery.each(jQuery.browser, function(i, val) {
	   if($.browser.msie && $.browser.version.substr(0,3)=='7.0'){
	      $('.topnavigation ul ul.menu').css('margin-left','-80px');
	      $('#header_bar ul li ul li.first.last').css('margin-left','4px');
	      $('#searchbox_bg .form-submit').css('top','-38px');
	      $('#beats_comment_textbox').css('margin-top','-10px');
	      $('#searchbox_bg_corner input').css('float','none');
	      $('#searchbox_bg_corner input.form-submit').css('position','absolute');
	      $('#searchbox_bg_corner input.form-submit').css('margin-left','235px');
	      $('#searchbox_bg_corner input.form-submit').css('margin-top','-27px');
	   }
    });

    $('.form-textarea').blur(function(){
	  $(this).each(function() {
      if($(this).val().length < 1){
        $(this).val('Leave your Comment here...');
      }});
    });

	$('.crowd_pulse_menu_item', context).each(function(){
	      $(this).click(function(){

			$('.crowd_pulse_menu_item').removeClass('activetab');
			$(this).addClass('activetab');
			Drupal.three_beats.loadView('vote','block_1', '#vote_celebrity', false, false,$(this).attr('alt'));
			$('.views-row-even').empty();
			$('.views-row-odd').empty();
			var color = $(this).css('background-color') ? $(this).css('background-color') :  $(this).css('color');

			$('.crowd_pulse_menu_item', context).each(function(){

				var item_color = $(this).attr('item_color')
				var item = $(this).attr('item')

				/*if($(this).hasClass('activetab'))
				{
					$(this).parent().addClass(item).css('color','#000000');
				}
				else
				{
					$(this).removeClass(item).css('background-color','#000000').css('color',item_color);
				}*/
			});
	    });
   });
};

Drupal.three_beats.createLoader = function(target, className) {
  if (!className) {
    className = 'top';
  }
  className += '-loader';

  $(target).addClass('ajax-views-loader').prepend('<div class="'+className+'" id="views-ajax-preloader"> <div class="background"></div><div class="loader"></div></div>');
  $('#views-ajax-preloader .background').css('height', $(target).css('height'));
  $('#views-ajax-preloader .loader').css('height', $(target).css('height'));
};

Drupal.three_beats.removeLoader = function(target) {

  if (!target) {
    $('.ajax-views-loader').removeClass('ajax-views-loader');
  }
  else {
    $(target).removeClass('ajax-views-loader');
  }

  $('#views-ajax-preloader').remove();
};

   //var target = this.parentNode;
Drupal.three_beats.loadView = function(view_name, display_id, target, is_cacheable, show_loading) {
    var args = [];
    for (var i = 5; i < arguments.length; i ++) {
      args.push(arguments[i]);
  }
    args = args.join('/');

   var viewData = {view_name: view_name, view_display_id: display_id, view_args: args};

   Drupal.settings.views.ajaxViews[0].view_display_id  = display_id;
   Drupal.settings.views.ajaxViews[0].view_args        = args;

   var $target = $(target).children()[0];

   var cache_id = Drupal.three_beats.cacheId(view_name + display_id + args);

   if (show_loading) {
     Drupal.three_beats.createLoader(target);
  }
  if (!Drupal.three_beats.ViewsCache[cache_id] || !is_cacheable) {
    $.getJSON('/views/ajax', viewData, function(response){
      if (is_cacheable) {
        Drupal.three_beats.ViewsCache[cache_id] = response;
      }
      if (show_loading) {
        Drupal.three_beats.removeLoader(target);
      }
      if (response.__callbacks) {
        $.each(response.__callbacks, function(i, callback) {
          eval(callback)($target, response);
        });
      }
    });
  } else {
    if (show_loading) {
      Drupal.three_beats.removeLoader(target);
    }
    if (Drupal.three_beats.ViewsCache[cache_id].__callbacks) {
      $.each(Drupal.three_beats.ViewsCache[cache_id].__callbacks, function(i, callback) {
        eval(callback)($target, Drupal.three_beats.ViewsCache[cache_id]);
      });
    }
  }
};

Drupal.three_beats.cacheId = function(string) {
  return 'cache_' + hex_md5(string);
};