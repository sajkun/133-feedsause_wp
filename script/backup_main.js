var Cookie =
{
   set: function(name, value, days)
   {
      var domain, domainParts, date, expires, host;

      if (days)
      {
         date = new Date();
         date.setTime(date.getTime()+(days*24*60*60*1000));
         expires = "; expires="+date.toGMTString();
      }
      else
      {
         expires = "";
      }

      host = location.host;
      if (host.split('.').length === 1)
      {
         // no "." in a domain - it's localhost or something similar
         document.cookie = name+"="+value+expires+"; path=/";
      }
      else
      {
         // Remember the cookie on all subdomains.
          //
         // Start with trying to set cookie to the top domain.
         // (example: if user is on foo.com, try to set
         //  cookie to domain ".com")
         //
         // If the cookie will not be set, it means ".com"
         // is a top level domain and we need to
         // set the cookie to ".foo.com"
         domainParts = host.split('.');
         domainParts.shift();
         domain = '.'+domainParts.join('.');

         document.cookie = name+"="+value+expires+"; path=/; domain="+domain;

         // check if cookie was successfuly set to the given domain
         // (otherwise it was a Top-Level Domain)
         if (Cookie.get(name) == null || Cookie.get(name) != value)
         {
            // append "." to current domain
            domain = '.'+host;
            document.cookie = name+"="+value+expires+"; path=/; domain="+domain;
         }
      }
   },

   get: function(name)
   {
      var nameEQ = name + "=";
      var ca = document.cookie.split(';');
      for (var i=0; i < ca.length; i++)
      {
         var c = ca[i];
         while (c.charAt(0)==' ')
         {
            c = c.substring(1,c.length);
         }

         if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
      }
      return null;
   },

   erase: function(name)
   {
      Cookie.set(name, '', -1);
   }
};
if(!days_offset){
  var days_offset = 10;
}else{
  days_offset = parseInt(days_offset);
}


var timer;

/**
* Initiates carousel on post page
*/
function init_article_gallery(){
  if(!jQuery('.article-gallery').length)
    return false;

  var owl = jQuery('.article-gallery');

  owl.owlCarousel({
    responsive :{
      0 : {
        items: 1,
      },
      768: {
        autoWidth: true,
      }
    },
    loop: true,
    center: true,
    margin: 40,
    autoPlay: true,
    lazyLoad : true,

  })
}


/**
* initiates datepicker
*/
function init_datepicker(){
    var args = (jQuery('.checkout').length)?
      {
        minDate : 0,
        dateFormat: 'dd M yy',
        onClose : function(date, args){
          var prefix = (parseInt(args.selectedMonth)<10)? '0' : '';

          var month = parseInt(args.selectedMonth) + 1 ;
          var store_date = args.selectedYear+'-'+prefix+month +'-'+args.selectedDay;

          jQuery(this).closest('.shipping-item__date').find('[type=date]').val(store_date);
        }
      }
      : {};

  jQuery( ".datepicker" ).datepicker(args);
}


/**
* Initiates carousel on post page
*/
function init_showcase(){
  if(!jQuery('.slider-images').length)
    return false;

  var owl = jQuery('.slider-images');
  $args = {
     responsive :{
      0 : {
        items: 1,
      },
      768: {
        autoWidth: true,
      }
    },
    slideBy: 4,
    margin: 40,
    dots: false,
    nav: false,
    lazyLoad: true,
  }


  if(owl.length > 2){
    $args.loop = true;
    $args.autoPlay = true;
    $args.dots = true;
    $args.dotsEach = 4;
    $args.center = true;
  }

  owl.owlCarousel($args);
}


function check_other_address(obj){
  var prop = jQuery(obj).prop('checked');

  if(prop){
    jQuery('#other_address').slideDown('fast', function() {
    });
  }else{
    jQuery('#other_address').slideUp('fast', function() {

    });
  }
}


/**
* replaces part of a string
*
* @param {needle} - object with pairs {search : replace }
* @param {highstack} - string
*
* @return String
*/
function str_replace(needle, highstack){
  var template = highstack;
    for(key in needle){
    var exp = new RegExp("\\{" + key + "\\}", "gi");
      template = template.replace(exp, function(str){
        value = needle[key];
        return value;
      });
    }
    return template;
}


/**
*returns to previous page
*/
function goBack() {
  window.history.back();
}


/**
* toggles show of an html element
*
* @param {selector} - className of an elemnt to show
*/
function show_slide_down(selector){
  jQuery('body').find('.'+selector).slideDown('fast');
}


/**
* Applies coupon code
*/
function theme_apply_coupon(){
  if(timer){
    clearTimeout(timer);
  }

  timer = setTimeout(function(){
      var $form = jQuery( 'form.checkout' );

      if ( $form.is( '.processing' ) ) {
        return false;
      }

      $form.addClass( 'processing' ).block({
        message: null,
        overlayCSS: {
          background: '#fff',
          opacity: 0.6
        }
      });

      var data = {
        security:   wc_checkout_params.apply_coupon_nonce,
        coupon_code:  jQuery('.coupon_code').val()
      };

      jQuery.ajax({
        type:   'POST',
        url:    wc_checkout_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'apply_coupon' ),
        data:   data,
        success:  function( code ) {
          jQuery( '.woocommerce-error, .woocommerce-message' ).remove();
          $form.removeClass( 'processing' ).unblock();

          if ( code ) {
            $form.before( code );
            // $form.slideUp();

            jQuery( document.body ).trigger( 'update_checkout', { update_shipping_method: false } );
          }
        },
        dataType: 'html'
      });

      return false;
  }, 1200)
}


/**
* Removes coupon code from a cart
*
* @param {coupon} =- string
*/
function clear_coupon_code_checkout(coupon){
  var container = jQuery( 'form.checkout' );

  container.addClass( 'processing' ).block({
    message: null,
    overlayCSS: {
      background: '#fff',
      opacity: 0.6
    }
  });

  var data = {
    security: wc_checkout_params.remove_coupon_nonce,
    coupon:   coupon
  };

  jQuery.ajax({
    type:    'POST',
    url:     wc_checkout_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'remove_coupon' ),
    data:    data,
    success: function( code ) {
      jQuery( '.woocommerce-error, .woocommerce-message' ).remove();
      container.removeClass( 'processing' ).unblock();

      if ( code ) {

        jQuery( document.body ).trigger( 'update_checkout', { update_shipping_method: false } );

      }
    },
    error: function ( jqXHR ) {
      if ( wc_checkout_params.debug_mode ) {
        /* jshint devel: true */
        console.log( jqXHR.responseText );
      }
    },
    dataType: 'html'
  });
}



/**
* Removes cart item from a cart
*
* @param {item_key} =- string
*/
function remove_checkout_item(item_key){
  if(!item_key)
    return false;

  var container = jQuery( 'form.checkout' );

  container.addClass( 'processing' ).block({
    message: null,
    overlayCSS: {
      background: '#fff',
      opacity: 0.6
    }
  });

  var data = {
    cart_item_key: item_key
  };

  jQuery.ajax({
    type:    'POST',
    url:     wc_checkout_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'remove_from_cart' ),
    data:    data,
    success: function( code ) {
      jQuery( '.woocommerce-error, .woocommerce-message' ).remove();
      container.removeClass( 'processing' ).unblock();

      if ( code ) {
        jQuery( document.body ).trigger( 'update_checkout', { update_shipping_method: false } );
      }
    },
    error: function ( jqXHR ) {
      if ( wc_checkout_params.debug_mode ) {
        /* jshint devel: true */
        console.log( jqXHR.responseText );
      }
    },
    dataType: 'json'
  });
}

/**
* Initiates lazy load for all pictures
*/
function init_lazy_load(){

  jQuery('.lazy-load').lazy({
    effect: 'fadeIn',
    afterLoad: function(element) {
      jQuery(element).css({'height' : 'auto'});
      if(jQuery(element).hasClass('zoom')){
        jQuery(document).trigger({
          type: 'trigger_zoom',
        })
      }
    },
  });
}


/**
* Sets currency cookie
*/
function set_currency (cur){
  Cookie.set('theme-currency', cur);
  location.reload();
}


jQuery(document).on('updated_checkout', function(){
  init_datepicker();
})
/*select imitation click. Expands dropdown of a select imitation*/
jQuery(document).on('click','.select-imitation', function(e){
  var obj = jQuery(this);
  obj.toggleClass('active');

  if(jQuery(e.target).closest('li').length){
    var row = jQuery(e.target).closest('li');
    var val = row.data('currency');
    var text = row.html();

    obj.find('.select-imitation__value').html(text);
    obj.find('.select-imitation__data').val(val);

  }
})


/*closes select imitation dropdown if click was outside the select*/
jQuery(document).on('click', function(e){
  if(!jQuery(e.target).closest('.select-imitation').length){
    jQuery('.select-imitation').removeClass('active');
  }

  if(!jQuery(e.target).closest('.photo-item').length){
    jQuery('.photo-item__overlay').removeClass('visible');
  }
})

jQuery(document).on('click','.mobile-menu-toggle', function(e){
  jQuery(this).toggleClass('active');
  jQuery('.mobile-menu').toggleClass('active');
})


/**/
jQuery(document).on('click','.js-show-download', function(e){
  e.preventDefault();
  var parent = jQuery(this).closest('.photo-item');
  jQuery('.photo-item__overlay').removeClass('visible');
  parent.find('.photo-item__overlay-download').addClass('visible');
})



jQuery(document).on('click','.js-show-request', function(e){
  e.preventDefault();
  var parent = jQuery(this).closest('.photo-item');
  jQuery('.photo-item__overlay').removeClass('visible');
  parent.find('.photo-item__overlay-request').addClass('visible');
})



jQuery(document).on('click','.js-show-buy', function(e){
  e.preventDefault();
  var parent = jQuery(this).closest('.photo-item');
  jQuery('.photo-item__overlay').removeClass('visible');
  parent.find('.photo-item__overlay-buy').addClass('visible');
})

jQuery(document).on('click','.js-exec-cancel', function(e){
  e.preventDefault();
  var parent = jQuery(this).closest('.photo-item');
  jQuery('.photo-item__overlay').removeClass('visible');
})



jQuery(document).on('click','.my-order__filter-item', function(e){
  e.preventDefault();
  jQuery('.my-order__filter-item').removeClass('active');
  jQuery(this).addClass('active');

  var target = jQuery(this).attr('href').slice(1);

  var childs = (target === 'all') ? jQuery('.my-order').find('.filtering-item') : jQuery('.my-order').find('[data-type='+target+']');


  if(target === 'all'){
    jQuery('.my-order').find('.filtering-item').removeClass('hidden');
  }else{
    jQuery('.my-order').find('.filtering-item').each(function(ind, el){
     if(jQuery(el).data('type') !== target){
      jQuery(el).addClass('hidden');
     }else{
      jQuery(el).removeClass('hidden');
     }
    })
  }
})


jQuery(document).on('click','.my-order__tabs-item ', function(e){
  e.preventDefault();
  var target = '.'+jQuery(this).data('target');
  jQuery('.my-order__tabs-item').removeClass('active');
  jQuery(this).addClass('active');
  jQuery('.my-order__tab-content').addClass('hidden');
  jQuery(target).removeClass('hidden');
})


jQuery(document).on('input', '.photo-item__overlay-textarea', function(e){
  var val = jQuery(this).val();
  var length_left = 500 - val.length;
  value = (length_left >= 0 )? val : val.slice(0, 500) ;
  length_left = (length_left >0)? length_left : 0;
  jQuery(this).val(value);
  jQuery(this).siblings('.photo-item__overlay-limit').find('.current').text(length_left);
})


/*toggles show of a datepicker*/
jQuery('.shipping-item__date').click(function(e){

  setTimeout(function(){

    if(!jQuery(e.target).closest('input').length && jQuery(window).width()>992){
      jQuery(e.target).closest('.shipping-item__date').find('.datepicker').datepicker( "show" );
    }
  },10);
})


/*sets classes for input wrapper on focus input */
jQuery(document).on('blur', '.input-with-icon input', function(e){
  jQuery(this).closest('.input-with-icon').removeClass('active');
})


/*removes classes for input wrapper on loose focus input */
jQuery(document).on('focus', '.input-with-icon input', function(e){
  jQuery(this).closest('.input-with-icon').addClass('active');
})


/*expands mobile menu item with child items*/
jQuery(document).on('click', '.mobile-menu .has-child',function(e){
  e.preventDefault();
  jQuery(this).siblings('.menu-item').removeClass('expanded');
  jQuery(this).toggleClass('expanded');
  jQuery(this).find('.sub-menu__wrapper').slideToggle();
})


/*sets a class for input wrapper on focus input*/
jQuery(document).on('focus', '.form-field', function(e){
  var wrapper = jQuery(this).closest('.label-checkout-holder');
  wrapper.addClass('selected');
})


/*removes a class for input wrapper on loose focus input*/
jQuery(document).on('blur', '.form-field', function(e){
  var wrapper = jQuery(this).closest('.label-checkout-holder');

  if(!jQuery(this).val()){
    wrapper.removeClass('selected');
  }
})


/*adds a price value to submit form button when woocomerce triggers found_variation event*/
jQuery(document).ready( function($) {
  var $form = $('.variations_form'),
        $button = $form.find('.single_add_to_cart_button');

  $form.on( 'found_variation', function( event, variation){

     var $text = 'Create Images';
     var $html_button = '<b>'+variation.price_html+'</b> '+$text+'<i class="icon-arrow"></i>';
      $button.html($html_button);
  });
})


/*toggles class for shipping methods on checkout page*/
jQuery(document).on('click', '.shipping-item',function(e){
  var old_prop_checked;
  if(jQuery(this).hasClass('disabled')){ return 1};

  jQuery(this).addClass('active').removeClass('not-active').siblings('.shipping-item').removeClass('active').addClass('not-active');

   old_prop_checked = jQuery(this).find('input.shipping_type').prop('checked');

   if(!old_prop_checked){
    jQuery(this).find('input.shipping_type').prop({'checked': true}).trigger('change');

    jQuery(this).siblings('.shipping-item').find('[type=checkbox]').prop({'checked': false}).trigger('change');

    jQuery(this).siblings('.shipping-item').find('[type=radio]').prop({'checked': false}).trigger('change');
   }

} )

// /*ajax reload shipping methods*/
// jQuery(document).on('country_to_state_changed', function( event, country, wrapper){
//   jQuery( document.body ).trigger( 'update_checkout', { test_parameter_: false });
// })


/*bind actions to select*/
jQuery(document).on('updated_checkout', function( event, data){

console.log(data);
  if(data.fragments['form.woocommerce-checkout']){
    console.log(1);
    jQuery('.site-footer').remove();
  }

  var args = (jQuery('.checkout').length)?
      {
        minDate : 0,
        onClose : function(date, args){
          var prefix = (parseInt(args.selectedMonth)<10)? '0' : '';
          var prefix_day = (parseInt(args.selectedDay)<10)? '0' : '';

          var month = parseInt(args.selectedMonth) + 1 ;
          var store_date = args.selectedYear+'-'+prefix+month +'-'+prefix_day+args.selectedDay;

          jQuery(this).closest('.shipping-item__date').find('[type=date]').val(store_date);
        }
      }
      : {};

  jQuery('.checkout').find( ".datepicker" ).datepicker(args);

  jQuery('.checkout').find('.shipping-item__date').bind(function(e){
    setTimeout(function(){

      if(!jQuery(e.target).closest('input').length && jQuery(window).width()>992){
        jQuery(e.target).closest('.shipping-item__date').find('.datepicker').datepicker( "show" );
      }
    },10);
  })

  var checkbox = jQuery('.checkout').find('[name=ship_to_different_address]');


  if(checkbox.prop('checked') === false){
    jQuery('.shipping_address').slideUp();
  }else{
    jQuery('.shipping_address').slideDown();
  }
})

/*shows popup with video*/
jQuery(document).on('click', '.trigger-video', function(e){
  e.preventDefault();
  jQuery('.video-popup-wrapper .video-block').html('');


  var type = jQuery(this).data('type');

  var search = {
    url : jQuery(this).attr('href'),
  };

  var video = '', template='';

  if(!type && (search.url.indexOf(WP_URLS.home_url) >=0)){
    type = 'plain';
  }

  if(!type && (search.url.indexOf('youtu') >=0)){
    type = 'youtube';
  }


  switch (type){
    case 'youtube':
      template = '<iframe src="{url}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
      break;
    case 'plain':
      template = '<video id="view_video_file" controls> <source src="{url}" > </video>';
      break;
    default:
      break;
  }

  video = str_replace(search, template);

  jQuery('.video-popup-wrapper').addClass('shown');
  jQuery('.video-popup-wrapper .video-block').html(video);
})

/*closes popup with video */
jQuery(document).on('click', '.video-popup-wrapper .icon-close', function(e){
  jQuery('.video-popup-wrapper').removeClass('shown');
   jQuery('.video-popup-wrapper .video-block').html('');
})

/*closes popup with video */
jQuery(document).on('click', '.video-popup-wrapper', function(e){
  if(!jQuery(e.target).closest('.video-block').length){
    jQuery('.video-popup-wrapper').removeClass('shown');
     jQuery('.video-popup-wrapper .video-block').html('');
  }
})

/*filter category products items*/

jQuery(document).on('click', '.categories__item', function(e){
  if(jQuery(this).data('filter')){
    e.preventDefault();

    var category = jQuery(this).data('filter');
    var products = jQuery('div.product');

    jQuery(this).addClass('selected').siblings('.categories__item').removeClass('selected');

    if('all' === category){
      products.removeClass('hidden');
      return 1;
    }

    products.each(function(ind, el){
      var categories = jQuery(el).data('category');
      categories = categories.split(',');

      if(categories.indexOf(category)>=0){
        jQuery(el).removeClass('hidden');
      }else{
        jQuery(el).addClass('hidden');
      }
    })
  }
})


jQuery(document).on('country_to_state_changed', function(e, data){
  if(data!==theme_default_country){

    jQuery('[name=ship_to_different_address').prop({'checked': 0})
  }
})

jQuery(document).on('country_to_state_changing', function(e, data){
  if(data!==theme_default_country){
    jQuery('[name=ship_to_different_address').prop({'checked': 0})
  }
})

jQuery(document).on('click', '.product-attribute-sidebar .return-link',  function(e){
  e.preventDefault();
  console.log('close');
  jQuery(this).closest('.product-attribute-sidebar').removeClass('shown');
})


function show_product_sidebar(id){
  jQuery('.'+id).addClass('shown').focus();
}

jQuery('.product-attribute-sidebar').click(function(e){
  if(!jQuery(e.target).closest('.inner').length){
    jQuery('.product-attribute-sidebar').removeClass('shown');
  }
})
var Cookie =
{
   set: function(name, value, days)
   {
      var domain, domainParts, date, expires, host;

      if (days)
      {
         date = new Date();
         date.setTime(date.getTime()+(days*24*60*60*1000));
         expires = "; expires="+date.toGMTString();
      }
      else
      {
         expires = "";
      }

      host = location.host;
      if (host.split('.').length === 1)
      {
         // no "." in a domain - it's localhost or something similar
         document.cookie = name+"="+value+expires+"; path=/";
      }
      else
      {
         // Remember the cookie on all subdomains.
          //
         // Start with trying to set cookie to the top domain.
         // (example: if user is on foo.com, try to set
         //  cookie to domain ".com")
         //
         // If the cookie will not be set, it means ".com"
         // is a top level domain and we need to
         // set the cookie to ".foo.com"
         domainParts = host.split('.');
         domainParts.shift();
         domain = '.'+domainParts.join('.');

         document.cookie = name+"="+value+expires+"; path=/; domain="+domain;

         // check if cookie was successfuly set to the given domain
         // (otherwise it was a Top-Level Domain)
         if (Cookie.get(name) == null || Cookie.get(name) != value)
         {
            // append "." to current domain
            domain = '.'+host;
            document.cookie = name+"="+value+expires+"; path=/; domain="+domain;
         }
      }
   },

   get: function(name)
   {
      var nameEQ = name + "=";
      var ca = document.cookie.split(';');
      for (var i=0; i < ca.length; i++)
      {
         var c = ca[i];
         while (c.charAt(0)==' ')
         {
            c = c.substring(1,c.length);
         }

         if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
      }
      return null;
   },

   erase: function(name)
   {
      Cookie.set(name, '', -1);
   }
};
jQuery(document).ready(function(){
  init_article_gallery();
  init_showcase();
  init_lazy_load();
  init_datepicker();

  jQuery('.product__gallery-item').fancybox();
  jQuery('.fancybox-image').fancybox();
  jQuery('.fancybox-wrapper a').fancybox();
  jQuery('.init-select').select2();
  jQuery('.wpforms-field-select select').select2();
})


if(!theme_currency){
  var theme_currency = ['£', '$'];
}

jQuery(function($){
  var selects = $('#block-variations select');
  var form    = $('.variations_form');


  selects.each(function(ind, el){
    options = $(el).find('option');
  })

  /*replaces theme variation's option's selects with theme styled html*/
  $.fn.theme_replace_attributes_selects = function($select){
    var options = $select.find('option');
    var output  = '';

    options.each(function(ind, el){
      var template = '<div class="col margin-bottom-20"><label class="single-recipe__option"> <input type="radio" name="__{input_name}" value="{value}" class="theme-attributes-inputs"> <span class="single-recipe__option-view"> {icon} {name} {price} {description}</span> </label></div>';

      var replace = {};
      var name    = $(el).text();
      var value   = $(el).attr('value');

      if(value){
        var search  = '';
        var price   = '';
        var icon    = '';
        var input_name = $select.attr('name');
        var symbol;

        for(id in theme_currency){
          search = new RegExp('\\Wd{0,}'+theme_currency[id]+'\\d{0,}');
          price  = (name.indexOf(theme_currency[id]) >=0 && name.match(search))? name.match(search)[0] : price;

          symbol  = (name.indexOf(theme_currency[id]) >=0 && name.match(search))? theme_currency[id] : symbol;

          name   = (name.indexOf(theme_currency[id]) >=0 && name.match(search))? name.replace(search, '') : name;
        }

        var current_currency = Cookie.get('theme-currency');

        if(theme_currency_options && theme_currency_options[current_currency]){
          var price_val = price.replace(symbol, '');

          new_price_val = parseFloat(theme_currency_options[current_currency].rate) * parseFloat(price_val);

          price = theme_currency_options[current_currency].symbol+new_price_val.toFixed(2);
        }



        replace.price        = (price)? '<span class="price">'+ price + '</span>' : '';
        replace.name         = (name)? '<span class="title">'+ name + '</span>' : '';
        replace.description   = (jQuery(el).data('description'))? '<span class="description">'+ jQuery(el).data('description') + '</span>' : '';
        replace.icon         = (icon)? icon : '';
        replace.input_name   = (input_name)? input_name : '';
        replace.value        =  value;

        output += str_replace(replace, template);
      }
    });

    $select.addClass('hidden').next('.value').append(output);
  }

  $.fn.theme_trigger_attribute = function(value, select_name){
    var select_name = select_name.substr(2);
    var select      = jQuery('[name='+select_name+']');
    select.val(value).trigger('change');
  }

  selects.each(function(index, el) {
    $.fn.theme_replace_attributes_selects($(el));
  });


  $(document).on('click', '.theme-attributes-inputs',function(){
    var value        = $(this).val();
    var select_name  = $(this).attr('name');
    $.fn.theme_trigger_attribute(value, select_name);
  })

  $( document.body ).on('updated_checkout', function(e, arg){
     $('.regular-checkout-submit').append('<i class="icon-arrow"></i>');
  })
})

console.log('script loaded');