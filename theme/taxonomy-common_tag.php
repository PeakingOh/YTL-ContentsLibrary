<?php
/*
Template Name: タグアーカイブ
*/
get_header();
?>

<main>
<section id="library-section-title">
  <h2>キーワード検索</h2>
</section>

<div class="container">
  <div class="tag-archive">
    <div class="keyword">
      <small>キーワード</small>
      <h3><?php single_term_title(); ?></h3>
    </div>
      
    <div class="flex-box">
      <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
      <div class="background">
        <a href="<?php the_permalink(); ?>" class="contents-box-link">
            <div class="contents-box">
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
      <?php endwhile; ?>
    </div>


    <?php else : ?>
      <p>記事はありません。</p>
    <?php endif; ?>

  </div>
</div>

</main>

<?php get_footer(); ?>