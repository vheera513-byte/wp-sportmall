<?php
/**
 * Template Name: تماس با ما
 * Template Post Type: page
 *
 * @package Sportmall
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	get_template_part( 'template-parts/header/page-hero', null, array(
		'title'    => get_the_title(),
		'eyebrow'  => __( 'کنار تو، در هر قدم', 'sportmall' ),
		'subtitle' => has_excerpt() ? get_the_excerpt() : __( 'برای انتخاب بهتر، پیگیری سفارش یا هر پرسشی که داری، ما اینجاییم.', 'sportmall' ),
		'class'    => 'page-hero--contact',
	) );
	?>

	<main id="main-content" class="page-main shell">
		<div class="contact-layout">
			<div class="contact-copy">
				<div class="entry-content">
					<?php the_content(); ?>
				</div>

				<div class="contact-cards">
					<a class="contact-card" href="tel:+982112345678">
						<span class="contact-card-icon"><?php sportmall_the_icon( 'headphones' ); ?></span>
						<span>
							<small><?php esc_html_e( 'تلفن پشتیبانی', 'sportmall' ); ?></small>
							<strong dir="ltr">۰۲۱ ۱۲۳۴ ۵۶۷۸</strong>
							<em><?php esc_html_e( 'شنبه تا چهارشنبه، ۹ تا ۱۸', 'sportmall' ); ?></em>
						</span>
					</a>
					<a class="contact-card" href="mailto:hello@sportmall.example">
						<span class="contact-card-icon"><?php sportmall_the_icon( 'mail' ); ?></span>
						<span>
							<small><?php esc_html_e( 'ایمیل', 'sportmall' ); ?></small>
							<strong dir="ltr">hello@sportmall.example</strong>
							<em><?php esc_html_e( 'پاسخ در کمتر از یک روز کاری', 'sportmall' ); ?></em>
						</span>
					</a>
					<div class="contact-card">
						<span class="contact-card-icon"><?php sportmall_the_icon( 'pin' ); ?></span>
						<span>
							<small><?php esc_html_e( 'فروشگاه', 'sportmall' ); ?></small>
							<strong><?php esc_html_e( 'تهران، خیابان ولیعصر', 'sportmall' ); ?></strong>
							<em><?php esc_html_e( 'پلاک ۱۲۴، طبقهٔ همکف', 'sportmall' ); ?></em>
						</span>
					</div>
				</div>

				<div class="contact-links">
					<a class="text-link" href="<?php echo esc_url( home_url( '/shipping/' ) ); ?>"><?php esc_html_e( 'راهنمای ارسال سفارش', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
					<a class="text-link" href="<?php echo esc_url( home_url( '/returns/' ) ); ?>"><?php esc_html_e( 'بازگشت و تعویض', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
					<a class="text-link" href="<?php echo esc_url( home_url( '/size-guide/' ) ); ?>"><?php esc_html_e( 'راهنمای سایز', 'sportmall' ); ?><?php sportmall_the_icon( 'arrow' ); ?></a>
				</div>
			</div>

			<div class="contact-form-card">
				<p class="eyebrow"><?php esc_html_e( 'بنویس، ما می‌خوانیم', 'sportmall' ); ?></p>
				<h2><?php esc_html_e( 'چه کمکی می‌توانیم بکنیم؟', 'sportmall' ); ?></h2>

				<?php sportmall_contact_status(); ?>

				<form class="contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
					<input type="hidden" name="action" value="sportmall_contact">
					<?php wp_nonce_field( 'sportmall_contact', 'sportmall_contact_nonce' ); ?>

					<p class="contact-honeypot" aria-hidden="true">
						<label for="sm_website"><?php esc_html_e( 'این فیلد را خالی بگذار', 'sportmall' ); ?></label>
						<input type="text" id="sm_website" name="sm_website" tabindex="-1" autocomplete="off">
					</p>

					<div class="contact-fields">
						<label>
							<span><?php esc_html_e( 'نام و نام خانوادگی', 'sportmall' ); ?> <b>*</b></span>
							<input type="text" name="sm_name" required autocomplete="name" placeholder="<?php esc_attr_e( 'مثلاً سارا احمدی', 'sportmall' ); ?>">
						</label>
						<label>
							<span><?php esc_html_e( 'ایمیل', 'sportmall' ); ?> <b>*</b></span>
							<input type="email" name="sm_email" required autocomplete="email" dir="ltr" placeholder="you@example.com">
						</label>
						<label>
							<span><?php esc_html_e( 'شمارهٔ تماس', 'sportmall' ); ?></span>
							<input type="tel" name="sm_phone" autocomplete="tel" dir="ltr" placeholder="0912 000 0000">
						</label>
						<label>
							<span><?php esc_html_e( 'موضوع', 'sportmall' ); ?></span>
							<select name="sm_subject">
								<option value="order"><?php esc_html_e( 'پیگیری سفارش', 'sportmall' ); ?></option>
								<option value="size"><?php esc_html_e( 'راهنمای سایز', 'sportmall' ); ?></option>
								<option value="return"><?php esc_html_e( 'بازگشت یا تعویض', 'sportmall' ); ?></option>
								<option value="product"><?php esc_html_e( 'انتخاب محصول', 'sportmall' ); ?></option>
								<option value="other"><?php esc_html_e( 'سایر', 'sportmall' ); ?></option>
							</select>
						</label>
						<label class="contact-field-wide">
							<span><?php esc_html_e( 'شمارهٔ سفارش (اختیاری)', 'sportmall' ); ?></span>
							<input type="text" name="sm_order" dir="ltr" placeholder="SM-12345">
						</label>
						<label class="contact-field-wide">
							<span><?php esc_html_e( 'پیام تو', 'sportmall' ); ?> <b>*</b></span>
							<textarea name="sm_message" rows="6" required placeholder="<?php esc_attr_e( 'هر جزئیاتی که کمک می‌کند بهتر پاسخ بدهیم…', 'sportmall' ); ?>"></textarea>
						</label>
					</div>

					<div class="contact-submit">
						<button class="accent-button" type="submit" name="submit">
							<?php esc_html_e( 'ارسال پیام', 'sportmall' ); ?>
							<?php sportmall_the_icon( 'arrow' ); ?>
						</button>
						<small><?php esc_html_e( 'با ارسال این فرم، با سیاست حریم خصوصی ما موافقت می‌کنی.', 'sportmall' ); ?></small>
					</div>
				</form>
			</div>
		</div>
	</main>

	<?php
endwhile;

get_footer();
