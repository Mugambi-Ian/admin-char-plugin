<?php

/**
 * Plugin Name: Admin Chart
 * Description: A plugin that an prints out an area chart on the admin dashboard.
 * Version: 1.0.0
 * Author: Ian Mugambi
 * License: GPL2
 */

class AdminChartPlugin
{
  private $domain = 'admin-chart';

  function __construct()
  {
    add_action('rest_api_init', array($this, 'register_api'));
    add_action('wp_dashboard_setup', array($this, 'load_widget'));
    add_action('admin_menu', array($this, 'load_settings_page'));
    add_action('init', array($this, 'load_script'));
  }


  function register_api()
  {
    register_rest_route('admin-chart/v1', 'data', array(
      'methods' => 'GET',
      'callback' => array($this, 'get_chart_data'),
      'permission_callback' => array($this, 'is_permitted'),
    ));
  }

  function get_chart_data($data)
  {
    if (is_numeric(($data['days']))) {
      $total = 0;
      $result = [];
      $days = $data['days'];
      $weeks = floor($days / 7);
      if ($days % 7) $weeks = $weeks + 1;
      while ($total < $weeks) {
        $total = $total + 1;
        $week = explode(",", get_option("admin_chart_week_" . $total));
        if (count($week) > 1)
          $result = array_merge($result, $week);
      }
      $result = array_slice($result, 0, $days);
      return new WP_REST_Response($result);
    }
    return new WP_REST_Response(null, 404);
  }

  function is_permitted()
  {
    $user_id = apply_filters('determine_current_user', false);
    wp_set_current_user($user_id);
    $current_user  = wp_get_current_user();
    $permissions  = $current_user->allcaps;
    return $permissions['manage_options'];
  }


  function load_widget()
  {
    wp_add_dashboard_widget(
      'admin_chart_widget',
      __('Admin Chart', $this->domain),
      array($this, 'widget_title')
    );
  }


  function load_script()
  {
    $transalation_path =  dirname(plugin_basename(__FILE__)) . '/languages/';
    load_plugin_textdomain($this->domain, false, $transalation_path);
    $script = 'admin-chart-widget-script';
    wp_enqueue_script(
      $script,
      plugin_dir_url(__FILE__) . 'dist/index.js',
      array('wp-i18n'),
      false,
      true
    );
    load_plugin_textdomain($this->domain, false, $transalation_path);
    wp_localize_script($script, 'locale', array("data" => $this->get_locale_data()));
  }

  function get_locale_data()
  {
    $locale = apply_filters('plugin_locale', get_locale(), $this->domain);
    $locale_path  = $this->domain . "-" . $locale . '.json';
    $languages_dir = plugin_dir_path(__FILE__) . 'languages';
    if (is_dir($languages_dir) && $handle = opendir($languages_dir)) {
      while (false !== ($file = readdir($handle))) {
        if ($file === $locale_path) {
          $file_path = $languages_dir . '/' . $file;
          $result = json_decode(file_get_contents($file_path), true);
          closedir($handle);
          return $result;
        }
      }
      closedir($handle);
    }
    return null;
  }

  function widget_title()
  {
    echo '<div id="admin-chart-widget"></div>';
  }

  function load_settings_page()
  {
    add_options_page(
      __('Admin Chart Settings', $this->domain),
      __('Admin Chart', $this->domain),
      'manage_options',
      'admin_chart_settings',
      array($this, 'settings_page')
    );
  }

  function settings_page()
  {
    include 'settings.php';
  }
}
new AdminChartPlugin();
