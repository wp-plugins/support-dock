<?php

/*
Plugin Name: Support Dock
Plugin URI: http://cbfreeman.com/downloads/support-dock/
Description: A customer support ticket solution with faq for registered members.
Version: 1.0
Author: cbfreeman
Author URI: http://cbfreeman.com
License: GPLv2
*/



/*
  Copyright (c) 2014 Craig Freeman (email :ceo@cbfreeman.com)

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

 
 // Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SUPPORT_DOCK' ) ) {
if ( ! defined( 'SDOCK_JS_URL' ) )
		define( 'SDOCK_JS_URL', plugin_dir_url( __FILE__ ) . 'js' );

	if ( ! defined( 'SDOCK_CSS_URL' ) )
		define( 'SDOCK_CSS_URL', plugin_dir_url( __FILE__ ) . 'css' );
  
 //Register post shortcode
 function sdock_suppport_ticket_form($atts) {
   global $wp_version;
   require 'sdock-ticket.php';
    
        return $results;
}
 add_shortcode("sdticket777", "sdock_suppport_ticket_form");
 
  
  //Add database tables for support dock
  
  global $wpdb, $wp_version;
  
  define("SUPPORT_TICKET_TABLE", $wpdb->prefix . "sdtickets");
  define("SUPPORT_TICKET_RECORDS_TABLE", $wpdb->prefix . "sdrecords");
  
     if(strtoupper($wpdb->get_var("show tables like '". SUPPORT_TICKET_TABLE . "'")) != strtoupper(SUPPORT_TICKET_TABLE))
    {
        $wpdb->query("
            CREATE TABLE IF NOT EXISTS `". SUPPORT_TICKET_TABLE . "` (
              `id` int(11) NOT NULL auto_increment,
              `stckid` char(250) NOT NULL ,
              `dept` char(250) NOT NULL ,
              `sfrom` char(250) NOT NULL ,
              `sto` char(250) NOT NULL default '',
              `subject` char(250) NOT NULL default '',
              `concern` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
              `sstatus` char(3) NOT NULL default '1',
              `date` char(250) NOT NULL,
              UNIQUE KEY  (`id`) )
            ");
        
       
    if(strtoupper($wpdb->get_var("show tables like '". SUPPORT_TICKET_RECORDS_TABLE . "'")) != strtoupper(SUPPORT_TICKET_RECORDS_TABLE))
    {
        $wpdb->query("
            CREATE TABLE `". SUPPORT_TICKET_RECORDS_TABLE . "` (
              `id` int(11) NOT NULL auto_increment,
              `rtckid` int(11) NOT NULL,
              `parentid` int(11) NOT NULL,
              `dept` char(250) NOT NULL ,
              `rfrom` char(250) NOT NULL ,
              `rto` char(250) NOT NULL ,
              `subject` char(250) NOT NULL default '',
              `concern` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
              `rstatus` char(3) NOT NULL default '3',
              `date` char(250) NOT NULL,
              UNIQUE KEY  (`id`) )
            ");
            
            
    }
  
}
 
 

class SUPPORT_DOCK {

    /* Saved options */
    public $options;

static function init() {
  
  // Load translations
   load_plugin_textdomain( 'support-dock', null, basename( dirname( __FILE__ ) ) . '/langs/' );
 
   //Actions
   add_action('admin_menu', array(__CLASS__, 'menu_page') );
   add_action('admin_enqueue_scripts', array(__CLASS__, 'sd_enqueue_admin') );
   add_action('wp_enqueue_scripts', array(__CLASS__, 'sdock_enqueue_admin') );

}


 	/**
		 * Record plugin activation
		 *
		 * @since 0.1
		 * @global $wp_version
		 */
		static function install() {
			global $wp_version;
			// Prevent activation if requirements are not met
			// WP 3.0 required
			if ( version_compare( $wp_version, '3.0', '<=' ) ) {
				deactivate_plugins( __FILE__ );

				wp_die( __( 'Support Dock requires WordPress 3.0 or newer.', 'support_dock' ), __( 'Upgrade your Wordpress installation.', 'support_dock' ) );
			}

			
		}
	
  //Register admin styles and scripts
 static function sd_enqueue_admin() {
  wp_enqueue_style('sdstyle', SDOCK_CSS_URL . '/sdstyle.css');
    }
	
	//Register front-end styles and scripts
 static function sdock_enqueue_admin() {
  wp_enqueue_script( 'sd-tabs-script', SDOCK_JS_URL . '/sd-tabs-script.js', array( 'jquery'), '', true );
  wp_enqueue_style('jquery');
  wp_enqueue_script('jquery-ui-core');
  wp_enqueue_script('jquery-ui-tabs');
  wp_enqueue_script('jquery-ui-tabs');
  wp_enqueue_style('tabs', SDOCK_CSS_URL . '/tabs.css');
    }
    
    
//Add dasboard menu
static function menu_page() {
			add_menu_page( __( 'Support Dock', 'support_dock' ), __( 'Support Dock', 'support_dock' ), 'administrator', 'sdock_options',       array( __CLASS__, 'sdock_page' ), '', plugins_url( 'images/icon.png' ),6);
    	
    	// Add a submenu to the Support Dock menu:
    add_submenu_page('sdock_options', __( 'Logs', 'support_dock' ), __( 'Logs', 'support_dock' ), 'administrator', 'sdock_sent', array(__CLASS__, 'sent_page'));
    
   
		}



		/**
		 * Include tickets page
		 *
		 * @since 0.1
		 * @global $wp_version
		 */
		static function sdock_page() {
			global $wp_version;

			require 'sdock-options.php';
		}
		

                 /**
		 * Include support records page
		 *
		 * @since 0.1
		 * @global $wp_version
		 */
		static function sent_page() {
			global $wp_version;

			require 'sdock-sent.php';
		}

}

}

SUPPORT_DOCK::init();
