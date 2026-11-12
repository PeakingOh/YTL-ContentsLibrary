<?php /*
Template Name: 医療従事者向け
*/ ?>


<?php get_header(); ?>

<main>
  <section id="section-title">
    <h2>情報提供資材</h2>
  </section>

  <div class="container">
    <div class="category-icon">
      <figure>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/material/material_icon01.svg" alt="医療従事者向け">
      </figure>
      <p>医療従事者向け</p>
    </div>
  </div>

  <section id="section-post" class="post-slide">
    <div class="title-label">
      <h3>スライド資料</h3>
    </div>

    <div class="posts">
      <?php
      $child_term = get_term_by('slug', 'child01-parent05', 'common_category');

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
      <button class="button-more library-more" data-parent="parent05" data-child="child01-parent05" data-post-type="material">
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
      $child_term = get_term_by('slug', 'child01-parent05', 'common_category');

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
      <button class="button-more library-more" data-parent="parent05" data-child="child01-parent05" data-post-type="video-library">
        <span>もっと見る</span>
      </button>
    </div>
  </section>

  <div class="secondarynav">
    <div class="container">
      <ul>
        <li class="active">
          <div class="nav-box">
            <svg id="グループ_2575" data-name="グループ 2575" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="34.922" height="38.275" viewBox="0 0 34.922 38.275">
              <g id="グループ_2572" data-name="グループ 2572" transform="translate(0 0)" clip-path="url(#clip-path)">
                <path id="パス_10917" data-name="パス 10917" d="M34.248,64.311a.672.672,0,0,1-.668-.6L32.6,53.948a5.529,5.529,0,0,0-4.6-4.894l-5.9-.965-4.307,2.4a.671.671,0,0,1-.654,0l-4.307-2.4-5.9.965a5.529,5.529,0,0,0-4.6,4.894L1.34,63.707A.672.672,0,0,1,0,63.572l.985-9.759A6.876,6.876,0,0,1,6.71,47.728l6.13-1a.675.675,0,0,1,.436.076l4.184,2.331L21.644,46.8a.676.676,0,0,1,.436-.076l6.131,1a6.875,6.875,0,0,1,5.722,6.085l.985,9.759a.672.672,0,0,1-.6.736c-.023,0-.046,0-.068,0" transform="translate(0 -26.036)" fill="#fff"/>
                <path id="パス_10918" data-name="パス 10918" d="M28.406,46.152a.672.672,0,0,1-.617-.936l.649-1.516a.672.672,0,1,1,1.236.529l-.649,1.516a.671.671,0,0,1-.618.408" transform="translate(-15.457 -24.127)" fill="#fff"/>
                <path id="パス_10919" data-name="パス 10919" d="M47.967,46.152a.671.671,0,0,1-.618-.408L46.7,44.228a.672.672,0,1,1,1.236-.529l.649,1.516a.671.671,0,0,1-.353.882.665.665,0,0,1-.264.054" transform="translate(-25.996 -24.127)" fill="#fff"/>
                <path id="パス_10920" data-name="パス 10920" d="M29.577,19.26c-3.595,0-5.812-3.283-6.674-6.226a2.259,2.259,0,0,1-1.089-2.011L21.749,10a2.238,2.238,0,0,1,.828-2.137c-.038-1.4.048-5.4,2.2-6.447a.287.287,0,0,0,.081-.114c.312-.653.8-1.043,2.475-1.234,2.079-.237,5.108.182,6.628,1.426l.059.048c.981.8,2.6,2.127,2.554,6.318A2.236,2.236,0,0,1,37.4,10l-.065,1.027A2.279,2.279,0,0,1,36.3,13c-.821,3.082-2.987,6.256-6.727,6.256M28.538,1.341a9.325,9.325,0,0,0-1.057.057c-1.255.143-1.352.345-1.415.479a1.423,1.423,0,0,1-.706.743c-1.254.609-1.538,3.749-1.423,5.585a.672.672,0,0,1-.421.666c-.253.1-.475.257-.426,1.039l.065,1.027c.043.686.21.865.522.969a.672.672,0,0,1,.438.467c.67,2.557,2.5,5.542,5.462,5.542,3.885,0,5.192-4.242,5.5-5.542a.674.674,0,0,1,.429-.479c.3-.105.447-.276.49-.957l.065-1.027c.049-.781-.173-.937-.425-1.038a.672.672,0,0,1-.421-.648c.141-3.855-1.178-4.933-2.052-5.647l-.06-.049a7.971,7.971,0,0,0-4.567-1.187" transform="translate(-12.116 0)" fill="#fff"/>
                <path id="パス_10921" data-name="パス 10921" d="M37.7,9.052a.672.672,0,0,1-.653-.518,1.013,1.013,0,0,0-.518-.685c-.9-.51-2.855-.369-5.243.376-2.195.685-3.832.646-4.866-.115A2.512,2.512,0,0,1,25.4,6.2a.671.671,0,0,1,.672-.672h0a.672.672,0,0,1,.672.663,1.164,1.164,0,0,0,.485.852c.657.467,1.954.432,3.653-.1,1.632-.51,4.623-1.221,6.309-.26a2.365,2.365,0,0,1,1.16,1.543.673.673,0,0,1-.654.827M26.745,6.2h0Z" transform="translate(-14.156 -3.079)" fill="#fff"/>
                <path id="パス_10922" data-name="パス 10922" d="M19.5,57.2a.672.672,0,0,1-.67-.626c-.373-5.5,1.756-8.535,1.846-8.661a.672.672,0,0,1,1.093.782c-.028.04-1.936,2.813-1.6,7.788a.672.672,0,0,1-.625.716H19.5" transform="translate(-10.467 -26.544)" fill="#fff"/>
                <path id="パス_10923" data-name="パス 10923" d="M55.662,54.909h-.009a.672.672,0,0,1-.664-.68,10.367,10.367,0,0,0-1.283-5.548.672.672,0,0,1,1.108-.76,11.445,11.445,0,0,1,1.519,6.325.671.671,0,0,1-.671.663" transform="translate(-29.866 -26.545)" fill="#fff"/>
                <path id="パス_10924" data-name="パス 10924" d="M17.383,75.8a2.393,2.393,0,1,1,2.393-2.393A2.4,2.4,0,0,1,17.383,75.8m0-3.443a1.05,1.05,0,1,0,1.05,1.05,1.051,1.051,0,0,0-1.05-1.05" transform="translate(-8.353 -39.575)" fill="#fff"/>
                <path id="パス_10925" data-name="パス 10925" d="M49.376,70.618H48.307a.672.672,0,0,1-.569-.315,6.414,6.414,0,0,1-.96-3.422c0-3.224,2.283-5.846,5.088-5.846s5.088,2.623,5.088,5.846a6.461,6.461,0,0,1-.844,3.229.672.672,0,0,1-.582.336H54.48a.672.672,0,0,1,0-1.344h.642a5.185,5.185,0,0,0,.488-2.221c0-2.483-1.68-4.5-3.745-4.5s-3.744,2.02-3.744,4.5a5.135,5.135,0,0,0,.573,2.393h.681a.672.672,0,1,1,0,1.344" transform="translate(-26.07 -34.016)" fill="#fff"/>
              </g>
            </svg>
            <p>医療従事者向け</p>
          </div>
        </li>
  
        <li class="passive">
          <a href="<?php echo home_url(); ?>/info-material/patient">
            <div class="nav-box">
              <svg id="グループ_2576" data-name="グループ 2576" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="33.955" height="38.28" viewBox="0 0 33.955 38.28">
                <g id="グループ_2570" data-name="グループ 2570" transform="translate(0 0)" clip-path="url(#clip-path)">
                  <path id="パス_10909" data-name="パス 10909" d="M59.321,64.908a.672.672,0,0,1-.668-.6L57.7,54.826a5.351,5.351,0,0,0-4.453-4.735l-5.954-.973a.672.672,0,0,1,.217-1.326l5.954.974a6.7,6.7,0,0,1,5.573,5.926l.957,9.478a.672.672,0,0,1-.6.736c-.023,0-.046,0-.068,0" transform="translate(-26.039 -26.628)" fill="#011976"/>
                  <path id="パス_10910" data-name="パス 10910" d="M.673,64.908a.672.672,0,0,0,.668-.6L2.3,54.826A5.351,5.351,0,0,1,6.751,50.09l5.954-.973a.672.672,0,0,0-.217-1.326l-5.954.974A6.7,6.7,0,0,0,.961,54.691L0,64.169a.672.672,0,0,0,.6.736c.023,0,.046,0,.068,0" transform="translate(0 -26.628)" fill="#011976"/>
                  <path id="パス_10911" data-name="パス 10911" d="M33.677,55.243a4.227,4.227,0,0,1-3.608-2,.672.672,0,1,1,1.14-.711,2.908,2.908,0,0,0,4.936,0,.672.672,0,1,1,1.14.711,4.227,4.227,0,0,1-3.608,2" transform="translate(-16.7 -29.097)" fill="#011976"/>
                  <path id="パス_10912" data-name="パス 10912" d="M23.505,49.423a.672.672,0,0,1-.108-1.335l1.815-.3a.672.672,0,0,1,.216,1.326l-1.815.3a.7.7,0,0,1-.109.009" transform="translate(-12.725 -26.628)" fill="#011976"/>
                  <path id="パス_10913" data-name="パス 10913" d="M27.605,47.272a.665.665,0,0,1-.264-.054.672.672,0,0,1-.354-.882l.63-1.473a.672.672,0,1,1,1.235.529l-.63,1.473a.672.672,0,0,1-.618.408" transform="translate(-15.009 -24.774)" fill="#011976"/>
                  <path id="パス_10914" data-name="パス 10914" d="M46.6,47.273a.671.671,0,0,1-.618-.408l-.63-1.473a.672.672,0,0,1,1.235-.529l.63,1.473a.672.672,0,0,1-.354.882.665.665,0,0,1-.264.054" transform="translate(-25.244 -24.774)" fill="#011976"/>
                  <path id="パス_10915" data-name="パス 10915" d="M28.756,22.161c-3.5,0-5.657-3.191-6.5-6.053a2.222,2.222,0,0,1-1.051-1.964l-.063-1a2.15,2.15,0,0,1,.913-2.164,7.31,7.31,0,0,1,.641-1.5,4.893,4.893,0,0,0,.31-4.282l-.023-.054a.672.672,0,1,1,1.238-.523l.027.063a6.243,6.243,0,0,1-.387,5.466,5.918,5.918,0,0,0-.581,1.442.674.674,0,0,1-.406.475c-.242.1-.439.238-.39.989l.062,1c.046.723.23.839.483.924a.672.672,0,0,1,.438.467c.649,2.476,2.423,5.368,5.286,5.368,3.759,0,5.025-4.109,5.324-5.368a.672.672,0,0,1,.429-.478c.244-.086.407-.2.453-.912l.063-1c.047-.751-.148-.893-.389-.989a.673.673,0,0,1-.421-.664,3.461,3.461,0,0,0-.925-2.32,6.1,6.1,0,0,0-4.4-1.6,8.256,8.256,0,0,0-2,.063.672.672,0,0,1-1.035-.744c.16-.514.682-.758,3.09-.661A7.324,7.324,0,0,1,34.3,8.2a4.9,4.9,0,0,1,1.24,2.835,2.189,2.189,0,0,1,.823,2.106l-.063,1a2.208,2.208,0,0,1-1,1.936c-.8,3-2.91,6.081-6.551,6.081M27.139,7.208h0" transform="translate(-11.779 -2.348)" fill="#011976"/>
                  <path id="パス_10916" data-name="パス 10916" d="M34.927,21.026a.59.59,0,0,1-.062,0,.672.672,0,0,1-.607-.731c.01-.108.94-10.868-3.842-16.11a8.791,8.791,0,0,0-6.789-2.837c-3.907,0-6.763,2.016-8.489,5.991A27.586,27.586,0,0,0,13.29,17.55a.672.672,0,0,1-.672.665H12.61a.672.672,0,0,1-.664-.68C12.006,12.262,13.265,0,23.626,0A10.084,10.084,0,0,1,31.41,3.278c2.189,2.4,3.558,6.023,4.068,10.766a35.215,35.215,0,0,1,.117,6.372.673.673,0,0,1-.669.61" transform="translate(-6.657 0)" fill="#011976"/>
                </g>
              </svg>
              <p>患者向け</p>
            </div>
          </a>
        </li>
      </ul>
    </div>
  </div>

</main>

<?php get_footer(); ?>