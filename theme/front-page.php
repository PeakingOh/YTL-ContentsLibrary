<?php get_header(); ?>
<main>
  <section id="welcome">
		<div class="inner">
			<div class="text-box">
        <div class="txt top">
          <p>人</p>
          <p>材</p>
          <p>育</p>
          <p>成</p>
          <p>に</p>
          <p>も</p>
        </div>

        <div class="txt bottom">
          <p>最</p>
          <p>先</p>
          <p>端</p>
          <p>技</p>
          <p>術</p>
          <p>を</p>
          <p>。</p>
        </div>
      </div>
		</div>
	</section>

  <section id="message">
    <div class="inner">
      <div class="container">
        <div class="message-text fadein">
          <h3>
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/message_sp.png" alt="YTL">
            </figure>
          </h3>
          
          <div class="text-area">
            <p>私たちYTLは、患者様や医療従事者に寄り添った活動ができる<span>「学び」のサポートをいたします。</span></p>
          </div>
        </div>
        
        <div class="default-button">
          <a href="<?php echo home_url(); ?>/about/" class="button-more"><span>詳しくみる</span></a>
        </div>
      </div>
    </div>
	</section>

  <section id="contents">
    <div class="container">
      <div class="flex-box">
        <div class="contents-box contents-medical">
          <div class="section-title">
            <h3>
              <figure>
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contentsname_01.png" alt="疾患別コンテンツ">
              </figure>
              <small>Medical Category</small>
            </h3>
          </div>
          <div class="contents-image">
            <figure>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contents_01.jpg" alt="疾患別コンテンツ">
            </figure>
          </div>
          <div class="default-button">
            <a href="<?php echo home_url(); ?>/medical/" class="button-more"><span>もっと見る</span></a>
          </div>
        </div>

        <div class="contents-box contents-healthcare">
          <div class="section-title">
            <h3>
              <figure>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contentsname_02.png" alt="医療制度コンテンツ">
              </figure>
              <small>Healthcare System</small>
            </h3>
          </div>
          <div class="contents-image">
            <figure>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contents_02.jpg" alt="医療制度コンテンツ">
            </figure>
          </div>
          <div class="default-button">
            <a href="<?php echo home_url(); ?>/healthcare/" class="button-more"><span>もっと見る</span></a>
          </div>
        </div>

        <div class="contents-box contents-skill">
          <div class="section-title">
            <h3>
              <figure>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contentsname_03.png" alt="スキル研修">
              </figure>
              <small>Skill Training</small>
            </h3>
          </div>
          <div class="contents-image">
            <figure>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contents_03.jpg" alt="スキル研修">
            </figure>
          </div>
          <div class="default-button">
            <a href="<?php echo home_url(); ?>/skill/" class="button-more"><span>もっと見る</span></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="news">

		<div class="container">
			<div class="flex-box">
				<div class="text-box">
					<h3>
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news_title.png" alt="YTL">
            </figure>
            <span>お知らせ</span>
          </h3>

					<div class="default-button pc-view">
            <a href="<?php echo home_url(); ?>/news/" class="button-more"><span>もっと見る</span></a>
          </div>
				</div>

				<div class="news-box">
					<?php
						$the_query = new WP_Query(
							array(
								'posts_per_page' => 3
							)
						);
					?>
					
					<?php if($the_query->have_posts()): ?>
					
						
					<ul class="news-list">
						<?php while($the_query->have_posts()):$the_query->the_post(); ?>
						
						<?php
							$cat = get_the_category();
							$cat = $cat[0];
						?>
						<li>
							<a href="<?php the_permalink(); ?>">
								<date><?php the_time("Y.m.d"); ?></date>
								<!-- <span class="label <?php echo $cat->category_nicename; ?>"><?php echo $cat->cat_name; ?></span> -->
								<span class="text">
									<?php
									if(mb_strlen($post->post_title, 'UTF-8')>20){
										$title= mb_substr($post->post_title, 0, 26, 'UTF-8');
										echo $title.'…';
									}else{
										echo $post->post_title;
									}
									?>				    
								</span>
							</a>
						</li>
						<?php endwhile; ?>
					</ul>
					<?php endif; ?>
					<?php wp_reset_postdata(); ?>
				</div>

        <div class="default-button sp-view">
          <a href="<?php echo home_url(); ?>/news/" class="button-more"><span>もっと見る</span></a>
        </div>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>