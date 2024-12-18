<?php

namespace MetForm\Base;

defined('ABSPATH') || exit;

class Shortcode
{

	use \MetForm\Traits\Singleton;


	public function __construct()
	{
		

		add_shortcode('metform', [$this, 'render_form']);
		add_shortcode('mf_thankyou', [$this, 'render_thank_you_page']);
		add_shortcode('mf_first_name', [$this, 'render_first_name']);
		add_shortcode('mf_last_name', [$this, 'render_last_name']);
		add_shortcode('mf_payment_status', [$this, 'render_payment_status']);
		add_shortcode('mf_transaction_id', [$this, 'render_transaction_id']);
		add_shortcode('mf',[$this,'render_mf_field']);
	}

	public function enqueue_form_assets(){
		wp_enqueue_style('metform-ui');
		wp_enqueue_style('metform-style');
		wp_enqueue_script('htm');
		wp_enqueue_script('metform-app');
	}


	public function render_form($atts)
	{
		$this->enqueue_form_assets();

		if( isset($atts['form_id']) ){
			$atts['form_id'] = absint(sanitize_text_field($atts['form_id']));
		}
		
		$attributes = shortcode_atts(array(
			'form_id' => 'test',
		), $atts);

		return '<div class="mf-form-shortcode">' . \MetForm\Utils\Util::render_form_content($attributes['form_id'], $attributes['form_id']) . '</div>';
	}

	public function render_thank_you_page($atts)
	{
		if($GLOBALS['pagenow'] == 'post.php'){
			return;
		}
		global $post;
		
		$this->enqueue_form_assets();

		$a = shortcode_atts(array(
			'fname' => '',
			'lname' => '',
		), $atts);

		//phpcs:ignore WordPress.Security.NonceVerification -- Nonce can't be added, Its a callback function of 'add_shortcode'
		$post_id = isset($_GET['id']) ? sanitize_text_field(wp_unslash($_GET['id'])) : '';
		// ##check transient id and session hashed token 
		if(empty($post_id)){
			return ;
		}
		$token_str = $post_id.get_current_user_id();
		$access_status_check = $this->transient_and_session_checker($token_str, $post_id);
		if(!$access_status_check){
			return; // return nothing or below invalid access 
			// return "invalid access";
		}
		
		$postMeta = get_post_meta(
			$post_id,
			'metform_entries__form_data',
			true
		);
		$first_name = !empty($postMeta[$a['fname']]) ? $postMeta[$a['fname']] : '';

		$payment_status = get_post_meta(
			$post_id,
			'metform_entries__payment_status',
			true
		);

		$tnx_id = get_post_meta(
			$post_id,
			'metform_entries__payment_trans',
			true
		);
	
		$msg = '';

		if ($payment_status == 'paid') {
			$msg = $first_name . esc_html__(' Thank you for your payment.', 'metform'). '<br>' . esc_html__(' Your transcation ID : ', 'metform' ). $tnx_id;
		} else {
			$msg = esc_html__('Thank you . Your payment status : ', 'metform') . $payment_status;
		}
		
		return $msg;
	}

	public function render_mf_field($atts){
		$this->enqueue_form_assets();

		$a = shortcode_atts(array(
			'field' => ''
		),$atts);

		//phpcs:ignore WordPress.Security.NonceVerification -- Nonce can't be added, Its a callback function of 'add_shortcode'
		$post_id = isset($_GET['id']) ? sanitize_text_field(wp_unslash($_GET['id'])) : '';
		// ##check transient id and session hashed token 
		if(empty($post_id)){
			return ;
		}
		$token_str = $post_id.get_current_user_id();
		$access_status_check = $this->transient_and_session_checker($token_str, $post_id);
	
		if(!$access_status_check){
			return; // return nothing or below invalid access 
			// return "invalid access";
		}

		$field = get_post_meta(
			$post_id,
			'metform_entries__form_data',
			true
		);
		
		if(!is_array($field)){
			return esc_html__("No entry found.", 'metform')."<br>"; // br added if one page have multiple shortcode which is not available
		}
		 
		if(!key_exists($a['field'], $field)){
			return  $a['field'] . esc_html__("No entry found.", 'metform').'<br>';
		}
		
		$field = get_post_meta($post_id, 'metform_entries__form_data',true) [$a['field']];

		return is_array($field) ? map_deep(implode(" , ",$field), 'esc_html') : esc_html($field);
	}

	public function render_first_name($atts)
	{
		$this->enqueue_form_assets();
		//phpcs:ignore WordPress.Security.NonceVerification -- Nonce can't be added, Its a callback function of 'add_shortcode'
		$post_id = isset($_GET['id']) ? sanitize_text_field(wp_unslash($_GET['id'])) : '';
		// ##check transient id and session hashed token 
		if(empty($post_id)){
			return ;
		}
		$token_str = $post_id.get_current_user_id();
		$access_status_check = $this->transient_and_session_checker($token_str, $post_id);
		if(!$access_status_check){
			return; // return nothing or below invalid access 
			// return "invalid access";
		}

		$first_name = get_post_meta(
			$post_id,
			'metform_entries__form_data',
			true
		)['mf-listing-fname'];
		return esc_html($first_name);
	}

	public function render_last_name($atts)
	{
		$this->enqueue_form_assets();
		//phpcs:ignore WordPress.Security.NonceVerification -- Nonce can't be added, Its a callback function of 'add_shortcode'
		$post_id = isset($_GET['id']) ? sanitize_text_field(wp_unslash($_GET['id'])) : '';
		// ##check transient id and session hashed token 
		if(empty($post_id)){
			return ;
		}
		$token_str = $post_id.get_current_user_id();
		$access_status_check = $this->transient_and_session_checker($token_str, $post_id);
		if(!$access_status_check){
			return; // return nothing or below invalid access 
			// return "invalid access";
		}

		$last_name = get_post_meta(
			$post_id,
			'metform_entries__form_data',
			true
		)['mf-listing-lname'];
		return esc_html($last_name);
	}

	public function render_payment_status($atts)
	{
		$this->enqueue_form_assets();
		//phpcs:ignore WordPress.Security.NonceVerification -- Nonce can't be added, Its a callback function of 'add_shortcode'
		$post_id = isset($_GET['id']) ? sanitize_text_field(wp_unslash($_GET['id'])) : '';
		// ##check transient id and session hashed token 
		if(empty($post_id)){
			return ;
		}
		$token_str = $post_id.get_current_user_id();
		$access_status_check = $this->transient_and_session_checker($token_str, $post_id);
		if(!$access_status_check){
			return; // return nothing or below invalid access 
			// return "invalid access";
		}

		$payment_status = get_post_meta(
			$post_id,
			'metform_entries__payment_status',
			true
		);
		return $payment_status;
	}

	public function render_transaction_id($atts)
	{
		$this->enqueue_form_assets();
		//phpcs:ignore WordPress.Security.NonceVerification -- Nonce can't be added, Its a callback function of 'add_shortcode'
		$post_id = isset($_GET['id']) ? sanitize_text_field(wp_unslash($_GET['id'])) : '';
		// ##check transient id and session hashed token 
		if(empty($post_id)){
			return ;
		}
		$token_str = $post_id.get_current_user_id();
		$access_status_check = $this->transient_and_session_checker($token_str, $post_id);
		if(!$access_status_check){
			return; // return nothing or below invalid access 
			// return "invalid access";
		}

		$tnx_id = get_post_meta(
			$post_id,
			'metform_entries__payment_trans',
			true
		);

		return $tnx_id;
	}

	public function transient_and_session_checker($token_str, $post_id)
	{
		$has_transient_mf_entry_id = get_transient( 'transient_mf_form_data_entry_id_'.$post_id );
		$status = true; 
		
		// if transient expire return false 
		if(empty($has_transient_mf_entry_id)){
			$status = false;
		}
		// if transient mismatche return false
		if( $has_transient_mf_entry_id != $post_id ){
			$status = false;
		}
		// if  token empty return false
		if(!isset($_COOKIE['bWYtY29va2ll'])) {
			$status = false;
		}
		// token not matched return false 
		if((isset($_COOKIE['bWYtY29va2ll']) && !password_verify($token_str, sanitize_text_field(wp_unslash($_COOKIE['bWYtY29va2ll']))))) {
			$status = false;
		}
		
		return $status;
	}
}
