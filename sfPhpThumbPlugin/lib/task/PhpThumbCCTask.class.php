<?php

class PhpThumbCCTask extends sfBaseTask
{
	protected function configure()
	{
		// // add your own arguments here
		// $this->addArguments(array(
		//   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
		// ));

		$this->addOptions(array(
		new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
		new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
		new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
		// add your own options here
		));

		$this->namespace        = 'phpthumb';
		$this->name             = 'cc';
		$this->briefDescription = '';
		$this->detailedDescription = <<<EOF
The [PhpThumbCC|INFO] task does things.
Call it with:

  [php symfony PhpThumbCC|INFO]
EOF;
	}

	protected function execute($arguments = array(), $options = array())
	{
		ini_set('max_execution_time', 120);
		ini_set('memory_limit','128M');

		$path = (sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.sfConfig::get('app_sfphpthumbplugin_cache_path','cache/'));
		
		if($path){
			$this->php_thumb_delete_dir_cache($path);
			echo "\r\n immagini in cache rimosse \r\n";	
		}else{
			echo "\r\n percorso non trovato \r\n";
		}
		
		
	}

	function php_thumb_delete_dir_cache($path) {
		$files = glob("$path/*");

		foreach($files as $file) {

			if(is_dir($file) && !is_link($file)) {
					
				$this->php_thumb_delete_dir_cache($file);
			}
			else {
					
				unlink($file);
			}
		}
		@rmdir($path);
	}
}
