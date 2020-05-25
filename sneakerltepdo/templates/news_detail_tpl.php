<div class="title-main"><span><?=$row_detail['ten'.$lang]?></span></div>
<div class="content-main w-clear"><?=htmlspecialchars_decode($row_detail['noidung'.$lang])?></div>
<div class="share">
	<b><?=_chiase?>:</b>
	<div class="social-plugin w-clear">
        <div class="addthis_inline_share_toolbox_qj48"></div>
        <div class="zalo-share-button" data-href="<?=getCurrentPageURL()?>" data-oaid="<?=($setting['oaidzalo']!='')?$setting['oaidzalo']:'579745863508352884'?>" data-layout="1" data-color="blue" data-customize=false></div>
    </div>
</div>
<div class="share othernews">
    <b><?=_baivietkhac?>:</b>
    <ul class="list-news-other">
        <?php for($i=0;$i<count($news);$i++) { ?>
            <li><a class="text-decoration-none" href="<?=get_slug($lang,$news[$i]['id'],'news')?>" title="<?=$news[$i]['ten'.$lang]?>">
                <?=$news[$i]['ten'.$lang]?> - <?=date("d/m/Y",$news[$i]['ngaytao'])?>
            </a></li>
        <?php } ?>
    </ul>
    <div class="pagination-home"><?=$paging?></div>
</div>