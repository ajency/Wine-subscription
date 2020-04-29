<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>
		
<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>	
	<div class="woocommerce-account-fields">	
		<?php if ( ! $checkout->is_registration_required() ) : ?>	
			<p class="form-row form-row-wide create-account">	
				<div class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox" id="createaccount_radio" onchange="switch_checkbox()">	
					<label><input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" type="radio" id="createaccount_radio_no" name="createaccount_radio" <?php checked( ( true !== $checkout->get_value( 'createaccount' ) && ( true !== apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ) ?> value="no"/>	
					<span><?php _e( 'Checkout As Guest', 'woocommerce' ); ?></span></label><br>	
					<label><input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" type="radio" id="createaccount_radio_yes" name="createaccount_radio" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ) ?> value="yes"/>	
					<span><?php _e( 'Register with us for future convenience and offers', 'woocommerce' ); ?></span></label><br>	
				</div>	
			</p>	
		<?php endif; ?>	
	</div>	
<?php endif; ?>

<div class="woocommerce-billing-fields">
	<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h4 class="hb-heading"><span><?php esc_html_e( 'Billing &amp; Shipping', 'woocommerce' ); ?>?></span></h4>

	<?php else : ?>

		<h4 class="hb-heading"><span><?php esc_html_e( 'Billing Address', 'woocommerce' ); ?></h4>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<div class="woocommerce-billing-fields__field-wrapper">
		<?php
		$fields = $checkout->get_checkout_fields( 'billing' );

		foreach ( $fields as $key => $field ) {
			woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
		}
		?>
	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
</div>
<br><br>	
<div class="delivery-slot woocommerce-shipping-fields">	
	<h4 class="hb-heading flex-row"><span>Preferred Delivery Slot</span><p class="delivery-condition">(Order must be placed by 5pm, for next day delivery.)</p></h4>	
	<!-- <p class="form-row form-row-first"> -->	
	<!-- 	<label>Preferred Day</label>	
		 <input type='text' id='preferred_date' name="preferred_date" style="padding-bottom: 5px !important;" readonly="readonly" /> -->	
			<?php $field_arr=array('required'=>true,'label'=>'Preferred Day','custom_attributes'=>array('readonly'=>'readonly'),'class'=>array('form-row-first'),'priority'=>110);	
			woocommerce_form_field( 'preferred_date', $field_arr, '' ); ?>	
	<!-- </p> -->	
	<!-- <p class="form-row form-row-last"> -->	
		<!-- 		<label>Preferred Time</label>	
		<select id="preferred_time" name="preferred_time">	
			<option value ="">Select</option>	
			<option value ="9:00 AM - 1.00 PM">9:00 AM - 1.00 PM</option>	
			<option value ="1:00 PM - 6.00 PM">1:00 PM - 6.00 PM</option>	
			<option value ="6:00 PM - 9.00 PM">6:00 PM - 9.00 PM</option>	
		</select> -->	
			<?php 	
			$preferred_time_arr=array(	
				'' => 'Select',	
				//'9:00 AM - 1.00 PM' => '9:00 AM - 1.00 PM',	
				//'1:00 PM - 6.00 PM' => '1:00 PM - 6.00 PM',	
				'12:00 PM - 3.00 PM' => '12:00 PM - 3.00 PM',	
				'3:00 PM - 6.00 PM' => '3:00 PM - 6.00 PM',	
				'6:00 PM - 9.00 PM' => '6:00 PM - 9.00 PM',	
			);	
			$field_arr1=array('type'=>'select','required'=>true,'label'=>'Preferred Time','options'=>$preferred_time_arr,'class'=>array('form-row-last'),'priority'=>120);	
			woocommerce_form_field( 'preferred_time', $field_arr1, '' ); ?>	
	<!-- </p> -->	
</div>

