<?php /*
Template Name:ログイン・会員登録
*/ ?>


<?php get_header(); ?>

<main>
  <section id="library-section-title">
    <h2>ログイン・新規会員登録</h2>
  </section>

  <div class="container">
		<section id="contact-message">
			<h3>本サイトの資材は、製薬企業等の会員様限定で提供しております。</h3>
			<p>コンテンツをご覧になるには、ログインまたは新規会員登録をお願いいたします。</p>
		</section>


    <div class="auth-page">
      <div class="login-box">
        <h4>
            <?php echo is_user_logged_in() ? 'ログイン済みです' : 'ログイン'; ?>
            <span>会員登録されている方</span>
        </h4>

        <?php if ( is_user_logged_in() ) : ?>
            <!-- ログイン中：ログアウトボタンのみ表示 -->
            <p>
                <a href="<?php echo wp_logout_url( get_permalink() ); ?>" class="button logout-button">ログアウト</a>
            </p>

        <?php else : ?>

            <?php
            // リダイレクト先を取得（パラメータがあればそちら、なければこのページ）
            $redirect_to = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : get_permalink();

            // ログインフォーム
            $args = [
                'redirect'       => $redirect_to,
                'label_username' => 'メールアドレス',
                'label_password' => 'パスワード',
                'label_remember' => 'ログイン状態を保存する',
                'label_log_in'   => 'ログイン',
                'id_username'    => 'login_username',
                'id_password'    => 'login_password',
                'id_submit'      => 'login_submit',
            ];

            wp_login_form($args);
            ?>

            <!-- ログイン失敗エラー -->
            <?php if ( isset($_GET['login']) && $_GET['login'] == 'failed' ) : ?>
              <p class="login-error">ログインに失敗しました。メールアドレスとパスワードをご確認ください。</p>
            <?php endif; ?>

            <!-- パスワードを忘れた方 -->
            <p class="lost-password">
              <a href="<?php echo home_url(); ?>/password-reset/">パスワードを忘れた方はこちら</a>
            </p>

        <?php endif; ?>
      </div>


      <div class="register-box">
        <h4>新規会員登録<span>会員登録されていない方</span></h4>
        <p class="text">
          本サイトは、国内の製薬企業および医療機関に勤務する医療関係者向けの限定コンテンツを提供しております。
          <span class="indent">詳細な資材の閲覧には<span class="marker">審査制の会員登録</span>が必要です。</span>
          <span class="sub">※ 国外の医療関係者や一般の方への提供は対象外です。ご了承ください。</span>
        </p>

        <?php if (is_user_logged_in()) : ?>
          <!-- ログイン済みならクリックでメッセージ -->
          <button type="button" class="register-link" onclick="alert('ログイン済みです');">
            会員登録はこちら
          </button>
        <?php else : ?>
          <!-- 未ログインなら会員登録ページへ -->
          <a class="register-link" href="<?php echo home_url(); ?>/signup/">
            会員登録はこちら
          </a>
        <?php endif; ?>

        <div class="flex-box">
          <div class="contents">
            <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/images/login_contents01.jpg" alt="YTL"> -->
            <div class="title-box">
              <p class="title">疾患別コンテンツ</p>
              <p class="lead">疾患教育や症例フォローに役立つ資材を幅広く制作しています。</p>
            </div>
          </div>

          <div class="contents">
            <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/images/login_contents01.jpg" alt="YTL"> -->
            <div class="title-box">
              <p class="title">医療制度コンテンツ</p>
              <p class="lead">医療業界を取り巻く環境変化をふまえ、修得した知識を役立てるようサポートいたします。</p>
            </div>
          </div>

          <div class="contents">
            <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/images/login_contents01.jpg" alt="YTL"> -->
            <div class="title-box last">
              <p class="title">スキル研修</p>
              <p class="lead">ご要望に合わせた資材作成から研修プランの立案・運営までサポートし、質の高い人材育成をサポートいたします。</p>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>

</main>

<?php get_footer(); ?>