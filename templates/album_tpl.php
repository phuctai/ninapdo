<div class="title-main"><span><?=$title_crumb?></span></div>
<div class="content-main w-clear">
    <?php if(count($product)>0) { for($i=0;$i<count($product);$i++) { ?>
        <a class="album text-decoration-none" href="<?=$func->get_slug($lang,$product[$i]['id'],'product')?>" title="<?=$product[$i]['ten'.$lang]?>">
            <p class="pic-album scale-img"><img onerror="this.src='//placehold.it/480x360';" src="<?=UPLOAD_PRODUCT_L?>480x360x1/<?=$product[$i]['photo']?>" alt="<?=$product[$i]['ten'.$lang]?>"/></p>
            <h3 class="name-album text-split"><?=$product[$i]['ten'.$lang]?></h3>
        </a>
    <?php } } else { ?>
        <div class="alert alert-warning" role="alert">
            <strong><?=khongtimthayketqua?></strong>
        </div>
    <?php } ?>
    <div class="clear"></div>
    <div class="pagination-home"><?=$paging?></div>
</div>