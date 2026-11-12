<?php get_header(); ?>

<main>
  <section id="library-section-title">
    <h2>お知らせ</h2>
  </section>

  <div class="container">
    <?php if(have_posts()): ?>
  		<ul class="article_list">
  			<?php while(have_posts()):the_post(); ?>
  			<?php
  				$cat = get_the_category();
  				$cat = $cat[0];
  			?>
  			
  			<li>
  				<a href="<?php the_permalink(); ?>">
  					<div class="news-contents">
  						<div class="label <?php echo $cat->category_nicename; ?>"><?php echo $cat->cat_name; ?></div>
  						<time><?php the_time("Y.m.d"); ?></time>
  						<h3><?php the_title(); ?></h3>
							<div class="excerpt">
								<?php 
								$excerpt = get_the_excerpt();
								echo wp_trim_words($excerpt, 50, '…'); // 20単語で省略
								?>
							</div>
  						<span class="readmore">続きを読む</span>
  					</div>
  				</a>
  			</li>
  			<?php endwhile; ?>
  		</ul>
    <?php endif; ?>

		<?php
		// ページネーションを表示
		the_posts_pagination(array(
				'mid_size'  => 1,
				'prev_text' => '前へ',
				'next_text' => '次へ',
				'screen_reader_text' => ' ',
		));
		?>
  		
  </div>

</main>
	  
<?php get_footer(); ?>