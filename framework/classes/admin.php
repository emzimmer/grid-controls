<?php

defined( 'ABSPATH' ) || exit;


/**
 * Grid Controls Admin.
 *
 * @since 0.1
 */
class EEGridControls_Admin extends EEGridControls_Config {

	/**
	 * License page actions.
	 *
	 * @since 2.2.0
	 */
	public $license;


	/**
	 * Init.
	 *
	 * @since 2.2.0
	 */
	protected function init() {

		if ( defined( 'CT_VERSION' ) ) :

			// The homepage slug, used for every page
			//
			$this->homeSlug = $this->_doSlug( 'home' );

			// Main admin page and license page are always loaded in the admin
			//
			add_action( 'admin_menu', [ $this, 'addBasicPages' ] );
			$this->_doLicenseActions();

			// Check license validity before running other methods
			//
			if ( $this->isValid() ) :


			else :
				$this->debug( 'License not valid.' );
				
			endif;
		endif;
	}


	/****************************************************************************
	 * Add pages.
	 */

	public function register_page( $title, $slug, $callback ) {

		$defineSlug = $slug === $this->homeSlug ? $this->homeSlug : $this->_doSlug( $slug );

		add_submenu_page(
			$this->homeSlug,
			$title,
			$title,
			'manage_options',
			$defineSlug,
			[ $this, $callback ]
		);

		register_setting( $defineSlug, $defineSlug );
	}

	public function register_section( $pageSlug, $sectionTitle, $sectionSlug ) {

		add_settings_section( 
			$this->_doSlug( $sectionSlug ),
			$sectionTitle,
			[ $this, 'gratuitousSectionCallback' ],
			$this->_doSlug( $pageSlug )
		);
	}

	public function register_field( $pageSlug, $sectionSlug, $fieldSlug, $fieldTitle, $fieldType, $args = array() ) {

		add_settings_field(
			$fieldSlug,
			$fieldTitle,
			[ $this, $fieldType . 'Callback' ],
			$this->_doSlug( $pageSlug ),
			$this->_doSlug( $sectionSlug ),
			$args
		);
	}


	/**
	 * Add basic pages.
	 */
	public function addBasicPages() {

		add_submenu_page( 'ct_dashboard_page', 'Grid Controls', 'Grid Controls', 'manage_options', $this->homeSlug, [ $this, 'homePage' ] );

		// Top level page and Home submenu
		//add_menu_page( 'Grid Controls', 'Grid Controls', 'manage_options', $this->homeSlug, [ $this, 'homePage' ] );

		// Homepage submenu item
		//$this->register_page(
		//	'Home',
		//	$this->homeSlug,
		//	'homePage'
		//);

		// License submenu item
		$this->register_page(
			'License',
			'license',
			'licensePage'
		);
	}


	/**
	 * Home page content.
	 *
	 * @since 2.2.0
	 */
	public function homePage() {
		// Check user capabilities
		if ( ! current_user_can( 'manage_options' ) )
			return;

		require_once EEGRID_ADMIN . 'home.php';
	}

	/**
	 * License page content.
	 *
	 * @since 1.0.2
	 */
	public function licensePage() {
		$license = $this->getOption( 'license_key' );
		$status  = $this->getOption( 'license_status' );
		$input_type = $license ? 'password' : 'text';

		// Check user capabilities
		if ( ! current_user_can( 'manage_options' ) )
			return;

		require_once EEGRID_ADMIN . 'license.php';
	}


	/**
	 * Set license actions.
	 */
	public function _doLicenseActions() {
		require_once 'license.php';
		$this->license = new EEGridControls_Admin_License(
			$this->prefix,
			$this->name,
			$this->plugin_url,
			$this->website_url
		);
	}


	/**
	 * Return a page slug.
	 *
	 * @since 2.2.0
	 */
	protected function _doSlug( $slug ) {
		return $this->prefix . '_' . $slug;
	}


	/**
	 * Generic admin options page.
	 *
	 * @since 1.0.0
	 */
	public function _genericAdminPage( $slug, $button_text = 'Save Settings', $extra_description = null ) {
		// Check user capabilities
		if ( ! current_user_can( 'manage_options' ) )
			return;

		?>
		<link rel="stylesheet" href="<?php echo EEUI_ADMIN_URI . 'styles.css'; ?>">
		<?php

		// Did the user submit the settings?
		if ( isset( $_GET['settings-updated'] ) ) {
			// Show saved message
			add_settings_error( $this->_doSlug( $slug ) . '_messages', $this->_doSlug( $slug ) . '_message', __( 'Settings Saved', $this->_doSlug( $slug ) ), 'updated' );
		}

		// Show error/update messages
		settings_errors( $this->_doSlug( $slug ) . '_messages' );
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<?php
			if ( $extra_description )
				echo '<div>' . $extra_description . '</div>';
			?>
			<form action="options.php" method="post">
				<?php
				// Output security fields for the registered setting
				settings_fields( $this->_doSlug( $slug ) );

				// Output sections and fields
				do_settings_sections( $this->_doSlug( $slug ) );

				// Output save settings button
				submit_button( $button_text );
				?>
			</form>
		</div>
		<?php
	}


	/**
	 * Checkbox field callback.
	 *
	 * @since 1.0.0
	 */
	public function checkboxCallback( $args ) {
		$label   = esc_attr( $args['label_for'] );
		$setting = esc_attr( $args['setting'] );
		$options = get_option( $setting );
		$checked = isset( $options[ $label ] ) ? ( checked( $options[ $label ], 1, false ) ) : '';
		$value = $args['value'] ? $args['value'] : $label;
		?>
		<input id="<?php echo $label; ?>" type="checkbox" value="1" name="<?php echo $setting . '[' . $value . ']'; ?>" <?php echo isset( $options[ $value ] ) ? ( checked( $options[ $value ], 1, false ) ) : ''; ?>>
		<?php
		$this->_fieldDescription( $args );
	}


	/**
	 * Select field callback.
	 *
	 * @since 1.0.0
	 */
	public function selectCallback( $args ) {
		$label   = esc_attr( $args['label_for'] );
		$setting = esc_attr( $args['setting'] );
		$options = get_option( $setting );
		$given_value = $args['value'] ? $args['value'] : $label;
		?>
		<select id="<?php echo $label; ?>" name="<?php echo $setting . '[' . $given_value . ']'; ?>">
			<?php
			foreach ( $args['options'] as $option ) :
				$value = strtolower( str_replace( ' ', '_', $option ) );
				$selected = isset( $options[ $given_value ] ) ? ( selected( $options[ $given_value ], $value, false ) ) : '';
				?>
				<option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $option; ?></option>
				<?php
			endforeach;
			?>
		</select>
		<?php
		$this->_fieldDescription( $args );
	}


	/**
	 * Text field callback.
	 *
	 * @since 1.0.0
	 */
	public function textCallback( $args ) {
		$label   = esc_attr( $args['label_for'] );
		$setting = esc_attr( $args['setting'] );
		$max_length = esc_attr( $args['max_length'] );
		$options = get_option( $setting );
		$value = isset( $options[ $label ] ) ? $options[ $label ] : '';
		?>
		<input id="<?php echo $label; ?>" type="text" name="<?php echo $setting . '[' . $label . ']'; ?>" value="<?php echo $value; ?>" maxlength="<?php echo $max_length; ?>">
		<?php
		$this->_fieldDescription( $args );
	}


	/**
	 * Description output for callbacks.
	 *
	 * @since 1.0.0
	 */
	public function _fieldDescription( $args ) {
		if ( isset( $args['description'] ) && $args['description'] !== '' ) :
			?>
			<p class="description"><?php echo $args['description']; ?></p>
			<?php
		endif;
	}


	/**
	 * Try experimental operations if available.
	 *
	 * @since 2.2.0
	 */
	public function _tryIncludeExperimental() {
		if ( file_exists( EEGRID_ROOT . 'framework/experimental/' ) && file_exists( EEGRID_ROOT . 'framework/experimental/directory.admin.php' ) )
			require_once EEGRID_ROOT . 'framework/experimental/directory.admin.php';
	}


	/****************************************************************************
	 * Additional, miscellaneous functions.
	 */


	/**
	 * Update option data.
	 *
	 * @since 2.2.0
	 */
	protected function updateOption( $option, $data ) {
		update_option( $this->prefix . '_' . $option, $data );
	}


	/**
	 * Required function for sections, though no need to have any actual content or output.
	 *
	 * @since 1.0.0
	 */
	public function gratuitousSectionCallback() {}

}// End of class
