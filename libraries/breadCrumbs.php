<?php
	class breadCrumbs
	{
		private $d;

		public function __construct($d)
		{
			$this->d = $d;
		}

		public function getUrl($title,$arr=array())
		{
			global $config_base;

			$breadcumb .='<ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';
			$breadcumb .='<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="text-decoration-none" itemprop="item" href="'.$config_base.'"><span itemprop="name">'.$title.'</span></a><meta itemprop="position" content="1" /></li>';
			$k = 1;

			for($i=0;$i<count($arr);$i++)
			{
				if($arr[$i]['name'])
				{
					$slug = ($arr[$i]['slug']) ? 'href="'.$config_base.$arr[$i]['slug'].'"' : "";
					$active = ($i == count($arr) - 1) ? "active" : "";
					$breadcumb .= '<li class="breadcrumb-item '.$active.'" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="text-decoration-none" itemprop="item" '.$slug.'><span itemprop="name">'.$arr[$i]['name'].'</span></a><meta itemprop="position" content="'.($k+1).'" /></li>';
					$k++;
				}
			}

		    $breadcumb .='</ol>';

		    return $this->minifyHtml($breadcumb);
		}

		static function minifyHtml($html)
		{
			$Search = array(
				'/(\n|^)(\x20+|\t)/',
				'/(\n|^)\/\/(.*?)(\n|$)/',
				'/\n/',
				'/\<\!--.*?-->/',
				'/(\x20+|\t)/',
				'/\>\s+\</',
				'/(\"|\')\s+\>/',
				'/=\s+(\"|\')/'
			);

			$Replace = array(
				"\n",
				"\n",
				" ",
				"",
				" ",
				"><",
				"$1>",
				"=$1"
			);

			$html = preg_replace($Search,$Replace,$html);

			return $html;
		}
	}
?>