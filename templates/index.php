<!DOCTYPE html>
<html lang="<?=$config['website']['lang-document']?>">
<head>
    <?php include SOURCES."head.php"; ?>
    <?php include SOURCES."css.php"; ?>
</head>
<body>
    <?php
        include SOURCES."seo.php";
        include TEMPLATE.LAYOUT."header.php";
        include TEMPLATE.LAYOUT."menu.php";
        include TEMPLATE.LAYOUT."mmenu.php";
        if($source=='index') include TEMPLATE.LAYOUT."slide.php";
        else include TEMPLATE.LAYOUT."breadcrumb.php";
    ?>
    <div class="wrap-main <?=($source=='index')?'wrap-home':''?> w-clear"><?php include TEMPLATE.$template."_tpl.php"; ?></div>
    <?php
        include TEMPLATE.LAYOUT."footer.php";
        include TEMPLATE.LAYOUT."strucdata.php";
        include TEMPLATE.LAYOUT."modal.php";
        include SOURCES."js.php";
        echo $func->getAddonsOnline("scriptMain","scriptMain","scriptMain",0,0);
        echo $func->getAddonsOnline($setting["fanpage"],"ChatMessages","messages",0,0);
        // if($deviceType=='phone') include TEMPLATE.LAYOUT."phone.php";
    ?>
</body>
</html>