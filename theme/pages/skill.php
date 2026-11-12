<?php /*
Template Name: スキル研修
*/ ?>


<?php get_header(); ?>

<main>
  <section id="section-title">
    <h2>スキル研修</h2>
  </section>

  <div class="container">
    <section id="section-message">
      <p>
      患者さまや医療従事者に寄り添った活動ができるよう、「学び」をサポートいたします。
        <span>ご要望に合わせた資材作成から研修プランの立案・運営までサポートし、質の高い人材育成を目指します。</span>
      </p>
    </section>
  </div>

  <section id="section-post" class="post-slide">
    <div class="title-label">
      <h3>スライド資料</h3>
    </div>

    <div class="posts">
      <?php
        // parent03 というスラッグのタームを取得
        $parent_term = get_term_by('slug', 'parent03', 'common_category');

        if ($parent_term) {
          $query = new WP_Query([
            'post_type'      => ['material'],
            'posts_per_page' => 6,
            'tax_query'      => [
              [
                'taxonomy'         => 'common_category',
                'field'            => 'term_id',
                'terms'            => $parent_term->term_id,
                'include_children' => false,
              ]
            ]
          ]);

        if ($query->have_posts()): ?>
          <div class="swiper my-medical-swiper">
            <div class="swiper-wrapper">
              <?php while ($query->have_posts()): $query->the_post(); ?>
                <div class="swiper-slide">
                  <div class="background">
                    <a href="<?php the_permalink(); ?>">
                      <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('large'); ?>
                      <?php endif; ?>
  
                      <div class="text-box">
                        <p class="slide-title">
                            <?php 
                            $title = get_the_title();
                            echo mb_strimwidth($title, 0, 40, '…', 'UTF-8'); 
                            ?>
                        </p>
  
                        <p class="slide-excerpt">
                            <?php 
                            $excerpt = get_the_excerpt(); 
                            echo mb_strimwidth($excerpt, 0, 100, '…', 'UTF-8'); 
                            ?>
                        </p>

                        <div class="flex-label">
                          <div class="post-type-label">
                            <?php 
                            $post_type = get_post_type();
                            $post_type_obj = get_post_type_object($post_type);
                            echo esc_html($post_type_obj->labels->singular_name); // 投稿タイプのラベルを表示
                            ?>
                          </div>

                          <div class="parent-label">
                            <?php
                            // 子カテゴリー
                            $terms = get_the_terms(get_the_ID(), 'common_category');
                            if ($terms && !is_wp_error($terms)) {
                                $child_terms = [];
                                $parent_terms = [];
        
                                foreach ($terms as $term) {
                                    if ($term->parent != 0) {
                                        $parent_term = get_term($term->parent, 'common_category');
                                        $parent_class = $parent_term ? 'cat-' . esc_attr($parent_term->slug) : 'cat-default';
                                        $child_terms[] = '<span class="cat ' . $parent_class . '">' . esc_html($term->name) . '</span>';
                                    } else {
                                        $parent_class = 'cat-' . esc_attr($term->slug);
                                        $parent_terms[] = '<span class="cat ' . $parent_class . '">' . esc_html($term->name) . '</span>';
                                    }
                                }
        
                                if (!empty($child_terms)) {
                                    echo '<div class="categories">' . implode(' ', $child_terms) . '</div>';
                                } elseif (!empty($parent_terms)) {
                                    echo '<div class="categories">' . implode(' ', $parent_terms) . '</div>';
                                }
                            }
                            ?>
                          </div>
                        </div>

                        <div class="tag-label">
                          <?php
                            // タグ
                            $tags = get_the_terms(get_the_ID(), 'common_tag');
                            if ($tags && !is_wp_error($tags)) {
                              $tag_names = wp_list_pluck($tags, 'name');
                              $tag_spans = array_map(function($name) {
                                return '<span class="tag">' . esc_html($name) . '</span>';
                              }, $tag_names);
        
                              echo '<div class="post-tags">' . implode($tag_spans) . '</div>';
                            }
                          ?>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
            <div class="swiper-navigation">
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
            </div>
          </div>
        <?php
        else:
          echo '<p class="not-post">関連する投稿はまだありません。</p>';
        endif;

        wp_reset_postdata();
        } else {
          echo '<p class="not-post">関連する投稿はまだありません。</p>';
        }
      ?>
    </div>

    <div class="default-button">
      <button class="button-more library-more" data-parent="parent03" data-post-type="material">
        <span>もっと見る</span>
      </button>
    </div>
  </section>

  <section id="section-post" class="post-movie">
    <div class="title-label">
      <h3>動画ライブラリ</h3>
    </div>

    <div class="posts">
      <?php
        // parent03 というスラッグのタームを取得
        $parent_term = get_term_by('slug', 'parent03', 'common_category');

        if ($parent_term) {
          $query = new WP_Query([
            'post_type'      => ['video_library'],
            'posts_per_page' => 6,
            'tax_query'      => [
              [
                'taxonomy'         => 'common_category',
                'field'            => 'term_id',
                'terms'            => $parent_term->term_id,
                'include_children' => false,
              ]
            ]
          ]);

        if ($query->have_posts()): ?>
          <div class="swiper my-medical-swiper">
            <div class="swiper-wrapper">
              <?php while ($query->have_posts()): $query->the_post(); ?>
                <div class="swiper-slide">
                  <div class="background">
                    <a href="<?php the_permalink(); ?>">
                      <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('large'); ?>
                      <?php endif; ?>
  
                      <div class="text-box">
                        <p class="slide-title">
                            <?php 
                            $title = get_the_title();
                            echo mb_strimwidth($title, 0, 40, '…', 'UTF-8'); 
                            ?>
                        </p>
  
                        <p class="slide-excerpt">
                            <?php 
                            $excerpt = get_the_excerpt(); 
                            echo mb_strimwidth($excerpt, 0, 100, '…', 'UTF-8'); 
                            ?>
                        </p>

                        <div class="flex-label">
                          <div class="post-type-label">
                            <?php 
                            $post_type = get_post_type();
                            $post_type_obj = get_post_type_object($post_type);
                            echo esc_html($post_type_obj->labels->singular_name); // 投稿タイプのラベルを表示
                            ?>
                          </div>

                          <div class="parent-label">
                            <?php
                            // 子カテゴリー
                            $terms = get_the_terms(get_the_ID(), 'common_category');
                            if ($terms && !is_wp_error($terms)) {
                                $child_terms = [];
                                $parent_terms = [];
        
                                foreach ($terms as $term) {
                                    if ($term->parent != 0) {
                                        $parent_term = get_term($term->parent, 'common_category');
                                        $parent_class = $parent_term ? 'cat-' . esc_attr($parent_term->slug) : 'cat-default';
                                        $child_terms[] = '<span class="cat ' . $parent_class . '">' . esc_html($term->name) . '</span>';
                                    } else {
                                        $parent_class = 'cat-' . esc_attr($term->slug);
                                        $parent_terms[] = '<span class="cat ' . $parent_class . '">' . esc_html($term->name) . '</span>';
                                    }
                                }
        
                                if (!empty($child_terms)) {
                                    echo '<div class="categories">' . implode(' ', $child_terms) . '</div>';
                                } elseif (!empty($parent_terms)) {
                                    echo '<div class="categories">' . implode(' ', $parent_terms) . '</div>';
                                }
                            }
                            ?>
                          </div>
                        </div>

                        <div class="tag-label">
                          <?php
                            // タグ
                            $tags = get_the_terms(get_the_ID(), 'common_tag');
                            if ($tags && !is_wp_error($tags)) {
                              $tag_names = wp_list_pluck($tags, 'name');
                              $tag_spans = array_map(function($name) {
                                return '<span class="tag">' . esc_html($name) . '</span>';
                              }, $tag_names);
        
                              echo '<div class="post-tags">' . implode($tag_spans) . '</div>';
                            }
                          ?>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
            <div class="swiper-navigation">
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
            </div>
          </div>
        <?php
        else:
          echo '<p class="not-post">関連する投稿はまだありません。</p>';
        endif;

        wp_reset_postdata();
        } else {
          echo '<p class="not-post">関連する投稿はまだありません。</p>';
        }
      ?>
    </div>

    <div class="default-button">
      <button class="button-more library-more" data-parent="parent03" data-post-type="video-library">
        <span>もっと見る</span>
      </button>
    </div>
    
  </section>

</main>

<?php get_footer(); ?>