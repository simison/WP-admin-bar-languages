<?php
/*
 Plugin Name: Admin bar languages
 Plugin URI: http://wordpress.org/extend/plugins/admin-bar-languages/
 Description: Show flags at "My sites" list in WordPress admin bar.
 Version: 1.1
 Author: Mikael Korpela
 Author URI: http://www.mikaelkorpela.fi
 License: GPL2
 */

/*  Copyright 2014  Mikael Korpela  (email : mikael@ihminen.org)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

defined('ABSPATH') or die("No script kiddies please!");


class AdminBarLanguages {
    public function __construct()
    {
        add_action( 'init', array($this, 'init_admin_bar_languages') );
    }

    /*
     * Run this plugin only when we have admin bar up there...
     */
    public function init_admin_bar_languages(){
        if( is_user_logged_in() && is_admin_bar_showing() ) {
            add_action( 'wp_before_admin_bar_render', array($this, 'flagatar_admin_bar') );
            add_action( 'admin_enqueue_scripts', array($this, 'flagatar_style') );
        }

        if (is_admin()){
            add_filter( 'plugin_row_meta', array($this, 'flagatar_plugin_links'), 10, 2 );
        }
    }


    /*
     * Include stylesheet for flags
     */
    public function flagatar_style() {
        wp_enqueue_style('flagatar', plugins_url('flagatar.css', __FILE__));
    }


    /*
     * Add those flags to My Sites -menu
     */
    public function flagatar_admin_bar() {
        global $wp_admin_bar, $blog_id;

        // This is functionality for WP 4.0+ only
        if( version_compare( get_bloginfo( 'version' ), '4.0', '>=' ) ) {

            // Get native language names
            if( file_exists( ABSPATH . 'wp-admin/includes/translation-install.php' ) ) require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
            $translations = ( function_exists( 'wp_get_available_translations' ) ) ? wp_get_available_translations() : array();

        }
        else {

            $translations = array();

        }

        // Loop user's blogs trough
        foreach( (array) $wp_admin_bar->user->blogs as $blog ) {

            $node_id = 'blog-' . $blog->userblog_id;

            $node = $wp_admin_bar->get_node( $node_id );

            if( $node ) {

                // We'll put it back...
                $wp_admin_bar->remove_node( $node_id );

                // Get language
                $lang = ( is_multisite() ) ? get_blog_option( $blog->userblog_id, 'WPLANG', 'en_US' ) : get_bloginfo( 'language' );

                // Oh, just sometimes language returns empty on WP 4.0, try different key
                if(empty($lang) && is_multisite() ) $lang = get_blog_option( $blog->userblog_id, 'language', 'en_US' );

                // Still no language? Default to US.
                if( empty($lang) ) $lang = 'en_US';

                // Blog name - and is this blog currently active?
                $blogname = ( $blog_id == $blog->userblog_id ) ? '<strong class="current">' . $blog->blogname . '</strong>' : $blog->blogname;

                // Update node and put it back
                $node->title = '<div class="blavatar flagatar" style="background-image:url(' . plugins_url( 'flags/' . strtoupper( substr( $lang, -2 ) ) . '.png', __FILE__ ) . ')"></div> ' . $blogname;

                // If we have name for this language, show it as title. Fall back to locale.
                $node->meta['title'] = (isset($translations[$lang])) ? esc_attr( $translations[$lang]['english_name'] . ' (' . $translations[$lang]['native_name'] . ')' ) : esc_attr( $lang );

                $wp_admin_bar->add_node( $node );
            }
        }
    }

    /*
     * Add donation link on the plugin listing
     */
    public function flagatar_plugin_links($links, $file) {
       if ( $file == plugin_basename(dirname(__FILE__).'/admin-bar-languages.php') ) {
         $links[] = '<a href="http://www.mikaelkorpela.fi/volunteering/">' . __('Donate') . '</a>';
       }
       return $links;
    }
}

$AdminBarLanguages = new AdminBarLanguages();
