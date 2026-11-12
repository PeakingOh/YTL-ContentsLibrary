<?php get_header(); ?>

<main>
  <section id="library-section-title">
    <h2>動画ライブラリ</h2>
  </section>

  <section id="post-contents">
    <div class="container">
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="title-box">
          <!-- タイトル -->
          <h3><?php the_title(); ?></h3>

          <div class="flex-label">
            <div class="post-type-label">
              <?php 
                $post_type = get_post_type();
                $post_type_obj = get_post_type_object($post_type);

                // 投稿タイプごとのリンク先を定義
                $custom_post_type_links = [
                    'video_library'  => '/video-library/', 
                    'material' => '/material/', 
                ];

                // リンク先を取得（存在しない場合はトップへ）
                $link = $custom_post_type_links[$post_type] ?? '/';

                // 出力
                echo '<a href="' . esc_url($link) . '">';
                echo esc_html($post_type_obj->labels->singular_name);
                echo '</a>';
              ?>
            </div>
  
            <div class="parent-label">
              <?php
                // タームごとのリンク先を設定（例: スラッグをキーにする）
                $custom_links = [
                  'p-parent01' => '/medical/',
                  'p-parent02' => '/healthcare/',
                  'p-parent03' => '/skill/',
                  'p-parent04' => '/webinar/',
                  'p-parent05' => '/info-material/',
                ];

                $terms = get_the_terms(get_the_ID(), 'common_category');

                if ($terms && !is_wp_error($terms)) {
                  $child_terms = [];
                  $parent_terms = [];

                  foreach ($terms as $term) {
                      // タームのクラスに合わせてリンクを取得（なければ通常のタームリンク）
                      $parent_class = $term->parent != 0 ? 'p-' . esc_attr(get_term($term->parent)->slug) : 'p-' . esc_attr($term->slug);
                      $link = isset($custom_links[$parent_class]) ? $custom_links[$parent_class] : get_term_link($term);

                      if ($term->parent != 0) { 
                          // 子カテゴリー
                          $child_terms[] = '<a class="' . $parent_class . '" href="' . esc_url($link) . '">' . esc_html($term->name) . '</a>';
                      } else {
                          // 親カテゴリー
                          $parent_terms[] = '<a class="' . $parent_class . '" href="' . esc_url($link) . '">' . esc_html($term->name) . '</a>';
                      }
                  }

                  if (!empty($child_terms)) {
                      echo '<div class="child-categories">';
                      echo implode($child_terms);
                      echo '</div>';
                  } elseif (!empty($parent_terms)) {
                      echo '<div class="parent-categories">';
                      echo implode(', ', $parent_terms);
                      echo '</div>';
                  }
                }
              ?>
            </div>
          </div>

          <div class="child-label">
            <?php
              // --- タグを取得して表示 ---
              $tags = get_the_terms(get_the_ID(), 'common_tag');

              if ($tags && !is_wp_error($tags)) {
                $tag_list = [];
                foreach ($tags as $tag) {
                  $tag_list[] = '<a href="' . get_term_link($tag) . '">' . esc_html($tag->name) . '</a>';
                }

                if (!empty($tag_list)) {
                  echo '<div class="post-tags">';
                  echo implode($tag_list); // リンク付きでカンマ区切り
                  echo '</div>';
                }
              }
            ?>
          </div>

        </div>
    
        <!-- サムネイル -->
        <?php if ( has_post_thumbnail() ) : ?>
          <div class="post-thumbnail"><?php the_post_thumbnail('large'); ?></div>
        <?php endif; ?>
    
        <!-- 本文 -->
        <div class="post-content">
          <?php the_content(); ?>
        </div>
        <?php if ( is_user_logged_in() ) : ?>

          <h4 class="sample-title">サンプル動画</h4>
    
        <!-- Vimeo動画 -->
        <?php if ( $video_url = get_field('video_url') ) : ?>
          <?php
            // Vimeo ID を取得
            preg_match('/vimeo\.com\/(\d+)/', $video_url, $matches);
            $video_id = $matches[1] ?? '';
            $embed_url = $video_id ? "https://player.vimeo.com/video/{$video_id}" : '';
          ?>
          <?php if ( $embed_url ) : ?>
            <div class="video-wrapper">
              <iframe src="<?php echo esc_url($embed_url); ?>" 
                frameborder="0" 
                allow="fullscreen; picture-in-picture" 
                allowfullscreen>
              </iframe>
            </div>
          <?php endif; ?>
        <?php endif; ?>

        <?php if ( $supervision = get_field('supervision') ) : ?>
          <h4 class="sample-title">監修</h4>
          <div class="extra-text"><?php echo wp_kses_post($supervision); ?></div>
        <?php endif; ?>

        <?php if ( $volume = get_field('volume') ) : ?>
            <h4 class="sample-title">ボリューム</h4>
            <div class="extra-text"><?php echo wp_kses_post($volume); ?></div>
        <?php endif; ?>

        <?php if ( $extra_text = get_field('extra_text') ) : ?>
            <h4 class="sample-title">仕様</h4>
            <div class="extra-text"><?php echo wp_kses_post($extra_text); ?></div>
        <?php endif; ?>

        <?php if ( $production = get_field('production') ) : ?>
            <h4 class="sample-title">制作年</h4>
            <div class="extra-text"><?php echo wp_kses_post($production); ?></div>
        <?php endif; ?>
    
        <!-- お問い合わせボタン（共通固定） -->
        <div class="contact-btn">
          <a href="<?php echo home_url(); ?>/contact/" class="btn">資材について問い合わせる</a>
        </div>
    
        <?php else : ?>
          <div class="login-message">
            <p>資材の閲覧には会員登録・ログインが必要です</p>
            <div class="login-button">
              <a href="<?php echo site_url('/member/?redirect_to=' . urlencode(get_permalink())); ?>" class="btn">ログインはこちら</a>
            </div>
          </div>
        <?php endif; ?>
    
      </article>
    </div>
  </section>

</main>

<?php get_footer(); ?>