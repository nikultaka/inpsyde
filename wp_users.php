<?php

/**
 * Plugin Name: Website Custom Plugin
 * Plugin URI: 
 * Description: Custom Plugin
 * Version: 1.0.0
 * Author: Nikul Panchal
 * Author URI: 
 * License: GPL2
 */
@define('WCP_PLUGIN_VERSION', '1.0.0');
@define('WCP_PLUGIN_DOMAIN', 'website-custom-plugin');
@define('WCP_PLUGIN_URL', WP_PLUGIN_URL . '/Website-Custome-Plugin');


include_once(dirname(__FILE__) . "/WCP/BackEnd/Users/Controller.php");

