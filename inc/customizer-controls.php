<?php
/**
 * Customizer Custom Controls
 *
 */
if ( class_exists( 'WP_Customize_Control' ) ) {

    /**
	 * Simple Notice Custom Control
	 */
	class Simple_Notice_Custom_Control extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'simple_notice';
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			$allowed_html = array(
				'a' => array(
					'href' => array(),
					'title' => array(),
					'class' => array(),
					'target' => array(),
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
				'i' => array(
					'class' => array()
				),
				'span' => array(
					'class' => array(),
				),
				'code' => array(),
			);
		?>
			<div class="simple-notice-custom-control">
				<?php if( !empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo wp_kses( $this->description, $allowed_html ); ?></span>
				<?php } ?>
			</div>
		<?php
		}
    }

    /**
	 * Toggle Switch Custom Control
	 */
	class Toggle_Switch_Custom_control extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'toggle_switch';
		/**
		 * Enqueue our scripts and styles
		 */
		/*public function enqueue(){
			wp_enqueue_style( 'skyrocket-custom-controls-css', $this->get_skyrocket_resource_url() . 'css/customizer.css', array(), '1.0', 'all' );
		}*/
		/**
		 * Render the control in the customizer
		 */
		public function render_content(){
		?>
			<div class="toggle-switch-control">
				<div class="toggle-switch">
					<input type="checkbox" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" class="toggle-switch-checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?>>
					<label class="toggle-switch-label" for="<?php echo esc_attr( $this->id ); ?>">
						<span class="toggle-switch-inner"></span>
						<span class="toggle-switch-switch"></span>
					</label>
				</div>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
			</div>
		<?php
		}
	}
    
    /**
     * Enqueue the stylesheet.
     */
    function iebase_enqueue_customizer_stylesheet() {
	   wp_register_style( 'iebase-customizer-css', get_template_directory_uri() . '/assets/css/customizer.css', NULL, NULL, 'all' );
	   wp_enqueue_style( 'iebase-customizer-css' );
    }
    add_action( 'customize_controls_print_styles', 'iebase_enqueue_customizer_stylesheet' );

    /**
	 * Switch sanitization
	 *
	 * @param  string		Switch value
	 * @return integer	Sanitized value
	 */
	if ( ! function_exists( 'iebase_switch_sanitization' ) ) {
		function iebase_switch_sanitization( $input ) {
			if ( true === $input ) {
				return 1;
			} else {
				return 0;
			}
		}
    }
    
    /**
     * radio/select buttons sanitization
     */
    function iebase_radio_select_sanitize( $input, $setting ) {
        $input = sanitize_key( $input );
        $choices = $setting->manager->get_control( $setting->id )->choices;
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
    }

    /** 
     * checkbox sanitization
     */
    function iebase_checkbox_sanitize( $input ) {
        if ( $input == 1 ) {
            return 1;
        } else {
            return '';
        }
    }

    /**
	 * Radio Button and Select sanitization
	 */
	if ( ! function_exists( 'iebase_radio_sanitization' ) ) {
		function iebase_radio_sanitization( $input, $setting ) {
			//get the list of possible radio box or select options
		 $choices = $setting->manager->get_control( $setting->id )->choices;

			if ( array_key_exists( $input, $choices ) ) {
				return $input;
			} else {
				return $setting->default;
			}
		}
    }
  
    /**
     * checkbox sanitization
     */ 
    if ( ! function_exists( 'iebase_sanitize_checkbox' ) ) {
        function iebase_sanitize_checkbox( $input ) {
        return ( ( isset( $input ) && true == $input ) ? true : false );
        }
    }

    /**
     * Sanitizes Fonts
     */
    if ( ! function_exists( 'iebase_sanitize_fonts' ) ) {
        function iebase_sanitize_fonts( $input ) {
            $valid = array(
                'Georgia,Times,"Times New Roman",serif' => 'Serif',
                '-apple-system, BlinkMacSystemFont, "Segoe UI", Ubuntu, "Helvetica Neue", sans-serif' => 'Sans Serif',
                '-apple-system, BlinkMacSystemFont, "Microsoft YaHei", Helvetica, Arial, sans-serif' => 'Microsoft YaHei',
                'Helvetica, Arial, sans-serif' => 'Helvetica',
                '-apple-system, BlinkMacSystemFont, "Noto Sans", Helvetica, Arial, sans-serif' => 'Noto Sans',
                '"Helvetica Neue", Helvetica, Roboto, Arial, sans-serif'=> 'Roboto',
                'Arial, sans-serif' => 'Arial',
                'Trebuchet MS, Helvetica, sans-serif' => 'Trebuchet MS',
                'MS Sans Serif, Geneva, sans-serif' => 'MS Sans Serif',
                'Arial, sans-serif' => 'Arial',
                '"Avant Garde", sans-serif' => 'Avant Garde',
                'Cambria, Georgia, serif' => 'Cambria',
                'tahoma,arial,\5b8b\4f53,sans-serif' =>'SimSun',
                '-apple-system, BlinkMacSystemFont, "Lato", Helvetica, Arial, sans-serif' => 'Lato',
            );
        if ( array_key_exists( $input, $valid ) ) {
            return $input;
            } else {
            return '';
           }
        }
    }


}