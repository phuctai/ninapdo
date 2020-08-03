<?php if(count($slider)) { ?>
    <div class="slideshow">
        <div class="box-slide">
            <div class="slider-wrapper theme-default">
                <div id="slider-main" class="nivoSlider">
                    <?php for($i=0;$i<count($slider);$i++) { ?>
                        <?php $captionSlide = ($slider[$i]['ten'.$lang]!='' || $slider[$i]['mota'.$lang]!='') ? "title='#slide-caption".$i."'" : "" ; ?>
                        <a href="<?=$slider[$i]['link']?>" title="<?=$slider[$i]['ten'.$lang]?>"><img onerror="this.src='<?=THUMBS?>/1366x600x2/assets/images/noimage.png';" src="<?=THUMBS?>/1366x600x1/<?=UPLOAD_PHOTO_L.$slider[$i]['photo']?>" alt="<?=$slider[$i]['ten'.$lang]?>" <?=$captionSlide?>/></a>
                    <?php } ?>
                </div>
                <?php /* for($i=0;$i<count($slider);$i++) { if($slider[$i]['ten'.$lang] || $slider[$i]['mota'.$lang]) { ?>
                    <div id="slide-caption<?=$i?>" class="nivo-html-caption">
                        <a class="grid-caption" href="<?=$slider[$i]['link']?>">
                            <div class="box-caption">
                                <div class="inner-caption">
                                    <p class="label-caption"><?=$slider[$i]['ten'.$lang]?></p>
                                    <p class="info-caption"><?=$slider[$i]['mota'.$lang]?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } } */ ?>
            </div>
        </div>
    </div>
<?php } ?>