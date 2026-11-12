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
  // ページ内の投稿タイプを結果エリアの有無から判定（イベントの二重登録を避ける）
  var postType = $('#video_library-results').length
    ? 'video_library'
    : ($('#material-results').length ? 'material' : null);

  var slugToPostType = {
    'video-library': 'video_library',
    'material': 'material'
  };

  function storageKeyFor(type) {
    return type + 'Filter';
  }

  function fetchPosts(type, parent, term) {
    var restUrl = (typeof PostTypeAjax !== 'undefined' && PostTypeAjax.restUrl)
      ? PostTypeAjax.restUrl
      : null;

    if (!restUrl) {
      console.error('[ytl] PostTypeAjax.restUrl が未定義です');
      return;
    }

    $.ajax({
      url: restUrl,
      type: 'GET',
      dataType: 'json',
      data: {
        post_type: type,
        parent: parent,
        term: term
      },
      success: function(res) {
        var html = (res && typeof res.html === 'string') ? res.html : '';
        $('#' + type + '-results').html(html);
      },
      error: function(xhr, status, error) {
        console.error('[ytl] library-posts fetch failed', status, error, xhr && xhr.status);
      }
    });
  }

  // 「もっと見る」からの復帰（localStorage）
  if (postType) {
    var saved = null;
    try {
      saved = JSON.parse(localStorage.getItem(storageKeyFor(postType)));
    } catch (e) {
      saved = null;
    }

    if (saved && saved.parent) {
      var parent = saved.parent;
      var term = saved.term || 'all';

      $('.tab-button[data-parent="' + parent + '"]').addClass('active');
      $('.child-buttons[data-parent="' + parent + '"]').show();
      $('.child-button[data-term="' + term + '"]').addClass('active');

      fetchPosts(postType, parent, term);
      localStorage.removeItem(storageKeyFor(postType));
    }
  }

  // 親タブ
  $(document).on('click', '.tab-button', function(){
    if (!postType) return;

    var parent = $(this).data('parent');
    $(this).siblings().removeClass('active');
    $(this).addClass('active');

    $('.child-buttons').hide();
    $('.child-buttons[data-parent="' + parent + '"]').show();

    if ($('.child-buttons[data-parent="' + parent + '"]').length === 0) {
      fetchPosts(postType, parent, 'all');
    }
  });

  // 子タブ
  $(document).on('click', '.child-button', function(){
    if (!postType) return;

    var parent = $(this).closest('.child-buttons').data('parent');
    var term = $(this).data('term');

    $(this).siblings().removeClass('active');
    $(this).addClass('active');

    fetchPosts(postType, parent, term);
  });

  // カテゴリページの「もっと見る」
  $(document).on('click', '.library-more', function(){
    var parent = $(this).data('parent');
    var child = $(this).data('child') || 'all';
    var slug = $(this).data('post-type'); // video-library | material
    var type = slugToPostType[slug];

    if (!type) return;

    localStorage.setItem(storageKeyFor(type), JSON.stringify({ parent: parent, term: child }));

    var targetId = type === 'video_library' ? 'video_library-results' : 'material-results';
    window.location.href = '/' + slug + '/#' + targetId;
  });
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

