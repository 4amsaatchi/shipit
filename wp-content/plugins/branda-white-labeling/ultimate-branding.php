<?php
/*
Plugin Name: Branda
Plugin URI: https://wpmudev.com/project/ultimate-branding/
Description: A complete white label and branding solution for multisite. Login images, favicons, remove WordPress links and branding, and much more.
Author: WPMU DEV
Version: 3.4.8.1
Author URI: https://wpmudev.com/
Requires PHP: 5.6
Text_domain: ub


Copyright 2009-2019 Incsub (https://incsub.com)

Lead Developer - Marcin Pietrzak (Incsub)

Contributors - Sam Najian (Incsub), Ve Bailovity (Incsub), Barry (Incsub), Andrew Billits, Ulrich Sossou, Marko Miljus, Joseph Fusco (Incsub), Calum Brash (Incsub), Joel James ( Incsub)

This program is free software; you can redistribute it and/or modify it under
the terms of the GNU General Public License (Version 2 - GPLv2) as published
by the Free Software Foundation.

This program is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program; if not, write to the Free Software Foundation, Inc., 51 Franklin
St, Fifth Floor, Boston, MA 02110-1301 USA

 */

if ( defined( 'BRANDA_BUILD_TYPE' ) ) {
	// Another version of the plugin must be active already, abort
	return;
}

/**
 * Branda Version
 */
$ub_version = null;

require_once 'build.php';

// Include the configuration library.
require_once dirname( __FILE__ ) . '/etc/config.php';
// Include the functions library.
if ( file_exists( 'inc/deprecated-functions.php' ) ) {
	require_once 'inc/deprecated-functions.php';
}
require_once 'inc/functions.php';
require_once 'inc/class-branda-helper.php';

/**
 * Set ub Version.
 */
if ( ! function_exists( 'branda_set_ub_version' ) ) {
	function branda_set_ub_version() {
		global $ub_version;
		$data = get_plugin_data( __FILE__, false, false );
		$ub_version = $data['Version'];
	}
}

// Set up my location.
set_ultimate_branding( __FILE__ );

if ( ! defined( 'BRANDA_SUI_VERSION' ) ) {
	define( 'BRANDA_SUI_VERSION', '2.9.6' );
}

$dash_notification_path = dirname( __FILE__ ) . '/external/dash-notice/wpmudev-dash-notification.php';
if ( file_exists( $dash_notification_path ) ) {
	include_once $dash_notification_path;
}

add_action(
	'admin_init',
	function() {
		// Black Friday banner 2022.
		if ( file_exists( dirname( __FILE__ ) . '/external/black-friday/banner.php' ) ) {
			include_once dirname( __FILE__ ) . '/external/black-friday/banner.php';

			new \WPMUDEV\BlackFriday\Banner(
				array(
					'close'       => __( 'Close', 'ub' ),
					'get_deal'    => __( 'Get deal', 'ub' ),
					'intro'       => __( 'Black Friday offer for WP businesses and agencies', 'ub' ),
					'off'         => __( 'Off', 'ub' ),
					'title'       => __( 'Everything you need to run your WP business for', 'ub' ),
					'discount'    => __( '83.5', 'ub' ),
					'price'       => __( '3000', 'ub' ),
					'description' => __( 'From the creators of Branda, WPMU DEV’s all-in-one platform gives you all the Pro tools and support you need to run and grow a web development business. Trusted by over 50,000 web developers. Limited deals available.', 'ub' ),
				),
				'https://wpmudev.com/black-friday/?coupon=BFP-2022&utm_source=branda&utm_medium=plugin&utm_campaign=BFP-2022-branda&utm_id=BFP-2022&utm_term=BF-2022-plugin-Branda&utm_content=BF-2022',
				\WPMUDEV\BlackFriday\Banner::BRANDA
			);
		}
	}
);

register_activation_hook( __FILE__, 'branda_register_activation_hook' );
register_deactivation_hook( __FILE__, 'branda_register_deactivation_hook' );
register_uninstall_hook( __FILE__, 'branda_register_uninstall_hook' );
