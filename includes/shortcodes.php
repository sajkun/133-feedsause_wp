<?php
class theme_shortcodes{

  public function __construct(){
    add_shortcode( 'print_image_and_text', array($this,'print_image_and_text_cb' ));

    add_shortcode( 'marked_button', array($this,'marked_button_cb' ));

    add_shortcode( 'video_link', array($this,'video_link_cb' ));
  }


  /**
  * Shortcode callback
  * prints formatted text and image
  *
  * @param $args - array of shortcode data
  *
  * @return string of html
  */
  public function print_image_and_text_cb($args){

    $html = '';
    switch ($args['image_position']) {
      case 'right':
           $html =  printf('<div class="row"> <div class="col-12 col-md-7 order-sm-2"> <div class="showcase-preview__image"> <img src="%1$s" alt="%2$s"> </div> </div> <div class="col-12 col-md-5"> <div class="showcase-preview__data"> <div class="showcase-preview__data-inner"> <span class="showcase-preview__category">%3$s</span> <span class="showcase-preview__title">%2$s</span> <span class="showcase-preview__description">%4$s</span> </div> </div> </div></div>',
                       esc_url($args['image_url']),
                       esc_attr($args['title']),
                       esc_attr($args['subtitle']),
                       esc_attr($args['text'])
                     );
      break;

      default:
           $html =  printf('<div class="row"> <div class="col-12 col-md-7"> <div class="showcase-preview__image"> <img src="%1$s" alt="%2$s"> </div> </div> <div class="col-12 col-md-5"> <div class="showcase-preview__data"> <div class="showcase-preview__data-inner"> <span class="showcase-preview__category">%3$s</span> <span class="showcase-preview__title">%2$s</span> <span class="showcase-preview__description">%4$s</span> </div> </div> </div> </div>',
                       esc_url($args['image_url']),
                       esc_attr($args['title']),
                       esc_attr($args['subtitle']),
                       esc_attr($args['text'])
                     );

        break;
    }
    return $html;
  }

    /**
  * Shortcode callback
  * prints marked button
  *
  * @param $args - array of shortcode data
  *
  * @return string of html
  */
  public function marked_button_cb($args){
    $style_page = (isset($args['style']) && ('yes' === $args['style'] || 'true' == $args['style']))? 'button-current-page': '';
    $arrow = (isset($args['arrow']) && (('yes' === $args['arrow'] )|| ('true' == $args['arrow'])))? '<svg class="icon svg-icon-arrowr"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-arrowr"></use> </svg>': '';
    $bg = (isset($args['color']))? $args['color']: '';
    return sprintf('<a class="button button_lg %3$s %5$s" href="%2$s">%1$s %4$s</a>',esc_attr($args['text']), esc_url($args['url']), $style_page, $arrow, $bg );
  }    /**
  * Shortcode callback
  * prints marked button
  *
  * @param $args - array of shortcode data
  *
  * @return string of html
  */

  public function video_link_cb($args){
    return sprintf('<a class="link link_video trigger-video" href="%s" data-type="%s">%s</a>',esc_url($args['url']), esc_attr($args['type']), esc_attr($args['text']));
  }

}

new theme_shortcodes();