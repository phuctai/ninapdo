<div class="menu">
    <div class="wrap-content d-flex align-items-center justify-content-between">
        <div class="ddsmoothmenu" id="smoothmenu1">
            <ul class="d-flex align-items-center justify-content-start">
                <li class="li-first"><a class="transition <?php if($com=='' || $com=='index') echo 'active'; ?>" href="" title="<?=_trangchu?>"><h2><?=_trangchu?></h2></a></li>
                <li class="line"></li>
                <li class="li-first"><a class="transition <?php if($com=='gioi-thieu') echo 'active'; ?>" href="<?=get_comlang('gioi-thieu',$lang)?>" title="<?=_gioithieu?>"><h2><?=_gioithieu?></h2></a></li>
                <li class="line"></li>
                <li class="li-first">
                    <a class="transition <?php if($com=='san-pham') echo 'active'; ?>" href="<?=get_comlang('san-pham',$lang)?>" title="<?=_sanpham?>"><h2><?=_sanpham?></h2></a>
                    <?php if(count($splistmenu)) { ?>
                        <ul>
                            <?php for($i=0;$i<count($splistmenu); $i++) {
                            	$spcatmenu = $d->rawQuery("SELECT ten$lang, id FROM table_product_cat WHERE hienthi=1 AND id_list = ? ORDER BY stt,id DESC",array($splistmenu[$i]['id'])); ?>
                                <li>
                                    <a class="transition" title="<?=$splistmenu[$i]['ten'.$lang]?>" href="<?=get_slug($lang,$splistmenu[$i]['id'],'product_list')?>"><h2><?=$splistmenu[$i]['ten'.$lang]?></h2></a>
                                    <?php if(count($spcatmenu)>0) { ?>
                                        <ul>
                                            <?php for($j=0;$j<count($spcatmenu);$j++) {
                                                $spitemmenu = $d->rawQuery("SELECT ten$lang, id FROM table_product_item WHERE hienthi=1 AND id_cat = ? ORDER BY stt,id DESC",array($spcatmenu[$j]['id'])); ?>
                                                <li>
                                                    <a class="transition" title="<?=$spcatmenu[$j]['ten'.$lang]?>" href="<?=get_slug($lang,$spcatmenu[$j]['id'],'product_cat')?>"><h2><?=$spcatmenu[$j]['ten'.$lang]?></h2></a>
                                                    <?php if(count($spitemmenu)) { ?>
                                                        <ul>
                                                            <?php for($u=0;$u<count($spitemmenu);$u++) {
                                                                $spsubmenu = $d->rawQuery("SELECT ten$lang, id FROM table_product_sub WHERE hienthi=1 AND id_item = ? ORDER BY stt,id DESC",array($spitemmenu[$u]['id'])); ?>
                                                                <li>
                                                                    <a class="transition" title="<?=$spitemmenu[$u]['ten'.$lang]?>" href="<?=get_slug($lang,$spitemmenu[$u]['id'],'product_item')?>"><h2><?=$spitemmenu[$u]['ten'.$lang]?></h2></a>
                                                                    <?php if(count($spsubmenu)) { ?>
                                                                        <ul>
                                                                            <?php for($s=0;$s<count($spsubmenu);$s++) { ?>
                                                                                <li>
                                                                                    <a class="transition" title="<?=$spsubmenu[$s]['ten'.$lang]?>" href="<?=get_slug($lang,$spsubmenu[$s]['id'],'product_sub')?>"><h2><?=$spsubmenu[$s]['ten'.$lang]?></h2></a>
                                                                                </li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    <?php } ?>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
                <li class="line"></li>
                <li class="li-first">
                    <a class="transition <?php if($com=='tin-tuc') echo 'active'; ?>" href="<?=get_comlang('tin-tuc',$lang)?>" title="<?=_tintuc?>"><h2><?=_tintuc?></h2></a>
                    <?php if(count($ttlistmenu)) { ?>
                        <ul>
                            <?php for($i=0;$i<count($ttlistmenu); $i++) {
                                $ttcatmenu = $d->rawQuery("SELECT ten$lang, id FROM table_news_cat WHERE hienthi=1 AND id_list = ? ORDER BY stt,id DESC",array($ttlistmenu[$i]['id'])); ?>
                                <li>
                                    <a class="transition" title="<?=$ttlistmenu[$i]['ten'.$lang]?>" href="<?=get_slug($lang,$ttlistmenu[$i]['id'],'news_list')?>"><h2><?=$ttlistmenu[$i]['ten'.$lang]?></h2></a>
                                    <?php if(count($ttcatmenu)>0) { ?>
                                        <ul>
                                            <?php for($j=0;$j<count($ttcatmenu);$j++) {
                                                $ttitemmenu = $d->rawQuery("SELECT ten$lang, id FROM table_news_item WHERE hienthi=1 AND id_cat = ? ORDER BY stt,id DESC",array($ttcatmenu[$j]['id'])); ?>
                                                <li>
                                                    <a class="transition" title="<?=$ttcatmenu[$j]['ten'.$lang]?>" href="<?=get_slug($lang,$ttcatmenu[$j]['id'],'news_cat')?>"><h2><?=$ttcatmenu[$j]['ten'.$lang]?></h2></a>
                                                    <?php if(count($ttitemmenu)) { ?>
                                                        <ul>
                                                            <?php for($u=0;$u<count($ttitemmenu);$u++) {
                                                                $ttsubmenu = $d->rawQuery("SELECT ten$lang, id FROM table_news_sub WHERE hienthi=1 AND id_item = ? ORDER BY stt,id DESC",array($ttitemmenu[$u]['id'])); ?>
                                                                <li>
                                                                    <a class="transition" title="<?=$ttitemmenu[$u]['ten'.$lang]?>" href="<?=get_slug($lang,$ttitemmenu[$u]['id'],'news_item')?>"><h2><?=$ttitemmenu[$u]['ten'.$lang]?></h2></a>
                                                                    <?php if(count($ttsubmenu)) { ?>
                                                                        <ul>
                                                                            <?php for($s=0;$s<count($ttsubmenu);$s++) { ?>
                                                                                <li>
                                                                                    <a class="transition" title="<?=$ttsubmenu[$s]['ten'.$lang]?>" href="<?=get_slug($lang,$ttsubmenu[$s]['id'],'news_sub')?>"><h2><?=$ttsubmenu[$s]['ten'.$lang]?></h2></a>
                                                                                </li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    <?php } ?>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
                <li class="line"></li>
                <li class="li-first"><a class="transition <?php if($com=='tuyen-dung') echo 'active'; ?>" href="<?=get_comlang('tuyen-dung',$lang)?>" title="<?=_tuyendung?>"><h2><?=_tuyendung?></h2></a></li>
                <li class="line"></li>
                <li class="li-first"><a class="transition <?php if($com=='thu-vien-anh') echo 'active'; ?>" href="<?=get_comlang('thu-vien-anh',$lang)?>" title="<?=_thuvienanh?>"><h2><?=_thuvienanh?></h2></a></li>
                <li class="line"></li>
                <li class="li-first"><a class="transition <?php if($com=='video') echo 'active'; ?>" href="<?=get_comlang('video',$lang)?>" title="Video"><h2>Video</h2></a></li>
                <li class="line"></li>
                <li class="li-first"><a class="transition <?php if($com=='lien-he') echo 'active'; ?>" href="<?=get_comlang('lien-he',$lang)?>" title="<?=_lienhe?>"><h2><?=_lienhe?></h2></a></li>
            </ul>
        </div>
        <div class="search w-clear">
            <input type="text" id="keyword" placeholder="<?=_nhaptukhoatimkiem?>" onkeypress="doEnter(event,'keyword');"/>
            <p onclick="onSearch('keyword');"><i class="fas fa-search"></i></p>
        </div>
    </div>
</div>