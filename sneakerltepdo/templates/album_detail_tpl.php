<div class="title-main"><span><?=$row_detail['ten'.$lang]?></span></div>
<div class="content-main album-gallery w-clear">
    <?php if(count($hinhanhsp)>0) { for($i=0;$i<count($hinhanhsp);$i++) { ?>
        <a class="album text-decoration-none" rel="album-<?=$row_detail['id']?>" href="<?=_upload_product_l.$hinhanhsp[$i]['photo']?>" title="<?=$row_detail['ten'.$lang]?>">
            <p class="pic-album scale-img"><img onerror="this.src='//placehold.it/480x360';" src="<?=_upload_product_l?>480x360x1/<?=$hinhanhsp[$i]['photo']?>" alt="<?=$row_detail['ten'.$lang]?>"/></p>
        </a>
    <?php } } else { ?>
        <div class="alert alert-warning" role="alert">
            <strong><?=_khongtimthayketqua?></strong>
        </div>
    <?php } ?>
</div>