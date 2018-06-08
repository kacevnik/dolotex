   $(document).ready(function() {
      $("#mmenu").mmenu({
         navbar: {
            title: "DOLOTEX"
         }
      });

      $('.more_product_catalog .btn').click(function(event) {
        var count = $(this).attr('data-count-tovar');
        var show = $(this).attr('data-show-row');
        var more = $(this).find('span').html();

        $.each($('.hide_row'), function(index, value) {
            var number = $(this).attr('data-number');
            if(number*1 < show*1){
              $(this).fadeIn('300').removeClass('hide_row').addClass('show_row');
            }
        });

        var res_more = more*1 - count*1;

        $(this).attr('data-show-row', count*1 + show*1);
        $(this).find('span').html(res_more);

        if(res_more < 1){
          $(this).parent().hide();
        }

        return false;
      });

      //Иницилизация и отправка плагина AjaxForm отправки даных из форм
      $('form').ajaxForm(function(){
        //$("a[title='Close']").trigger("click");
        $('form').clearForm();
        $(".fancybox-close-small").trigger("click");
        $("#thanks_link").trigger("click");
      });

      $('#douwload_price').click(function(event) {
        if($('.form_pdf input[name="phone"]').val() != '' && $('.form_pdf input[name="phone"]').val() != ' '){
          window.open(GlobalDATA.kdv_price);
        }
      });

      $('.obj_item').click(function(){
         $('.object_check_tab').hide();
         $('.obj_item').removeClass('active');
         $('#tab_object_check_' + $(this).attr('data-tab')).fadeIn(500);
         $(this).addClass('active');
         return false;
      });

      $('.product_tabs a').click(function() {
         $('.product_tab_content').hide();
         $('#product_tab_' + $(this).attr('product-data-tab')).fadeIn(500);
         return false;
      });

      //Плавная прокрутка до заданного ID элемента
      $("a[href*='#']").bind("click", function(e){
        var anchor = $(this);
        $('html, body').stop().animate({
          scrollTop: $(anchor.attr('href')).offset().top
        }, 500);
        e.preventDefault();
        return false;
      });

      $('.catalog_item_cart').click(function(){
         $('[name="name_product"]').val($(this).parent().parent().find('[data-name-product]').html());
      });

      $('[name="phone"]').inputmask("+380 (99) 99 99 999");

      $(".client_slider").owlCarousel({
          loop:true,
          margin: 30,
          responsive:{
              0:{
                  items:1,
                  nav:true
              },
              500:{
               items:2,
               nav:true
              },
              767:{
                  items:3,
                  nav:true
              },
              992:{
                  items:4,
                  nav:true
              }
          },
          navText: ['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
          autoplay: true,
          autoplayTimeout: 5000
      });       

      $(".product_more_slider_wrap").owlCarousel({
          loop:true,
          margin: 30,
          responsive:{
              0:{
                  items:1,
                  nav:true
              },
              500:{
               items:2,
               nav:true
              },
              767:{
                  items:4,
                  nav:true
              },
              992:{
                  items:4,
                  nav:true
              }
          },
          navText: ['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
          autoplay: true,
          autoplayTimeout: 5000
      });      

      $(".com_slider").owlCarousel({
          loop:true,
          margin: 30,
          responsive:{
              0:{
                  items:1,
                  nav:true
              },
              500:{
                  items:1,
                  nav:true
              },
              767:{
                  items:2,
                  nav:true
              },
              992:{
                  items:2,
                  nav:true
              }
          },
          navText: ['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>']
      });

      $('[data-fancybox]').fancybox();
      $('[data-fancybox-video]').fancybox();

      var api = $("#mmenu").data( "mmenu" );
      api.bind('open:finish', function() {
         $('.hamburger').addClass('is-active');
      }).bind('close:finish', function(){
         $('.hamburger').removeClass('is-active');
      });
      
   });