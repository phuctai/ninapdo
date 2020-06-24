<?php
	class CssMinify
	{
		private $pathCss = array();
		private $debugCss;
		private $pathImg = '../images';
		private $pathRepImg = 'assets/images';
		private $pathFonts = '../fonts';
		private $pathRepFonts = 'assets/fonts';

		function __construct($debugCss, $func)
		{
			$this->debugCss = $debugCss;
			$this->func = $func;
		}

		public function setCss($path)
		{
			$this->pathCss[] = $path;
		}

		public function getCss()
		{
			if(empty($this->pathCss)) die("No files to optimize");
			return ($this->debugCss) ? $this->defaultCss() : $this->miniCss();
		}

		private function miniCss()
		{
			$strCss = '';
			$extension = '';
			foreach($this->pathCss as $path)
			{
				$path_parts = pathinfo($path);
				$extension = strtolower($path_parts['extension']);
				if($extension != 'css') die("Invalid file");
				$myfile = fopen($path, "r") or die("Unable to open file");
				$sizefile = filesize($path);
		        if($sizefile) $strCss .= $this->compressCss(fread($myfile,$sizefile));
			}
			if($strCss) $strCss = $this->replaceCss($strCss);
			return '<style type="text/css">'.$strCss.'</style>';
		}

		private function replaceCss($strCss)
		{
			$strCss = str_replace($this->pathImg, $this->pathRepImg, $strCss);
			$strCss = str_replace($this->pathFonts, $this->pathRepFonts, $strCss);
			return $strCss;
		}

		private function defaultCss()
		{
			$linkCss = '';
			$extension = '';
			foreach($this->pathCss as $path)
			{
				$path_parts = pathinfo($path);
				$extension = strtolower($path_parts['extension']);
				if($extension != 'css') die("Invalid file");
				$linkCss .= '<link href="'.$path.'?v='.$this->func->stringRandom(10).'" rel="stylesheet">'.PHP_EOL;
			}
			return $linkCss;
		}

		private function compressCss($buffer)
		{
		    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		    $buffer = str_replace(': ', ':', $buffer);
		    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
		    return $buffer;
		}
	}
?>