<?php
/**
 * Checkout billing information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
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

		<h4 class="hb-heading"><span><?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></span></h4>

	<?php else : ?>

		<h4 class="hb-heading"><span><?php _e( 'Billing Address', 'woocommerce' ); ?></span></h4>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<div class="woocommerce-billing-fields__field-wrapper">
		<?php foreach ( $checkout->get_checkout_fields( 'billing' ) as $key => $field ) : ?>
			<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
		<?php endforeach; ?>
	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>

	<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
		<div class="woocommerce-account-fields">
			<?php if ( ! $checkout->is_registration_required() ) : ?>

				<p class="form-row form-row-wide create-account" style="display: none">
					<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
						<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ) ?> type="checkbox" name="createaccount" value="1" /> <span><?php _e( 'Create an account?', 'woocommerce' ); ?></span>
					</label>
				</p>

			<?php endif; ?>

			<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

			<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

				<div class="create-account">
					<?php foreach ( $checkout->get_checkout_fields( 'account' )  as $key => $field ) : ?>
						<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
					<?php endforeach; ?>
					<div class="clear"></div>
				</div>

			<?php endif; ?>

			<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
		</div>
	<?php endif; ?>
	
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
				'9:00 AM - 1.00 PM' => '9:00 AM - 1.00 PM',
				'1:00 PM - 6.00 PM' => '1:00 PM - 6.00 PM',
				'6:00 PM - 9.00 PM' => '6:00 PM - 9.00 PM',
			);


			$field_arr1=array('type'=>'select','required'=>true,'label'=>'Preferred Time','options'=>$preferred_time_arr,'class'=>array('form-row-last'),'priority'=>120);

			woocommerce_form_field( 'preferred_time', $field_arr1, '' ); ?>


	<!-- </p> -->
</div>
