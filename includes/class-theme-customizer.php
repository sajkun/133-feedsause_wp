<?php
/**
 * Adds options to the customizer for theme.
 *
 * @package theme
 */
// defined( 'ABSPATH' ) || exit;

class velesh_theme_customizer{
    /**
   * Constructor.
   */
  public function __construct() {
    add_action( 'customize_register', array( $this, 'add_sections' ) );

    add_action( 'customize_controls_enqueue_scripts', array( $this, 'add_scripts' ), 999 );
    // add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ), 999 );
    // add_action( 'customize_controls_print_styles', array( $this, 'add_styles' ) );
    // add_action( 'customize_controls_print_scripts', array( $this, 'add_scripts' ), 30 );
    // add_action( 'customize_controls_print_styles', array( $this, 'add_inline_styles' ) );
  }



  /**
   * Add settings to the customizer.
   *
   * @param WP_Customize_Manager $wp_customize Theme Customizer object.
   */
  public function add_sections( $wp_customize ) {
    $this->add_site_footer_section( $wp_customize );
    $this->add_site_header( $wp_customize );
    $this->add_site_static_sections( $wp_customize );
    $this->add_site_woo_scections( $wp_customize );
    // $this->add_product_images_section( $wp_customize );
    // $this->add_checkout_section( $wp_customize );
  }


  /**
   * Scripts to improve our form.
   */
  public function add_scripts() {
      wp_enqueue_script('velesh_theme_customizer', THEME_URL .'/script/customizer.js', array( 'jquery','customize-preview' ), '', true );
  }

  /**
   * Store site footer section.
   *
   * @param WP_Customize_Manager $wp_customize Theme Customizer object.
   */
  public function add_site_footer_section( $wp_customize ){

    /*footer settings*/

      $wp_customize->add_section(
          'theme_footer_section',
          array(
              'title'       => 'Theme Footer',
              'priority'    => 300,
              'description' => ' This section is designed to change displaying of footer settings'
          )
      );

      // scedule

        $wp_customize->add_setting(
            'theme_footer_schedule',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option'
            )
        );

        $wp_customize->add_control(
            'theme_footer_schedule',
            array(
                'section'   => 'theme_footer_section',
                'label'     => 'Schedule:',
                'type'      => 'text',
                'settings'    => 'theme_footer_schedule',
            )
        );


        $wp_customize->selective_refresh->add_partial( 'theme_footer_schedule', array(
            'selector' => '.site-footer .schedule',
            //'render_callback' => 'theme_footer_schedule',
        ) );

        // phone

        $wp_customize->add_setting(
            'theme_footer_phone',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option'
            )
        );

        $wp_customize->add_control(
            'theme_footer_phone',
            array(
                'section'   => 'theme_footer_section',
                'label'     => 'Phone:',
                'type'      => 'text',
                'settings'    => 'theme_footer_phone',
            )
        );

        $wp_customize->selective_refresh->add_partial( 'theme_footer_phone', array(
            'selector' => '.site-footer .phone',
        ) );

        // email

        $wp_customize->add_setting(
            'theme_footer_email',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option'
            )
        );

        $wp_customize->add_control(
            'theme_footer_email',
            array(
                'section'   => 'theme_footer_section',
                'label'     => 'Email:',
                'type'      => 'text',
                'settings'    => 'theme_footer_email',
            )
        );

        $wp_customize->selective_refresh->add_partial( 'theme_footer_email', array(
            'selector' => '.site-footer .email',
        ) );

        // address

        $wp_customize->add_setting(
            'theme_footer_address',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option'
            )
        );

        $wp_customize->add_control(
            'theme_footer_address',
            array(
                'section'   => 'theme_footer_section',
                'label'     => 'Address:',
                'type'      => 'textarea',
                'settings'    => 'theme_footer_address',
            )
        );

        $wp_customize->selective_refresh->add_partial( 'theme_footer_address', array(
            'selector' => '.site-footer .address',
        ) );

        $wp_customize->add_setting('theme_separator_1');

        $wp_customize->add_control(
          new Prefix_Separator_Control(
            $wp_customize,
            'theme_separator_1',
            array(
              'section' => 'theme_footer_section',
            )
          )
        );

      /*social settings*/

        $wp_customize->add_setting(
            'theme_footer_instagram',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option'
            )
        );

        $wp_customize->add_control(
            'theme_footer_instagram',
            array(
                'section'   => 'theme_footer_section',
                'label'     => 'Url for instagram link:',
                'type'      => 'text',
                'settings'  => 'theme_footer_instagram',
            )
        );

        $wp_customize->add_setting(
            'theme_footer_facebook',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option'
            )
        );

        $wp_customize->add_control(
            'theme_footer_facebook',
            array(
                'section'   => 'theme_footer_section',
                'label'     => 'Url for facebook link:',
                'type'      => 'text',
                'settings'    => 'theme_footer_facebook',
            )
        );

        $wp_customize->add_setting(
            'theme_footer_twitter',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option'
            )
        );

        $wp_customize->add_control(
            'theme_footer_twitter',
            array(
                'section'   => 'theme_footer_section',
                'label'     => 'Url for twitter link:',
                'type'      => 'text',
                'settings'    => 'theme_footer_twitter',
            )
        );

        $wp_customize->selective_refresh->add_partial( 'theme_footer_instagram', array(
            'selector' => '.site-footer .socials',
        ) );

        $wp_customize->add_setting('theme_separator_2');

        $wp_customize->add_control(
          new Prefix_Separator_Control(
            $wp_customize,
            'theme_separator_2',
            array(
              'section' => 'theme_footer_section',
            )
          )
        );

      /*copyrights setting*/

        $wp_customize->add_setting(
            'theme_footer_copyrights',
            array(
                'default'    => '',
                'transport'  => 'postMessage',
                'type'       => 'option'
            )
        );

        $wp_customize->add_control(
            'theme_footer_copyrights',
            array(
                'section'   => 'theme_footer_section',
                'label'     => 'Text in bottom row of a footer:',
                'type'      => 'text',
                'settings'  => 'theme_footer_copyrights',
            )
        );

        $wp_customize->selective_refresh->add_partial( 'theme_footer_copyrights', array(
            'selector' => '.site-footer .copyrights',
            //'render_callback' => 'theme_footer_copyrights',
        ) );

    /**/
  }



  /**
   * Store site header section.
   *
   * @param WP_Customize_Manager $wp_customize Theme Customizer object.
   */
  public function add_site_header( $wp_customize ){
    $wp_customize->add_setting(
        'theme_header_logo_mob',
        array(
            'default'    =>  '',
            'transport'  =>  'postMessage',
            'type'       => 'option',
        )
    );

    $wp_customize->add_control(
      new WP_Customize_Image_Control(
        $wp_customize,
        'theme_header_logo_mob',
        array(
          'label' => __('Logo for Mobiles', 'theme-translations'),
          'section' => 'title_tagline',
          'settings' => 'theme_header_logo_mob',
          'priority' => 8 )
      )
    );

    $wp_customize->add_setting(
        'theme_header_logo_contrast',
        array(
            'default'    =>  '',
            'transport'  =>  'postMessage',
            'type'       => 'option',
        )
    );

    $wp_customize->add_control(
      new WP_Customize_Image_Control(
        $wp_customize,
        'theme_header_logo_contrast',
        array(
          'label' => __('Contrast Logo', 'theme-translations'),
          'section' => 'title_tagline',
          'settings' => 'theme_header_logo_contrast',
          'priority' => 8 )
      )
    );

    $wp_customize->add_setting(
        'theme_header_logo_contrast_mob',
        array(
            'default'    =>  '',
            'transport'  =>  'postMessage',
            'type'       => 'option',
        )
    );

    $wp_customize->add_control(
      new WP_Customize_Image_Control(
        $wp_customize,
        'theme_header_logo_contrast_mob',
        array(
          'label' => __('Contrast Logo for Mobiles', 'theme-translations'),
          'section' => 'title_tagline',
          'settings' => 'theme_header_logo_contrast_mob',
          'priority' => 8 )
      )
    );
  }


  /**
   * Store site static informational sections for woocommerce pages.
   *
   * @param WP_Customize_Manager $wp_customize Theme Customizer object.
   */
  public function add_site_woo_scections( $wp_customize ){

   /**
   * settings for shop page of woocommerce
   */

      $wp_customize->add_section(
          'theme_woo_shop',
          array(
              'title'       => 'Woocommerce: Shop Page',
              'priority'    => 350,
              'panel'     => 'theme_site_sections'
          )
      );
      $wp_customize->add_setting(
          'theme_woo_shop_title',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'default'    => 'Discover your style',
              'type'       => 'option',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );

      $wp_customize->add_control(
          'theme_woo_shop_title',
          array(
              'section'   => 'theme_woo_shop',
              'label'     => 'Shop title',
              'type'      => 'text',
              'settings'    => 'theme_woo_shop_title',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'theme_woo_shop_title', array(
          'selector' => '.theme-shop-header .page-title',
      ) );


      $wp_customize->add_setting(
          'theme_woo_shop_title_marked',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'default'    => 'Discover',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );

      $wp_customize->add_control(
          'theme_woo_shop_title_marked',
          array(
              'section'     => 'theme_woo_shop',
              'label'       => 'Marked text in title:',
              'type'        => 'text',
              'settings'    => 'theme_woo_shop_title_marked',
              'description' => 'Print here a part of text from a title row, you want to be marked with another color and background. Letter capitalization is important',
          )
      );

      $wp_customize->add_setting(
          'theme_woo_shop_comment',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
          )
      );

      $wp_customize->add_control(
          'theme_woo_shop_comment',
          array(
              'section'     => 'theme_woo_shop',
              'label'       => 'Comment on woocommerce shop page',
              'type'        => 'textarea',
              'settings'    => 'theme_woo_shop_comment',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'theme_woo_shop_comment', array(
          'selector' => '.theme-shop-header .page-title__comment',
      ) );

  }

  /**
   * Store site static informational sections.
   *
   * @param WP_Customize_Manager $wp_customize Theme Customizer object.
   */
  public function add_site_static_sections( $wp_customize ){

    $wp_customize->add_panel( 'theme_site_sections', array(
      'priority'       => 300,
      'capability'     => 'manage_options',
      'theme_supports' => '',
      'title'          => __( 'Theme Static Sections', 'theme-translate' ),
    ) );


   /**
   * settings for moto section on home.
   */
      $wp_customize->add_section(
          'static_home_page_moto',
          array(
              'title'       => 'Home page: After hero section moto',
              'priority'    => 300,
              'description' => 'Displays static content for home page',
              'panel'     => 'theme_site_sections'
          )
      );

       $wp_customize->add_setting(
          'home_moto_before',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
          )
      );


      $wp_customize->add_control(
          'home_moto_before',
          array(
              'section'   => 'static_home_page_moto',
              'label'     => 'First row: ',
              'description' => 'Small  capitalized letters',
              'type'      => 'text',
              'settings'    => 'home_moto_before',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'home_moto_before', array(
          'selector' => '.promo-text .moto',
          //'render_callback' => 'theme_footer_schedule',
      ) );

      $wp_customize->add_setting(
          'home_moto',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
          )
      );

      $wp_customize->add_control(
          'home_moto',
          array(
              'section'   => 'static_home_page_moto',
              'label'     => 'Second row',
              'type'      => 'text',
              'settings'    => 'home_moto',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'home_moto', array(
          'selector' => '.promo-text .text',
      ) );


      $wp_customize->add_setting(
          'home_moto_marked',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
          )
      );

      $wp_customize->add_control(
          'home_moto_marked',
          array(
              'section'     => 'static_home_page_moto',
              'label'       => 'Marked text in 2nd row:',
              'type'        => 'text',
              'settings'    => 'home_moto_marked',
              'description' => 'Print a part of text from second row, you want to be marked with another color and background',
          )
      );


   /**
   * settings for block with showcases on a home page
   */

      $wp_customize->add_section(
          'static_home_page_showcases',
          array(
              'title'       => 'Home page: Showcases',
              'priority'    => 300,
              'description' => 'Displays a showcases ',
              'panel'     => 'theme_site_sections'
          )
      );


        $wp_customize->add_setting(
            'static_home_page_showcases_subtitle',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option',
            )
        );

        $wp_customize->add_control(
            'static_home_page_showcases_subtitle',
            array(
                'section'   => 'static_home_page_showcases',
                'label'     => 'Subtitle',
                'type'      => 'text',
                'settings'    => 'static_home_page_showcases_subtitle',
            )
        );

        $wp_customize->selective_refresh->add_partial( 'static_home_page_showcases_subtitle', array(
            'selector' => '.showcases-media__sub-title',
        ) );

        $wp_customize->add_setting(
            'static_home_page_showcases_title',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option',
            )
        );

        $wp_customize->add_control(
            'static_home_page_showcases_title',
            array(
                'section'   => 'static_home_page_showcases',
                'label'     => 'Title',
                'type'      => 'textarea',
                'settings'    => 'static_home_page_showcases_title',
                'description' => 'use &lt;br&gt; to start new row',
            )
        );

        $wp_customize->selective_refresh->add_partial( 'static_home_page_showcases_title', array(
            'selector' => '.showcases-media__title',
        ) );

        $wp_customize->add_setting(
            'static_home_page_showcases_text',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option',
            )
        );

        $wp_customize->add_control(
            'static_home_page_showcases_text',
            array(
                'section'   => 'static_home_page_showcases',
                'label'     => 'Comment',
                'type'      => 'textarea',
                'settings'    => 'static_home_page_showcases_text',
                'description' => 'use &lt;br&gt; to start new row',
            )
        );

        $wp_customize->selective_refresh->add_partial( 'static_home_page_showcases_text', array(
            'selector' => '.showcases-media__comment',
        ) );

        for ($i=1; $i < 4; $i++) {
          $wp_customize->add_setting(
              'static_home_page_showcases_item'.$i.'_title',
              array(
                  'default'    =>  '',
                  'transport'  =>  'postMessage',
                  'type'       => 'option',
              )
          );

          $wp_customize->add_control(
              'static_home_page_showcases_item'.$i.'_title',
              array(
                  'section'   => 'static_home_page_showcases',
                  'label'     => 'Item #'.$i.' title',
                  'type'      => 'textarea',
                  'settings'    => 'static_home_page_showcases_item'.$i.'_title',
              )
          );
          $wp_customize->add_setting(
              'static_home_page_showcases_item'.$i.'_text',
              array(
                  'default'    =>  '',
                  'transport'  =>  'postMessage',
                  'type'       => 'option',
              )
          );

          $wp_customize->add_control(
              'static_home_page_showcases_item'.$i.'_text',
              array(
                  'section'   => 'static_home_page_showcases',
                  'label'     => 'Item #'.$i.' text',
                  'type'      => 'textarea',
                  'settings'    => 'static_home_page_showcases_item'.$i.'_text',
              )
          );
          $wp_customize->add_setting(
              'static_home_page_showcases_item'.$i.'_url',
              array(
                  'default'    =>  '',
                  'transport'  =>  'postMessage',
                  'type'       => 'option',
              )
          );

          $wp_customize->add_control(
              'static_home_page_showcases_item'.$i.'_url',
              array(
                  'section'   => 'static_home_page_showcases',
                  'label'     => 'Item #'.$i.' url',
                  'type'      => 'text',
                  'settings'    => 'static_home_page_showcases_item'.$i.'_url',
              )
          );

        }

   /**
   * settings for block with a customer story on a home page
   */

      $wp_customize->add_section(
          'static_home_page_story',
          array(
              'title'       => 'Home page: Customer\'s story',
              'priority'    => 300,
              'description' => 'Displays a customers story ',
              'panel'     => 'theme_site_sections'
          )
      );

        $wp_customize->add_setting(
            'static_home_page_story_subtitle',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option',
            )
        );

        $wp_customize->add_control(
            'static_home_page_story_subtitle',
            array(
                'section'   => 'static_home_page_story',
                'label'     => 'Subtitle',
                'type'      => 'text',
                'settings'    => 'static_home_page_story_subtitle',
            )
        );

        $wp_customize->selective_refresh->add_partial( 'static_home_page_story_subtitle', array(
            'selector' => '.colored .stories-block__category',
        ) );

        $wp_customize->add_setting(
            'static_home_page_story_title',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option',
            )
        );

        $wp_customize->add_control(
            'static_home_page_story_title',
            array(
                'section'   => 'static_home_page_story',
                'label'     => 'Title',
                'type'      => 'textarea',
                'description' => 'use &lt;br&gt; to start new row',
                'settings'    => 'static_home_page_story_title',
            )
        );

        $wp_customize->selective_refresh->add_partial( 'static_home_page_story_title', array(
            'selector' => '.colored .stories-block__title',
        ) );

        $wp_customize->add_setting(
            'static_home_page_story_text',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option',
            )
        );

        $wp_customize->add_control(
            'static_home_page_story_text',
            array(
                'section'   => 'static_home_page_story',
                'label'     => 'Text',
                'type'      => 'textarea',
                'description' => 'use &lt;br&gt; to start new row',
                'settings'    => 'static_home_page_story_text',
            )
        );

        $wp_customize->selective_refresh->add_partial( 'static_home_page_story_text', array(
            'selector' => '.colored .stories-block__text',
        ) );

        $wp_customize->add_setting(
            'static_home_page_story_link_text',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option',
            )
        );

        $wp_customize->add_control(
            'static_home_page_story_link_text',
            array(
                'section'   => 'static_home_page_story',
                'label'     => 'Text of a video link',
                'type'      => 'text',
                'settings'    => 'static_home_page_story_link_text',
            )
        );

        $wp_customize->selective_refresh->add_partial( 'static_home_page_story_link_text', array(
            'selector' => '.colored .video-link span',
        ) );

        $wp_customize->add_setting(
            'static_home_page_story_link_url',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option',
            )
        );

        $wp_customize->add_control(
            'static_home_page_story_link_url',
            array(
                'section'   => 'static_home_page_story',
                'label'     => 'Url of a video link',
                'type'      => 'text',
                'settings'    => 'static_home_page_story_link_url',
            )
        );

        $wp_customize->add_setting(
            'static_home_page_story_image',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option',
            )
        );

        $wp_customize->add_control(
          new WP_Customize_Image_Control(
            $wp_customize,
            'static_home_page_story_image',
            array(
              'label' => __('Image', 'theme-translations'),
              'section' => 'static_home_page_story',
              'settings' => 'static_home_page_story_image',
               )
          )
    );

   /**
   * settings for block with social media and any text on a home page
   */

      $wp_customize->add_section(
          'static_home_page_social_media',
          array(
              'title'       => 'Home page: Social media ready',
              'priority'    => 300,
              'description' => 'Displays any text with title and subtitle. Has background with socail media\'s icons ',
              'panel'     => 'theme_site_sections'
          )
      );
        $wp_customize->add_setting(
            'static_home_page_social_media_subtitle',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option',
            )
        );

        $wp_customize->add_control(
            'static_home_page_social_media_subtitle',
            array(
                'section'   => 'static_home_page_social_media',
                'label'     => 'Subtitle',
                'type'      => 'text',
                'settings'    => 'static_home_page_social_media_subtitle',
            )
        );

        $wp_customize->selective_refresh->add_partial( 'static_home_page_social_media_subtitle', array(
            'selector' => '.media-details .media-details__category',
        ) );

        $wp_customize->add_setting(
            'static_home_page_social_media_title',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option',
            )
        );

        $wp_customize->add_control(
            'static_home_page_social_media_title',
            array(
                'section'   => 'static_home_page_social_media',
                'label'     => 'Title',
                'type'      => 'text',
                'description' => 'use &lt;br&gt; to start new row',
                'settings'    => 'static_home_page_social_media_title',
            )
        );

        $wp_customize->selective_refresh->add_partial( 'static_home_page_social_media_title', array(
            'selector' => '.media-details .media-details__title',
        ) );

        $wp_customize->add_setting(
            'static_home_page_social_media_text',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option',
            )
        );

        $wp_customize->add_control(
            'static_home_page_social_media_text',
            array(
                'section'   => 'static_home_page_social_media',
                'label'     => 'Text',
                'type'      => 'textarea',
                'description' => 'use &lt;br&gt; to start new row',
                'settings'    => 'static_home_page_social_media_text',
            )
        );

        $wp_customize->selective_refresh->add_partial( 'static_home_page_social_media_text', array(
            'selector' => '.media-details .media-details__text',
        ) );


      /**
   * settings for advantages of a home page
   */
      $wp_customize->add_section(
          'static_home_page_features',
          array(
              'title'       => 'Home page: line with site features',
              'priority'    => 300,
              'description' => 'Displays icons and short text about waht we are',
              'panel'     => 'theme_site_sections'
          )
      );

       $wp_customize->add_setting(
          'static_home_page_features_item1',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
          )
      );


      $wp_customize->add_control(
          'static_home_page_features_item1',
          array(
              'section'   => 'static_home_page_features',
              'label'     => 'Item #1',
              'description' => '',
              'type'      => 'text',
              'settings'    => 'static_home_page_features_item1',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'static_home_page_features_item1', array(
          'selector' => '.why-block__item:nth-child(1) .why-block__item-text',
      ) );
       $wp_customize->add_setting(
          'static_home_page_features_item2',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
          )
      );


      $wp_customize->add_control(
          'static_home_page_features_item2',
          array(
              'section'   => 'static_home_page_features',
              'label'     => 'Item #2',
              'description' => '',
              'type'      => 'text',
              'settings'    => 'static_home_page_features_item2',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'static_home_page_features_item2', array(
          'selector' => '.why-block__item:nth-child(2) .why-block__item-text',
      ) );

       $wp_customize->add_setting(
          'static_home_page_features_item3',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
          )
      );

      $wp_customize->add_control(
          'static_home_page_features_item3',
          array(
              'section'   => 'static_home_page_features',
              'label'     => 'Item #3',
              'description' => '',
              'type'      => 'text',
              'settings'    => 'static_home_page_features_item3',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'static_home_page_features_item3', array(
          'selector' => '.why-block__item:nth-child(3) .why-block__item-text',
      ) );

   /**
   * settings for advantages block section on home page.
   */

      $wp_customize->add_section(
          'static_home_page_adv',
          array(
              'title'       => 'Home page: Advantages',
              'priority'    => 300,
              'description' => 'Displays three blocks in a row with text and icons on static home page. Section located below hero screen',
              'panel'     => 'theme_site_sections'
          )
      );


      $wp_customize->add_setting(
          'theme_advantages_block[1][title]',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
          )
      );

      $wp_customize->add_control(
          'theme_advantages_block[1][title]',
          array(
              'section'   => 'static_home_page_adv',
              'label'     => 'Section 1. Title',
              'type'      => 'text',
              'settings'    => 'theme_advantages_block[1][title]',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'theme_advantages_block[1][title]', array(
          'selector' => '.inf-1 .information__title',
      ) );

      $wp_customize->add_setting(
          'theme_advantages_block[1][text]',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
          )
      );

      $wp_customize->add_control(
          'theme_advantages_block[1][text]',
          array(
              'section'   => 'static_home_page_adv',
              'label'     => 'Section 1. text',
              'type'      => 'textarea',
              'settings'    => 'theme_advantages_block[1][text]',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'theme_advantages_block[1][text]', array(
          'selector' => '.inf-1 .information__text',
      ) );

      $wp_customize->add_setting(
          'theme_advantages_block[1][icon]',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
          )
      );

      $wp_customize->add_control(
        new WP_Customize_Image_Control(
          $wp_customize,
          'theme_advantages_block[1][icon]',
          array(
            'label' => __('Section 1. Icon', 'theme-translations'),
            'section' => 'static_home_page_adv',
            'settings' => 'theme_advantages_block[1][icon]',
            )
        )
      );

      $wp_customize->selective_refresh->add_partial( 'theme_advantages_block[1][icon]', array(
          'selector' => '.inf-1 .information__icon',
      ) );


      $wp_customize->add_setting(
          'theme_advantages_block[2][title]',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
          )
      );

      $wp_customize->add_control(
          'theme_advantages_block[2][title]',
          array(
              'section'   => 'static_home_page_adv',
              'label'     => 'Section 2. Title',
              'type'      => 'text',
              'settings'    => 'theme_advantages_block[2][title]',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'theme_advantages_block[2][title]', array(
          'selector' => '.inf-2 .information__title',
      ) );

      $wp_customize->add_setting(
          'theme_advantages_block[2][text]',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
          )
      );

      $wp_customize->add_control(
          'theme_advantages_block[2][text]',
          array(
              'section'   => 'static_home_page_adv',
              'label'     => 'Section 2. text',
              'type'      => 'textarea',
              'settings'    => 'theme_advantages_block[2][text]',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'theme_advantages_block[2][text]', array(
          'selector' => '.inf-2 .information__text',
      ) );

      $wp_customize->add_setting(
          'theme_advantages_block[2][icon]',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
          )
      );

      $wp_customize->add_control(
        new WP_Customize_Image_Control(
          $wp_customize,
          'theme_advantages_block[2][icon]',
          array(
            'label' => __('Section 2. Icon', 'theme-translations'),
            'section' => 'static_home_page_adv',
            'settings' => 'theme_advantages_block[2][icon]',
            )
        )
      );

      $wp_customize->selective_refresh->add_partial( 'theme_advantages_block[2][icon]', array(
          'selector' => '.inf-2 .information__icon',
      ) );


      $wp_customize->add_setting(
          'theme_advantages_block[3][title]',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
          )
      );

      $wp_customize->add_control(
          'theme_advantages_block[3][title]',
          array(
              'section'   => 'static_home_page_adv',
              'label'     => 'Section 3. Title',
              'type'      => 'text',
              'settings'    => 'theme_advantages_block[3][title]',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'theme_advantages_block[3][title]', array(
          'selector' => '.inf-3 .information__title',
      ) );

      $wp_customize->add_setting(
          'theme_advantages_block[3][text]',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
          )
      );

      $wp_customize->add_control(
          'theme_advantages_block[3][text]',
          array(
              'section'   => 'static_home_page_adv',
              'label'     => 'Section 3. text',
              'type'      => 'textarea',
              'settings'    => 'theme_advantages_block[3][text]',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'theme_advantages_block[3][text]', array(
          'selector' => '.inf-3 .information__text',
      ) );

      $wp_customize->add_setting(
          'theme_advantages_block[3][icon]',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
          )
      );

      $wp_customize->add_control(
        new WP_Customize_Image_Control(
          $wp_customize,
          'theme_advantages_block[3][icon]',
          array(
            'label' => __('Section 3. Icon', 'theme-translations'),
            'section' => 'static_home_page_adv',
            'settings' => 'theme_advantages_block[3][icon]',
            )
        )
      );

      $wp_customize->selective_refresh->add_partial( 'theme_advantages_block[3][icon]', array(
          'selector' => '.inf-3 .information__icon',
      ) );

    /**
   * settings for showcase page
   */

      $wp_customize->add_section(
          'showcase_setting_section',
          array(
            'title'       => 'Showcase Page',
            'priority'    => 300,
            'description' => 'Displays a header of a showcase archive page',
            'panel'     => 'theme_site_sections'
          )
      );

     $wp_customize->add_setting(
          'theme_page_showcase',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );

      $args = array(
        'posts_per_page' => -1,
        'limit'          => -1,
      );
      $pages = get_pages($args);

      $choices = array();

      foreach ($pages as $key => $p) {
        $choices[$p->ID] = $p->post_title;
      }

      $wp_customize->add_control(
          'theme_page_showcase',
          array(
              'section'   => 'showcase_setting_section',
              'label'     => 'Page that should be used as a showcase archive',
              'type'      => 'select',
              'settings'  => 'theme_page_showcase',
              'choices'   => $choices
          )
      );


      $args = array(
        'posts_per_page' => -1,
        'limit'          => -1,
        'post_type'      => 'wpcf7_contact_form',
      );

      $forms  = get_posts($args);
      $choices = array();

      foreach ($forms as $key => $p) {
        $choices[$p->ID] = $p->post_title;
      }



     $wp_customize->add_setting(
          'showcase_title',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );

      $wp_customize->add_control(
          'showcase_title',
          array(
              'section'   => 'showcase_setting_section',
              'label'     => 'Title of a showcase archive page',
              'type'      => 'text',
              'settings'    => 'showcase_title',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'showcase_title', array(
          'selector' => '.showcase-hero__title',
      ) );

      $wp_customize->add_setting(
          'showcase_title_marked',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );

      $wp_customize->add_control(
          'showcase_title_marked',
          array(
              'section'     => 'showcase_setting_section',
              'label'       => 'Marked text in title:',
              'type'        => 'text',
              'settings'    => 'showcase_title_marked',
          )
      );

     $wp_customize->add_setting(
          'showcase_comment',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );

      $wp_customize->add_control(
          'showcase_comment',
          array(
              'section'   => 'showcase_setting_section',
              'label'     => 'Comment of a showcase archive page',
              'type'      => 'textarea',
              'settings'    => 'showcase_comment',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'showcase_comment', array(
          'selector' => '.showcase-hero__comment',
      ) );
   /**
   * settings for support page
   */

      $wp_customize->add_section(
          'support_setting_section',
          array(
            'title'       => 'Support Page',
            'priority'    => 300,
            'description' => 'Displays a header of a support page',
            'panel'     => 'theme_site_sections'
          )
      );

     $wp_customize->add_setting(
          'theme_page_support',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );

      $args = array(
        'posts_per_page' => -1,
        'limit'          => -1,
      );
      $pages = get_pages($args);

      $choices = array();

      foreach ($pages as $key => $p) {
        $choices[$p->ID] = $p->post_title;
      }

      $wp_customize->add_control(
          'theme_page_support',
          array(
              'section'   => 'support_setting_section',
              'label'     => 'Page that should be used as pricing',
              'type'      => 'select',
              'settings'  => 'theme_page_support',
              'choices'   => $choices
          )
      );


      $args = array(
        'posts_per_page' => -1,
        'limit'          => -1,
        'post_type'      => 'wpcf7_contact_form',
      );


      $forms  = get_posts($args);

      $args = array(
        'posts_per_page' => -1,
        'limit'          => -1,
        'post_type'      => 'wpforms',
      );

      $forms_w = get_posts($args);
      $choices = array();

     $active_plugins = get_option('active_plugins');

     $contact_plugins = array(
      'wpforms/wpforms.php' => array(
        'name'  => 'WPForms',
        'value' => 'wpf'
      ),
      'contact-form-7/wp-contact-form-7.php' => array(
        'name'  => 'Contact Form 7',
        'value' => 'cf7'
      ),
     );

     $choices_contact = array();

     foreach ($contact_plugins as $key => $p) {
       if(in_array($key, $active_plugins)){
         $choices_contact[$p['value']] = $p['name'];
       }
     }

     if(count($choices_contact > 1)) :
       $wp_customize->add_setting(
            'theme_page_support_form_type',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option',
            )
        );

        $wp_customize->add_control(
            'theme_page_support_form_type',
            array(
                'section'   => 'support_setting_section',
                'label'     => 'Contant Form plugin',
                'type'      => 'radio',
                'settings'  => 'theme_page_support_form_type',
                'choices'   => $choices_contact,
            )
        );

    endif;

      if($forms && in_array('contact-form-7/wp-contact-form-7.php', $active_plugins)){
      foreach ($forms as $key => $p) {
        $choices[$p->ID] = $p->post_title;
      }

       $wp_customize->add_setting(
            'theme_page_support_form',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option',
                'sanitize_callback' => 'sanitize_text_field'
            )
        );

        $wp_customize->add_control(
            'theme_page_support_form',
            array(
                'section'   => 'support_setting_section',
                'label'     => 'Contant Form to be used on page',
                'type'      => 'select',
                'settings'  => 'theme_page_support_form',
                'choices'   => $choices
            )
        );


      $wp_customize->selective_refresh->add_partial( 'theme_page_support_form', array(
          'selector' => '.contact-form .form-wrapper',
      ) );
      }

      if($forms_w && in_array('wpforms/wpforms.php', $active_plugins)){
          foreach ($forms_w as $key => $p) {
            $choices[$p->ID] = $p->post_title;
          }

         $wp_customize->add_setting(
              'theme_page_support_form_wpf',
              array(
                  'default'    =>  '',
                  'transport'  =>  'postMessage',
                  'type'       => 'option',
                  'sanitize_callback' => 'sanitize_text_field'
              )
          );

          $wp_customize->add_control(
              'theme_page_support_form_wpf',
              array(
                  'section'   => 'support_setting_section',
                  'label'     => 'Contant Form to be used on page',
                  'type'      => 'select',
                  'settings'  => 'theme_page_support_form_wpf',
                  'choices'   => $choices,
                  'hidden'    => true,

              )
          );


        $wp_customize->selective_refresh->add_partial( 'theme_page_support_form_wpf', array(
            'selector' => '.contact-form .form-wrapper',
        ) );
      }


     $wp_customize->add_setting(
          'support_title',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );

      $wp_customize->add_control(
          'support_title',
          array(
              'section'   => 'support_setting_section',
              'label'     => 'Title of a support page',
              'type'      => 'text',
              'settings'    => 'support_title',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'support_title', array(
          'selector' => '.support-section .page-title',
      ) );

      $wp_customize->add_setting(
          'support_title_marked',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'default'    => 'Friendly,',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );

      $wp_customize->add_control(
          'support_title_marked',
          array(
              'section'     => 'support_setting_section',
              'label'       => 'Marked text in title:',
              'type'        => 'text',
              'settings'    => 'support_title_marked',
              'description' => 'Print here a part of text from a title row, you want to be marked with another color and background',
          )
      );

     $wp_customize->add_setting(
          'support_comment',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );

      $wp_customize->add_control(
          'support_comment',
          array(
              'section'   => 'support_setting_section',
              'label'     => 'Comment of a support page',
              'type'      => 'textarea',
              'settings'    => 'support_comment',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'support_comment', array(
          'selector' => '.support-section .page-title__comment ',
      ) );
   /**
   * settings for cta section on home.
   */
      $wp_customize->add_section(
          'pricing_setting_section',
          array(
            'title'       => 'Pricing Page',
            'priority'    => 300,
            'description' => 'Displays a header of a pricing page',
            'panel'     => 'theme_site_sections'
          )
      );

     $wp_customize->add_setting(
          'theme_page_pricing',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );

      $args = array(
        'posts_per_page' => -1,
        'limit'          => -1,
      );
      $pages = get_pages($args);

      $choices = array();

      foreach ($pages as $key => $p) {
        $choices[$p->ID] = $p->post_title;
      }

      $wp_customize->add_control(
          'theme_page_pricing',
          array(
              'section'   => 'pricing_setting_section',
              'label'     => 'Page that should be used as pricing',
              'type'      => 'select',
              'settings'  => 'theme_page_pricing',
              'choices'   => $choices
          )
      );


     $wp_customize->add_setting(
          'pricing_title',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );

      $wp_customize->add_control(
          'pricing_title',
          array(
              'section'   => 'pricing_setting_section',
              'label'     => 'title of a pricing page',
              'type'      => 'text',
              'settings'    => 'pricing_title',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'pricing_title', array(
          'selector' => '.pricing__moto',
      ) );

      $wp_customize->add_setting(
          'pricing_title_marked',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );

      $wp_customize->add_control(
          'pricing_title_marked',
          array(
              'section'     => 'pricing_setting_section',
              'label'       => 'Marked text in title:',
              'type'        => 'text',
              'settings'    => 'pricing_title_marked',
              'description' => 'Print here a part of text from a title row, you want to be marked with another color and background',
          )
      );

     $wp_customize->add_setting(
          'pricing_comment',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );

      $wp_customize->add_control(
          'pricing_comment',
          array(
              'section'   => 'pricing_setting_section',
              'label'     => 'Comment of a pricing page',
              'type'      => 'textarea',
              'settings'    => 'pricing_comment',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'pricing_comment', array(
          'selector' => '.pricing__comment.textcenter',
      ) );
   /**
   * settings for cta section on home.
   */
      $wp_customize->add_section(
          'cta_setting_section',
          array(
              'title'       => 'All pages: CTA section',
              'priority'    => 300,
              'description' => 'Displays call to action section with a link to recipe\'s page',
              'panel'     => 'theme_site_sections'

          )
      );

       $wp_customize->add_setting(
          'cta_title',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );


      $wp_customize->add_control(
          'cta_title',
          array(
              'section'   => 'cta_setting_section',
              'label'     => 'Section title: ',
              'type'      => 'text',
              'settings'    => 'cta_title',
          )
      );



      $wp_customize->selective_refresh->add_partial( 'cta_title', array(
          'selector' => '.cta-recipe .section-title',
      ) );

      $wp_customize->add_setting(
          'cta_moto',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );

      $wp_customize->add_control(
          'cta_moto',
          array(
              'section'   => 'cta_setting_section',
              'label'     => 'Call to action text',
              'type'      => 'text',
              'settings'    => 'cta_moto',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'cta_moto', array(
          'selector' => '.cta-recipe .section-comment',
      ) );


      $wp_customize->add_setting(
          'cta_moto_marked',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );

      $wp_customize->add_control(
          'cta_moto_marked',
          array(
              'section'     => 'cta_setting_section',
              'label'       => 'Marked text in title:',
              'type'        => 'text',
              'settings'    => 'cta_moto_marked',
              'description' => 'Print here a part of text from a title row, you want to be marked with another color and background',
          )
      );

  /**
   * settings for blog section on home.
   */

      $wp_customize->add_section(
          'theme_blog_setting_section',
          array(
              'title'       => 'Blog',
              'priority'    => 300,
              'description' => 'Static content in blog page',
              'panel'     => 'theme_site_sections'
          )
      );

       $wp_customize->add_setting(
          'theme_blog_articles_title',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );


      $wp_customize->add_control(
          'theme_blog_articles_title',
          array(
              'section'   => 'theme_blog_setting_section',
              'label'     => 'Title before latest articles in blog: ',
              'type'      => 'text',
              'settings'   => 'theme_blog_articles_title',
          )
      );

      $wp_customize->selective_refresh->add_partial( 'theme_blog_articles_title', array(
          'selector' => '.blog-title-feed',
      ) );


      $wp_customize->add_setting(
          'blog_articles_comment',
          array(
              'default'    =>  '',
              'transport'  =>  'postMessage',
              'type'       => 'option',
              'sanitize_callback' => 'sanitize_text_field'
          )
      );


      $wp_customize->add_control(
          'blog_articles_comment',
          array(
              'section'   => 'theme_blog_setting_section',
              'label'     => 'Comments before latest articles in blog: ',
              'type'      => 'text',
              'settings'    => 'blog_articles_comment',
          )
      );


      $wp_customize->selective_refresh->add_partial( 'blog_articles_comment', array(
          'selector' => '.blog-comment-feed',
      ) );
  }
}

new velesh_theme_customizer();

if ( ! class_exists( 'Prefix_Separator_Control' ) ) {
  return null;
}
/**
 * Class Prefix_Separator_Control
 *
 * Custom control to display separator
 */
class Prefix_Separator_Control extends WP_Customize_Control {
  public function render_content() {
    ?>
    <label><br>
      <hr>
    </label>
      <?php if ( $this->label ): ?>
        <h4 style="text-transform: uppercase; margin: 0"><?php echo $this->label; ?>:</h4>
      <?php else: ?>
        <br>
      <?php endif ?>
    <?php
  }
}
