<?php /*
Template Name: 情報提供資材 一覧
*/ ?>


<?php get_header(); ?>

<main>
  <section id="section-title">
    <h2>情報提供資材</h2>
  </section>

  <div class="container">
    <section id="section-message">
      <p>
        医療従事者とのリレーションを活かしたコンタクト、薬剤師向けメディアを活用したプロモーション支援、
        <span>さらに企画立案から制作まで一貫対応するコンテンツ制作など、多角的なプロモーション施策をご提案しています。</span>
      </p>
    </section>

    <section id="section-contents-list">
      <ul>
        <li>
          <a href="<?php echo home_url(); ?>/info-material/professional">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/material/material_icon01.svg" alt="医療従事者向け">
            </figure>
            <p>医療従事者向け</p>
          </a>
        </li>

        <li>
          <a href="<?php echo home_url(); ?>/info-material/patient">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/material/material_icon02.svg" alt="患者向け">
            </figure>
            <p>患者向け</p>
          </a>
        </li>
      </ul>
    </section>
  </div>

</main>

<?php get_footer(); ?>