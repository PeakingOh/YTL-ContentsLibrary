document.addEventListener('DOMContentLoaded', function() {
  const navToggle = document.getElementById('nav-toggle');

  navToggle.addEventListener('click', function() {
    navToggle.classList.toggle('open');
  });
});

$(function () {
  // 親メニューにhover
  $('.parent-menu').hover(
    function () {
      $(this).next('.children-menu').addClass('active');
    },
    function () {
      $(this).next('.children-menu').removeClass('active');
    }
  );

  // 子メニューにhover
  $('.children-menu').hover(
    function () {
      $(this).addClass('active');
    },
    function () {
      $(this).removeClass('active');
    }
  );
});

// element fade-in
$(function(){
  $(window).scroll(function (){
      $('.fadein').each(function(){
          var elemPos = $(this).offset().top;
          var scroll = $(window).scrollTop();
          var windowHeight = $(window).height();
          if (scroll > elemPos - windowHeight){
              $(this).addClass('slidein');
          }
      });
  });
});

window.addEventListener('load', function () {
  new Swiper('.my-medical-swiper', {
    slidesPerView: 1.3,
    spaceBetween: 30,
    centeredSlides: true,

    // ナビゲーションはスライド内に配置
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },

    breakpoints: {
      640: {
        slidesPerView: 2.3,
      },
      1024: {
        slidesPerView: 3.5,
        spaceBetween: 50,
        centeredSlides: false,
        slidesOffsetBefore: 100,
        slidesOffsetAfter: 100,
      },
    }
  });
});

window.addEventListener('load', function () {
  const slider = document.querySelector('.video-slider');
  slider.style.visibility = 'visible';

  new Swiper('.video-slider', {
    slidesPerView: 1,
    spaceBetween: 20,
    centeredSlides: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    pagination: {
      el: '.video-pagination',
      clickable: true,
    },
    breakpoints: {
      640: { 
        slidesPerView: 2.2, 
        spaceBetween: 40, 
      },
      1024: { 
        slidesPerView: 3.5,
        spaceBetween: 50,
        centeredSlides: false,
        slidesOffsetBefore: 100,
        slidesOffsetAfter: 100,
      },
    }
  });
});

document.querySelectorAll('.swiper-slide').forEach(slide => {
  slide.addEventListener('click', () => {
    const link = slide.getAttribute('data-link');
    if (link) {
      window.location.href = link;
    }
  });
});


jQuery(function($){

  // 初期設定
  var postTypes = ['video_library','material'];

  postTypes.forEach(function(postType){
      var ajaxurl = PostTypeAjax[postType];
      var resultId = '#' + postType + '-results';
      var storageKey = postType + 'Filter';

      // ページロード時の LocalStorage確認
      var filter = JSON.parse(localStorage.getItem(storageKey));
      if(filter){
          var parent = filter.parent;
          var term = filter.term;

          $('.tab-button[data-parent="'+parent+'"]').addClass('active');
          $('.child-buttons[data-parent="'+parent+'"]').show();
          $('.child-button[data-term="'+term+'"]').addClass('active');

          fetchPosts(postType, ajaxurl, parent, term);
          localStorage.removeItem(storageKey);
      }

      // 親タブクリック
      $(document).on('click', '.tab-button', function(){
          var parent = $(this).data('parent');
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          $('.child-buttons').hide();
          $('.child-buttons[data-parent="'+parent+'"]').show();

          if($('.child-buttons[data-parent="'+parent+'"]').length === 0){
              fetchPosts(postType, ajaxurl, parent, 'all');
          }
      });

      // 子ボタンクリック
      $(document).on('click', '.child-button', function(){
          var parent = $(this).closest('.child-buttons').data('parent');
          var term = $(this).data('term');

          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          fetchPosts(postType, ajaxurl, parent, term);
      });

      // 「もっと見る」ボタン用
        $(document).on('click', '.library-more', function(){
          var parent = $(this).data('parent');
          var child = $(this).data('child') || 'all';
          var postType = $(this).data('post-type'); // 動画ライブラリ or スライド資料
      
          // localStorage に保存
          localStorage.setItem(storageKey, JSON.stringify({parent: parent, term: child}));
      
          // 遷移先のIDを決める
          var targetId = postType === 'video-library' ? 'video_library-results' : 'material-results';
      
          // 遷移URL生成
          if(postType) {
              window.location.href = '/' + postType + '/#' + targetId;
          }
      });    
  });

  function fetchPosts(postType, ajaxurl, parent, term){
      $.ajax({
          url: ajaxurl,
          type: 'POST',
          data: {
              action: 'fetch_' + postType,
              post_type: postType,
              parent: parent,
              term: term
          },
          success: function(res){
              $('#'+postType+'-results').html(res);
          }
      });
  }

});

jQuery(document).ready(function($){
  var helpText = '<div class="custom-help-text">パスワードは8文字以上で、英字（大文字・小文字）と数字を含めてください。</div>';

  $('#um_field_184_user_password').after(helpText);
});

jQuery(document).ready(function($){
  var helpText = '<div class="custom-help-text">個人のメールアドレス（@gmail.com 等）でのご登録は、審査が通らない場合がございますのでご留意ください。</div>';

  $('#um_field_184_user_email').after(helpText);
});

jQuery(document).ready(function($){
  var helpText = '<div class="custom-help-text">パスワードは8文字以上で、英字（大文字・小文字）と数字を含めてください。</div>';

  $('#um_field_251_user_password').after(helpText);
});

jQuery(document).ready(function($){
  var helpText = '<div class="custom-help-text">個人のメールアドレス（@gmail.com 等）でのご登録は、審査が通らない場合がございますのでご留意ください。</div>';

  $('#um_field_251_user_email').after(helpText);
});

jQuery(document).ready(function($){
  var helpText = '<div class="custom-help-text">ハイフン「-」有りの半角数字で入力してください。<br>例：03-1234-5678</div>';

  $('#um_field_251_phone').after(helpText);
});

jQuery(document).ready(function($){
  var helpText = '<div class="custom-help-text">YTL（株式会社医学アカデミー）からサービスに関する最新情報などをご登録いただいたメールアドレス宛にお届けしております。</div>';

  $('#um_field_251_newsletter').after(helpText);
});

jQuery(document).ready(function($){
  var helpText = '<div class="custom-help-text">YTL（株式会社医学アカデミー）からサービスに関する最新情報などをご登録いただいたメールアドレス宛にお届けしております。</div>';

  $('#um_field_184_delivery').after(helpText);
});

document.getElementById('login_submit').addEventListener('click', function(e) {
  var username = document.getElementById('login_username').value.trim();
  var password = document.getElementById('login_password').value.trim();
  if (!username || !password) {
      e.preventDefault(); // フォーム送信を止める
      alert('メールアドレスとパスワードを入力してください。');
  }
});

