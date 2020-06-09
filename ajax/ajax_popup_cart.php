<?php
	include "ajax_config.php";
?>
<form method="post" action="" enctype="multipart/form-data">
    <script type="text/javascript">
        $(".del-procart").click(function(){
            if(confirm('<?=banmuonxoasanphamnay?>'))
            {
                var code = $(this).data("code");
                var ship = $(".price-ship").val();
                var endow = $(".price-endow").val();

                $.ajax({
                    type: "POST",
                    url:'ajax/ajax_delete_cart.php',
                    dataType: 'json',
                    data: {code:code,ship:ship,endow:endow},
                    success: function(result){
                        if(result.max)
                        {
                            $('.price-temp').val(result.temp);
                            $('.load-price-temp').html(result.tempText);
                            $('.price-total').val(result.total);
                            $('.load-price-total').html(result.totalText);
                            $(".procart-"+code).remove();
                        }
                        else
                        {
                            $(".wrap-cart").html('<a href="" class="empty-cart text-decoration-none"><i class="fa fa-cart-arrow-down"></i><p><?=khongtontaisanphamtronggiohang?></p><span><?=vetrangchu?></span></a>');
                        }
                    }
                });
            }
        })

        $("input.quantity-procat").change(function(){
            var quantity=$(this).val();
            var pid = $(this).data("pid");
            var code = $(this).data("code");
            update_cart(pid,code,quantity);
        })

        function update_cart(pid,code,quantity)
        {
            var ship = 0;
            var endow = 0;

            $.ajax({
                type: "POST",
                url: "ajax/ajax_update_cart.php",
                dataType: 'json',
                data: {pid:pid,code:code,q:quantity,ship:ship,endow:endow},
                success: function(result){
                    if(result){
                        $('.load-price-'+code).html(result.gia);
                        $('.load-price-new-'+code).html(result.giamoi);
                        $('.price-temp').val(result.temp);
                        $('.load-price-temp').html(result.tempText);
                    }
                }
            });
        }

        function quantity_cart(element,pid,code,quantity)
        {
            $(element+code+" span").click(function(){
                var $button = $(this);
                var oldValue = $button.parent().find("input").val();
                if($button.text() == "+")
                {
                    quantity = parseFloat(oldValue) + 1;
                }
                else
                {
                    if(oldValue > 1) quantity = parseFloat(oldValue) - 1;
                }
                $button.parent().find("input").val(quantity);
                update_cart(pid,code,quantity);
            });
        }
    </script>
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
                    $proinfo = $cart->get_product_info($pid); ?>
                    <div class="procart procart-<?=$code?> d-flex align-items-start justify-content-between">
                        <div class="pic-procart">
                            <a class="text-decoration-none" href="<?=$func->get_slug($lang,$proinfo['id'],'product')?>" target="_blank" title="<?=$proinfo['ten'.$lang]?>"><img onerror="this.src='//placehold.it/85x85';" src="<?=UPLOAD_PRODUCT_L.$proinfo['photo']?>" alt="<?=$proinfo['ten'.$lang]?>"></a>
                            <a class="del-procart text-decoration-none" data-code="<?=$code?>">
                                <i class="fa fa-times-circle"></i>
                                <span><?=xoa?></span>
                            </a>
                        </div>
                        <div class="info-procart">
                            <h3 class="name-procart"><a class="text-decoration-none" href="<?=$func->get_slug($lang,$proinfo['id'],'product')?>" target="_blank" title="<?=$proinfo['ten'.$lang]?>"><?=$proinfo['ten'.$lang]?></a></h3>
                            <div class="khuyenmai-procart"><?=str_replace("\n","<br/>",htmlspecialchars_decode($proinfo['khuyenmai'.$lang]))?></div>
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
                                        <?=number_format($cart->get_price_new($pid)*$q,0, ',', '.')."đ"?>
                                    </p>
                                    <p class="price-old-cart load-price-<?=$code?>">
                                        <?=number_format($cart->get_price($pid)*$q,0, ',', '.')."đ"?>
                                    </p>
                                <?php } else { ?>
                                    <p class="price-new-cart load-price-<?=$code?>">
                                        <?=number_format($cart->get_price($pid)*$q,0, ',', '.')."đ"?>
                                    </p>
                                <?php } ?>
                            </div>
                            <div class="quantity-counter-procart quantity-counter-procart-<?=$code?> d-flex align-items-stretch justify-content-between">
                                <span class="counter-procart-minus counter-procart">-</span>
                                <input type="number" class="quantity-procat" min="1" value="<?=$q?>" data-pid="<?=$pid?>" data-code="<?=$code?>"/>
                                <span class="counter-procart-plus counter-procart">+</span>
                            </div>
                            <div class="pic-procart pic-procart-rp">
                                <a class="text-decoration-none" href="<?=$func->get_slug($lang,$proinfo['id'],'product')?>" target="_blank" title="<?=$proinfo['ten'.$lang]?>"><img onerror="this.src='//placehold.it/85x85';" src="<?=UPLOAD_PRODUCT_L.$proinfo['photo']?>" alt="<?=$proinfo['ten'.$lang]?>"></a>
                                <a class="del-procart text-decoration-none" data-code="<?=$code?>">
                                    <i class="fa fa-times-circle"></i>
                                    <span><?=xoa?></span>
                                </a>
                            </div>
                            <script type="text/javascript">
                                quantity_cart(".quantity-counter-procart-",<?=$pid?>,"<?=$code?>",<?=$q?>);
                            </script>
                        </div>
                        <div class="price-procart">
                            <?php if($proinfo['giamoi']) { ?>
                                <p class="price-new-cart load-price-new-<?=$code?>">
                                    <?=number_format($cart->get_price_new($pid)*$q,0, ',', '.')."đ"?>
                                </p>
                                <p class="price-old-cart load-price-<?=$code?>">
                                    <?=number_format($cart->get_price($pid)*$q,0, ',', '.')."đ"?>
                                </p>
                            <?php } else { ?>
                                <p class="price-new-cart load-price-<?=$code?>">
                                    <?=number_format($cart->get_price($pid)*$q,0, ',', '.')."đ"?>
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