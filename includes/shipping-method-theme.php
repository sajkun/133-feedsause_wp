<?php
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    function request_a_shipping_quote_init() {
        if ( ! class_exists( 'WC_Request_shipping_with_date' ) ) {
            class WC_Request_shipping_with_date extends WC_Shipping_Method {
                /**
                 * Constructor for your shipping class
                 *
                 * @access public
                 * @return void
                 */
                public function __construct( $instance_id = 0  ) {
                    $this->id                 = 'shipping_method_with_date'; // Id for your shipping method. Should be uunique.
                    $this->instance_id        = absint( $instance_id );
                    $this->method_title       = __( 'Shipping Method With Date' );  // Title shown in admin
                    $this->method_description = __( 'Shipping method to be used when a delivery date should be specified' ); // Description shown in admin


                    $this->supports = array(
                        'shipping-zones',
                        'instance-settings',
                        'instance-settings-modal',
                    );

                    $this->enabled              = $this->get_option( 'enabled' );

                    $this->init();
                }

                /**
                 * Init your settings
                 *
                 * @access public
                 * @return void
                 */
                function init() {
                    // Load the settings API
                    $this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
                    $this->init_settings(); // This is part of the settings API. Loads settings you previously init.

                    // Save settings in admin if you have any defined
                    add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
                    $this->title                = $this->get_option( 'title' );
                    $this->tax_status           = $this->get_option( 'tax_status' );
                    $this->cost                 = $this->get_option( 'cost' );
                    $this->type                 = $this->get_option( 'type', 'class' );
                }

                function init_form_fields() {



                    $cost_desc = __( 'Enter a cost (excl. tax) or sum, e.g. <code>10.00 * [qty]</code>.', 'woocommerce' ) . '<br/><br/>' . __( 'Use <code>[qty]</code> for the number of items, <br/><code>[cost]</code> for the total cost of items, and <code>[fee percent="10" min_fee="20" max_fee=""]</code> for percentage based fees.', 'woocommerce' );

                    $settings = array(

                        'title' => array(
                            'title'       => __( 'Title', 'theme-translations' ),
                            'type'        => 'text',
                            'description' => __( 'Title to be displayed on site', 'theme-translations' ),
                            'default'     => __( 'Free shipping', 'theme-translations' )
                        ),

                        'enable_datepicker' => array(
                            'title'       => __( 'Enable Datepicker', 'theme-translations' ),
                            'type'        => 'checkbox',
                            'description' => __( 'Enable datepicker for a shipping method', 'theme-translations' ),
                            'default'     => 'yes'
                        ),

                       'datepicker_comment' => array(
                            'title'       => __( 'Comment for datepicker', 'theme-translations' ),
                            'type'        => 'text',
                            'description' => __( 'Description of a datepicker field', 'theme-translations' ),
                            'default'     => __( 'Due date', 'theme-translations' )
                        ),


                        'enable_shipping_check' => array(
                            'title'       => __( 'Show Shipping Checkbox', 'theme-translations' ),
                            'type'        => 'checkbox',
                            'description' => __( 'Show Checkbox \'Ship to different address\' within method selection '),
                            'default'     => 'no'
                        ),

                        'instance_icon' => array(
                            'title'       => __( 'Image Icon', 'theme-translations' ),
                            'type'        => 'checkbox',
                        ),

                        'tax_status' => array(
                            'title'   => __( 'Tax status', 'woocommerce' ),
                            'type'    => 'select',
                            'class'   => 'wc-enhanced-select',
                            'default' => 'taxable',
                            'options' => array(
                                'taxable' => __( 'Taxable', 'woocommerce' ),
                                'none'    => _x( 'None', 'Tax status', 'woocommerce' ),
                            ),
                        ),
                        'cost'       => array(
                            'title'             => __( 'Cost', 'woocommerce' ),
                            'type'              => 'text',
                            'placeholder'       => '',
                            'description'       => $cost_desc,
                            'default'           => '0',
                            'desc_tip'          => true,
                            'sanitize_callback' => array( $this, 'sanitize_cost' ),
                        ),
                    );

                    $shipping_classes = WC()->shipping->get_shipping_classes();

                    if ( ! empty( $shipping_classes ) ) {
                        $settings['class_costs'] = array(
                            'title'       => __( 'Shipping class costs', 'woocommerce' ),
                            'type'        => 'title',
                            'default'     => '',
                            /* translators: %s: URL for link. */
                            'description' => sprintf( __( 'These costs can optionally be added based on the <a href="%s">product shipping class</a>.', 'woocommerce' ), admin_url( 'admin.php?page=wc-settings&tab=shipping&section=classes' ) ),
                        );
                        foreach ( $shipping_classes as $shipping_class ) {
                            if ( ! isset( $shipping_class->term_id ) ) {
                                continue;
                            }
                            $settings[ 'class_cost_' . $shipping_class->term_id ] = array(
                                /* translators: %s: shipping class name */
                                'title'             => sprintf( __( '"%s" shipping class cost', 'woocommerce' ), esc_html( $shipping_class->name ) ),
                                'type'              => 'text',
                                'placeholder'       => __( 'N/A', 'woocommerce' ),
                                'description'       => $cost_desc,
                                'default'           => $this->get_option( 'class_cost_' . $shipping_class->slug ), // Before 2.5.0, we used slug here which caused issues with long setting names.
                                'desc_tip'          => true,
                                'sanitize_callback' => array( $this, 'sanitize_cost' ),
                            );
                        }

                        $settings['no_class_cost'] = array(
                            'title'             => __( 'No shipping class cost', 'woocommerce' ),
                            'type'              => 'text',
                            'placeholder'       => __( 'N/A', 'woocommerce' ),
                            'description'       => $cost_desc,
                            'default'           => '',
                            'desc_tip'          => true,
                            'sanitize_callback' => array( $this, 'sanitize_cost' ),
                        );

                        $settings['type'] = array(
                            'title'   => __( 'Calculation type', 'woocommerce' ),
                            'type'    => 'select',
                            'class'   => 'wc-enhanced-select',
                            'default' => 'class',
                            'options' => array(
                                'class' => __( 'Per class: Charge shipping for each shipping class individually', 'woocommerce' ),
                                'order' => __( 'Per order: Charge shipping for the most expensive shipping class', 'woocommerce' ),
                            ),
                        );
                    }

                    $this->instance_form_fields = $settings;

                }


                /**
                 * Evaluate a cost from a sum/string.
                 *
                 * @param  string $sum Sum of shipping.
                 * @param  array  $args Args.
                 * @return string
                 */
                protected function evaluate_cost( $sum, $args = array() ) {
                    include_once WC()->plugin_path() . '/includes/libraries/class-wc-eval-math.php';

                    // Allow 3rd parties to process shipping cost arguments.
                    $args           = apply_filters( 'woocommerce_evaluate_shipping_cost_args', $args, $sum, $this );
                    $locale         = localeconv();
                    $decimals       = array( wc_get_price_decimal_separator(), $locale['decimal_point'], $locale['mon_decimal_point'], ',' );
                    $this->fee_cost = $args['cost'];

                    // Expand shortcodes.
                    add_shortcode( 'fee', array( $this, 'fee' ) );

                    $sum = do_shortcode(
                        str_replace(
                            array(
                                '[qty]',
                                '[cost]',
                            ),
                            array(
                                $args['qty'],
                                $args['cost'],
                            ),
                            $sum
                        )
                    );

                    remove_shortcode( 'fee', array( $this, 'fee' ) );

                    // Remove whitespace from string.
                    $sum = preg_replace( '/\s+/', '', $sum );

                    // Remove locale from string.
                    $sum = str_replace( $decimals, '.', $sum );

                    // Trim invalid start/end characters.
                    $sum = rtrim( ltrim( $sum, "\t\n\r\0\x0B+*/" ), "\t\n\r\0\x0B+-*/" );

                    // Do the math.
                    return $sum ? WC_Eval_Math::evaluate( $sum ) : 0;
                }

                /**
                 * Work out fee (shortcode).
                 *
                 * @param  array $atts Attributes.
                 * @return string
                 */
                public function fee( $atts ) {
                    $atts = shortcode_atts(
                        array(
                            'percent' => '',
                            'min_fee' => '',
                            'max_fee' => '',
                        ), $atts, 'fee'
                    );

                    $calculated_fee = 0;

                    if ( $atts['percent'] ) {
                        $calculated_fee = $this->fee_cost * ( floatval( $atts['percent'] ) / 100 );
                    }

                    if ( $atts['min_fee'] && $calculated_fee < $atts['min_fee'] ) {
                        $calculated_fee = $atts['min_fee'];
                    }

                    if ( $atts['max_fee'] && $calculated_fee > $atts['max_fee'] ) {
                        $calculated_fee = $atts['max_fee'];
                    }

                    return $calculated_fee;
                }

                /**
                 * Calculate the shipping costs.
                 *
                 * @param array $package Package of items from cart.
                 */
                public function calculate_shipping( $package = array() ) {
                    $rate = array(
                        'id'      => $this->get_rate_id(),
                        'label'   => $this->title,
                        'cost'    => 0,
                        'package' => $package,
                    );

                    // Calculate the costs.
                    $has_costs = false; // True when a cost is set. False if all costs are blank strings.
                    $cost      = $this->get_option( 'cost' );

                    if ( '' !== $cost ) {
                        $has_costs    = true;
                        $rate['cost'] = $this->evaluate_cost(
                            $cost, array(
                                'qty'  => $this->get_package_item_qty( $package ),
                                'cost' => $package['contents_cost'],
                            )
                        );
                    }

                    // Add shipping class costs.
                    $shipping_classes = WC()->shipping->get_shipping_classes();

                    if ( ! empty( $shipping_classes ) ) {
                        $found_shipping_classes = $this->find_shipping_classes( $package );
                        $highest_class_cost     = 0;

                        foreach ( $found_shipping_classes as $shipping_class => $products ) {
                            // Also handles BW compatibility when slugs were used instead of ids.
                            $shipping_class_term = get_term_by( 'slug', $shipping_class, 'product_shipping_class' );
                            $class_cost_string   = $shipping_class_term && $shipping_class_term->term_id ? $this->get_option( 'class_cost_' . $shipping_class_term->term_id, $this->get_option( 'class_cost_' . $shipping_class, '' ) ) : $this->get_option( 'no_class_cost', '' );

                            if ( '' === $class_cost_string ) {
                                continue;
                            }

                            $has_costs  = true;
                            $class_cost = $this->evaluate_cost(
                                $class_cost_string, array(
                                    'qty'  => array_sum( wp_list_pluck( $products, 'quantity' ) ),
                                    'cost' => array_sum( wp_list_pluck( $products, 'line_total' ) ),
                                )
                            );

                            if ( 'class' === $this->type ) {
                                $rate['cost'] += $class_cost;
                            } else {
                                $highest_class_cost = $class_cost > $highest_class_cost ? $class_cost : $highest_class_cost;
                            }
                        }

                        if ( 'order' === $this->type && $highest_class_cost ) {
                            $rate['cost'] += $highest_class_cost;
                        }
                    }

                    if ( $has_costs ) {
                        $this->add_rate( $rate );
                    }

                    /**
                     * Developers can add additional flat rates based on this one via this action since @version 2.4.
                     *
                     * Previously there were (overly complex) options to add additional rates however this was not user.
                     * friendly and goes against what Flat Rate Shipping was originally intended for.
                     */
                    do_action( 'woocommerce_' . $this->id . '_shipping_add_rate', $this, $rate );
                }

                /**
                 * Get items in package.
                 *
                 * @param  array $package Package of items from cart.
                 * @return int
                 */
                public function get_package_item_qty( $package ) {
                    $total_quantity = 0;
                    foreach ( $package['contents'] as $item_id => $values ) {
                        if ( $values['quantity'] > 0 && $values['data']->needs_shipping() ) {
                            $total_quantity += $values['quantity'];
                        }
                    }
                    return $total_quantity;
                }

                /**
                 * Finds and returns shipping classes and the products with said class.
                 *
                 * @param mixed $package Package of items from cart.
                 * @return array
                 */
                public function find_shipping_classes( $package ) {
                    $found_shipping_classes = array();

                    foreach ( $package['contents'] as $item_id => $values ) {
                        if ( $values['data']->needs_shipping() ) {
                            $found_class = $values['data']->get_shipping_class();

                            if ( ! isset( $found_shipping_classes[ $found_class ] ) ) {
                                $found_shipping_classes[ $found_class ] = array();
                            }

                            $found_shipping_classes[ $found_class ][ $item_id ] = $values;
                        }
                    }

                    return $found_shipping_classes;
                }

                /**
                 * Sanitize the cost field.
                 *
                 * @since 3.4.0
                 * @param string $value Unsanitized value.
                 * @return string
                 */
                public function sanitize_cost( $value ) {
                    $value = is_null( $value ) ? '' : $value;
                    $value = wp_kses_post( trim( wp_unslash( $value ) ) );
                    $value = str_replace( array( get_woocommerce_currency_symbol(), html_entity_decode( get_woocommerce_currency_symbol() ) ), '', $value );
                    return $value;
                }
            }
        }
    }

    add_action( 'woocommerce_shipping_init', 'request_a_shipping_quote_init' );

    function request_shipping_quote_shipping_method( $methods ) {
        $methods['shipping_method_with_date'] = 'WC_Request_shipping_with_date';

        return $methods;
    }

    add_filter( 'woocommerce_shipping_methods', 'request_shipping_quote_shipping_method' );
}