<?php

defined( 'ABSPATH' ) || exit;

/**
 * Init Grid Controls
 */
add_action( 'plugins_loaded', 'ee_grid_controls_init' );
function ee_grid_controls_init() {

	// Get the configuration class.
	require_once EEGRID_CLASSES . 'config.php';

	/**
	 * The builder is active.
	 */
	if ( isset( $_GET['ct_builder'] ) && $_GET['ct_builder'] == true ) :

		// Base class
		require_once EEGRID_CLASSES . 'interface.php';
		$editor_enhancer_grid_controls = new EEGridControls_Interface;

	/**
	 * The admin is active.
	 */
	elseif ( is_admin() ) :

		// Base class
		require_once EEGRID_CLASSES . 'admin.php';
		$editor_enhancer_grid_controls = new EEGridControls_Admin;

	endif;
}
