<?php 
Class sfGdThumb extends GdThumb{

	public $url;
	public $cropped = false;
	public $base_path = false;
	public $width = false;
	public $height = false;
	

	public function __construct ($fileName, $options = array(), $isDataStream = false){
		$this->base_path = sfConfig::get('app_sfPhpThumbPlugin_base_dir',sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_sfphpthumbplugin_cache_path','cache/'));
		
		if(!is_dir($this->base_path)){
			mkdir($this->base_path);
		}

		parent::__construct ($fileName, $options, $isDataStream);
	}
	public function getUrl($force = false, $path = false){		
		$dir1 = substr(md5($this->getFileName()),0,1);
		$dir2 = substr(md5($this->getFileName()),1,1);
		$dir = $dir1.'/'.$dir2; 
		$filename = $this->_generateUrl();
		$this->path = $this->base_path.$dir.'/'.$filename;
	
		if(!file_exists($this->path) || $force){
			if(!is_dir($this->base_path.$dir1)){
				mkdir($this->base_path.$dir1);
			}
			if(!is_dir($this->base_path.$dir)){
				mkdir($this->base_path.$dir);
			}
			
			$this->save($this->path);
		}
		$return = '';
		if(!$path){
			$return = sfContext::getInstance()->getRequest()->getUriPrefix ();
		}
		return $return.'/uploads/'.sfConfig::get('app_sfphpthumbplugin_cache_path','cache/')
			.$dir.'/'.$filename;
	}

	private function _generateUrl(){
		$base_name= basename($this->getFileName());
		
		$base_name = str_replace(strtolower('.'.$this->getFormat()), '', strtolower($base_name));
		if(!$this->width && !$this->height){
			$dim = $this->getCurrentDimensions();
			$base_name .= '_'.$dim['width'].'x'.$dim['height'];	
		}else{
			
			$base_name .= '_'.$this->width .'x'.$this->height ;
		}
		
		

		if($this->cropped){
			$base_name .= '_c';
		}
		$base_name .= '.'.strtolower($this->getFormat());

		return $base_name;
			
	}
	
	public function file_exist(){
		$dir1 = substr(md5($this->getFileName()),0,1);
		$dir2 = substr(md5($this->getFileName()),1,1);
		$dir = $dir1.'/'.$dir2; 
		$filename = $this->_generateUrl();
		
		if(file_exists($this->base_path.$dir.'/'.$filename)){
			$return = sfContext::getInstance()->getRequest()->getUriPrefix ();
			return $return.'/uploads/'.sfConfig::get('app_sfphpthumbplugin_cache_path','cache/').$dir.'/'.$filename;
		}else{
			return false;
		}
		
		
	}

	public function cropFromCenter($cropWidth, $cropHeight = null){
		$this->cropped = true;
		parent::cropFromCenter($cropWidth,$cropHeight);
		return $this;
	}

	public function crop ($startX, $startY, $cropWidth, $cropHeight){
		$this->cropped = true;
		parent::crop($startX, $startY, $cropWidth, $cropHeight);
		return $this;
	}
	

}
