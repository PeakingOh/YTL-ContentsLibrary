<?php

require_once get_template_directory() . '/inc/assets.php';
require_once get_template_directory() . '/inc/env-uploads.php';

// アイキャッチ有効化
add_theme_support('post-thumbnails');

//固定ページで抜粋を使えるようにする
add_post_type_support( 'page', 'excerpt' );


// アイキャッチ画像取得
function get_thumb_img($size = 'full') {
  $thumb_id = get_post_thumbnail_id();                         // アイキャッチ画像のIDを取得
  $thumb_img = wp_get_attachment_image_src($thumb_id, $size);  // $sizeサイズの画像内容を取得
  $thumb_src = $thumb_img[0];    // 画像のurlだけ取得
  $thumb_alt = get_the_title();  //alt属性に入れるもの（記事のタイトルにしています）
  return '<img src="'.$thumb_src.'" alt="'.$thumb_alt.'">';
}


// 管理者バージョンアップ通知表示
function update_nag_admin_only() {
  if ( ! current_user_can( 'administrator' )) {
    remove_action( 'admin_notices', 'update_nag', 3 );
  }
}
add_action( 'admin_init', 'update_nag_admin_only' );

// タイトルタグ出力
add_theme_support( 'title-tag' );

// ページタイトル取得
function get_page_title() {
  $page_title = wp_get_document_title();
  return $page_title;
}

// サイトキャッチフレーズ非表示
function wp_document_title_parts( $title ) {
  if ( is_home() || is_front_page() ) {
    unset( $title['tagline'] );
  } 
  return $title;
}
add_filter( 'document_title_parts', 'wp_document_title_parts');

// description変更
function get_description() {
  if(is_single()) {
    $description = get_the_excerpt();
  }
  elseif(is_front_page()) {
    $description = "人材育成を通じ、医療への貢献を目指します。私たちYTLは、患者様や医療従事者に寄り添った活動ができる「学び」のサポートをいたします。";
  }
  elseif(is_page()) {
    $description = get_the_excerpt();
  }
  elseif(is_home()) {
    $description = "一覧ページ";
  }
  if(empty($description)) {
    $description = bloginfo('description');
  }
  return $description;
}

// デフォルトsitemapを無効化
add_filter( 'wp_sitemaps_enabled', '__return_false' );

$post_types = [
  'video_library' => '動画ライブラリ',
  'material'      => 'スライド資料',
];

// カスタム投稿登録（既存コードそのまま）
foreach ($post_types as $slug => $name) {
  register_post_type($slug, [
      'labels' => [
          'name'          => $name,
          'singular_name' => $name,
          'add_new'       => '新規追加',
          'add_new_item'  => "{$name}を追加",
          'edit_item'     => "{$name}を編集",
          'view_item'     => "{$name}を表示",
      ],
      'public'        => true,
      'has_archive'   => true,
      'menu_position' => 5,
      'supports'      => ['title', 'editor', 'thumbnail'],
      'show_in_rest'  => true,
  ]);
}

// 共通カテゴリー（階層あり）
register_taxonomy('common_category', array_keys($post_types), [
  'labels' => [
      'name'              => '共通カテゴリー',
      'singular_name'     => '共通カテゴリー',
      'search_items'      => 'カテゴリーを検索',
      'all_items'         => 'すべてのカテゴリー',
      'parent_item'       => '親カテゴリー',
      'parent_item_colon' => '親カテゴリー:',
      'edit_item'         => 'カテゴリーを編集',
      'update_item'       => 'カテゴリーを更新',
      'add_new_item'      => '新しいカテゴリーを追加',
      'new_item_name'     => '新しいカテゴリー名',
      'menu_name'         => 'カテゴリー',
  ],
  'hierarchical'  => true,
  'public'        => true,
  'show_in_rest'  => true,
]);

// タグ（階層なし・投稿タイプ共通）
add_action('init', 'register_common_tag_taxonomy');
function register_common_tag_taxonomy() {

  register_taxonomy('common_tag', ['video_library', 'material'], [
    'labels' => [
        'name'                       => 'タグ',
        'singular_name'              => 'タグ',
        'menu_name'                  => 'タグ',
        'all_items'                  => 'すべてのタグ',
        'edit_item'                  => 'タグを編集',
        'view_item'                  => 'タグを表示',
        'update_item'                => 'タグを更新',
        'add_new_item'               => '新しいタグを追加',
        'new_item_name'              => '新しいタグ名',
        'search_items'               => 'タグを検索',
        'popular_items'              => '人気のタグ',
        'separate_items_with_commas' => 'カンマで区切ってタグを入力',
        'add_or_remove_items'        => 'タグを追加または削除',
        'choose_from_most_used'      => 'よく使われているタグから選択',
        'not_found'                  => 'タグが見つかりません',
    ],
    'hierarchical' => true, // タグは階層なし
    'public'       => true,
    'show_ui'      => true,
    'show_in_rest' => true,
  ]);
}

/*------------------------------------
 * カスタム投稿（video_library・material）
 * のパーマリンクを prefix + ID に変更
------------------------------------*/
add_filter('post_type_link', 'custom_post_type_id_permalink', 10, 2);
function custom_post_type_id_permalink($post_link, $post) {

    if ('video_library' === $post->post_type) {
        return home_url('/video_library/' . $post->ID . '/');
    }

    if ('material' === $post->post_type) {
        return home_url('/material/' . $post->ID . '/');
    }

    return $post_link;
}

/*------------------------------------
 * リライトルール
------------------------------------*/
add_action('init', 'custom_post_type_id_rewrite');
function custom_post_type_id_rewrite() {

    // video_library
    add_rewrite_rule(
        'video_library/([0-9]+)/?$',
        'index.php?post_type=video_library&p=$matches[1]',
        'top'
    );

    // material
    add_rewrite_rule(
        'material/([0-9]+)/?$',
        'index.php?post_type=material&p=$matches[1]',
        'top'
    );
}



/**
 * ライブラリ絞り込み用の投稿 HTML を生成
 *
 * 本番 nginx が /wp-admin/ を 403 にするため、admin-ajax ではなく REST から使う。
 */
function ytl_get_library_posts_html( $post_type, $parent = '', $term = '' ) {
  $post_type = sanitize_text_field( (string) $post_type );
  $parent    = sanitize_text_field( (string) $parent );
  $term      = sanitize_text_field( (string) $term );

  if ( ! $post_type || ! in_array( $post_type, array( 'video_library', 'material' ), true ) ) {
    return '<p class="nopost">不正な投稿タイプです</p>';
  }

  $tax_query = array();

  if ( $parent ) {
    $parent_term = get_term_by( 'slug', $parent, 'common_category' );

    if ( $parent_term ) {
      if ( $term === 'all' ) {
        $child_terms = get_terms(
          array(
            'taxonomy'   => 'common_category',
            'hide_empty' => true,
            'parent'     => $parent_term->term_id,
            'fields'     => 'ids',
          )
        );

        if ( is_wp_error( $child_terms ) ) {
          $child_terms = array();
        }

        $terms = array_merge( array( $parent_term->term_id ), $child_terms );

        $tax_query[] = array(
          'taxonomy' => 'common_category',
          'field'    => 'term_id',
          'terms'    => $terms,
          'operator' => 'IN',
        );
      } else {
        $tax_query[] = array(
          'taxonomy' => 'common_category',
          'field'    => 'slug',
          'terms'    => $term,
        );
      }
    }
  }

  $query = new WP_Query(
    array(
      'post_type'      => $post_type,
      'posts_per_page' => -1,
      'tax_query'      => $tax_query,
    )
  );

  ob_start();

  if ( $query->have_posts() ) {
    echo '<h3>検索結果</h3>';
    echo '<div class="post-items">';

    while ( $query->have_posts() ) {
      $query->the_post();

      $permalink  = get_permalink();
      $categories = get_the_terms( get_the_ID(), 'common_category' );

      echo '<div class="post-contents">';
      echo '<a href="' . esc_url( $permalink ) . '" class="post-item">';
      if ( has_post_thumbnail() ) {
        the_post_thumbnail( 'large' );
      }
      echo '<div class="text-box">';
      echo '<h4>' . esc_html( get_the_title() ) . '</h4>';
      echo '<p>' . esc_html( get_the_excerpt() ) . '</p>';
      if ( $categories && ! is_wp_error( $categories ) ) {
        foreach ( $categories as $cat ) {
          if ( $cat->parent ) {
            $parent_term  = get_term( $cat->parent, 'common_category' );
            $parent_class = $parent_term && ! is_wp_error( $parent_term )
              ? 'parent-cat-' . $parent_term->slug
              : 'parent-cat-default';
          } else {
            $parent_class = 'parent-cat-' . $cat->slug;
          }
          echo '<p class="post-categories ' . esc_attr( $parent_class ) . '">' . esc_html( $cat->name ) . '</p>';
        }
      }
      echo '</div>';
      echo '</a>';
      echo '</div>';
    }

    echo '</div>';
  } else {
    echo '<p class="nopost">関連する投稿はまだありません。</p>';
  }

  wp_reset_postdata();

  return (string) ob_get_clean();
}

// 後方互換: admin-ajax（ローカル等で /wp-admin が使える環境向け）
function register_post_type_ajax( $post_types = array( 'video_library', 'material' ) ) {
  foreach ( $post_types as $type ) {
    add_action( "wp_ajax_fetch_{$type}", 'fetch_post_type_posts' );
    add_action( "wp_ajax_nopriv_fetch_{$type}", 'fetch_post_type_posts' );
  }
}
add_action(
  'init',
  function () {
    register_post_type_ajax();
  }
);

function fetch_post_type_posts() {
  $post_type = sanitize_text_field( wp_unslash( $_POST['post_type'] ?? '' ) );
  $parent    = sanitize_text_field( wp_unslash( $_POST['parent'] ?? '' ) );
  $term      = sanitize_text_field( wp_unslash( $_POST['term'] ?? '' ) );

  echo ytl_get_library_posts_html( $post_type, $parent, $term );
  wp_die();
}

// 本番で /wp-admin が 403 でも使える REST エンドポイント
function ytl_register_library_posts_rest_route() {
  register_rest_route(
    'ytl/v1',
    '/library-posts',
    array(
      'methods'             => 'GET',
      'permission_callback' => '__return_true',
      'args'                => array(
        'post_type' => array(
          'required' => true,
          'type'     => 'string',
        ),
        'parent'    => array(
          'required' => false,
          'type'     => 'string',
          'default'  => '',
        ),
        'term'      => array(
          'required' => false,
          'type'     => 'string',
          'default'  => '',
        ),
      ),
      'callback'            => function ( WP_REST_Request $request ) {
        $html = ytl_get_library_posts_html(
          $request->get_param( 'post_type' ),
          $request->get_param( 'parent' ),
          $request->get_param( 'term' )
        );

        return new WP_REST_Response(
          array(
            'html' => $html,
          ),
          200
        );
      },
    )
  );
}
add_action( 'rest_api_init', 'ytl_register_library_posts_rest_route' );

// フロント用に REST URL を渡す（scripts.js 自体は footer で CDN jQuery の後に読み込む）
function enqueue_post_type_scripts() {
  // 実ファイルの無い handle だと環境によって localize が欠けるため、空スクリプトで登録する
  wp_register_script( 'ytl-scripts-config', false, array(), null, true );
  wp_enqueue_script( 'ytl-scripts-config' );

  wp_localize_script(
    'ytl-scripts-config',
    'PostTypeAjax',
    array(
      'restUrl' => esc_url_raw( rest_url( 'ytl/v1/library-posts' ) ),
    )
  );
}
add_action( 'wp_enqueue_scripts', 'enqueue_post_type_scripts' );





// ====================================================
// 管理者に新規申請者（購読者）を非表示
// ====================================================
add_action('pre_get_users', function($query) {
  if(!is_admin()) return;

  $current_user = wp_get_current_user();
  
  if(current_user_can('administrator')) {
      // 管理者は購読者を除外
      $query->set('role__not_in', ['subscriber']);
  }
});

add_action('admin_head', function() {
  if (!current_user_can('administrator')) {
      echo '<style>
          .update-nag, .notice, .update-message { display: none !important; }
      </style>';
  }
});

add_action('admin_menu', function() {
  $user = wp_get_current_user();
  if (in_array('user_admin', $user->roles)) {
      remove_menu_page('tools.php');
  }
}, 9999);

// ACF メニュー非表示（安全策）
add_action('admin_menu', function() {
  $user = wp_get_current_user();
  if (array_intersect(['ytl_admin','user_admin','editor'], $user->roles)) {
      remove_menu_page('edit.php?post_type=acf-field-group');
  }
}, 999);

add_action('admin_menu', function() {
  $user = wp_get_current_user();
  $restricted_roles = ['ytl_admin','user_admin','editor'];
  if (!array_intersect($restricted_roles, $user->roles)) return;

  // 標準メニュー非表示
  remove_menu_page('plugins.php');       // プラグイン
  remove_menu_page('tools.php');         // ツール
  remove_menu_page('options-general.php'); // 設定
  remove_menu_page('edit-comments.php'); // コメント

  // プラグイン個別メニュー（スラッグ要確認）
  remove_menu_page('ultimatemember');   // Ultimate Member
  remove_menu_page('siteguard');   // SiteGuard
  remove_menu_page('wpcf7');       // Contact Form 7
  remove_menu_page('wordfence');   // Wordfence
  remove_menu_page('wp-mail-smtp');   // wp-mail-smtp

  // ユーザー一覧は editor のみ非表示
  if (in_array('editor', $user->roles)) {
      remove_menu_page('users.php');
  }
}, 999);

// 管理者以外はダッシュボードを完全に空にする
function customize_dashboard_for_non_admin() {

  if (!current_user_can('administrator')) {

       // WP Mail SMTP
       remove_meta_box('wp_mail_smtp_reports_widget_lite', 'dashboard', 'normal');

       // Wordfence
       remove_meta_box('wordfence_activity_report_widget', 'dashboard', 'normal');

  }

}
add_action('wp_dashboard_setup', 'customize_dashboard_for_non_admin');


// ----------------------------
// Ultimate Member: 任意のフィールドをDBに保存せずメール通知
// ----------------------------

add_action('um_registration_complete', function($user_id) {
  // POSTデータから各フィールドを取得
  $user_name        = isset($_POST['user_name']) ? sanitize_text_field($_POST['user_name']) : '';
  $company     = isset($_POST['company']) ? sanitize_text_field($_POST['company']) : '';
  $department  = isset($_POST['department']) ? sanitize_text_field($_POST['department']) : '';
  $phone       = isset($_POST['phone-251']) ? sanitize_text_field($_POST['phone-251']) : '';
  $purpose     = isset($_POST['purpose']) ? sanitize_text_field($_POST['purpose']) : '';

  // 念のためユーザーメタから削除
  delete_user_meta($user_id, 'user_name');
  delete_user_meta($user_id, 'company');
  delete_user_meta($user_id, 'department');
  delete_user_meta($user_id, 'phone');
  delete_user_meta($user_id, 'purpose');

  // ----------------------------
  // 任意のメールアドレスに通知
  // ----------------------------
  $admin_email = array(
    'ytl.contentslibrary@ytl.jp'
  );
  $user_info   = get_userdata($user_id);

  $subject = '【通知】新規会員登録の申請がありました';

  $newsletter = get_user_meta( $user_id, 'newsletter', true );
  $newsletter_status = $newsletter ? "有り" : "無し";

  // メッセージ本文
  $message  = "以下のユーザーが会員登録を申請しました。管理画面から審査を行ってください。\n\n";
  $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
 $message .= "■ ユーザー名： " . $user_info->user_login . " | |\n";
 $message .= "■ 氏名： " . $user_name . " | |\n";
 $message .= "■ 会社名： " . $company . " | |\n";
 $message .= "■ 部署： " . $department . " | |\n";
 $message .= "■ 電話番号： " . $phone . " | |\n";
 $message .= "■ ご利用目的： " . $purpose . " | |\n";
 $message .= "■ メルマガ同意： " . $newsletter_status . " | |\n";
  $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
  $message .= "\n管理画面はこちらから：\n";
  $message .= home_url('/wp-admin/users.php');

  wp_mail($admin_email, $subject, $message);

}, 10, 1);

// 管理画面のユーザー一覧で英語表記を日本語に変換
add_filter('gettext', function($translated_text, $text, $domain) {
  $translations = array(
      'Pending administrator review' => '管理者承認待ち',
      'Approve' => '承認',
      'Reject' => '拒否',
      'Send activation email' => '有効化メールを送信',
      'Deactivate' => '無効化',
      'Put as pending' => '保留にする',
      'Membership rejected' => '登録が拒否されました',
  );

  if (isset($translations[$text])) {
      return $translations[$text];
  }

  return $translated_text;
}, 10, 3);


// ユーザー登録時にメールアドレスからユーザー名を自動生成
function auto_generate_username($user_id) {
  $user_info = get_userdata($user_id);
  if (!$user_info->user_login) {
      $email = $user_info->user_email;
      $username = sanitize_user(current(explode('@', $email)), true);
      wp_update_user([
          'ID' => $user_id,
          'user_login' => $username,
      ]);
  }
}
add_action('user_register', 'auto_generate_username');


// ログイン時にメールアドレスでも認証できるようにする
function login_with_email_only($user, $username, $password) {
  if (is_a($user, 'WP_User')) {
      return $user;
  }

  if (empty($username) || empty($password)) {
      return $user;
  }

  // 入力がメールアドレスならユーザー名に変換
  if (is_email($username)) {
      $user_obj = get_user_by('email', $username);
      if ($user_obj) {
          $username = $user_obj->user_login;
      }
  }

  return wp_authenticate_username_password(null, $username, $password);
}
add_filter('authenticate', 'login_with_email_only', 20, 3);


// ログイン失敗時にカスタムログインページへ戻す
function custom_login_failed_redirect($username) {
    $referrer = $_SERVER['HTTP_REFERER'];
    if ($referrer && !strstr($referrer, 'wp-login.php') && !strstr($referrer, 'wp-admin')) {
        wp_redirect(add_query_arg('login', 'failed', $referrer));
        exit;
    }
}
add_action('wp_login_failed', 'custom_login_failed_redirect');


// Ultimate Member 登録・パスワード変更時のカスタムバリデーション（購読者のみ）
function um_validate_password_complexity( $args ) {
  if ( isset( $args['user_password'] ) && !empty( $args['user_password'] ) ) {
      // ユーザーロールを取得
      $user_role = '';
      
      // 新規登録時: $args['role'] から取得
      if ( isset( $args['role'] ) ) {
          $user_role = $args['role'];
      } 
      // パスワード変更時: 現在のユーザーのロールを取得
      elseif ( is_user_logged_in() ) {
          $current_user = wp_get_current_user();
          $roles = $current_user->roles;
          $user_role = !empty($roles) ? $roles[0] : '';
      }
      
      // 購読者（subscriber）の場合のみパスワード複雑性をチェック
      if ( $user_role === 'subscriber' ) {
          $password = $args['user_password'];

          // 8文字以上
          if ( strlen($password) < 8 ) {
              UM()->form()->add_error('user_password', 'パスワードは8文字以上にしてください。');
          }

          // 大文字1文字以上
          if ( !preg_match('/[A-Z]/', $password) ) {
              UM()->form()->add_error('user_password', 'パスワードには少なくとも1つ大文字を含めてください。');
          }

          // 数字1文字以上
          if ( !preg_match('/[0-9]/', $password) ) {
              UM()->form()->add_error('user_password', 'パスワードには少なくとも1つ数字を含めてください。');
          }

          // 英字1文字以上（小文字でも可）
          if ( !preg_match('/[a-z]/', $password) ) {
              UM()->form()->add_error('user_password', 'パスワードには少なくとも1つ英字を含めてください。');
          }
      }
  }
}
add_action('um_submit_form_errors_hook', 'um_validate_password_complexity', 10, 1);

// // 登録完了ページのテキスト変更
// add_filter('gettext', function($translated_text, $text, $domain) {

//   if (strpos($translated_text, '承認を知らせるメール') !== false) {
//       return 'このたびは会員申請いただき、誠にありがとうございます。ご登録いただいたメールアドレス宛に、申請に関するご案内メールをお送りいたします。';
//   }

//   return $translated_text;

// }, 20, 3);













?>
