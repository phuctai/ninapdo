<?php
	$columnarr = array(
		"title"=>'TEXT',
		"keywords"=>'TEXT',
		"description"=>'TEXT'
	);

	$columnLang = array(
		"lang"=>"TEXT"
	);
	
	function createLangInit()
	{
		global $config, $d, $columnarr, $columnLang;

		foreach($config['website']['lang'] as $klang => $vlang)
		{
			foreach($columnLang as $kcol => $vcol)
			{
				$col = $kcol.$klang;
				$rowcol = $d->rawQueryOne("SHOW COLUMNS FROM table_lang LIKE '$col'");

				if($rowcol==null) $d->rawQuery("ALTER TABLE table_lang ADD $col $vcol CHARACTER SET utf8 COLLATE utf8_unicode_ci ");
			}
		}
		foreach($config['website']['lang'] as $klang => $vlang)
		{
			foreach($columnarr as $kcol => $vcol)
			{
				$col = $kcol.$klang;
				$rowcol = $d->rawQueryOne("SHOW COLUMNS FROM table_seo LIKE '$col'");

				if($rowcol==null) $d->rawQuery("ALTER TABLE table_seo ADD $col $vcol CHARACTER SET utf8 COLLATE utf8_unicode_ci ");
			}
		}
		foreach($config['website']['lang'] as $klang => $vlang)
		{
			foreach($columnarr as $kcol => $vcol)
			{
				$col = $kcol.$klang;
				$rowcol = $d->rawQueryOne("SHOW COLUMNS FROM table_seopage LIKE '$col'");

				if($rowcol==null) $d->rawQuery("ALTER TABLE table_seopage ADD $col $vcol CHARACTER SET utf8 COLLATE utf8_unicode_ci ");
			}
		}
		foreach($config['website']['lang'] as $klang => $vlang)
		{
			foreach($columnarr as $kcol => $vcol)
			{
				$col = $kcol.$klang;
				$rowcol = $d->rawQueryOne("SHOW COLUMNS FROM table_setting LIKE '$col'");

				if($rowcol==null) $d->rawQuery("ALTER TABLE table_setting ADD $col $vcol CHARACTER SET utf8 COLLATE utf8_unicode_ci ");
			}
		}
		die("Thêm cột ngôn ngữ thành công.");
	}

	function deleteLangInit($lang)
	{
		if($lang!='')
		{
			global $config, $d, $columnarr, $columnLang;

			foreach($config['website']['lang'] as $vlang)
			{
				foreach($columnLang as $kcol => $vcol)
				{
					$col = $kcol.$lang;
					$row = $d->rawQueryOne("SHOW COLUMNS FROM table_lang LIKE '$col'");

					if($row!=null) $d->rawQuery("ALTER TABLE table_lang DROP $col");
				}
			}
			foreach($config['website']['lang'] as $vlang)
			{
				foreach($columnarr as $kcol => $vcol)
				{
					$col = $kcol.$lang;
					$row = $d->rawQueryOne("SHOW COLUMNS FROM table_seo LIKE '$col'");

					if($row!=null) $d->rawQuery("ALTER TABLE table_seo DROP $col");
				}
			}
			foreach($config['website']['lang'] as $vlang)
			{
				foreach($columnarr as $kcol => $vcol)
				{
					$col = $kcol.$lang;
					$row = $d->rawQueryOne("SHOW COLUMNS FROM table_seopage LIKE '$col'");

					if($row!=null) $d->rawQuery("ALTER TABLE table_seopage DROP $col");
				}
			}
			foreach($config['website']['lang'] as $vlang)
			{
				foreach($columnarr as $kcol => $vcol)
				{
					$col = $kcol.$lang;
					$row = $d->rawQueryOne("SHOW COLUMNS FROM table_setting LIKE '$col'");

					if($row!=null) $d->rawQuery("ALTER TABLE table_setting DROP $col");
				}
			}
			die("Xóa cột ngôn ngữ thành công.");
		}
	}

	// createLangInit();
	// deleteLangInit('cn');
?>