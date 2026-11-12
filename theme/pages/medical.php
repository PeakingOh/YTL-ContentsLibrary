<?php /*
Template Name: 疾患別コンテンツ 一覧
*/ ?>


<?php get_header(); ?>

<main>
  <section id="section-title">
    <h2>疾患別コンテンツ</h2>
  </section>

  <div class="container">
    <section id="section-message">
      <p>
        疾患教育に欠かせない『疫学』『病態生理』『診断・検査』『治療』に関する資材から、
        <span>患者様一人ひとりに寄り添った症例フォローのための多様な資材まで、幅広く制作しています。</span>
      </p>
    </section>

    <section id="section-contents-list">
      <ul>
        <li>
          <a href="<?php echo home_url(); ?>/medical/onco/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/medical/medical_icon09.svg" alt="悪性腫瘍">
            </figure>
            <p>悪性腫瘍</p>
          </a>
        </li>

        <li>
          <a href="<?php echo home_url(); ?>/medical/hema/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/medical/medical_icon11.svg" alt="血液疾患">
            </figure>
            <p>血液疾患</p>
          </a>
        </li>

        <li>
          <a href="<?php echo home_url(); ?>/medical/immune/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/medical/medical_icon02.svg" alt="免疫・膠原病・感染症">
            </figure>
            <p>免疫・膠原病・感染症</p>
          </a>
        </li>

        <li>
          <a href="<?php echo home_url(); ?>/medical/gastro/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/medical/medical_icon01.svg" alt="消化器">
            </figure>
            <p>消化器</p>
          </a>
        </li>

        <li>
          <a href="<?php echo home_url(); ?>/medical/neuro/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/medical/medical_icon03.svg" alt="脳・神経">
            </figure>
            <p>脳・神経</p>
          </a>
        </li>

        <li>
          <a href="<?php echo home_url(); ?>/medical/uro/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/medical/medical_icon04.svg" alt="腎・泌尿器">
            </figure>
            <p>腎・泌尿器</p>
          </a>
        </li>

        <li>
          <a href="<?php echo home_url(); ?>/medical/gyn-breast/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/medical/medical_icon05.svg" alt="婦人科・乳腺">
            </figure>
            <p>婦人科・乳腺</p>
          </a>
        </li>

        <li>
          <a href="<?php echo home_url(); ?>/medical/resp/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/medical/medical_icon06.svg" alt="呼吸器">
            </figure>
            <p>呼吸器</p>
          </a>
        </li>

        <li>
          <a href="<?php echo home_url(); ?>/medical/eye-ent/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/medical/medical_icon07.svg" alt="眼・耳鼻">
            </figure>
            <p>眼・耳鼻</p>
          </a>
        </li>

        <li>
          <a href="<?php echo home_url(); ?>/medical/derm/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/medical/medical_icon08.svg" alt="皮膚">
            </figure>
            <p>皮膚</p>
          </a>
        </li>

        <li>
          <a href="<?php echo home_url(); ?>/medical/rare/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/medical/medical_icon10.svg" alt="希少疾患">
            </figure>
            <p>希少疾患</p>
          </a>
        </li>

        <li>
          <a href="<?php echo home_url(); ?>/medical/cardio/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/medical/medical_icon13.svg" alt="循環器">
            </figure>
            <p>循環器</p>
          </a>
        </li>

        <li>
          <a href="<?php echo home_url(); ?>/medical/metabolic/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/medical/medical_icon14.svg" alt="代謝・内分泌">
            </figure>
            <p>代謝・内分泌</p>
          </a>
        </li>

        <li>
          <a href="<?php echo home_url(); ?>/medical/stats/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/medical/medical_icon12.svg" alt="統計">
            </figure>
            <p>統計</p>
          </a>
        </li>

        <li>
          <a href="<?php echo home_url(); ?>/medical/other/">
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/medical/medical_icon15.svg" alt="その他">
            </figure>
            <p>その他</p>
          </a>
        </li>
      </ul>
    </section>
  </div>

</main>

<?php get_footer(); ?>