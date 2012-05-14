<?php
/* @var $thumb sfGdThumb */
function retrive_phpthumb_url($file,$width,$height,$adaptive= true,$optionsPhpThumb = array())
{
	return PhpThumbStatic::retrive_phpthumb_url($file, $width, $height,$adaptive,$optionsPhpThumb);

}

function retrive_phpthumb_tag($file,$width,$height,$adaptive= true,$options= array())
{
	if($options['src'] = retrive_phpthumb_url($file,$width,$height,$adaptive)){
		return tag('img',$options);
	};
	return false;
}
