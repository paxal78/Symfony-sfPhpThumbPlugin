<?php
class PathFile extends Doctrine_Template {
	protected $_options = array(
		'field' => 'filename',
		'asset' => false
	);
	
	public function getAsset() {
		return $this -> _options['asset'];
	}

	public function getUriFilename() {
		$invoker = $this -> getInvoker();
		if ($invoker -> get($this -> _options['field']) == '') {
			return false;
		}
		return '/uploads/'.strtolower($this -> _options['asset']).'/' . $invoker -> get($this -> _options['field']) ;

	}

	public function getPathFilename($noimage = true) {
		$invoker = $this -> getInvoker();

		if (!$this -> _options['asset']) {
			throw new sfException('Nessun asset configurato');
		}

		$assetMethod = 'asset' . ucfirst(strtolower($this -> _options['asset']));
		if ($invoker -> get($this -> _options['field']) == '') {
			if ($noimage) {
				return realpath(sfConfig::get('app_no_image', sfConfig::get('sf_upload_dir') . '/no-image.jpg'));
			} else {
				return false;
			}
		}

		$path = realpath(AssetsSingleton::getInstance() -> $assetMethod(AssetsSingleton::PATH) . $invoker -> get($this -> _options['field']));
		if (file_exists($path)) {
			return $path;
		}
		if ($noimage) {
			return realpath(sfConfig::get('app_no_image', sfConfig::get('sf_upload_dir') . '/no-image.jpg'));
		} else {
			return false;
		}

		return $invoker;
	}

	public function unlinkFilename() {
		$invoker = $this -> getInvoker();
		$assetMethod = 'asset' . ucfirst(strtolower($this -> _options['asset']));
		if (!$invoker -> isNew()) {
			@unlink(AssetsSingleton::getInstance() -> $assetMethod(AssetsSingleton::PATH) . $invoker -> get($this -> _options['field']));
			return true;
		}
		return false;

	}

}
