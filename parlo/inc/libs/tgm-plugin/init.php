<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme parlo
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

require_once get_template_directory() . '/inc/libs/tgm-plugin/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'parlo_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function parlo_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// load pre packaged plugin
		array(
			'name'               => __('Parlo Core','parlo'), // The plugin name.
			'slug'               => 'parlo-core', // The plugin slug (typically the folder name).
			'source'             => get_template_directory() . '/inc/libs/tgm-plugin/plugins/parlo-core.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),

		// Load wporg plugins
		array(
			'name'      => __('Contact Form 7', 'parlo'),
			'slug'      => 'contact-form-7',
			'required'  => false,
		),
		array(
			'name'      => __('Elementor','parlo'),
			'slug'      => 'elementor',
			'required'  => false,
		),
		array(
			'name'      => __('HT Instagram','parlo'),
			'slug'      => 'ht-instagram',
			'required'  => false,
		),
		array(
			'name'      => __('HT Slider For Elementor','parlo'),
			'slug'      => 'ht-slider-for-elementor',
			'required'  => false,
		),
		array(
			'name'      => __('WooLentor - WooCommerce Addons for Elementor Page Builder','parlo'),
			'slug'      => 'woolentor-addons',
			'required'  => true,
		),
		array(
			'name'      => __('MailChimp for WordPress','parlo'),
			'slug'      => 'mailchimp-for-wp',
			'required'  => false,
		),
		array(
			'name'      => __('WooCommerce','parlo'),
			'slug'      => 'woocommerce',
			'required'  => false,
		),
		array(
			'name'      => __('WooCommerce Variation Swatches','parlo'),
			'slug'      => 'woo-variation-swatches',
			'required'  => false,
		),
		array(
			'name'      => __('YITH WooCommerce Compare','parlo'),
			'slug'      => 'yith-woocommerce-compare',
			'required'  => false,
		),
		array(
			'name'      => __('YITH WooCommerce Wishlist','parlo'),
			'slug'      => 'yith-woocommerce-wishlist',
			'required'  => false,
		),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'parlo',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'return'                          => __( 'Return to Required Plugins Installer', 'parlo' ),
		'plugin_activated'                => __( 'Plugin activated successfully.', 'parlo' ),
		'activated_successfully'          => __( 'The following plugin was activated successfully:', 'parlo' ),
	);

	tgmpa( $plugins, $config );
}
