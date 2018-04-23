   $(document).ready(function() {
      $("#mmenu").mmenu({
         navbar: {
            title: "DOLOTEX"
         }
      });

      $('[name="phone"]').inputmask("+380 (99) 99 99 999");

       var api = $("#mmenu").data( "mmenu" );
       api.bind('open:finish', function() {
          $('.hamburger').addClass('is-active');
       }).bind('close:finish', function(){
            $('.hamburger').removeClass('is-active');
          });
   });