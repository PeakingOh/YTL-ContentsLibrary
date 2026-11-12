		<footer id="global-footer">
      <div class="contact">
        <div class="container">
          <div class="text-area">
            <p>会員登録をしていただくと<span>動画やスライド詳細をご確認いただけます。</span></p>
          </div>

          <div class="contact-button">
            <a href="<?php echo home_url(); ?>/member/">
              <div class="flex-box">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="34" height="34" viewBox="0 0 34 34">
                  <g id="グループ_2522" data-name="グループ 2522" transform="translate(-0.257 -0.257)" clip-path="url(#clip-path)">
                    <path id="パス_10755" data-name="パス 10755" d="M27.127,27.423a8.426,8.426,0,0,0-8.169-6.359H14.745a8.426,8.426,0,0,0-8.169,6.359,14.745,14.745,0,1,1,20.551,0m-1.876,1.54a14.739,14.739,0,0,1-16.805.007,6.32,6.32,0,0,1,6.3-5.8h4.213a6.324,6.324,0,0,1,6.3,5.8Zm-8.4,4.739A16.851,16.851,0,1,0,0,16.851,16.851,16.851,0,0,0,16.851,33.7m0-16.108a3.16,3.16,0,1,1,3.16-3.16,3.16,3.16,0,0,1-3.16,3.16m-5.266-3.16a5.266,5.266,0,1,0,5.266-5.266,5.266,5.266,0,0,0-5.266,5.266" transform="translate(0.235 0.235)" fill="#011976"/>
                  </g>
                </svg>
                <span>ログイン・会員登録はこちら</span>
              </div>
            </a>
          </div>
        </div>
      </div>

      <div class="top">
				<div class="container">
					<div class="flex-box">
						<div class="left">
              <h1>
                <a href="<?php echo home_url(); ?>">
                <div class="logo">
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="">
                </div>
                </a>
              </h1>
						</div>

            <div class="right">
              <div class="company-link">
                <p>Information</p>
                <ul>
                  <li><a href="<?php echo home_url(); ?>"><span>ホーム</span></a></li>
                  <li><a href="<?php echo home_url(); ?>/news/"><span>お知らせ</span></a></li>
                  <li><a href="<?php echo home_url(); ?>/about/"><span>会社概要</span></a></li>
                  <li><a href="<?php echo home_url(); ?>/contact/"><span>お問い合わせ</span></a></li>
                  <li><a href="<?php echo home_url(); ?>/member/"><span>ログイン・会員登録</span></a></li>
                  <li><a href="<?php echo home_url(); ?>/terms/"><span>利用規約</span></a></li>
                  <li><a href="https://igakuacademy.ac.jp/privacy/" target="_blank"><span>プライバシーポリシー</span></a></li>
                </ul>
              </div>

              <div class="company-link">
                <p>Medical Content</p>
                <ul>
                  <li><a href="<?php echo home_url(); ?>/medical/"><span>疾患別コンテンツ</span></a></li>
                  <li><a href="<?php echo home_url(); ?>/healthcare/"><span>医療制度コンテンツ</span></a></li>
                  <li><a href="<?php echo home_url(); ?>/skill/"><span>スキル研修</span></a></li>
                  <!-- <li><a href="<?php echo home_url(); ?>/webinar/"><span>Web講演会</span></a></li> -->
                  <!-- <li><a href="<?php echo home_url(); ?>/info-material/"><span>情報提供資料</span></a></li> -->
                </ul>
              </div>

              
            </div>
					</div>
				</div>
			</div>

			<div class="bottom">©︎ 2025 YTL</div>
		</footer>
    <?php wp_footer(); ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="<?php echo esc_url( site_get_asset_uri( 'assets/js/scripts.js' ) ); ?>"></script>
  </body>
</html>
