console.log('admin script was loaded 2');


function load_image(obj, size){

  var $parent = obj.closest('.image-download');
  // var send_attachment_bkp = wp.media.editor.send.attachment;

  wp.media.editor.send.attachment = function(props, attachment) {
    var val =attachment.id;
    var html;

    switch(attachment.type){
      case 'video':
        html = '<video width="280" controls> <source src="'+attachment.url+'" type="'+attachment.mime+'"></video>';
       break;
      default:
        html = '<img src="'+attachment.url+'" alt=""/>';
       break;
    }

    jQuery($parent).find('.image-placeholder *').remove();
    jQuery($parent).find('.image-placeholder').append(html);
    jQuery($parent).find('.image-id').val(val);
  };

  wp.media.editor.open();
}

function add_image_text_item(parent, slug, counter_id){
  var number = jQuery(counter_id).val();

   var  html_template = '<div class="image-text-wrapper__item"> <input type="hidden" name="{slug}[type]" value="image" /><div class="image-download"> <div class="image-placeholder"> <img src="<?php echo esc_url($image)?>" alt=""> </div> <input type="hidden" name="{slug}[image_id]" class="image-id"> <a href="javascript:void(0)" class="button" onclick="load_image(this)">Set image</a> </div> <h4>Before title</h4> <input type="text" class="large-text" name="{slug}[before_title]"> <h4>Title</h4> <textarea class="large-text" name="{slug}[title]" id="" cols="30" rows="5"></textarea> <h4>Text</h4> <textarea class="large-text" name="{slug}[text]" id="" cols="30" rows="5"></textarea> <br /> <a href="javascript:void(0)" onclick="delete_block(this, \'.image-text-wrapper__item\')">Delete block</a> </div>';

  var search = {
    slug : slug+'['+number+']',
  };

  var $html = string_replace(search, html_template);
  jQuery(parent).append($html);
  number++;
  jQuery(counter_id).val(number++)
}

function add_quote(parent, slug, counter_id){
  var number = jQuery(counter_id).val();

   var  html_template = '<div class="image-text-wrapper__item"> <input type="hidden" name="{slug}[type]" value="quote" /><h4>Text</h4> <textarea class="large-text" name="{slug}[text]" id="" cols="30" rows="5"></textarea> <h4>Author</h4> <textarea class="large-text" name="{slug}[author]" id="" cols="30" rows="5"></textarea> <br /> <a href="javascript:void(0)" onclick="delete_block(this, \'.image-text-wrapper__item\')">Delete block</a> </div>';

  var search = {
    slug : slug+'['+number+']',
  };

  var $html = string_replace(search, html_template);
  jQuery(parent).append($html);
  number++;
  jQuery(counter_id).val(number++)
}


function add_gallery_item(parent, slug, counter_id){
  var number = jQuery(counter_id).val();

  var  html_template = '<div class="gallery-wrapper__item"><div class="image-download"> <div class="image-placeholder"></div><input type="hidden" name="{slug}[image_id]" class="image-id"><a href="javascript:void(0)" class="button" onclick="load_image(this)">Set image</a></div> <h4>Slide Url</h4> <input type="text" class="large-text" name="{slug}[url]"><br /><a href="javascript:void(0)" onclick="delete_block(this, \'.gallery-wrapper__item\')">Delete Slide</a></div>';

  var search = {
    slug : slug+'['+number+']',
  };

  var $html = str_replace(search, html_template);

  jQuery(parent).append($html);
  number++;
  jQuery(counter_id).val(number++)
}

function delete_block(obj, target){
  jQuery(obj).closest(target).remove();
}

function clear_image(obj){
  var $parent = obj.closest('.image-download');
  jQuery($parent).find('.image-id').val(-1);
  jQuery($parent).find('.image-placeholder img').attr({'src': text_var.doomy_url});
}


function remove_banner(obj){
  jQuery(obj).closest('.banner').remove();
}


function remove_banner_block(obj){
  jQuery(obj).closest('div.article-block').slideUp('fast',function(){
     jQuery(obj).closest('div.article-block').find('.image-id').val('');
  })
}

var counter = null;

function add_banner(obj, num, page_slug, dummy){

  counter =(counter)? counter : num;
  counter++;

  var search = {
    num         : counter,
    page_slug   : page_slug,
    dummy       : dummy,
    set_image   : text_var.set_image,
    clear_image : text_var.clear_image,
    delete_slide : text_var.delete_slide,
    text        : text_var.text,
    info        : text_var.info1
  };

  var html = '<div class="article-block"> <div class="article-table"> <div class="article-table__image image-download"> <div class="image-download"> <input type="hidden" class="image-id" name="{page_slug}[items][{num}][image_id]" value="-1"> <div class="image-placeholder" onclick="load_image(this)"> <img src="{dummy}" alt=""> </div> <div class="button-holder"> <a href="javascript:void(0)" class="button submit-add-to-menu left" onclick="load_image(this)">{set_image}</a> &nbsp; <a href="javascript:void(0)" onclick="clear_image(this)">{clear_image}</a> </div> </div> </div> <div class="article-table__content"><p>{text}</p> <textarea class="fullwidth" rows="6" type="text" name="{page_slug}[items][{num}][text]"></textarea><br><p class="description"><i>{info}</i> </p><p> <a href="javascript:void(0)" onclick="remove_banner_block(this)">{delete_slide}</a> </p> </div> </div> </div>';

  replace = str_replace(search, html);
  jQuery(obj).closest('.js-acordeon').find('div.article-banners').append(replace);
}





jQuery('.close-popup').click(function(){
  jQuery('.popup-wrapper').removeClass('shown');
})



// function add_currency(cur){
//   var currencies = JSON.parse(cur);
//   var settings = '<option value="{value}">{name} ({symbol})</option>';
//   var select   = '';
//   var search = {};

//   for(id in currencies){
//     console.log(id);
//     search = {
//       value: 1,
//     };
//   }
// }

function add_ingreduents(obj){

  var html = '<div class="article-block options_group"> <div class="article-table2" style="padding:10px"> <div class="article-table__image image-download"> <div class="image-download"> <input type="hidden" class="image-id" name="{page_slug}[items][{num}][image_id]" value="-1"> <div class="image-placeholder" onclick="load_image(this)"> <img src="{dummy}" alt=""> </div> <div class="button-holder"> <a href="javascript:void(0)" class="button submit-add-to-menu left" onclick="load_image(this)">{set_image}</a> &nbsp; <a href="javascript:void(0)" onclick="clear_image(this)">{clear_image}</a> </div> </div> </div> <div class="options_group"> <p class="form-field"> <label>{title}</label> <input class="fullwidth" type="text" style="width:100%" name="{page_slug}[items][{num}][title]"> </p> <p class="form-field"> <label>{comment}</label> <input class="fullwidth" type="text" style="width:100%" name="{page_slug}[items][{num}][comment]"> </p> <p class="form-field"> <a href="javascript:void(0)" onclick="remove_banner_block(this)">{delete_slide}</a> </p> </div> </div> </div>';


  var counter   = parseInt(jQuery('#ingredients-counter').val());

  var search = {
    num         : counter,
    page_slug   : 'custom_product_ingredients',
    dummy       : '',
    set_image   : 'set image',
    clear_image : 'clear image',
    delete_slide : 'delete block',
    title        : 'Title:',
    comment        : 'comment',
  };

   replace = string_replace(search, html);

   jQuery('.ingredients-wrap').append(replace);

    counter++;
   jQuery('#ingredients-counter').val(counter);
}



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

function string_replace(needle, highstack){
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

jQuery(document).ready(function(){
  jQuery('.color-field').wpColorPicker();

  jQuery('#order-list-sort').sortable({
    stop: function( event, ui ) {
      var items = jQuery('#order-list-sort').find('.block-item');
      items.each(function(index, el) {
        jQuery(el).find('.order').val(index);
      });
    },
  });
  jQuery('#order-list-sort').disableSelection();
})