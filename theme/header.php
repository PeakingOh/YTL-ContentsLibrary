<!doctype html>
<html class="no-js" lang="ja">
  <head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8R8WJ2PXHJ"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-8R8WJ2PXHJ');
    </script>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_page_title(); ?></title>
	  <meta name="description" content="<?php echo get_description(); ?>">
	  <meta property="og:title" content="<?php echo get_page_title(); ?>">
	  <meta property="og:type" content="website">
	  <meta property="og:description" content="<?php echo get_description(); ?>">
		<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/assets/images/ogimage.jpg" />
	  <link href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png" rel="shortcut icon" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo esc_url( site_get_asset_uri( 'assets/css/styles.css' ) ); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
		<?php wp_head(); ?>
  </head>
  
  <body <?php body_class(); ?>>
  <div id="global-header">
    <div class="header--inner header-sp">
      <h1>
        <a href="<?php echo home_url(); ?>">
          <div class="logo">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="">
          </div>
        </a>
      </h1>

      <div class="right-box">
        <div class="sub-nav large-view">
          <div class="search-link">
            <a href="<?php echo home_url(); ?>/video-library/">
              <svg xmlns="http://www.w3.org/2000/svg" width="30.253" height="33.159" viewBox="0 0 30.253 33.159" aria-hidden="true" focusable="false">
                <g transform="translate(-1201 -22)">
                  <path d="M14,2A12,12,0,0,0,5.515,22.485,12,12,0,1,0,22.485,5.515,11.921,11.921,0,0,0,14,2m0-2A14,14,0,1,1,0,14,14,14,0,0,1,14,0Z" transform="translate(1201 22)" fill="currentColor"/>
                  <path d="M6.247,8.658l-7-8L.753-.659l7,8Z" transform="translate(1223.5 46.5)" fill="currentColor"/>
                </g>
              </svg>
              <span>動画ライブラリ</span>
            </a>
          </div>

          <div class="search-link">
            <a href="<?php echo home_url(); ?>/material/">
              <svg xmlns="http://www.w3.org/2000/svg" width="30.253" height="33.159" viewBox="0 0 30.253 33.159" aria-hidden="true" focusable="false">
                <g transform="translate(-1201 -22)">
                  <path d="M14,2A12,12,0,0,0,5.515,22.485,12,12,0,1,0,22.485,5.515,11.921,11.921,0,0,0,14,2m0-2A14,14,0,1,1,0,14,14,14,0,0,1,14,0Z" transform="translate(1201 22)" fill="currentColor"/>
                  <path d="M6.247,8.658l-7-8L.753-.659l7,8Z" transform="translate(1223.5 46.5)" fill="currentColor"/>
                </g>
              </svg>
              <span>スライド資料</span>
            </a>
          </div>
        </div>

        <div class="contact-nav medium-view">
          <ul>
            <li class="inquiry"><a href="<?php echo home_url(); ?>/contact/"><span>お問い合わせ</span></a></li>
            <li class="download"><a href="<?php echo home_url(); ?>/member/"><span>ログイン・会員登録</span></a></li>
          </ul>
        </div>

        <div class="search-button">
          <a href="<?php echo home_url(); ?>/search/">
            <svg xmlns="http://www.w3.org/2000/svg" width="30.253" height="33.159" viewBox="0 0 30.253 33.159" aria-hidden="true" focusable="false">
              <g transform="translate(-1201 -22)">
                <path d="M14,2A12,12,0,0,0,5.515,22.485,12,12,0,1,0,22.485,5.515,11.921,11.921,0,0,0,14,2m0-2A14,14,0,1,1,0,14,14,14,0,0,1,14,0Z" transform="translate(1201 22)" fill="currentColor"/>
                <path d="M6.247,8.658l-7-8L.753-.659l7,8Z" transform="translate(1223.5 46.5)" fill="currentColor"/>
              </g>
            </svg>
          </a>
        </div>

        <div id="nav-toggle">
          <span></span>
          <span></span>
          <span></span>
        </div>

        <nav class="sp-nav">
          <h1>
            <a href="<?php echo home_url(); ?>">
              <div class="logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_white.svg" alt="">
              </div>
            </a>
          </h1>

          <div class="inner">
            <div class="main-wrapper">
              <div class="main-nav">
                <div class="menu-lavel">
                  <p>Company Information</p>
                  <ul>
                    <li><a href="<?php echo home_url(); ?>">ホーム<span>Home</span></a></li>
                    <li><a href="<?php echo home_url(); ?>/news/">お知らせ<span>News</span></a></li>
                    <li><a href="<?php echo home_url(); ?>/about/">会社概要<span>About</span></a></li>
                  </ul>

                  <div class="sub-nav sub-nav-pc">
                    <div class="search-link">
                      <a href="<?php echo home_url(); ?>/video-library/">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30.253" height="33.159" viewBox="0 0 30.253 33.159" aria-hidden="true" focusable="false">
                          <g transform="translate(-1201 -22)">
                            <path d="M14,2A12,12,0,0,0,5.515,22.485,12,12,0,1,0,22.485,5.515,11.921,11.921,0,0,0,14,2m0-2A14,14,0,1,1,0,14,14,14,0,0,1,14,0Z" transform="translate(1201 22)" fill="currentColor"/>
                            <path d="M6.247,8.658l-7-8L.753-.659l7,8Z" transform="translate(1223.5 46.5)" fill="currentColor"/>
                          </g>
                        </svg>
                        <span>動画ライブラリ</span>
                      </a>
                    </div>

                    <div class="search-link">
                      <a href="<?php echo home_url(); ?>/material/">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30.253" height="33.159" viewBox="0 0 30.253 33.159" aria-hidden="true" focusable="false">
                          <g transform="translate(-1201 -22)">
                            <path d="M14,2A12,12,0,0,0,5.515,22.485,12,12,0,1,0,22.485,5.515,11.921,11.921,0,0,0,14,2m0-2A14,14,0,1,1,0,14,14,14,0,0,1,14,0Z" transform="translate(1201 22)" fill="currentColor"/>
                            <path d="M6.247,8.658l-7-8L.753-.659l7,8Z" transform="translate(1223.5 46.5)" fill="currentColor"/>
                          </g>
                        </svg>
                        <span>スライド資料</span>
                      </a>
                    </div>
                  </div>
                </div>

                <div class="menu-lavel">
                  <p>Medical Resources</p>
                  <ul>
                    <li><a href="<?php echo home_url(); ?>/medical/">疾患別コンテンツ<span>Medical</span></a></li>
                    <li><a href="<?php echo home_url(); ?>/healthcare/">医療制度コンテンツ<span>Healthcare</span></a></li>
                    <li><a href="<?php echo home_url(); ?>/skill/">スキル研修<span>Skills Training</span></a></li>
                    <!-- <li><a href="<?php echo home_url(); ?>/webinar/">Web講演会<span>Webinar</span></a></li> -->
                    <!-- <li><a href="<?php echo home_url(); ?>/info-material/">情報提供資材<span>Material</span></a></li> -->
                  </ul>
                </div>
              </div>

              <div class="sub-nav sub-nav-sp">
                <div class="search-link">
                  <a href="<?php echo home_url(); ?>/video-library/">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30.253" height="33.159" viewBox="0 0 30.253 33.159" aria-hidden="true" focusable="false">
                      <g transform="translate(-1201 -22)">
                        <path d="M14,2A12,12,0,0,0,5.515,22.485,12,12,0,1,0,22.485,5.515,11.921,11.921,0,0,0,14,2m0-2A14,14,0,1,1,0,14,14,14,0,0,1,14,0Z" transform="translate(1201 22)" fill="currentColor"/>
                        <path d="M6.247,8.658l-7-8L.753-.659l7,8Z" transform="translate(1223.5 46.5)" fill="currentColor"/>
                      </g>
                    </svg>
                    <span>動画ライブラリ</span>
                  </a>
                </div>

                <div class="search-link">
                  <a href="<?php echo home_url(); ?>/material/">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30.253" height="33.159" viewBox="0 0 30.253 33.159" aria-hidden="true" focusable="false">
                      <g transform="translate(-1201 -22)">
                        <path d="M14,2A12,12,0,0,0,5.515,22.485,12,12,0,1,0,22.485,5.515,11.921,11.921,0,0,0,14,2m0-2A14,14,0,1,1,0,14,14,14,0,0,1,14,0Z" transform="translate(1201 22)" fill="currentColor"/>
                        <path d="M6.247,8.658l-7-8L.753-.659l7,8Z" transform="translate(1223.5 46.5)" fill="currentColor"/>
                      </g>
                    </svg>
                    <span>スライド資料</span>
                  </a>
                </div>
              </div>
            </div>
            
            <div class="buttom-nav">
              <ul>
                <li class="inquiry"><a href="<?php echo home_url(); ?>/contact/"><span>お問い合わせ</span></a></li>
                <li class="download"><a href="<?php echo home_url(); ?>/member/"><span>ログイン・会員登録</span></a></li>
              </ul>
            </div>
          </div>
            
        </nav>
      </div>
    </div>

    <div class="header-pc">
      <nav class="header-bottom">
        <ul class="menu">
          <li><a href="<?php echo home_url(); ?>">ホーム</a></li>
          <li><a href="<?php echo home_url(); ?>/news/">お知らせ</a></li>
          <li><a href="<?php echo home_url(); ?>/about/">会社概要</a></li>
          
          <li class="menu-item">
            <a href="<?php echo home_url(); ?>/medical/" class="parent-menu">疾患別コンテンツ</a>
            <div class="submenu">
              <ul>
                <li><a href="<?php echo home_url(); ?>/medical/onco/">悪性腫瘍</a></li>
                <li><a href="<?php echo home_url(); ?>/medical/hema/">血液疾患</a></li>
                <li><a href="<?php echo home_url(); ?>/medical/immune/">免疫・膠原病・感染症</a></li>
                <li><a href="<?php echo home_url(); ?>/medical/gastro/">消化器</a></li>
                <li><a href="<?php echo home_url(); ?>/medical/neuro/">脳・神経</a></li>
                <li><a href="<?php echo home_url(); ?>/medical/uro/">腎・泌尿器</a></li>
                <li><a href="<?php echo home_url(); ?>/medical/gyn-breast/">婦人科・乳腺</a></li>
                <li><a href="<?php echo home_url(); ?>/medical/resp/">呼吸器</a></li>
                <li><a href="<?php echo home_url(); ?>/medical/eye-ent/">眼・耳鼻</a></li>
                <li><a href="<?php echo home_url(); ?>/medical/derm/">皮膚</a></li>
                <li><a href="<?php echo home_url(); ?>/medical/rare/">希少疾患</a></li>
                <li><a href="<?php echo home_url(); ?>/medical/cardio/">循環器</a></li>
                <li><a href="<?php echo home_url(); ?>/medical/metabolic/">代謝・内分泌</a></li>
                <li><a href="<?php echo home_url(); ?>/medical/stats/">統計</a></li>
                <li class="last-row"><a href="<?php echo home_url(); ?>/medical/other/">その他</a></li>
              </ul>
            </div>
          </li>

          <li class="menu-item">
            <a href="<?php echo home_url(); ?>/healthcare/" class="parent-menu">医療制度コンテンツ</a>
            <div class="submenu">
              <ul>
                <li><a href="<?php echo home_url(); ?>/healthcare/system/">医療制度</a></li>
                <li><a href="<?php echo home_url(); ?>/healthcare/ethics/">倫理</a></li>
                <li><a href="<?php echo home_url(); ?>/healthcare/safety/">医療安全</a></li>
              </ul>
            </div>
          </li>

          <li>
            <a href="<?php echo home_url(); ?>/skill/"　class="parent-menu">スキル研修</a>
          </li>

          <!-- <li>
            <a href="<?php echo home_url(); ?>/webinar/"　class="parent-menu">Web講演会</a></li>
          </li> -->

          <!-- <li class="menu-item">
            <a href="<?php echo home_url(); ?>/info-material/" class="parent-menu">情報提供資材</a>
            <div class="submenu">
              <ul>
                <li><a href="<?php echo home_url(); ?>/healthcare/professional/">医療従事者向け</a></li>
                <li><a href="<?php echo home_url(); ?>/healthcare/patient/">患者向け</a></li>
              </ul>
            </div>
          </li> -->
        </ul>
      </nav>
    </div>

    <div class="information-button">
			<button class="fixed_btn">
				<a href="<?php echo home_url(); ?>/contact/">お問い合わせ</a>
			</button>
		</div>
    
  </div>