<?php get_header(); ?>

<main>
  <section id="library-section-title">
    <h2>スライド資料</h2>
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

        <h4 class="sample-title">サンプル資料</h4>
    
        <!-- PDF URL -->
        <div class="material-content">
        <?php
          // ACF のフィールド名が pdf_file の想定。ID / Array / URL に対応
          $file = get_field('pdf_file');
          if ( is_numeric($file) ) {
            $pdf_url = wp_get_attachment_url( intval($file) );
          } elseif ( is_array($file) && ! empty($file['url']) ) {
            $pdf_url = $file['url'];
          } else {
            $pdf_url = $file;
          }

          if ( $pdf_url ) : ?>
            <!-- PDF.js CDN とワーカーを読み込む（軽くて確実） -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
            <script>pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';</script>

            <div class="mini-pdf-viewer" data-pdf="<?php echo esc_attr( $pdf_url ); ?>">
              <canvas class="mini-pdf-canvas" role="img" aria-label="PDF page"></canvas>
              <div class="mini-pdf-controls">
                <button class="mini-prev" type="button">◀</button>
                <span class="mini-page">1 / 1</span>
                <button class="mini-next" type="button">▶</button>
              </div>
            </div>

            <script>
            (function(){
              const wrapper = document.querySelector('.mini-pdf-viewer[data-pdf="<?php echo esc_js($pdf_url); ?>"]');
              if (!wrapper) return;
              const url = wrapper.dataset.pdf;
              const canvas = wrapper.querySelector('.mini-pdf-canvas');
              const ctx = canvas.getContext('2d');
              const info = wrapper.querySelector('.mini-page');
              const btnPrev = wrapper.querySelector('.mini-prev');
              const btnNext = wrapper.querySelector('.mini-next');

              let pdfDoc = null, pageNum = 1, scale = 1.25;

              // 右クリック抑止（canvas上）
              canvas.addEventListener('contextmenu', e => e.preventDefault());

              pdfjsLib.getDocument(url).promise.then(pdf => {
                pdfDoc = pdf;
                render(pageNum);
              }).catch(err => {
                console.error(err);
                wrapper.innerHTML = '<p>PDFを読み込めませんでした。</p>';
              });

              function render(num){
                pdfDoc.getPage(num).then(page=>{
                  // 親幅に合わせて scale を自動調整
                  const viewport = page.getViewport({ scale: scale });
                  const parentW = wrapper.clientWidth;
                  const desiredScale = parentW / viewport.width * scale;
                  const v = page.getViewport({ scale: desiredScale });

                  canvas.width = v.width;
                  canvas.height = v.height;

                  page.render({ canvasContext: ctx, viewport: v }).promise.then(()=>{
                    info.textContent = num + ' / ' + pdfDoc.numPages;
                    btnPrev.disabled = (num <= 1);
                    btnNext.disabled = (num >= pdfDoc.numPages);
                  });
                });
              }

              btnPrev.addEventListener('click', ()=> { if (pageNum>1){ pageNum--; render(pageNum); }});
              btnNext.addEventListener('click', ()=> { if (pageNum<pdfDoc.numPages){ pageNum++; render(pageNum); }});

              // キーボード左右対応
              wrapper.setAttribute('tabindex','0');
              wrapper.addEventListener('keydown', (e)=>{ if(e.key==='ArrowLeft') btnPrev.click(); if(e.key==='ArrowRight') btnNext.click(); });

              // 簡易レスポンシブ（ウィンドウリサイズで再描画）
              let resizeTimer;
              window.addEventListener('resize', ()=> {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(()=> { if(pdfDoc) render(pageNum); }, 150);
              });
            })();
            </script>
          <?php endif; ?>
        </div>

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