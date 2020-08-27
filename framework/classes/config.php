<?php

defined( 'ABSPATH' ) || exit;


/**
 * Editor Enhancer Config.
 *
 * @since 0.1
 */
class EEGridControls_Config {

	/**
	 * Debug.
	 *
	 * @since 2.2.0
	 */
	protected $debug = false;


	/**
	 * Prefix.
	 *
	 * @since 1.0.0
	 */
	protected $prefix = 'eegc';


	/**
	 * General variable prototypes.
	 *
	 * @since 2.2.0
	 */
	protected $name,
			  $version,
			  $plugin_url,
			  $website_url,
			  $admin_url,
			  $poke;


	/**
	 * Constructor.
	 *
	 * @since 0.1
	*/
	public function __construct() {

		// Set up general information
		$this->name        = 'Grid Controls';
		$this->version     = EEGRID_VERSION;
		$this->plugin_url  = 'http://editorenhancer.com';
		$this->website_url = get_site_url();
		$this->admin_url   = get_admin_url();
		$this->poke        = 6303;

		// Check for updates
		add_action( 'admin_init', [ $this, 'runUpdater' ], 0 );

		// Add the grid
		$this->init();
	}


	/**
	 * Get option data.
	 *
	 * @since 2.2.0
	 */
	protected function getOption( $option ) {
		return get_option( $this->prefix . '_' . $option );
	}


	/**
	 * Run updater functions.
	 *
	 * @since 2.2.0
	 */
	public function runUpdater() {

		if ( $this->getOption( 'license_key' ) && $license = trim( $this->getOption( 'license_key' ) ) ) :
			require_once 'edd.php';

			$edd_updater = new EEGridControls_EDD_SL_Plugin_Updater( $this->plugin_url, EEGRID_INDEX,
				array(
					'version' => $this->version,
					'license' => $license,
					'item_id' => $this->poke,
					'author'  => 'Ukuwi',
					'beta'    => false
				)
			);

		else :
			$this->debug( 'Updater license key not found.' );

		endif;
	}


	/**
	 * Check license.
	 *
	 * @since 1.0.3
	 */
	protected function isValid( $test = false ) {
		
		if ( ! $test ) :

			return ( $this->getOption( 'license_key' )
						&& $this->getOption( 'license_status' )
						&& $this->getOption( 'license_status' ) == 'valid'
						//&& $this->getOption( 'version' )
						//&& $this->getOption( 'version' ) === $this->version
					) ? true : false;

		else :
			global $wp_version;

			$license = trim( $this->getOption( 'license_key' ) );

			$api_params = array(
				'edd_action' => 'check_license',
				'license'    => $license,
				'item_name'  => $this->name,
				'item_id'    => $this->poke,
				'url'        => $this->website_url
			);

			// Call the custom API.
			$response = wp_remote_post( $this->plugin_url, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

			if ( is_wp_error( $response ) )
				return false;

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// Return boolean
			return ( $license_data->license == 'valid' );

		endif;
	}


	/**
	 * Debug function.
	 *
	 * @since 2.2.0
	 */
	protected function debug( $message ) {
		if ( $this->debug )
			echo '<script>console.log("Editor Enhancer: ' . $message . '");</script>';
	}
}// End of class
