<?php
	class JsMinify
	{
		private $pathJs = array();
		private $debugJs;
		private $cacheName = '';
		private $cacheFile = 'assets/js/';
		private $cacheSize = false;

		function __construct($debugJs, $func)
		{
			$this->debugJs = $debugJs;
			$this->func = $func;
		}

		public function setJs($path)
		{
			$this->pathJs[] = $path;
		}

		public function getJs()
		{
			if(empty($this->pathJs)) die("No files to optimize");
			return ($this->debugJs) ? $this->defaultJs() : $this->miniJs();
		}

		public function setCache($name)
		{
			$this->cacheName = $name;
			$this->cacheFile = $this->cacheFile.$this->cacheName.'.js';
			$this->cacheSize = filesize($this->cacheFile);
		}

		private function miniJs()
		{
			$strJs = '';
			$extension = '';

			if(!$this->cacheSize)
			{
				foreach($this->pathJs as $path)
				{
					$path_parts = pathinfo($path);
					$extension = strtolower($path_parts['extension']);
					if($extension != 'js') die("Invalid file");
					$myfile = fopen($path, "r") or die("Unable to open file");
					$sizefile = filesize($path);
			        if($sizefile) $strJs .= fread($myfile,$sizefile).PHP_EOL;
					fclose($myfile);
				}

				$file = fopen($this->cacheFile, "w") or die("Unable to open file");
				fwrite($file, $strJs);
				fclose($file);
			}

			return '<script type="text/javascript" src="'.$this->cacheFile.'"></script>';
		}

		private function defaultJs()
		{
			$linkJs = '';
			$extension = '';

			if($this->cacheSize)
			{
				$file = fopen($this->cacheFile, "r+") or die("Unable to open file");
				ftruncate($file, 0);
				fclose($file);
			}

			foreach($this->pathJs as $path)
			{
				$path_parts = pathinfo($path);
				$extension = strtolower($path_parts['extension']);
				if($extension != 'js') die("Invalid file");
				$linkJs .= '<script type="text/javascript" src="'.$path.'?v='.$this->func->stringRandom(10).'"></script>'.PHP_EOL;
			}

			return $linkJs;
		}
	}
?>