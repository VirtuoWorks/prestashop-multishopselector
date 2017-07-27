((function($, window){
  $(document).ready(function(){
    //Add Class for background image
    $('body').addClass('homeShopSelector');
    //Show hidden blocks if JavaScript is activated
    $('#multishopselector_block_home .hideNoScript').show();
    //Choose the right value on the submit action.
      var selectChoose = $('select');
      $('#multishopselector_block_home form').submit(function(){
        if (selectChoose.length) {
          $(this).attr('action',$(this).find('select').val());
        }
      });
    //Place connexion block in the middle of the page
    function  blockSelectShopCenter(){
      var height = $('body').innerHeight();
      if ( height >= 600) {
        height = (height - ($('.homeShopSelector .logoHome').innerHeight() + $('#multishopselector_block_home').innerHeight())) * 0.1;
        $('.homeShopSelector .blockCenterHome').css('marginTop',height);
      }
    };
    blockSelectShopCenter();
    $(window).resize(function(){blockSelectShopCenter();});
    $('.slogan_langues .menu__button').html('Connexion');
  });
})(jQuery, window));
