<?php /*
Template Name:新規会員登録フォーム
*/ ?>


<?php get_header(); ?>

<main>
	<section id="library-section-title">
    <h2>新規会員登録</h2>
  </section>

	<div class="container">

		<?php
      // 固定ページ本文を表示
      while ( have_posts() ) :
        the_post();
        the_content();
      endwhile;
    ?>
		
	</div>
		
	
</main>

<?php get_footer(); ?>