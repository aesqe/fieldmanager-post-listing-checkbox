<?php

class Fieldmanager_Postlist_Checkbox extends Fieldmanager_Field {

	public $checked_value = TRUE;
	public $unchecked_value = FALSE;

	public function form_element ( $post_id = NULL )	{
		if( ! $post_id ) {
			return false;
		}

		$post_id = esc_attr( $post_id );
		$value = (bool) get_post_meta($post_id, $this->name, true);

		return sprintf(
			'<input type="hidden" name="%1$s" value="%6$s" />'
			. '<input class="fm-element fieldmanager-postslist-checkbox-action" '
			. 'data-key="%1$s" data-post_id="%7$s"'
			. 'type="checkbox" name="%1$s" value="%2$s" %3$s %4$s id="%5$s" />',
			esc_attr( $this->get_form_name() ),
			esc_attr( (string) $this->checked_value ),
			$this->get_element_attributes(),
			( $value == $this->checked_value ) ? 'checked="checked"' : "",
			esc_attr( $this->get_element_id() ),
			$this->unchecked_value,
			$post_id
		);
	}

	public function add_column_checkbox( $title, $post_types, $position = 'normal' ) {
		return new Fieldmanager_Context_PostList( $title, $post_types, $position, $this );
	}
}

class Fieldmanager_Context_PostList extends Fieldmanager_Context {

	public function __construct ( $title, $post_types, $position = 'last', $fm = Null ) {
		if ( ! is_array( $post_types ) ) {
			$post_types = array( $post_types );
		}

		$this->title = $title;
		// $this->post_types = $post_types; // TODO
		// $this->position = $position; // TODO
		$this->fm = $fm;

		add_action( 'admin_enqueue_scripts', 
			array( $this, 'admin_enqueue_scripts') );
		add_action( 'wp_ajax_fieldmanager_postlist_checkbox-' . $this->fm->name, 
			array($this, 'ajax_postlist_checkbox_update') );
		add_action( 'manage_posts_custom_column', 
			array( $this, 'manage_posts_custom_column' ), 100, 2 );
		add_filter( 'manage_posts_columns', 
			array($this, 'manage_posts_columns'), 100, 2 );
	}

	function admin_enqueue_scripts () {
		wp_enqueue_script(
			'fieldmanager_postlist_checkbox-admin', 
			plugin_dir_url(__FILE__) . 'fieldmanager-postlist-checkbox.js', 
			array('jquery'), '1.0', true
		);
	}

	function manage_posts_columns ( $columns, $post_type ) {
		$columns[$this->fm->name] = $this->title;
		return $columns;
	}

	function manage_posts_custom_column ( $column_name, $post_id ) {
		if( $this->fm->name == $column_name ) {
			echo $this->fm->form_element($post_id);
		}
	}

	function ajax_postlist_checkbox_update () {
		if( empty($_POST) ) {
			$_POST = $_REQUEST;
		}
		
		if( ! isset($_POST['post_id']) ) {
			return false;
		}

		$post_id = (int) $_POST['post_id'];
		$meta_value = (int) $_POST[$this->fm->name];
		$update = update_post_meta($post_id, $this->fm->name, $meta_value);

		if( $update !== false ) {
			wp_send_json_success();
		} else {
			wp_send_json_error($update);
		}
	}
}
