<?php
/*
Template Name: スライド資料
*/
get_header();
?>

<main>
<section id="library-section-title">
  <h2>スライド資料</h2>
</section>

<section id="new-arrival">
  <h3>新着資料</h3>

  <?php
  $args = array(
    'post_type'      => 'material', // カスタム投稿タイプ
    'posts_per_page' => 5,               // 最新5件
    'orderby'        => 'date',
    'order'          => 'DESC',
  );
  $video_query = new WP_Query($args);
  ?>

  <?php if ($video_query->have_posts()) : ?>
    <div class="swiper video-slider">
      <div class="swiper-wrapper">
        <?php while ($video_query->have_posts()) : $video_query->the_post(); ?>
        <div class="swiper-slide" data-link="<?php the_permalink(); ?>">
          <div class="background">
              <div class="flex-box">
                
                <div class="thumbnail">
                  <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large'); ?>
                  <?php endif; ?>
                </div>
    
                <div class="text-box">
                  <p class="slide-title">
                    <?php echo esc_html( mb_strimwidth(get_the_title(), 0, 40, '…', 'UTF-8') ); ?>
                  </p>
    
                  <p class="slide-excerpt">
                    <?php echo esc_html( mb_strimwidth(get_the_excerpt(), 0, 100, '…', 'UTF-8') ); ?>
                  </p>
    
                  <?php
                    // --- 子カテゴリー（リンクなしテキスト） ---
                    $terms = get_the_terms(get_the_ID(), 'common_category');
                    if ($terms && !is_wp_error($terms)) {
                        $child_terms = [];
                        $parent_terms = [];

                        foreach ($terms as $term) {
                            if ($term->parent != 0) {
                                // 子カテゴリー
                                $parent_term = get_term($term->parent, 'common_category');
                                $parent_class = $parent_term ? 'cat-' . esc_attr($parent_term->slug) : 'cat-default';
                                $child_terms[] = '<span class="cat ' . $parent_class . '">' . esc_html($term->name) . '</span>';
                            } else {
                                // 親カテゴリー
                                $parent_class = 'cat-' . esc_attr($term->slug);
                                $parent_terms[] = '<span class="cat ' . $parent_class . '">' . esc_html($term->name) . '</span>';
                            }
                        }

                        if (!empty($child_terms)) {
                            // 子カテゴリーがあれば子カテゴリーを表示
                            echo '<div class="categories">' . implode(' ', $child_terms) . '</div>';
                        } elseif (!empty($parent_terms)) {
                            // 子カテゴリーがなければ親カテゴリーを表示
                            echo '<div class="categories">' . implode(' ', $parent_terms) . '</div>';
                        }
                    }
    
                    // --- タグ（リンクなしテキスト） ---
                    $tags = get_the_terms(get_the_ID(), 'common_tag');
                    if ($tags && !is_wp_error($tags)) {
                      $tag_names = wp_list_pluck($tags, 'name'); // タグ名だけの配列を取得
                      $tag_spans = array_map(function($name) {
                        return '<span class="tag">' . esc_html($name) . '</span>';
                      }, $tag_names);
    
                      echo '<div class="post-tags">' . implode($tag_spans) . '</div>';
                    }
                  ?>
                </div>
    
              </div>
          </div>
        </div>
        <?php endwhile; ?>
      </div>

      <div class="swiper-button-prev"></div>
      <div div class="swiper-button-next"></div>
    </div>
    
    <!-- ページネーションはスライダーの外に配置 -->
    <div class="video-pagination"></div>
  <?php endif; wp_reset_postdata(); ?>
  </section>

  <?php
    // このページ用の Post Type
    $post_type = 'material';

    // 親タブのラベル
    $parents = [
        'parent01' => '疾患別',
        'parent02' => '医療制度',
        'parent03' => 'スキル研修'
        // 'parent04' => 'Web講演会',
        // 'parent05' => '情報提供資材'
    ];
  ?>

  <div class="<?php echo esc_attr($post_type); ?>-container">

      <!-- 親タブ -->
      <div class="<?php echo esc_attr($post_type); ?>-tabs" id="search-form">
        <h3>投稿を探す</h3>
        <div class="flex-box">
          <?php foreach($parents as $slug => $label): ?>
            <button class="tab-button" data-parent="<?php echo esc_attr($slug); ?>">
              <?php echo esc_html($label); ?>
            </button>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- 子カテゴリー -->
      <div id="child-filters">
        <?php
          foreach($parents as $slug => $label){
              $parent_term = get_term_by('slug', $slug, 'common_category');
              if($parent_term){
                  $child_terms = get_terms([
                      'taxonomy' => 'common_category',
                      'hide_empty' => false,
                      'parent' => $parent_term->term_id
                  ]);

                  if(!empty($child_terms)){
                      usort($child_terms, function($a, $b){
                          return strcmp($a->slug, $b->slug);
                      });

                      echo '<div class="inner">';
                      echo '<div class="child-buttons" data-parent="'.$slug.'" style="display:none;">';
                      echo '<button class="child-button" data-term="all">すべて</button>';
                      foreach($child_terms as $term){
                          echo '<button class="child-button" data-term="'.$term->slug.'">'.$term->name.'</button>';
                      }
                      echo '</div>';
                      echo '</div>';
                  }
              }
          }
        ?>
      </div>

      <div class="container">
        <!-- 投稿表示 -->
        <div id="<?php echo esc_attr($post_type); ?>-results"></div>
      </div>

  </div>

</main>

<?php get_footer(); ?>