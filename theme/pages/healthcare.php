<?php /*
Template Name: 医療制度コンテンツ 一覧
*/ ?>


<?php get_header(); ?>

<main>
  <section id="section-title">
    <h2>医療制度コンテンツ</h2>
  </section>

  <div class="container">
    <section id="section-message">
      <p>医療業界を取り巻く環境変化をふまえ、修得した知識を役立てるようサポートいたします。</p>
    </section>

    <section id="section-contents-list">
      <ul>
        <li>
          <a href="<?php echo home_url(); ?>/healthcare/system/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/healthcare/healthcare_icon01.svg" alt="医療制度">
            </figure>
            <p>医療制度</p>
          </a>
        </li>

        <li>
          <a href="<?php echo home_url(); ?>/healthcare/ethics/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/healthcare/healthcare_icon02.svg" alt="倫理">
            </figure>
            <p>倫理</p>
          </a>
        </li>

        <li>
          <a href="<?php echo home_url(); ?>/healthcare/safety/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/healthcare/healthcare_icon03.svg" alt="医療安全">
            </figure>
            <p>医療安全</p>
          </a>
        </li>
      </ul>
    </section>
  </div>

</main>

<?php get_footer(); ?>