<?php
/**
 * Adds custom meta box to WordPress post, page or custom post type.
 * @author Nazmul Ahsan <n.mukto@gmail.com>
*/
if( ! class_exists( 'IEBASE_Meta_Box' )  ) :
class IEBASE_Meta_Box {

	/**
	 * @var string|array $post_type post types to add meta box to.
	 */
	public $post_type;

	/**
	 * @var string $context side|normal|advanced location of the meta box.
	 */
	public $context;

	/**
	 * @var string $priority high|low position of the meta box.
	 */
	public $priority;

	/**
	 * @var string $hook_priority priority of triggering thie hook. Default is 10.
	 */
	public $hook_priority = 10;

	/**
	 * @var array $fields meta fields to be added.
	 */
	public $fields;

	/**
	 * @var string $meta_box_id meta box id.
	 */
	public $meta_box_id;

	/**
	 * @var string $label meta box label.
	 */
	public $label;

	function __construct( $args = null ){
		$this->meta_box_id 		= $args['meta_box_id'] ? : 'iebase_meta_box';
		$this->label 			= $args['label'] ? : 'IEBASE Metabox';
		$this->post_type 		= $args['post_type'] ? : 'post';
		$this->context 			= $args['context'] ? : 'normal';
		$this->priority 		= $args['priority'] ? : 'high';
		$this->hook_priority 	= $args['hook_priority'] ? : 10;
		$this->fields 			= $args['fields'] ? : array();

		self::hooks();
	}

	function enqueue_scripts() {
        wp_enqueue_media();
        wp_enqueue_script( 'jquery' );
    }

	public function hooks(){
		add_action( 'add_meta_boxes' , array( $this, 'add_meta_box' ), $this->hook_priority );
		add_action( 'save_post', array( $this, 'save_meta_fields' ), 1, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_head', array( $this, 'scripts' ) );
	}

	public function add_meta_box() {
		if( is_array( $this->post_type ) ){
			foreach ( $this->post_type as $post_type ) {
				add_meta_box( $this->meta_box_id, $this->label, array( $this, 'meta_fields_callback' ), $post_type, $this->context, $this->priority );
			}
		}
		else{
			add_meta_box( $this->meta_box_id, $this->label, array( $this, 'meta_fields_callback' ), $this->post_type, $this->context, $this->priority );
		}
	}

	public function meta_fields_callback() {
		global $post;

		echo '<input type="hidden" name="iebase_cmb_nonce" id="iebase_cmb_nonce" value="' .
		wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

		foreach ( $this->fields as $field ) {

			if ( $field['type'] == 'text' || $field['type'] == 'number' || $field['type'] == 'email' || $field['type'] == 'url' || $field['type'] == 'password' ) {
				echo $this->field_text( $field );
			}
			elseif( $field['type'] == 'textarea' ){
				echo $this->field_textarea( $field );
			}
			elseif( $field['type'] == 'radio' ){
				echo $this->field_radio( $field );
			}
			elseif( $field['type'] == 'checkbox' ){
				echo $this->field_checkbox( $field );
			}
			elseif( $field['type'] == 'file' ){
				echo $this->field_file( $field );
			}

			do_action( "iebase_meta_field-{$field['name']}", $field, $post->post_type );
		}


	}

	public function save_meta_fields( $post_id, $post ) {
		if (
			! isset( $_POST['iebase_cmb_nonce'] ) ||
			! wp_verify_nonce( $_POST['iebase_cmb_nonce'], plugin_basename( __FILE__ ) ) ||
			! current_user_can( 'edit_post', $post->ID ) ||
			$post->post_type == 'revision'
		) {
			return $post->ID;
		}

		foreach ( $this->fields as $field ){
			$key = $field['name'];
			$meta_values[$key] = $_POST[$key];
		}

		foreach ( $meta_values as $key => $value ) {
			$value = implode( ',', (array) $value );
			if( get_post_meta( $post->ID, $key, FALSE )) {
				update_post_meta( $post->ID, $key, $value );
			} else {
				add_post_meta( $post->ID, $key, $value );
			}
			if( ! $value ) delete_post_meta( $post->ID, $key );
		}

	}

	public function field_text( $field ){
		global $post;
		$field['default'] = ( isset( $field['default'] ) ) ? $field['default'] : '';
		$value = get_post_meta( $post->ID, $field['name'], true ) != '' ? esc_attr ( get_post_meta( $post->ID, $field['name'], true ) ) : $field['default'];
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'iebase-meta-field';
		$readonly  = isset( $field['readonly'] ) && ( $field['readonly'] == true ) ? " readonly" : "";
		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? " disabled" : "";

		$html	= sprintf( '<fieldset class="iebase-row" id="iebase_cmb_fieldset_%1$s">', $field['name'] );
		$html	.= sprintf( '<label class="iebase-label" for="iebase_cmb_%1$s">%2$s</label>', $field['name'], $field['label']);

		$html  .= sprintf( '<input type="%1$s" class="%2$s" id="iebase_cmb_%3$s" name="%3$s" value="%5$s" %6$s %7$s/>', $field['type'], $class, $field['name'], $field['name'], $value, $readonly, $disabled );

		$html	.= $this->field_description( $field );
		$html	.= '</fieldset>';
		return $html;
	}

	public function field_textarea( $field ){
		global $post;
		$value = get_post_meta( $post->ID, $field['name'], true ) != '' ? esc_attr (get_post_meta( $post->ID, $field['name'], true ) ) : $field['default'];
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'iebase-meta-field';
		$cols  = isset( $field['columns'] ) ? $field['columns'] : 24;
		$rows  = isset( $field['rows'] ) ? $field['rows'] : 5;
		$readonly  = isset( $field['readonly'] ) && ( $field['readonly'] == true ) ? " readonly" : "";
		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? " disabled" : "";

		$html	= sprintf( '<fieldset class="iebase-row" id="iebase_cmb_fieldset_%1$s">', $field['name'] );
		$html	.= sprintf( '<label class="iebase-label" for="iebase_cmb_%1$s">%2$s</label>', $field['name'], $field['label']);

		$html  .= sprintf( '<textarea rows="' . $rows . '" cols="' . $cols . '" class="%1$s-text" id="iebase_cmb_%2$s" name="%3$s" %4$s %5$s >%6$s</textarea>', $class, $field['name'], $field['name'], $readonly, $disabled, $value );

		$html .= $this->field_description( $field );
		$html	.= '</fieldset>';

		return $html;
	}

	public function field_radio( $field ){
		global $post;
		$value = get_post_meta( $post->ID, $field['name'], true ) != '' ? esc_attr (get_post_meta( $post->ID, $field['name'], true ) ) : $field['default'];
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'iebase-meta-field';
		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? " disabled" : "";

        $html	= sprintf( '<fieldset class="iebase-row" id="iebase_cmb_fieldset_%1$s">', $field['name'] );
        $html .= '<label class="iebase-label">'.$field['label'].'</label>';
        foreach ( $field['options'] as $key => $label ) {
            $html .= sprintf( '<label for="%1$s[%2$s]">', $field['name'], $key );

            $html .= sprintf( '<input type="radio" class="radio %1$s" id="%2$s[%3$s]" name="%2$s" value="%3$s" %4$s %5$s />', $class, $field['name'], $key, checked( $value, $key, false ), $disabled );

            $html .= sprintf( '%1$s</label>', $label );
        }

        $html .= $this->field_description( $field );
        $html .= '</fieldset>';

        return $html;
	}

	public function field_checkbox( $field ){
		global $post;
		$field['default'] = ( isset( $field['default'] ) ) ? $field['default'] : '';
		$value = get_post_meta( $post->ID, $field['name'], true ) != '' ? esc_attr (get_post_meta( $post->ID, $field['name'], true ) ) : $field['default'];
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'iebase-meta-field';
		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? " disabled" : "";

		$html	= sprintf( '<fieldset class="iebase-row" id="iebase_cmb_fieldset_%1$s">', $field['name'] );
		$html	.= sprintf( '<label class="iebase-label" for="iebase_cmb_%1$s">%2$s</label>', $field['name'], $field['label']);

		$html  .= sprintf( '<input type="checkbox" class="checkbox" id="iebase_cmb_%1$s" name="%1$s" value="on" %2$s %3$s />', $field['name'], checked( $value, 'on', false ), $disabled );

		$html .= $this->field_description( $field, true ) . '';
		$html	.= '</fieldset>';
		return $html;
	}

	public function field_file( $field ){
		global $post;
		$value = get_post_meta( $post->ID, $field['name'], true ) != '' ? esc_attr (get_post_meta( $post->ID, $field['name'], true ) ) : $field['default'];
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'iebase-meta-field';
		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? " disabled" : "";

        $id    = $field['name']  . '[' . $field['name'] . ']';
        $upload_button = isset( $field['upload_button'] ) ? $field['upload_button'] : __( 'Choose File' );
        $select_button = isset( $field['select_button'] ) ? $field['select_button'] : __( 'Select' );

        $html	= sprintf( '<fieldset class="iebase-row" id="iebase_cmb_fieldset_%1$s">', $field['name'] );
        $html	.= sprintf( '<label class="iebase-label" for="iebase_cmb_%1$s">%2$s</label>', $field['name'], $field['label']);
        $html  .= sprintf( '<input type="text" class="%1$s-text iebase-file" id="iebase_cmb_%2$s" name="%2$s" value="%3$s" %4$s />', $class, $field['name'], $value, $disabled );
        $html  .= '<input type="button" class="button iebase-browse" data-title="' . $field['label'] . '" data-select-text="' . $select_button . '" value="' . $upload_button . '" ' . $disabled . ' />';
        $html  .= $this->field_description( $field );
        $html	.= '</fieldset>';
        return $html;
	}

	public function field_description( $args ) {
        if ( ! empty( $args['desc'] ) ) {
        	if( isset( $args['desc_nop'] ) && $args['desc_nop'] ) {
        		$desc = sprintf( '<small class="iebase-small">%s</small>', $args['desc'] );
        	} else{
        		$desc = sprintf( '<p class="description">%s</p>', $args['desc'] );
        	}
        } else {
            $desc = '';
        }

        return $desc;
    }

    function scripts() {
        ?>
        <script>
            jQuery(document).ready(function($) {
                //color picker
                //$('.wp-color-picker-field').wpColorPicker();

                // media uploader
                $('.iebase-browse').on('click', function (event) {
                    event.preventDefault();

                    var self = $(this);

                    var file_frame = wp.media.frames.file_frame = wp.media({
                        title: self.data('title'),
                        button: {
                            text: self.data('select-text'),
                        },
                        multiple: false
                    });

                    file_frame.on('select', function () {
                        attachment = file_frame.state().get('selection').first().toJSON();

                        self.prev('.iebase-file').val(attachment.url);
                        $('.supports-drag-drop').hide()
                    });

                    file_frame.open();
                });

				/*jQuery('#iebase_post_link').addClass('hidden');
                    jQuery('input#post-format-link').click(function () {
                    jQuery('#iebase_post_link').fadeToggle(400);
                });

                if (jQuery('input#post-format-link:checked').val() !== undefined) {
                    //jQuery('#iebase_post_link').show();
					jQuery('#iebase_post_link').style.display = "block"
                }*/
				jQuery(document).ready(function () {
                    jQuery("#iebase_post_link").addClass("hidden");

                    jQuery("input#post-format-link").change(function () {

                        if (jQuery(this).is(':checked')) {
                            jQuery("#iebase_post_link").removeClass("hidden");
			                jQuery("#iebase_download_link").addClass("hidden");
                        }
                    });

	                jQuery("input#post-format-0").change(function () {

                        if (jQuery(this).is(':checked')) {
	                        jQuery("#iebase_post_link").addClass("hidden");
	                        jQuery("#iebase_download_link").removeClass("hidden");
                        }
                    });

                });

        });

        </script>

        <style type="text/css">
            /* version 3.8 fix */
            .form-table th { padding: 20px 10px; }
            .iebase-row { border-bottom: 1px solid #ebebeb; padding: 8px 4px; }
            .iebase-row:last-child { border-bottom: 0px;}
            .iebase-row .iebase-label {display: inline-block; vertical-align: top; width: 200px; font-size: 15px; line-height: 24px;}
            .iebase-row .iebase-browse { width: 96px;}
            .iebase-row .iebase-file { width: calc( 100% - 110px ); margin-right: 4px; line-height: 20px;}
            #postbox-container-1 .iebase-meta-field, #postbox-container-1 .iebase-meta-field-text {width: 100%;}
            #postbox-container-2 .iebase-meta-field, #postbox-container-2 .iebase-meta-field-text {width: 74%;}
			#postbox-container-2 .radio.iebase-meta-field{width:auto;}
            #postbox-container-1 .iebase-meta-field-text.iebase-file { width: calc(100% - 101px) }
            #postbox-container-2 .iebase-meta-field-text.iebase-file { width: calc(74% - 101px) }
            #wpbody-content .metabox-holder { padding-top: 5px; }
        </style>
        <?php
    }
}
endif;

if ( ! function_exists( 'iebase_meta_box' ) ) {
	function iebase_meta_box( $args ){
		return new \IEBASE_Meta_Box( $args );
	}
}