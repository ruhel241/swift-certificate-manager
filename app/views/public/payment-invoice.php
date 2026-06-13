<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get invoice hash from query var.
 */
$swiftcm_hash = sanitize_text_field(
	get_query_var( 'hash', '' )
);

if ( empty( $swiftcm_hash ) ) {
	return;
}

/**
 * Get payment info by hash.
 */
$swiftcm_payment_info = ( new \SwiftCertificateManager\Models\SwiftCMPayment )->getHash( $swiftcm_hash );

?>

<?php if ( $swiftcm_payment_info ) : ?>

	<?php
	    $swiftcm_certificate_info = ( new \SwiftCertificateManager\Models\SwiftCMGenerate())->getInfo( $swiftcm_payment_info->request_id );
	?>

	<div class="swiftcm-invoice-wrrapper">
		<div class="invoice-header">
			<div class="invoice-logo">
				<img
					src="<?php echo esc_url( SWIFTCM_PLUGIN_URL . 'assets/admin/images/logo.png' ); ?>"
					alt="<?php echo esc_attr__( 'Swift Certificate Manager', 'swift-certificate-manager' ); ?>"
				>
			</div>

			<div class="invoice-title">
				<h1><?php echo esc_html__( 'INVOICE', 'swift-certificate-manager' ); ?></h1>
				<div class="invoice-number">
					<?php
					echo esc_html(
						'#INV-' . gmdate( 'Y' ) . '-000' . $swiftcm_payment_info->id
					);
					?>
				</div>
			</div>
		</div>

		<div class="invoice-details">
			<div class="invoice-details-col client-details">
				<div class="info-block">
					<h3><?php echo esc_html__( 'Billed To', 'swift-certificate-manager' ); ?></h3>
					<p>
						<?php echo esc_html( $swiftcm_certificate_info->student_name ); ?>
					</p>
					<p>
						<?php echo esc_html( $swiftcm_certificate_info->student_email ); ?>
					</p>
                    <p>
						<?php
						echo esc_html__(
							'Course Name:',
							'swift-certificate-manager'
						);
						?>
						<?php echo esc_html( $swiftcm_certificate_info->course_name ); ?>
					</p>
				</div>
			</div>

			<div class="invoice-details-col company-details">
				<div class="info-block">
					<h3><?php echo esc_html__( 'From', 'swift-certificate-manager' ); ?></h3>
					<p>
						<?php bloginfo( 'name' ); ?>
					</p>
				</div>
				<div class="info-block">
					<h3>
						<?php echo esc_html__( 'Invoice Details', 'swift-certificate-manager' ); ?>
					</h3>
					<p>
						<strong>
							<?php echo esc_html__( 'Invoice Date:', 'swift-certificate-manager' ); ?>
						</strong>

						<?php
						echo esc_html(
							gmdate(
								'F j, Y',
								strtotime( $swiftcm_payment_info->created_at )
							)
						);
						?>
					</p>
					<p>
						<strong>
							<?php echo esc_html__( 'Status:', 'swift-certificate-manager' ); ?>
						</strong>
						<span class="status-badge status-paid">
							<?php echo esc_html( $swiftcm_payment_info->payment_status ); ?>
						</span>
					</p>
				</div>
			</div>
		</div>

		<div class="payment-info">
			<h3>
				<?php echo esc_html__( 'Payment Information', 'swift-certificate-manager' ); ?>
			</h3>

			<div class="payment-method">
				<div>
					<strong>
						<?php echo esc_html__( 'Payment Method:', 'swift-certificate-manager' ); ?>
					</strong>
				</div>

				<div>
					<?php echo esc_html( $swiftcm_payment_info->payment_method ); ?>

					(<?php echo esc_html( $swiftcm_payment_info->card_brand ); ?>
					ending in
					<?php echo esc_html( $swiftcm_payment_info->card_last_4 ); ?>
					)
				</div>
			</div>

			<div class="payment-method">
				<div>
					<strong>
						<?php echo esc_html__( 'Transaction ID:', 'swift-certificate-manager' ); ?>
					</strong>
				</div>
				<div>
					<?php echo esc_html( $swiftcm_payment_info->charge_id ); ?>
				</div>

			</div>

			<div class="payment-method">
				<div>
					<strong>
						<?php echo esc_html__( 'Payment Date:', 'swift-certificate-manager' ); ?>
					</strong>
				</div>

				<div>
					<?php
					echo esc_html(
						gmdate(
							'F j, Y',
							strtotime( $swiftcm_payment_info->created_at )
						)
					);
					?>
				</div>
			</div>
		</div>

		<div class="footer">
			<p>
				<?php
				echo esc_html__('Thank you for purchasing our certificate.', 'swift-certificate-manager');
				?>
			</p>
			<p>
				<?php
					echo esc_html__( 'If you have any questions about this invoice, please contact us at info@swiftcertificate.com', 'swift-certificate-manager');
				?>
			</p>

			<p>
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
				<?php echo esc_html__( 'SWIFT CERTIFICATE', 'swift-certificate-manager' ); ?>

				<br>

				<?php
				echo esc_html__( 'All rights reserved.', 'swift-certificate-manager' );
				?>
			</p>
		</div>
	</div>
<?php else : ?>
	<div
		class="swiftcm-error-message"
		style="margin-top:30px;background:#fff;width:100%;padding:50px;box-shadow:0 5px 25px rgba(0,0,0,0.1);border-radius:5px;"
	>
		<h2>
			<?php echo esc_html__( 'Invoice Not Found', 'swift-certificate-manager' ); ?>
		</h2>
		<p>
			<?php
			echo esc_html__(
				'The requested payment information could not be found.',
				'swift-certificate-manager'
			);
			?>
		</p>
	</div>
<?php endif; ?>