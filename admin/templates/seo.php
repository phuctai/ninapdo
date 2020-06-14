<!-- SEO -->
<?php
    if($com == "static" || $com == "seopage")
    {
        foreach($config['website']['comlang'] as $k => $v)
        {
            if($type == $k)
            {
                $slugurlArray = $v;
                break;
            }
        }
    }
?>
<div class="card-seo">
    <?php if($config['website']['seo']['lang-active']) { ?>
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                    <?php foreach($config['website']['lang'] as $k => $v) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?=($k=='vi')?'active':''?>" id="tabs-lang" data-toggle="pill" href="#tabs-seolang-<?=$k?>" role="tab" aria-controls="tabs-seolang-<?=$k?>" aria-selected="true">SEO (<?=$v?>)</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                    <?php foreach($config['website']['lang'] as $k => $v) { ?>
                        <div class="tab-pane fade show <?=($k=='vi')?'active':''?>" id="tabs-seolang-<?=$k?>" role="tabpanel" aria-labelledby="tabs-lang">
                            <div class="form-group">
                                <div class="label-seo">
                                    <label for="title<?=$k?>">SEO Title (<?=$k?>):</label>
                                    <strong class="count-seo"><span><?=strlen(utf8_decode($seo['title'.$k]))?></span>/70 ký tự</strong>
                                </div>
                                <input type="text" class="form-control check-seo title-seo" name="dataSeo[title<?=$k?>]" id="title<?=$k?>" placeholder="SEO Title (<?=$k?>)" value="<?=$seo['title'.$k]?>">
                            </div>
                            <div class="form-group">
                                <div class="label-seo">
                                    <label for="keywords<?=$k?>">SEO Keywords (<?=$k?>):</label>
                                    <strong class="count-seo"><span><?=strlen(utf8_decode($seo['keywords'.$k]))?></span>/70 ký tự</strong>
                                </div>
                                <input type="text" class="form-control check-seo keywords-seo" name="dataSeo[keywords<?=$k?>]" id="keywords<?=$k?>" placeholder="SEO Keywords (<?=$k?>)" value="<?=$seo['keywords'.$k]?>">
                            </div>
                            <div class="form-group">
                                <div class="label-seo">
                                    <label for="description<?=$k?>">SEO Description (<?=$k?>):</label>
                                    <strong class="count-seo"><span><?=strlen(utf8_decode($seo['description'.$k]))?></span>/160 ký tự</strong>
                                </div>
                                <textarea class="form-control check-seo description-seo" name="dataSeo[description<?=$k?>]" id="description<?=$k?>" rows="5" placeholder="SEO Description (<?=$k?>)"><?=$seo['description'.$k]?></textarea>
                            </div>
                            
                            <?php if($k == "vi" || $k == "en") { ?>
                                <!-- SEO preview -->
                                <div class="form-group form-group-seo-preview">
                                    <label class="label-seo-preview">Khi lên top, page này sẽ hiển thị theo dạng mẫu như sau:</label>
                                    <div class="seo-preview">
                                        <?php if($slugurlArray) { ?>
                                            <p class="slug-seo-preview" id="seourlpreview<?=$k?>" data-seourlstatic="0"><?=$config_base?><strong><?=$slugurlArray[$k]?></strong></p>
                                        <?php } else { ?>
                                            <p class="slug-seo-preview" id="seourlpreview<?=$k?>" data-seourlstatic="<?=($com == 'setting') ? 0 : 1?>"><?=$config_base?><strong><?=$item['tenkhongdau'.$k]?></strong></p>
                                        <?php } ?>
                                        <p class="title-seo-preview text-split" id="title-seo-preview<?=$k?>"><?php if($seo['title'.$k]) { echo $seo['title'.$k]; } else if($item['ten'.$k]) { echo $item['ten'.$k]; } else { echo "Title"; } ?></p>
                                        <p class="description-seo-preview text-split" id="description-seo-preview<?=$k?>"><?=($seo['description'.$k])?$seo['description'.$k]:"Description"?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } else { $k = "vi"; ?>
        <div class="form-group">
            <div class="label-seo">
                <label for="title<?=$k?>">SEO Title:</label>
                <strong class="count-seo"><span><?=strlen(utf8_decode($seo['title'.$k]))?></span>/70 ký tự</strong>
            </div>
            <input type="text" class="form-control check-seo title-seo" name="dataSeo[title<?=$k?>]" id="title<?=$k?>" placeholder="SEO Title" value="<?=$seo['title'.$k]?>">
        </div>
        <div class="form-group">
            <div class="label-seo">
                <label for="keywords<?=$k?>">SEO Keywords:</label>
                <strong class="count-seo"><span><?=strlen(utf8_decode($seo['keywords'.$k]))?></span>/70 ký tự</strong>
            </div>
            <input type="text" class="form-control check-seo keywords-seo" name="dataSeo[keywords<?=$k?>]" id="keywords<?=$k?>" placeholder="SEO Keywords" value="<?=$seo['keywords'.$k]?>">
        </div>
        <div class="form-group">
            <div class="label-seo">
                <label for="description<?=$k?>">SEO Description:</label>
                <strong class="count-seo"><span><?=strlen(utf8_decode($seo['description'.$k]))?></span>/160 ký tự</strong>
            </div>
            <textarea class="form-control check-seo description-seo" name="dataSeo[description<?=$k?>]" id="description<?=$k?>" rows="5" placeholder="SEO Description"><?=$seo['description'.$k]?></textarea>
        </div>

        <!-- SEO preview -->
        <div class="form-group form-group-seo-preview">
            <label class="label-seo-preview">Khi lên top, page này sẽ hiển thị theo dạng mẫu như sau:</label>
            <div class="seo-preview">
                <?php if($slugurlArray) { ?>
                    <p class="slug-seo-preview" id="seourlpreview<?=$k?>" data-seourlstatic="0"><?=$config_base?><strong><?=$slugurlArray[$k]?></strong></p>
                <?php } else { ?>
                    <p class="slug-seo-preview" id="seourlpreview<?=$k?>" data-seourlstatic="<?=($com == 'setting') ? 0 : 1?>"><?=$config_base?><strong><?=$item['tenkhongdau'.$k]?></strong></p>
                <?php } ?>
                <p class="title-seo-preview text-split" id="title-seo-preview<?=$k?>"><?php if($seo['title'.$k]) { echo $seo['title'.$k]; } else if($item['ten'.$k]) { echo $item['ten'.$k]; } else { echo "Title"; } ?></p>
                <p class="description-seo-preview text-split" id="description-seo-preview<?=$k?>"><?=($seo['description'.$k])?$seo['description'.$k]:"Description"?></p>
            </div>
        </div>
    <?php } ?>
</div>