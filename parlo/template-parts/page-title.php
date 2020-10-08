<?php if ( !is_front_page() ) { ?>
<div class="page-title-area">
    <div class="ht-container">
        <div class="ht-col-md-12 ht-col-sx-12 ht-center-md">
            <?php
                if ( function_exists('is_woocommerce') && is_woocommerce() ) { woocommerce_breadcrumb(); } else{ 
                    parlo_breadcrumbs(); 
                }
            ?>
        </div>
    </div>
</div>
<?php } ?>