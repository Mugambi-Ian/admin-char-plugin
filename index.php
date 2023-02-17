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

  function __construct()
  {
    add_action('wp_dashboard_setup', array($this, 'load_widget'));
    add_action('admin_menu', array($this, 'load_settings_page'));
  }


  function load_widget()
  {
    wp_add_dashboard_widget(
      'admin_chart_widget',
      'Admin Chart',
      array($this, 'widget_title')
    );
    wp_enqueue_script(
      'admin-chart-widget-script',
      plugin_dir_url(__FILE__) . 'dist/index.js',
      array(),
      '1.0.0',
      true
    );
  }
  
  function widget_title()
  {
    echo '<div id="admin-chart-widget"></div>';
  }

  function load_settings_page()
  {
    add_options_page(
      'Admin Chart Settings',
      'Admin Chart',
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
