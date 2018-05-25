<?php
    if (defined( 'FW' )){
        $kdv_tovar_price = fw_get_db_post_option(get_the_ID(), 'kdv_tovar_price');
        $kdv_tovar_box = fw_get_db_post_option(get_the_ID(), 'kdv_tovar_box');
    }

?>
    <div class="col-md-3 col-sm-4">
      <div class="catalog_item" id="post-<?php the_ID(); ?>">
        <div class="catalog_item_img">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('tovar-thumb'); ?>
            </a>
        </div>
        <h3><a href="<?php the_permalink(); ?>" data-name-product="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
        <div class="catalog_item_content">
          <div class="catalog_item_price"><?php echo $kdv_tovar_price; ?></div>
          <p><?php echo $kdv_tovar_box; ?></p>
          <a class="catalog_item_cart" data-fancybox data-src="#call_back_hidden_product" href="javascript:;">
            <i class="fas fa-shopping-cart"></i>
          </a>
        </div>
      </div>
    </div>