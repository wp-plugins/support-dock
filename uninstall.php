<?php
if ( !defined('WP_UNINSTALL_PLUGIN') ) {
    exit();
}
delete_option('sdock_options');
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}sdrecords");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}sdtickets");

?>
