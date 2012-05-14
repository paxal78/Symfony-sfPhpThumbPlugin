<?php 

Class sfPhpThumbFactory extends  PhpThumbFactory{

	public static function create ($filename = null, $options = array(), $isDataStream = false)
	{
		if(is_array($filename)){
			$filename = $filename[0];
		}
		// map our implementation to their class names
		$implementationMap = array
		(
			'imagick'	=> 'ImagickThumb',
			'gd' 		=> 'sfGdThumb'
			);

			// grab an instance of PhpThumb
			$pt = PhpThumb::getInstance();
			// load the plugins
			$pt->loadPlugins(self::$pluginPath);

			$toReturn = null;
			$implementation = self::$defaultImplemenation;

			// attempt to load the default implementation
			if ($pt->isValidImplementation(self::$defaultImplemenation))
			{

				$imp = $implementationMap[self::$defaultImplemenation];
				$toReturn = new $imp($filename, $options, $isDataStream);
			}
			// load the gd implementation if default failed
			else if ($pt->isValidImplementation('gd'))
			{
				$imp = $implementationMap['gd'];
				$implementation = 'gd';
				$toReturn = new $imp($filename, $options, $isDataStream);
			}
			// throw an exception if we can't load
			else
			{
				throw new Exception('You must have either the GD or iMagick extension loaded to use this library');
			}

			$registry = $pt->getPluginRegistry($implementation);
			$toReturn->importPlugins($registry);
			return $toReturn;
	}
}