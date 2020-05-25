<ul class="h-card hidden">
    <li class="h-fn fn"><?=$setting['ten'.$lang]?></li>
    <li class="h-org org"><?=$setting['ten'.$lang]?></li>
    <li class="h-tel tel"><?=preg_replace('/[^0-9]/','',$setting['hotline']);?></li>
    <li><a class="u-url ul" href="<?=$config_base?>"><?=$config_base?></a></li>
</ul>

<?php if($config['website']['seo']['headings']) { ?>
	<h1 class="hidden-seoh"><?=($seo_h1)?$seo_h1:$setting['seo_h1'.$seolangkey]?></h1>
	<h2 class="hidden-seoh"><?=($seo_h2)?$seo_h2:$setting['seo_h2'.$seolangkey]?></h2>
	<h3 class="hidden-seoh"><?=($seo_h3)?$seo_h3:$setting['seo_h3'.$seolangkey]?></h3>
<?php } else { ?>
	<h1 class="hidden-seoh"><?=$seo_h1?></h1>
<?php } ?>