<?php

class PhpThumbStatic {
	public static function retrive_phpthumb_url($file, $width, $height, $adaptive = true, $optionsPhpThumb = array()) {
		if (!file_exists($file) || !is_file($file)) {
			return false;
		}
		if (!count($optionsPhpThumb)) {
			$optionsPhpThumb = array(
				'jpegQuality' => sfConfig::get('app_phpthumb_plugin_jpegQuality', 70),
				'resizeUp' => sfConfig::get('app_phpthumb_plugin_resizeUp', false)
			);
		}

		$thumb = sfPhpThumbFactory::create($file, $optionsPhpThumb);
		if ($adaptive) {
			$thumb -> cropped = true;
		}
		$thumb -> width = $width;
		$thumb -> height = $height;

		if ($filename_in_cache = $thumb -> file_exist()) {
			return $filename_in_cache;
		}

		if ($adaptive) {
			$thumb -> adaptiveResize($width, $height);
		} else {
			$thumb -> resize($width, $height);
		}
		return $thumb -> getUrl();

	}

	public static function remove_cache($file, $width, $height, $adaptive = true, $optionsPhpThumb = array()) {
		$url = self::retrive_phpthumb_url($file, $width, $height, $adaptive, $optionsPhpThumb);
		$path = str_replace(sfContext::getInstance()->getRequest()->getUriPrefix(), '', $url);
		$path = realpath(sfConfig::get('sf_web_dir').$path);
		@unlink($path);

	}

}
