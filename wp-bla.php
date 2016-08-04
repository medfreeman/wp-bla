<?php
/*
Plugin Name: Bla
Plugin URI: https://github.com/medfreeman/wp-bla
Description: Provides an interface for maintaining voxusini monthly blas
Version: 1.1
Author: Mehdi Lahlou
Author URI: https://github.com/medfreeman
Author Email: mehdi.lahlou@free.fr
License: GPLv3

  Copyright 2016 Mehdi Lahlou (mehdi.lahlou@free.fr)

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

class Bla {

	const POST_TYPE = 'bla';
	const LANG_PREFIX = 'bla';

	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
		// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

		// Load plugin text domain
		add_action( 'init', array( $this, 'plugin_textdomain' ) );
		// Register post type
		add_action( 'init', array( $this, 'register_post_type_bla' ) );
	} // end constructor

	/**
	 * Fired when the plugin is activated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
	 */
	public function activate( $network_wide ) {
		$this->register_post_type_bla();
		flush_rewrite_rules();
	} // end activate

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
	 */
	public function deactivate( $network_wide ) {
		flush_rewrite_rules();
	} // end deactivate

	/**
	 * Loads the plugin text domain for translation
	 */
	public function plugin_textdomain() {

		load_plugin_textdomain( 'bla', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );

	} // end plugin_textdomain

	public function register_post_type_bla() {
		register_post_type( self::POST_TYPE, array(
			'label' => __( 'Blas', self::LANG_PREFIX ),
			'singular_label' => __( 'Bla', self::LANG_PREFIX ),
			'labels' => array( 'add_new_item' => __( 'Ajouter un Bla', self::LANG_PREFIX ) ),
			'public' => true,
			'show_ui' => true,
			'menu_position' => 25,
			'menu_icon' => plugins_url( 'bla/images/icons/news.png' ),
			'query_var' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => array( 'title', 'editor' ),
			'rewrite' => array( 'slug' => 'bla', 'with_front' => false ),
			'has_archive' => 'bla',
			'labels' => array(
				'archives' => 'les blas',
			),
		));
	} // end register_post_type_bla
} // end class

$bla = new Bla();
