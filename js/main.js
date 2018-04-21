   $(document).ready(function() {
      $("#mmenu").mmenu({
         navbar: {
            title: "DOLOTEX"
         }
      });

       var api = $("#mmenu").data( "mmenu" );
       api.bind('open:finish', function() {
          $('.hamburger').addClass('is-active');
       }).bind('close:finish', function(){
            $('.hamburger').removeClass('is-active');
          });
   });