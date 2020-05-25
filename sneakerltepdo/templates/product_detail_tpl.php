<div class="grid-pro-detail w-clear">
    <div class="left-pro-detail w-clear">
        <a id="Zoom-1" class="MagicZoom" data-options="zoomMode: off; hint: off; rightClick: true; selectorTrigger: hover; expandCaption: false; history: false;" href="detail/540x540x1/<?=_upload_product_l.$row_detail['photo']?>" title="<?=$row_detail['ten'.$lang]?>"><img onerror="this.src='//placehold.it/540x540';" src="detail/540x540x1/<?=_upload_product_l.$row_detail['photo']?>" alt="<?=$row_detail['ten'.$lang]?>"></a>
        <?php if(count($hinhanhsp)>0) { ?>
            <div class="gallery-thumb-pro">
                <p class="control-thumb-pro prev-thumb-pro"><i class="fas fa-chevron-left"></i></p>
                <div class="slick-thumb-pro">
                    <div><a class="thumb-pro-detail" data-zoom-id="Zoom-1" href="detail/540x540x1/<?=_upload_product_l.$row_detail['photo']?>" title="<?=$row_detail['ten'.$lang]?>"><img onerror="this.src='//placehold.it/540x540';" src="detail/540x540x1/<?=_upload_product_l.$row_detail['photo']?>" alt="<?=$row_detail['ten'.$lang]?>"></a></div>
                    <?php for($i=0;$i<count($hinhanhsp);$i++) { ?>
                        <div><a class="thumb-pro-detail" data-zoom-id="Zoom-1" href="detail/540x540x1/<?=_upload_product_l.$hinhanhsp[$i]['photo']?>" title="<?=$row_detail['ten'.$lang]?>"><img onerror="this.src='//placehold.it/540x540';" src="detail/540x540x1/<?=_upload_product_l.$hinhanhsp[$i]['photo']?>" alt="<?=$row_detail['ten'.$lang]?>"></a></div>
                    <?php } ?>
                </div>
                <p class="control-thumb-pro next-thumb-pro"><i class="fas fa-chevron-right"></i></p>
            </div>
        <?php } ?>
    </div>

    <div class="right-pro-detail w-clear">
        <p class="title-pro-detail"><?=$row_detail['ten'.$lang]?></p>
        <div class="social-plugin social-plugin-pro-detail w-clear">
            <div class="addthis_inline_share_toolbox_qj48"></div>
            <div class="zalo-share-button" data-href="<?=getCurrentPageURL()?>" data-oaid="<?=($setting['oaidzalo']!='')?$setting['oaidzalo']:'579745863508352884'?>" data-layout="1" data-color="blue" data-customize=false></div>
        </div>
        <div class="desc-pro-detail"><?=str_replace("\n","<p></p>",$row_detail['mota'.$lang])?></div>
        <ul class="attr-pro-detail">
            <li class="w-clear"> 
                <label class="attr-label-pro-detail"><?=_masp?>:</label>
                <div class="attr-content-pro-detail"><?=$row_detail['masp']?></div>
            </li>
            <?php if($pro_brand['id']) { ?>
                <li class="w-clear">
                    <label class="attr-label-pro-detail"><?=_thuonghieu?>:</label>
                    <div class="attr-content-pro-detail"><a class="text-decoration-none" href="<?=get_slug($lang,$pro_brand['id'],'product_brand')?>" title="<?=$pro_brand['ten'.$lang]?>"><?=$pro_brand['ten'.$lang]?></a></div>
                </li>
            <?php } ?>
            <li class="w-clear">
                <label class="attr-label-pro-detail"><?=_gia?>:</label>
                <div class="attr-content-pro-detail">
                    <?php if($row_detail['giamoi']) { ?>
                        <span class="price-new-pro-detail"><?=number_format($row_detail['giamoi'],0, ',', '.')."đ"?></span>
                        <span class="price-old-pro-detail"><?=number_format($row_detail['gia'],0, ',', '.')."đ"?></span>
                    <?php } else { ?>
                        <span class="price-new-pro-detail"><?=($row_detail['gia'])?number_format($row_detail['gia'],0, ',', '.')."đ":_lienhe?></span>
                    <?php } ?>
                </div>
            </li>
            <li class="w-clear"> 
                <label class="attr-label-pro-detail d-block"><?=_mausac?>:</label>
                <div class="attr-content-pro-detail d-block">
                    <?php for($i=0;$i<count($mau);$i++) { ?>
                        <?php if($mau[$i]['loaihienthi']==1) { ?>
                            <a class="color-pro-detail text-decoration-none" data-idpro="<?=$row_detail['id']?>">
                                <input style="background-image: url(<?=_upload_mau_l.$mau[$i]['thumb']?>)" type="radio" value="<?=$mau[$i]['id']?>" name="color-pro-detail">
                            </a>
                        <?php } else { ?>
                            <a class="color-pro-detail text-decoration-none" data-idpro="<?=$row_detail['id']?>">
                                <input style="background-color: #<?=$mau[$i]['mau']?>" type="radio" value="<?=$mau[$i]['id']?>" name="color-pro-detail">
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </li>
            <li class="w-clear">
                <label class="attr-label-pro-detail d-block"><?=_kichthuoc?>:</label>
                <div class="attr-content-pro-detail d-block">
                    <?php for($i=0;$i<count($size);$i++) { ?>
                        <a class="size-pro-detail text-decoration-none">
                            <input type="radio" value="<?=$size[$i]['id']?>" name="size-pro-detail">
                            <?=$size[$i]['ten'.$lang]?>
                        </a>
                    <?php } ?>
                </div> 
            </li>
            <li class="w-clear"> 
                <label class="attr-label-pro-detail d-block"><?=_soluong?>:</label>
                <div class="attr-content-pro-detail d-block">
                    <div class="quantity-pro-detail">
                        <span class="quantity-minus-pro-detail">-</span>
                        <input type="number" class="qty-pro" min="1" value="1" readonly />
                        <span class="quantity-plus-pro-detail">+</span>
                    </div>
                </div>
            </li>
            <li class="w-clear"> 
                <label class="attr-label-pro-detail"><?=_luotxem?>:</label>
                <div class="attr-content-pro-detail"><?=$row_detail['luotxem']?></div>
            </li>
        </ul>
        <div class="cart-pro-detail">
            <a class="transition addnow text-decoration-none" onclick="add_to_cart(<?=$row_detail['id']?>,'addnow');" href="javascript:void(0)"><i class="fas fa-shopping-bag"></i><span>Thêm vào giỏ hàng</span></a>
            <a class="transition buynow text-decoration-none" onclick="add_to_cart(<?=$row_detail['id']?>,'buynow');" href="javascript:void(0)"><i class="fas fa-shopping-bag"></i><span>Đặt hàng</span></a>
        </div>
    </div>

    <div class="clear"></div>

    <div class="tags-pro-detail w-clear">
        <?php foreach($pro_tags as $v) { ?>
            <a class="transition text-decoration-none w-clear" href="<?=get_slug($lang,$v['id'],'tags')?>" title="<?=$v['ten'.$lang]?>"><i class="fas fa-tags"></i><?=$v['ten'.$lang]?></a>
        <?php } ?>
    </div>

    <div class="clear"></div>

    <div class="tabs-pro-detail">
        <ul class="ul-tabs-pro-detail w-clear">
            <li class="active transition" data-tabs="info-pro-detail"><?=_thongtinsanpham?></li>
            <li class="transition" data-tabs="commentfb-pro-detail"><?=_binhluan?></li>
        </ul>
        <div class="content-tabs-pro-detail info-pro-detail active"><?=htmlspecialchars_decode($row_detail['noidung'.$lang])?></div>
        <div class="content-tabs-pro-detail commentfb-pro-detail"><div class="fb-comments" data-href="<?=getCurrentPageURL()?>" data-numposts="3" data-colorscheme="light" data-width="100%"></div></div>
    </div>
</div>

<div class="title-main"><span><?=_sanphamcungloai?></span></div>
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