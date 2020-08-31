<?php
/**
 * Plugin Name: GIT Grid Controls
 * Plugin URI: https://editorenhancer.com
 * Description: Add grid controls to Oxygen's Advanced styles panels.
 * Version: 1.0.1
 * Author: Editor Enhancer
 * Author URI: https://editorenhancer.com
 * Text Domain: ee_grid_controls
 */

defined( 'ABSPATH' ) || exit;


/**
 * General definitions.
 */
define( 'EEGRID',			true );
define( 'EEGRID_VERSION',	'1.0.1' );
define( 'EEGRID_INDEX',	    __FILE__ );
define( 'EEGRID_ROOT',		plugin_dir_path( EEGRID_INDEX ) );
define( 'EEGRID_URI',		plugin_dir_url( EEGRID_INDEX ) );


/**
 * Directory definitions with trailing slashes.
 */
define( 'EEGRID_ADMIN',			EEGRID_ROOT . 'framework/admin/' );
define( 'EEGRID_ADMIN_URI',		EEGRID_URI . 'framework/admin/' );
define( 'EEGRID_CLASSES',			EEGRID_ROOT . 'framework/classes/' );
define( 'EEGRID_CLASSES_URI',		EEGRID_URI . 'framework/classes/' );
define( 'EEGRID_PACKAGES',		EEGRID_ROOT . 'framework/packages/' );
define( 'EEGRID_PACKAGES_URI',	EEGRID_URI . 'framework/packages/' );
define( 'EEGRID_INCLUDES',		EEGRID_ROOT . 'framework/includes/' );
define( 'EEGRID_INCLUDES_URI',	EEGRID_URI . 'framework/includes/' );


/**
 * Begin the startup process.
 */
require_once 'framework/grid-controls-init.php';
