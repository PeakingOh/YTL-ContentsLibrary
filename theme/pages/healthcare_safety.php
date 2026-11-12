<?php /*
Template Name: 医療安全
*/ ?>


<?php get_header(); ?>

<main>
  <section id="section-title">
    <h2>医療制度コンテンツ</h2>
  </section>

  <div class="container">
    <div class="category-icon">
      <figure>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/healthcare/healthcare_icon03.svg" alt="医療安全">
      </figure>
      <p>医療安全</p>
    </div>
  </div>

  <!-- <section id="section-post" class="post-slide">
    <div class="title-label">
      <h3>スライド資料</h3>
    </div>

    <div class="posts">
      <?php
      $child_term = get_term_by('slug', 'child03-parent02', 'common_category');

      if ($child_term) {
        $query = new WP_Query([
          'post_type'      => ['material'],
          'posts_per_page' => 5,
          'tax_query'      => [
            [
              'taxonomy'         => 'common_category',
              'field'            => 'term_id',
              'terms'            => $child_term->term_id,
              'include_children' => false, // 子孫は含めない
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
      <button class="button-more library-more" data-parent="parent02" data-child="child03-parent02" data-post-type="material">
        <span>もっと見る</span>
      </button>
    </div>
  </section> -->

  <section id="section-post" class="post-movie">
    <div class="title-label">
      <h3>動画ライブラリ</h3>
    </div>

    <div class="posts">
      <?php
      $child_term = get_term_by('slug', 'child03-parent02', 'common_category');

      if ($child_term) {
        $query = new WP_Query([
          'post_type'      => ['video_library'],
          'posts_per_page' => 5,
          'tax_query'      => [
            [
              'taxonomy'         => 'common_category',
              'field'            => 'term_id',
              'terms'            => $child_term->term_id,
              'include_children' => false, // 子孫は含めない
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
      <button class="button-more library-more" data-parent="parent02" data-child="child03-parent02" data-post-type="video-library">
        <span>もっと見る</span>
      </button>
    </div>
  </section>

  <div class="secondarynav">
    <div class="container">
      <ul>
        <li class="passive">
          <a href="<?php echo home_url(); ?>/healthcare/system">
            <div class="nav-box">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40.753" height="30.274" viewBox="0 0 40.753 30.274">
                <g id="グループ_2581" data-name="グループ 2581" transform="translate(0 0)">
                  <g id="グループ_2565" data-name="グループ 2565" transform="translate(0 0)" clip-path="url(#clip-path)">
                    <path class="icon-path" d="M24.229,21.637l-.046,0a17.645,17.645,0,0,0-2.766,0,.591.591,0,0,1-.637-.589v-2.43a17.612,17.612,0,0,0-2.34.434.59.59,0,0,1-.737-.572V15.646a.591.591,0,0,1,.444-.572A18.859,18.859,0,0,1,20.78,14.6V12.052a.591.591,0,0,1,.544-.589,18.874,18.874,0,0,1,2.952,0,.591.591,0,0,1,.544.589V14.6a18.859,18.859,0,0,1,2.633.478.591.591,0,0,1,.444.572v2.832a.59.59,0,0,1-.737.572,17.588,17.588,0,0,0-2.34-.434v2.43a.591.591,0,0,1-.591.591m-2.859-4.262a.591.591,0,0,1,.591.591v2.452c.558-.025,1.119-.025,1.678,0V17.965a.59.59,0,0,1,.637-.589,18.771,18.771,0,0,1,2.44.356V16.11a17.554,17.554,0,0,0-2.533-.388.591.591,0,0,1-.544-.589V12.607c-.558-.027-1.12-.027-1.678,0v2.527a.591.591,0,0,1-.544.589,17.554,17.554,0,0,0-2.533.388v1.622a18.79,18.79,0,0,1,2.44-.356l.047,0" transform="translate(-10.814 -6.967)" fill="#fff"/>
                    <path class="icon-path" d="M8.313,26.819a.591.591,0,0,1-.591-.591V2.063a.591.591,0,0,1,.39-.555,25.239,25.239,0,0,1,17.184,0,.59.59,0,0,1,.389.555V26.228a.591.591,0,1,1-1.181,0V2.481a24.061,24.061,0,0,0-15.6,0V25.4a25.136,25.136,0,0,1,13.817-.507.591.591,0,1,1-.281,1.147,23.96,23.96,0,0,0-13.925.743.593.593,0,0,1-.2.035" transform="translate(-4.717 0)" fill="#fff"/>
                    <path class="icon-path" d="M68.218,26.819a.593.593,0,0,1-.2-.035,24.058,24.058,0,0,0-16.378,0,.59.59,0,0,1-.792-.555V2.063a.59.59,0,0,1,.389-.555,25.24,25.24,0,0,1,17.184,0,.591.591,0,0,1,.389.555v5.8a.591.591,0,1,1-1.181,0V2.481a24.061,24.061,0,0,0-15.6,0V25.4a25.246,25.246,0,0,1,15.6,0V12.82a.591.591,0,1,1,1.181,0V26.228a.591.591,0,0,1-.591.591" transform="translate(-31.06 0)" fill="#fff"/>
                    <path class="icon-path" d="M18.918,49.673A.591.591,0,0,1,18.8,48.5a22.839,22.839,0,0,1,8.758,0,.591.591,0,1,1-.232,1.158,21.648,21.648,0,0,0-8.295,0,.593.593,0,0,1-.116.012" transform="translate(-11.196 -29.369)" fill="#fff"/>
                    <path class="icon-path" d="M70.569,26.459a.6.6,0,0,1-.116-.012,21.646,21.646,0,0,0-8.295,0,.591.591,0,1,1-.232-1.158,22.852,22.852,0,0,1,8.758,0,.591.591,0,0,1-.115,1.17" transform="translate(-37.538 -15.189)" fill="#fff"/>
                    <path class="icon-path" d="M70.569,14.852a.6.6,0,0,1-.116-.012,21.646,21.646,0,0,0-8.295,0,.591.591,0,1,1-.232-1.158,22.837,22.837,0,0,1,8.758,0,.591.591,0,0,1-.115,1.17" transform="translate(-37.538 -8.099)" fill="#fff"/>
                    <path class="icon-path" d="M70.569,38.066a.6.6,0,0,1-.116-.012,21.646,21.646,0,0,0-8.295,0,.591.591,0,1,1-.232-1.158,22.852,22.852,0,0,1,8.758,0,.591.591,0,0,1-.115,1.17" transform="translate(-37.538 -22.279)" fill="#fff"/>
                    <path class="icon-path" d="M70.569,49.673a.6.6,0,0,1-.116-.012,21.646,21.646,0,0,0-8.295,0,.591.591,0,1,1-.232-1.158,22.837,22.837,0,0,1,8.758,0,.591.591,0,0,1-.115,1.17" transform="translate(-37.538 -29.369)" fill="#fff"/>
                    <path class="icon-path" d="M20.377,35.315a5.718,5.718,0,0,1-3.4-1.125H.59A.59.59,0,0,1,0,33.6V8.844a.591.591,0,0,1,.59-.591h.92a.591.591,0,0,1,0,1.181H1.181V33.009H17.174a.589.589,0,0,1,.367.128,4.538,4.538,0,0,0,5.671,0,.589.589,0,0,1,.367-.128H39.572V9.434h-.329a.591.591,0,0,1,0-1.181h.92a.591.591,0,0,1,.59.591V33.6a.59.59,0,0,1-.59.59H23.78a5.717,5.717,0,0,1-3.4,1.125" transform="translate(0 -5.041)" fill="#fff"/>
                  </g>
                </g>
              </svg>
              <p>医療制度</p>
            </div>
          </a>
        </li>
  
        <li class="passive">
          <a href="<?php echo home_url(); ?>/healthcare/ethics">
            <div class="nav-box">
              <svg id="グループ_2582" data-name="グループ 2582" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="33.116" height="35.064" viewBox="0 0 33.116 35.064">
                <g id="グループ_2566" data-name="グループ 2566" clip-path="url(#clip-path)">
                  <path class="icon-path" d="M27.7,35.064h-.012a.586.586,0,0,1-.574-.6,20.266,20.266,0,0,1,2.572-9.657,17.686,17.686,0,0,0,2.053-11.78C30.37,2,19.608,1.275,19.15,1.249l-.042,0a18.939,18.939,0,0,0-6.911.637,11.194,11.194,0,0,0-8.341,9.343c-.01.047-.4,1.78.507,2.547a1.16,1.16,0,0,1,.406.837c.1,1.462-2.2,4.241-3.576,5.768a.072.072,0,0,0-.02.038c.049.13.257.5,1.086.879,1.7.783,1.548,3.094,1.424,3.972a3.667,3.667,0,0,1,1.133,3.318c-.223.993-.411,2.109.177,2.778.529.6,1.717.837,3.432.681a28.9,28.9,0,0,0,7.912-1.912.586.586,0,1,1,.446,1.083,29.529,29.529,0,0,1-8.264,2c-2.154.2-3.6-.154-4.407-1.075-1.03-1.174-.646-2.887-.44-3.808a2.679,2.679,0,0,0-.986-2.388.586.586,0,0,1-.207-.582c.005-.023.484-2.447-.712-3a3,3,0,0,1-1.7-1.55,1.2,1.2,0,0,1,.253-1.216c2.507-2.776,3.421-4.561,3.27-4.942-1.45-1.214-.907-3.565-.883-3.665C4.963-1.38,18.614.009,19.236.08c.595.042,12.206,1.038,13.66,12.806a18.882,18.882,0,0,1-2.164,12.44,19.277,19.277,0,0,0-2.452,9.162.586.586,0,0,1-.586.575" transform="translate(0 0)" fill="#011976"/>
                  <path class="icon-path" d="M29.993,85.433a.586.586,0,0,1-.581-.518L29.155,82.7a.586.586,0,1,1,1.164-.135l.257,2.218a.586.586,0,0,1-.515.649.579.579,0,0,1-.068,0" transform="translate(-17.896 -50.369)" fill="#011976"/>
                  <path class="icon-path" d="M34.211,34.8a.588.588,0,0,1-.311-.089,5.954,5.954,0,1,1,6.321,0,.586.586,0,1,1-.622-.993,4.782,4.782,0,1,0-5.076,0,.586.586,0,0,1-.312,1.082" transform="translate(-19.097 -14.554)" fill="#011976"/>
                  <path class="icon-path" d="M41.067,59.389a3.3,3.3,0,0,1-.912-.129,3.5,3.5,0,0,1-2.523-3.35v-.4a.586.586,0,0,1,.586-.586h5.7a.586.586,0,0,1,.586.586v.4a3.5,3.5,0,0,1-2.523,3.35,3.3,3.3,0,0,1-.912.129m-2.255-3.294a2.325,2.325,0,0,0,1.667,2.039,2.127,2.127,0,0,0,1.176,0,2.326,2.326,0,0,0,1.667-2.039Z" transform="translate(-23.103 -33.719)" fill="#011976"/>
                  <path class="icon-path" d="M45.6,16.49a.586.586,0,0,1-.586-.586V14.251a.586.586,0,0,1,1.173,0V15.9a.586.586,0,0,1-.586.586" transform="translate(-27.633 -8.389)" fill="#011976"/>
                  <path class="icon-path" d="M34.514,19.46a.585.585,0,0,1-.508-.293l-.827-1.432a.586.586,0,0,1,1.015-.586l.827,1.432a.586.586,0,0,1-.507.879" transform="translate(-20.321 -10.349)" fill="#011976"/>
                  <path class="icon-path" d="M26.4,27.574a.583.583,0,0,1-.292-.079l-1.432-.827a.586.586,0,0,1,.586-1.015l1.432.827a.586.586,0,0,1-.293,1.094" transform="translate(-14.968 -15.702)" fill="#011976"/>
                  <path class="icon-path" d="M23.429,38.659H21.776a.586.586,0,1,1,0-1.172h1.653a.586.586,0,1,1,0,1.172" transform="translate(-13.009 -23.014)" fill="#011976"/>
                  <path class="icon-path" d="M24.968,49.254a.586.586,0,0,1-.293-1.094l1.432-.827a.586.586,0,0,1,.586,1.015l-1.432.827a.582.582,0,0,1-.292.079" transform="translate(-14.968 -29.011)" fill="#011976"/>
                  <path class="icon-path" d="M63.949,49.254a.582.582,0,0,1-.292-.079l-1.432-.827a.586.586,0,0,1,.586-1.015l1.432.827a.586.586,0,0,1-.293,1.094" transform="translate(-38.022 -29.011)" fill="#011976"/>
                  <path class="icon-path" d="M66.789,38.659H65.136a.586.586,0,1,1,0-1.172h1.653a.586.586,0,1,1,0,1.172" transform="translate(-39.629 -23.014)" fill="#011976"/>
                  <path class="icon-path" d="M62.519,27.574a.586.586,0,0,1-.294-1.094l1.432-.827a.586.586,0,0,1,.586,1.015l-1.432.827a.583.583,0,0,1-.292.079" transform="translate(-38.022 -15.702)" fill="#011976"/>
                  <path class="icon-path" d="M55.366,19.46a.586.586,0,0,1-.507-.879l.827-1.432a.586.586,0,0,1,1.015.586l-.827,1.432a.585.585,0,0,1-.508.293" transform="translate(-33.631 -10.349)" fill="#011976"/>
                  <path class="icon-path" d="M42.766,44.2a.587.587,0,0,1-.586-.585L42.168,39.5,40.6,37.537a.934.934,0,0,1,.73-1.514h2.842a.933.933,0,0,1,.733,1.511l-.673.853a.586.586,0,0,1-.92-.726l.368-.466H41.829l1.383,1.74a.582.582,0,0,1,.127.363l.013,4.317a.586.586,0,0,1-.585.588Z" transform="translate(-24.803 -22.115)" fill="#011976"/>
                </g>
              </svg>

              <p>倫理</p>
            </div>
          </a>
        </li>
  
        <li class="active">
          <div class="nav-box">
            <svg id="グループ_2583" data-name="グループ 2583" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="39.443" height="32.838" viewBox="0 0 39.443 32.838">
              <g id="グループ_2564" data-name="グループ 2564" transform="translate(0 0)" clip-path="url(#clip-path)">
                <path class="icon-path" d="M34.526,18.562a.591.591,0,0,1-.418-.173l-4.056-4.056.836-.836,3.638,3.638L42.262,9.4A4.812,4.812,0,1,0,35,3.121a.612.612,0,0,1-.949,0A4.812,4.812,0,0,0,25.42,6.609a.591.591,0,1,1-1.173.15,6,6,0,0,1,10.28-4.907A6,6,0,1,1,43.1,10.235l-8.155,8.154a.591.591,0,0,1-.418.173" transform="translate(-14.767 0)" fill="#011976"/>
                <path class="icon-path" d="M31.005,22.53h-.041a.592.592,0,0,1-.516-.391L29.056,18.25l-1.025,2.113a.592.592,0,0,1-.532.334H21.078a.591.591,0,0,1,0-1.183h6.051l1.477-3.047a.591.591,0,0,1,1.089.058l1.412,3.943,1.1-2.113a.591.591,0,0,1,.524-.317H36.37a.591.591,0,1,1,0,1.183H33.093l-1.564,2.992a.591.591,0,0,1-.524.318" transform="translate(-12.503 -9.846)" fill="#011976"/>
                <path class="icon-path" d="M80.813,39.774a.591.591,0,0,1-.481-.936l5.71-7.974a6.321,6.321,0,0,0,1.167-4.039l-.44-7.452a.868.868,0,0,0-.866-.816h0a.811.811,0,0,0-.8.708l-1.087,8.561a.591.591,0,1,1-1.173-.149l1.087-8.561a2,2,0,0,1,1.97-1.742H85.9a2.051,2.051,0,0,1,2.047,1.93l.44,7.452A7.511,7.511,0,0,1,87,31.553l-5.71,7.974a.59.59,0,0,1-.481.247" transform="translate(-48.959 -10.603)" fill="#011976"/>
                <path class="icon-path" d="M63.981,52.281a.575.575,0,0,1-.058,0,.591.591,0,0,1-.532-.646l.237-2.448a3.908,3.908,0,0,1,.943-2.2l5.576-6.43a2.092,2.092,0,0,1,3.236,2.649l-3.5,4.525a.591.591,0,0,1-.936-.723l3.5-4.525a.909.909,0,0,0-1.406-1.151l-5.576,6.429a2.731,2.731,0,0,0-.659,1.535l-.237,2.448a.592.592,0,0,1-.588.535" transform="translate(-38.686 -24.313)" fill="#011976"/>
                <path class="icon-path" d="M68.146,74.416a.587.587,0,0,1-.107-.01l-9.082-1.665a.591.591,0,0,1-.475-.688l.631-3.44a.591.591,0,0,1,.688-.475L68.883,69.8a.591.591,0,0,1,.475.688l-.631,3.44a.59.59,0,0,1-.581.485m-8.394-2.731,7.919,1.452.417-2.277-7.919-1.452Z" transform="translate(-35.685 -41.578)" fill="#011976"/>
                <path class="icon-path" d="M7.589,39.774a.591.591,0,0,1-.482-.247L1.4,31.553a7.507,7.507,0,0,1-1.387-4.8L.451,19.3A2.052,2.052,0,0,1,2.5,17.374h.007a2,2,0,0,1,1.97,1.742l1.086,8.561a.591.591,0,1,1-1.173.149L3.3,19.265a.812.812,0,0,0-.8-.708h0a.868.868,0,0,0-.866.817l-.44,7.451A6.323,6.323,0,0,0,2.36,30.864l5.71,7.974a.591.591,0,0,1-.48.936" transform="translate(0.001 -10.603)" fill="#011976"/>
                <path class="icon-path" d="M20.9,52.281a.592.592,0,0,1-.588-.535L20.075,49.3a2.731,2.731,0,0,0-.659-1.535l-5.577-6.429a.909.909,0,0,0-1.406,1.151l3.5,4.525a.591.591,0,1,1-.936.723L11.5,43.208a2.092,2.092,0,0,1,3.236-2.649l5.576,6.43a3.908,3.908,0,0,1,.943,2.2l.237,2.448a.591.591,0,0,1-.532.646.577.577,0,0,1-.058,0" transform="translate(-6.751 -24.313)" fill="#011976"/>
                <path class="icon-path" d="M16.005,74.416a.592.592,0,0,1-.582-.485l-.631-3.44a.591.591,0,0,1,.475-.688l9.082-1.665a.591.591,0,0,1,.688.475l.631,3.44a.591.591,0,0,1-.475.688l-9.083,1.665a.611.611,0,0,1-.106.01m.058-3.557.417,2.277L24.4,71.684l-.417-2.277Z" transform="translate(-9.022 -41.578)" fill="#011976"/>
              </g>
            </svg>
            <p>医療安全</p>
          </div>
        </li>
      </ul>
    </div>
  </div>

</main>

<?php get_footer(); ?>