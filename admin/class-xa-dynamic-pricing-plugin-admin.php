<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.xadapter.com
 * @since      1.0.0
 *
 * @package    xa_dynamic_pricing_plugin
 * @subpackage xa_dynamic_pricing_plugin/admin
 */
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    xa_dynamic_pricing_plugin
 * @subpackage xa_dynamic_pricing_plugin/admin
 * @author     Your Name <email@example.com>
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class xa_dynamic_pricing_plugin_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $xa_dynamic_pricing_plugin    The ID of this plugin.
     */
    private $xa_dynamic_pricing_plugin;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $xa_dynamic_pricing_plugin       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($xa_dynamic_pricing_plugin, $version) {

        $this->xa_dynamic_pricing_plugin = $xa_dynamic_pricing_plugin;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in xa_dynamic_pricing_plugin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The xa_dynamic_pricing_plugin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->xa_dynamic_pricing_plugin, plugin_dir_url(__FILE__) . 'css/xa-dynamic-pricing-plugin-admin.css', array(), $this->version, 'all');

        if(preg_match("/dynamic-pricing-main-page/i", $_SERVER['REQUEST_URI'])){
                wp_enqueue_style('font-awesome-min-css', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all');
                wp_enqueue_style('bootstrap-min-css', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css', array(), $this->version, 'all');
                wp_enqueue_style('mdb-min-css', 'https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css', array(), $this->version, 'all');
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in xa_dynamic_pricing_plugin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The xa_dynamic_pricing_plugin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        if(preg_match("/dynamic-pricing-main-page/i", $_SERVER['REQUEST_URI'])) {
            wp_enqueue_script('jquery-my', '//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
            wp_enqueue_script('jquery-my');
        }

        wp_enqueue_script('popover-min-js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js', array('jquery-my'), $this->version, false);
        wp_enqueue_script('popover-min-js');

        wp_enqueue_script('mdb-min-js', 'https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/js/mdb.min.js', array('jquery-my', 99), $this->version, false);
        wp_enqueue_script('mdb-min-js');

        wp_enqueue_script('bootstrap-min-js', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js', array('jquery-my'), $this->version, false);
        wp_enqueue_script('bootstrap-min-js');

        wp_enqueue_script($this->xa_dynamic_pricing_plugin, plugin_dir_url(__FILE__) . 'js/xa-dynamic-pricing-plugin-admin.js', array('jquery'), $this->version, false);
        wp_enqueue_script('jquery-ui-sortable');

        wp_register_script('wcsf_example_ajax', plugins_url('/js/script.js', __FILE__), array('jquery-my'));
        wp_enqueue_script( 'wcsf_example_ajax' );


    }



}

add_action('wp_ajax_fun_save', 'fun_save');
function fun_save(){
    parse_str($_POST['data'],$data);

    $get_option_xa_dp_rules = serialize(get_option('xa_dp_rules'));
    $filename = 'data_opt_price.txt';


    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/' . $filename, $get_option_xa_dp_rules, LOCK_EX);

}

add_action('wp_ajax_fun_load', 'fun_load');
function fun_load(){
    parse_str($_POST['data'],$data);

    $get_file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data_opt_price.txt');
    update_option('xa_dp_rules', unserialize($get_file));
}

add_action('wp_ajax_test', 'test');
function test(){
    parse_str($_POST['data'],$data);

    // update_option('all', $data['offer_name_5']);

    $change_dp_rules = get_option('xa_dp_rules', array());
    $count_elm = array_keys($change_dp_rules['product_rules']);

    // $active_tab = "product_rules";

    foreach ($count_elm as $item) {
        $this_offer_name = 'offer_name_' . $item;
        $this_rule_on = 'rule_on_' . $item;
        $this_product_id = 'product_id_' . $item;
        $this_category_id = 'category_id_' . $item;
        $this_check_on = 'check_on_' . $item;
        $this_min = 'min_' . $item;
        $this_max = 'max_' . $item;
        $this_discount_type = 'discount_type_' . $item;
        $this_value = 'value_' . $item;
        $this_max_discount = 'max_discount_' . $item;
        $this_allow_roles = 'allow_roles_' . $item;
        $this_from_date = 'from_date_' . $item;
        $this_to_date = 'to_date_' . $item;
        $this_email_ids = 'email_ids_' . $item;
        $this_prev_order_count = 'prev_order_count_' . $item;
        $this_prev_order_total_amt = 'prev_order_total_amt_' . $item;
        $this_repeat_rule = 'repeat_rule_' . $item;
        $this_adjustment = 'adjustment_' . $item;

        $prev_data["product_rules"][$item] = array(
            'offer_name' => $data[$this_offer_name], // change
            'rule_on' => $data[$this_rule_on], // fixed
            'product_id' => array (
                0 => $data[$this_product_id]
            ), // hidden
            'category_id' => $data[$this_category_id] != '' ? $data[$this_category_id] : NULL, // hidden
            'check_on' => $data[$this_check_on], // fixed
            'min' => $data[$this_min], // change
            'max' => $data[$this_max], // change
            'discount_type' => $data[$this_discount_type], // fixed
            'value' => $data[$this_value], // change
            'max_discount' =>  $data[$this_max_discount] != '' ? $data[$this_max_discount] : NULL, // NULL and hidden
            'allow_roles' =>  array(), // empty and hidden
            'from_date' => $data[$this_from_date] != '' ? $data[$this_from_date] : NULL, // NULL and hidden
            'to_date' => $data[$this_to_date] != '' ? $data[$this_to_date] : NULL, // NULL and hidden
            'adjustment' => $data[$this_adjustment] != '' ? $data[$this_adjustment] : NULL, // NULL and hidden
            'email_ids' => $data[$this_email_ids] != '' ? $data[$this_email_ids] : NULL, // NULL and hidden
            'prev_order_count' => $data[$this_prev_order_count] != '' ? $data[$this_prev_order_count] : NULL, // NULL and hidden
            'prev_order_total_amt' => $data[$this_prev_order_total_amt] != '' ? $data[$this_prev_order_total_amt] : NULL, // NULL and hidden
            'repeat_rule' => $data[$this_repeat_rule] != '' ? $data[$this_repeat_rule] : NULL// NULL and hidden
        );
        $prev_data["combinational_rules"] = array();
        $prev_data["category_rules"] = array();
        $prev_data["cart_rules"] = array();
        $prev_data["buy_get_free_rules"] = array();

        update_option('xa_dp_rules', $prev_data);
    }

    wp_die();
}