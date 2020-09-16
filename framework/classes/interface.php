<?php

defined( 'ABSPATH' ) || exit;


/**
 * Editor Enhancer Interface.
 *
 * @since 2.2.0
 */
class EEGridControls_Interface extends EEGridControls_Config {

	/**
	 * Constructor.
	 */
	public function init() {

		// Don't do anything unless validity is confirmed
		if ( $this->isValid() ) :

			if ( class_exists( 'CT_Component' ) ) :

				add_action( 'ct_toolbar_advanced_settings', [ $this, 'enqueue_advanced_tabs' ], 11 );
				$this->_add_grid_styles();

			else :
				echo '<script>console.log("CT_Component class is not available.");</script>';

			endif;

		else :
			$this->debug( 'License not valid.' );

		endif;
	}


	/**
	 * Enqueue advanced tabs for managing grid styles
	 */
	public function enqueue_advanced_tabs() {

		global $oxygen_toolbar;


		/**
		 * Child controls
		 */
		?>
		<div class="oxygen-sidebar-advanced-subtab"
			ng-show="showAllStyles
					&& (isActiveName('ct_div_block')
						|| isActiveName('oxy_dynamic_list')
						|| isActiveName('ct_modal')
						|| isActiveName('oxy_tab_content')
					);"
			ng-click="switchTab('advanced', 'ee-grid-parent')">
			<img src="<?php echo CT_FW_URI; ?>/toolbar/UI/oxygen-icons/advanced/layout.svg" title="EE Grid" alt="EE Grid" />
			<span>Grid Parent Controls</span>
			<img src="<?php echo CT_FW_URI; ?>/toolbar/UI/oxygen-icons/advanced/open-section.svg">
		</div>

		<div class="ee-grid-parent" ng-if="isShowTab('advanced', 'ee-grid-parent')">
			<div class='oxygen-control-row'>
				<div class='oxygen-control-wrapper' id='oxygen-control-layout-display'>
					<label class='oxygen-control-label'><?php _e("Display", "oxygen"); ?></label>
					<div class='oxygen-control'>
						<div class='oxygen-button-list'>

							<?php $oxygen_toolbar->button_list_button('display','grid'); ?>
							<?php $oxygen_toolbar->button_list_button('display','inline-grid');?>

						</div>
					</div>
				</div>
			</div>

			<div class='oxygen-control-row'>
				<?php $oxygen_toolbar->simple_input_with_wrapper('grid-template-columns','Grid Template Columns'); ?>
			</div>
			<div class='oxygen-control-row'>
				<?php $oxygen_toolbar->simple_input_with_wrapper('grid-template-rows','Grid Template Rows'); ?>
			</div>
			<div class='oxygen-control-row'>
				<?php $oxygen_toolbar->simple_input_with_wrapper('grid-template-areas','Grid Template Areas'); ?>
			</div>

			<div class='oxygen-control-row'>
				<?php $oxygen_toolbar->simple_input_with_wrapper('column-gap','Column Gap'); ?>
				<?php $oxygen_toolbar->simple_input_with_wrapper('row-gap','Row Gap'); ?>
			</div>

			<div class='oxygen-control-row'>
				<div class='oxygen-control-wrapper'>
					<label class='oxygen-control-label'><?php _e("Justify Items","oxygen"); ?></label>
					<div class='oxygen-control'>
						<div class='oxygen-button-list'>

							<?php $oxygen_toolbar->button_list_button('justify-items','start'); ?>
							<?php $oxygen_toolbar->button_list_button('justify-items','center'); ?>
							<?php $oxygen_toolbar->button_list_button('justify-items','end'); ?>
							<?php $oxygen_toolbar->button_list_button('justify-items','stretch'); ?>

						</div>
					</div>
				</div>
			</div>

			<div class='oxygen-control-row'>
				<div class='oxygen-control-wrapper'>
					<label class='oxygen-control-label'><?php _e("Align Items","oxygen"); ?></label>
					<div class='oxygen-control'>
						<div class='oxygen-button-list'>

							<?php $oxygen_toolbar->button_list_button('align-items','start'); ?>
							<?php $oxygen_toolbar->button_list_button('align-items','center'); ?>
							<?php $oxygen_toolbar->button_list_button('align-items','end'); ?>
							<?php $oxygen_toolbar->button_list_button('align-items','stretch'); ?>

						</div>
					</div>
				</div>
			</div>

			<div class='oxygen-control-row'>
				<div class='oxygen-control-wrapper' id='oxygen-control-layout-justify-content'>
					<label class='oxygen-control-label'><?php _e("Justify Content","oxygen"); ?></label>
					<div class='oxygen-control'>
						<div class='oxygen-button-list'>

							<?php $oxygen_toolbar->button_list_button('justify-content','start'); ?>
							<?php $oxygen_toolbar->button_list_button('justify-content','center'); ?>
							<?php $oxygen_toolbar->button_list_button('justify-content','end'); ?>
							<?php $oxygen_toolbar->button_list_button('justify-content','stretch'); ?>
							<?php $oxygen_toolbar->button_list_button('justify-content','space-around'); ?>
							<?php $oxygen_toolbar->button_list_button('justify-content','space-between'); ?>
							<?php $oxygen_toolbar->button_list_button('justify-content','space-evenly'); ?>

						</div>
					</div>
				</div>
			</div>

			<div class='oxygen-control-row'>
				<div class='oxygen-control-wrapper' id='oxygen-control-layout-justify-content'>
					<label class='oxygen-control-label'><?php _e("Align Content","oxygen"); ?></label>
					<div class='oxygen-control'>
						<div class='oxygen-button-list'>

							<?php $oxygen_toolbar->button_list_button('align-content','start'); ?>
							<?php $oxygen_toolbar->button_list_button('align-content','center'); ?>
							<?php $oxygen_toolbar->button_list_button('align-content','end'); ?>
							<?php $oxygen_toolbar->button_list_button('align-content','stretch'); ?>
							<?php $oxygen_toolbar->button_list_button('align-content','space-around'); ?>
							<?php $oxygen_toolbar->button_list_button('align-content','space-between'); ?>
							<?php $oxygen_toolbar->button_list_button('align-content','space-evenly'); ?>

						</div>
					</div>
				</div>
			</div>

			<div class='oxygen-control-row'>
				<div class='oxygen-control-wrapper' id='oxygen-control-layout-justify-content'>
					<label class='oxygen-control-label'>Grid Auto Flow</label>
					<div class='oxygen-control'>
						<div class='oxygen-button-list'>

							<?php $oxygen_toolbar->button_list_button('grid-auto-flow','row'); ?>
							<?php $oxygen_toolbar->button_list_button('grid-auto-flow','column'); ?>
							<?php $oxygen_toolbar->button_list_button('grid-auto-flow','row dense'); ?>
							<?php $oxygen_toolbar->button_list_button('grid-auto-flow','column dense'); ?>

						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		/**
		 * Child controls
		 */
		?>
		<div class="oxygen-sidebar-advanced-subtab"
			ng-show="showAllStyles
					&& (isActiveName('ct_div_block')
						|| isActiveName('ct_headline')
						|| isActiveName('ct_text_block')
						|| isActiveName('oxy_rich_text')
						|| isActiveName('ct_link_text')
						|| isActiveName('ct_link')
						|| isActiveName('ct_link_button')
						|| isActiveName('ct_image')
						|| isActiveName('ct_video')
						|| isActiveName('oxy-dashboard-customizer-at-a-glance')
						|| isActiveName('oxy-dashboard-customizer-recent-posts')
						|| isActiveName('oxy-dashboard-customizer-future-posts')
						|| isActiveName('oxy-dashboard-customizer-admin-link-wrapper')
					);"
			ng-click="switchTab('advanced', 'ee-grid-child')">
			<img src="<?php echo CT_FW_URI; ?>/toolbar/UI/oxygen-icons/advanced/layout.svg" title="EE Grid" alt="EE Grid" />
			<span>Grid Child Controls</span>
			<img src="<?php echo CT_FW_URI; ?>/toolbar/UI/oxygen-icons/advanced/open-section.svg">
		</div>

		<div class="ee-grid-child" ng-if="isShowTab('advanced', 'ee-grid-child')">

			<div class='oxygen-control-row'>
				<?php $oxygen_toolbar->simple_input_with_wrapper('grid-column-start','Grid Column Start'); ?>
			</div>
			<div class='oxygen-control-row'>
				<?php $oxygen_toolbar->simple_input_with_wrapper('grid-column-end','Grid Column End'); ?>
			</div>

			<div class='oxygen-control-row'>
				<?php $oxygen_toolbar->simple_input_with_wrapper('grid-row-start','Grid Row Start'); ?>
			</div>
			<div class='oxygen-control-row'>
				<?php $oxygen_toolbar->simple_input_with_wrapper('grid-row-end','Grid Row End'); ?>
			</div>

			<div class='oxygen-control-row'>
				<?php $oxygen_toolbar->simple_input_with_wrapper('grid-area','Grid Area'); ?>
			</div>

			<div class='oxygen-control-row'>
				<div class='oxygen-control-wrapper'>
					<label class='oxygen-control-label'>Justify Self</label>
					<div class='oxygen-control'>
						<div class='oxygen-button-list'>

							<?php $oxygen_toolbar->button_list_button('justify-self','start'); ?>
							<?php $oxygen_toolbar->button_list_button('justify-self','center'); ?>
							<?php $oxygen_toolbar->button_list_button('justify-self','end'); ?>
							<?php $oxygen_toolbar->button_list_button('justify-self','stretch'); ?>

						</div>
					</div>
				</div>
			</div>

			<div class='oxygen-control-row'>
				<div class='oxygen-control-wrapper'>
					<label class='oxygen-control-label'>Align Self</label>
					<div class='oxygen-control'>
						<div class='oxygen-button-list'>

							<?php $oxygen_toolbar->button_list_button('align-self','start'); ?>
							<?php $oxygen_toolbar->button_list_button('align-self','center'); ?>
							<?php $oxygen_toolbar->button_list_button('align-self','end'); ?>
							<?php $oxygen_toolbar->button_list_button('align-self','stretch'); ?>

						</div>
					</div>
				</div>
			</div>

		</div>
		<?php
	}


	/**
	 * Add grid styles
	 */
	private function _add_grid_styles() {

		$grid_styles = [
			'grid-template-columns',
			'grid-template-rows',
			'grid-template-areas',
			'column-gap',
			'row-gap',
			'justify-items',
			'grid-auto-flow',
			'grid-column-start',
			'grid-column-end',
			'grid-row-start',
			'grid-row-end',
			'grid-area',
			'justify-self',
			'align-self'
		];

		foreach ( $grid_styles as $style )
			array_push( CT_Component::$options_white_list, $style );

	}
	
}// End of class
