<?php /*
Template Name:お問い合わせ
*/ ?>


<?php get_header(); ?>

<main>
	<section id="library-section-title">
    <h2>お問い合わせ</h2>
  </section>

	<div class="container">
		<section id="contact-message">
			<h3>お気軽にご連絡ください。</h3>
			<p>
				ご相談、サービスに関するご不明点は、下記フォームに必要事項をご記入の上、
				<span>お問い合わせください。3営業日以内を目安に担当者よりご連絡いたします。</span>
			</p>
		</section>

		<section id="contact-form">			
			<?php if(have_posts()): ?>
	  	<?php while(have_posts()):the_post(); ?>
					<?php the_content(); ?>
		  <?php endwhile;endif; ?>
		</section>

	</div>
		
	
</main>

<?php get_footer(); ?>