<?php /*
Template Name:キーワード・タグ検索
*/ ?>


<?php get_header(); ?>

<main>

<section id="library-section-title">
  <h2>キーワード検索</h2>
</section>

<div class="container">
  <div class="search-page">
    <div class="search-form">
      <h3>検索ワード</h3>
      <!-- キーワード検索フォーム -->
      <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="text" name="s" placeholder="キーワードを入力" value="">
        <button type="submit"><span>検索</span></button>
      </form>
    </div>

    <div class="tag-list">
      <h3>タグ一覧</h3>
      <?php
      $tags = get_terms([
        'taxonomy'   => 'common_tag',
        'hide_empty' => true,
      ]);

      if ($tags && !is_wp_error($tags)) {
        foreach ($tags as $tag) {
            echo '<a href="' . esc_url(get_term_link($tag)) . '" class="tag-item">';
            echo '<p>' . esc_html($tag->name) . '</p>';
            echo '</a>';
        }
      }
      ?>
    </div>
  </div>
</div>

</main>

<?php get_footer(); ?>