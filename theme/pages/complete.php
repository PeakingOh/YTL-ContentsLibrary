<?php /*
Template Name:お問い合わせ-完了
*/ ?>


<?php get_header(); ?>

<main>
	<section id="library-section-title">
    <h2>お問い合わせ</h2>
  </section>

	<div class="container">
    <section id="contact-complete-message">
      <h3>送信が完了しました</h3>

      <div class="text">
        <p>
          お問い合わせいただき、ありがとうございます。<br>
          送信内容を確認のうえ、担当者より3営業日以内にご連絡いたします。
        </p>
        <p>
          ご不明な点がある場合は、<a href="<?php echo home_url(); ?>/contact/">再度お問い合わせ</a>ください。
        </p>
      </div>
    </section>

	</div>
		
	
</main>

<?php get_footer(); ?>