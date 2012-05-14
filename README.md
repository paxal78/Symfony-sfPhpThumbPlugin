<h2>Instructions for use</h2>
<p>This plugin for Symfony (tested on 1.4v) is built on <a href="http://phpthumb.gxdlabs.com/">http://phpthumb.gxdlabs.com/</a>.</p>
<h3>Basic</h3>


<pre><code>

	$thumb = sfPhpThumbFactory::create($file, $options);	
	$thumb -> width = $width;
	$thumb -> height = $height;
	$thumb -> resize($width, $height);
	
	or 
	
	$thumb -> adaptiveResize($width, $height);
	
	$thumb -> getUrl();
	 
    
</code></pre>

<p>
	...but....in this way every time you resize an image you spend time resource for the operation.
</p>
<h3>Cached image</h3>
<p>
	If you'll use the helper the image will be put in a cache folder and only first time you call the image it will be resized. Next time you will get the image cached.
</p>

<pre><code>

/**
 * @var $file string path of file  
 * @var $adaptive boolean
 * @var  $optionsPhpThumb array options PhpThumb lib
 * @return string url
 */
	
  retrive_phpthumb_url($file,$width,$height,$adaptive,$optionsPhpThumb );
  
  /**
 * @var $file string path of file  
 * @var $adaptive boolean
 * @var  $options attribute tags
 * @return html anchor
 */

  retrive_phpthumb_tag($file,$width,$height,$adaptive,$options)
    
</code></pre>

<p>un example of cached image</p>

<pre><code>
	/uploads/cache/0/c/filename_80x100_c.jpg     
</code></pre>

<h3>Configuration</h3>

#app.yml
all:
  sfphpthumbplugin_cache_path: cache/
  base_id: %SF_UPLOAD_DIR%
  no_image: %SF_UPLOAD_DIR%/no-image.jpg


