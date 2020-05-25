<div class="title-main"><span><?=($title_cat!='')?$title_cat:$title_crumb?></span></div>
<div class="content-main w-clear">
    <?php if(count($product)>0) { for($i=0;$i<count($product);$i++) { ?>
        <div class="product">
            <a class="box-product text-decoration-none" href="<?=get_slug($lang,$product[$i]['id'],'product')?>" title="<?=$product[$i]['ten'.$lang]?>">
                <p class="pic-product scale-img"><img onerror="this.src='//placehold.it/270x270';" src="product/270x270x1/<?=_upload_product_l.$product[$i]['photo']?>" alt="<?=$product[$i]['ten'.$lang]?>"/></p>
                <h3 class="name-product text-split"><?=$product[$i]['ten'.$lang]?></h3>
                <p class="price-product">
                    <?php if($product[$i]['giakm']) { ?>
                        <span class="price-new"><?=number_format($product[$i]['giamoi'],0, ',', '.').'đ'?></span>
                        <span class="price-old"><?=number_format($product[$i]['gia'],0, ',', '.').'đ'?></span>
                        <span class="price-per"><?='-'.$product[$i]['giakm'].'%'?></span>
                    <?php } else { ?>
                        <span class="price-new"><?=($product[$i]['gia'])?number_format($product[$i]['gia'],0, ',', '.').'đ':_lienhe?></span>
                    <?php } ?>
                </p>
            </a>
            <p class="cart-product w-clear">
                <span class="cart-add transition" onclick="add_to_cart(<?=$product[$i]['id']?>,'addnow')">Thêm vào giỏ hàng</span>
                <span class="cart-buy transition" onclick="add_to_cart(<?=$product[$i]['id']?>,'buynow')">Mua ngay</span>
            </p>
        </div>
    <?php } } else { ?>
        <div class="alert alert-warning" role="alert">
            <strong><?=_khongtimthayketqua?></strong>
        </div>
    <?php } ?>
    <div class="clear"></div>
    <div class="pagination-home"><?=$paging?></div>
</div>