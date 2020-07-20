<?php
	include "ajax_config.php";
?>
<form method="post" action="" enctype="multipart/form-data">
    <div class="wrap-cart">
        <div class="top-cart">
            <div class="list-procart">
                <div class="procart procart-label d-flex align-items-start justify-content-between">
                    <div class="pic-procart"><?=hinhanh?></div>
                    <div class="info-procart"><?=tensanpham?></div>
                    <div class="quantity-procart">
                        <p><?=soluong?></p>
                        <p><?=thanhtien?></p>
                    </div>
                    <div class="price-procart"><?=thanhtien?></div>
                </div>
                <?php for($i=0;$i<count($_SESSION['cart']);$i++) {
                    $pid = $_SESSION['cart'][$i]['productid'];
                    $q = $_SESSION['cart'][$i]['qty'];
                    $mau = ($_SESSION['cart'][$i]['mau'])?$_SESSION['cart'][$i]['mau']:0;
                    $size = ($_SESSION['cart'][$i]['size'])?$_SESSION['cart'][$i]['size']:0;
                    $code = ($_SESSION['cart'][$i]['code'])?$_SESSION['cart'][$i]['code']:"";
                    $proinfo = $cart->get_product_info($pid);
                    $pro_price = $proinfo['gia'];
                    $pro_price_new = $proinfo['giamoi'];
                    $pro_price_qty = $pro_price*$q;
                    $pro_price_new_qty = $pro_price_new*$q; ?>
                    <div class="procart procart-<?=$code?> d-flex align-items-start justify-content-between">
                        <div class="pic-procart">
                            <a class="text-decoration-none" href="<?=$proinfo[$sluglang]?>" target="_blank" title="<?=$proinfo['ten'.$lang]?>"><img onerror="this.src='<?=THUMBS?>/85x85x2/assets/images/noimage.png';" src="<?=THUMBS?>/85x85x1/<?=UPLOAD_PRODUCT_L.$proinfo['photo']?>" alt="<?=$proinfo['ten'.$lang]?>"></a>
                            <a class="del-procart text-decoration-none" data-code="<?=$code?>">
                                <i class="fa fa-times-circle"></i>
                                <span><?=xoa?></span>
                            </a>
                        </div>
                        <div class="info-procart">
                            <h3 class="name-procart"><a class="text-decoration-none" href="<?=$proinfo[$sluglang]?>" target="_blank" title="<?=$proinfo['ten'.$lang]?>"><?=$proinfo['ten'.$lang]?></a></h3>
                            <div class="properties-procart">
                                <?php if($mau) { $maudetail = $d->rawQueryOne("SELECT ten$lang FROM table_product_mau WHERE type = ? AND id = ?",array($proinfo['type'],$mau)); ?>
                                    <p>Màu: <strong><?=$maudetail['ten'.$lang]?></strong></p>
                                <?php } ?>
                                <?php if($size) { $sizedetail = $d->rawQueryOne("SELECT ten$lang FROM table_product_size WHERE type = ? AND id = ?",array($proinfo['type'],$size)); ?>
                                    <p>Size: <strong><?=$sizedetail['ten'.$lang]?></strong></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="quantity-procart">
                            <div class="price-procart price-procart-rp">
                                <?php if($proinfo['giamoi']) { ?>
                                    <p class="price-new-cart load-price-new-<?=$code?>">
                                        <?=number_format($pro_price_new_qty,0, ',', '.')."đ"?>
                                    </p>
                                    <p class="price-old-cart load-price-<?=$code?>">
                                        <?=number_format($pro_price_qty,0, ',', '.')."đ"?>
                                    </p>
                                <?php } else { ?>
                                    <p class="price-new-cart load-price-<?=$code?>">
                                        <?=number_format($pro_price_qty,0, ',', '.')."đ"?>
                                    </p>
                                <?php } ?>
                            </div>
                            <div class="quantity-counter-procart quantity-counter-procart-<?=$code?> d-flex align-items-stretch justify-content-between">
                                <span class="counter-procart-minus counter-procart">-</span>
                                <input type="number" class="quantity-procat" min="1" value="<?=$q?>" data-pid="<?=$pid?>" data-code="<?=$code?>"/>
                                <span class="counter-procart-plus counter-procart">+</span>
                            </div>
                            <div class="pic-procart pic-procart-rp">
                                <a class="text-decoration-none" href="<?=$proinfo[$sluglang]?>" target="_blank" title="<?=$proinfo['ten'.$lang]?>"><img onerror="this.src='<?=THUMBS?>/85x85x2/assets/images/noimage.png';" src="<?=THUMBS?>/85x85x1/<?=UPLOAD_PRODUCT_L.$proinfo['photo']?>" alt="<?=$proinfo['ten'.$lang]?>"></a>
                                <a class="del-procart text-decoration-none" data-code="<?=$code?>">
                                    <i class="fa fa-times-circle"></i>
                                    <span><?=xoa?></span>
                                </a>
                            </div>
                        </div>
                        <div class="price-procart">
                            <?php if($proinfo['giamoi']) { ?>
                                <p class="price-new-cart load-price-new-<?=$code?>">
                                    <?=number_format($pro_price_new_qty,0, ',', '.')."đ"?>
                                </p>
                                <p class="price-old-cart load-price-<?=$code?>">
                                    <?=number_format($pro_price_qty,0, ',', '.')."đ"?>
                                </p>
                            <?php } else { ?>
                                <p class="price-new-cart load-price-<?=$code?>">
                                    <?=number_format($pro_price_qty,0, ',', '.')."đ"?>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="money-procart">
                <div class="total-procart d-flex align-items-center justify-content-between">
                    <p><?=tamtinh?>:</p>
                    <p class="total-price load-price-temp"><?=number_format($cart->get_order_total(),0, ',', '.')?>đ</p>
                </div>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-between">
                <a href="san-pham" class="buymore-cart text-decoration-none" title="<?=tieptucmuahang?>">
                    <i class="fa fa-angle-double-left"></i>
                    <span><?=tieptucmuahang?></span>
                </a>
                <a class="btn-cart btn btn-primary" href="gio-hang" title="<?=thanhtoan?>"><?=thanhtoan?></a>
            </div>
        </div>
    </div>
</form>