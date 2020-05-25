<!DOCTYPE html>
<html lang="<?=$config['website']['langHtml']?>">
<head>
    ABC
    <?php include _SOURCE."head.php"; ?>
    <?php include _SOURCE."css.php"; ?>
</head>
<body>
    <?php
        include _SOURCE."seo.php";
        include _TEMPLATE._LAYOUT."header.php";
        include _TEMPLATE._LAYOUT."menu.php";
        include _TEMPLATE._LAYOUT."mmenu.php";
        if($source=='index') include _TEMPLATE._LAYOUT."slide.php";
        else include _TEMPLATE._LAYOUT."breadcrumb.php";
    ?>
    <div class="wrap-main <?=($source=='index')?'wrap-home':''?> w-clear"><?php include _TEMPLATE.$template."_tpl.php"; ?></div>
    <?php
        include _TEMPLATE._LAYOUT."footer.php";
        include _TEMPLATE._LAYOUT."strucdata.php";
        include _TEMPLATE._LAYOUT."modal.php";
        include _SOURCE."js.php";
        echo getAddonsOnline("scriptMain","scriptMain","scriptMain",0,0);
        echo getAddonsOnline($setting["fanpage"],"ChatMessages","messages",0,0);
        // if($deviceType=='phone') include _TEMPLATE._LAYOUT."phone.php";
    ?>
</body>
</html>