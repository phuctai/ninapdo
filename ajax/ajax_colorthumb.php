<?php
	include "ajax_config.php";
	
	$id_mau = htmlspecialchars($_POST['id_mau']);
	$idpro = htmlspecialchars($_POST['idpro']);
	$hinhanhsp = $d->rawQuery("SELECT photo, id_photo, id FROM table_gallery WHERE id_mau = ? AND id_photo = ? AND com = ? AND type = ? AND kind = ? AND val = ?",array($id_mau,$idpro,'product','san-pham','man','san-pham'));
	$row_detail = $d->rawQueryOne("SELECT ten$lang, photo FROM table_product WHERE id = ? AND type = ?",array($idpro,'san-pham'));
?>
<?php if(count($hinhanhsp)) { ?>
	<a id="Zoom-1" class="MagicZoom" data-options="zoomMode: off; hint: off; rightClick: true; selectorTrigger: hover; expandCaption: false; history: false;" href="<?=WATERMARK?>/product/540x540x1/<?=UPLOAD_PRODUCT_L.$hinhanhsp[0]['photo']?>" title="<?=$row_detail['ten'.$lang]?>"><img onerror="this.src='<?=THUMBS?>/540x540x2/assets/images/noimage.png';" src="<?=WATERMARK?>/product/540x540x1/<?=UPLOAD_PRODUCT_L.$hinhanhsp[0]['photo']?>" alt="<?=$row_detail['ten'.$lang]?>"></a>
    <div class="gallery-thumb-pro">
        <p class="control-thumb-pro prev-thumb-pro"><i class="fas fa-chevron-left"></i></p>
        <div class="slick-thumb-pro">
            <?php for($i=0;$i<count($hinhanhsp);$i++) { ?>
                <div><a class="thumb-pro-detail" data-zoom-id="Zoom-1" href="<?=WATERMARK?>/product/540x540x1/<?=UPLOAD_PRODUCT_L.$hinhanhsp[$i]['photo']?>" title="<?=$row_detail['ten'.$lang]?>"><img onerror="this.src='<?=THUMBS?>/540x540x2/assets/images/noimage.png';" src="<?=WATERMARK?>/product/540x540x1/<?=UPLOAD_PRODUCT_L.$hinhanhsp[$i]['photo']?>" alt="<?=$row_detail['ten'.$lang]?>"></a></div>
            <?php } ?>
        </div>
        <p class="control-thumb-pro next-thumb-pro"><i class="fas fa-chevron-right"></i></p>
    </div>
	
	<script src="assets/magiczoomplus/magiczoomplus.js" type="text/javascript"></script>
	<script type="text/javascript">
	    $(document).ready(function() 
	    {
            $(".slick-thumb-pro").slick({
                dots: false,
                autoplay: false,
                infinite: false,
                slidesToShow: 4,
                slidesToScroll: 1,
                swipeToSlide: true,
                prevArrow: $('.prev-thumb-pro'),
                nextArrow: $('.next-thumb-pro')
            });
	    });
	</script>
<?php } else { ?>
	<img onerror="this.src='<?=THUMBS?>/540x540x2/assets/images/noimage.png';" src="" alt="<?=khongtimthayketqua?>"/>
<?php } ?>