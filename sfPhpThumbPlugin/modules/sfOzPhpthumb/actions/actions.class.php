<?php

/**
 * dashboard actions.
 *
 * @package    italydestination
 * @subpackage dashboard
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfOzPhpthumbActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeClear(sfWebRequest $request)
  {
  	sfConfig::set('sf_web_debug',false);
	if($this->getUser()->isSuperAdmin()){
		$currentDir = getcwd();
	
		chdir(sfConfig::get('sf_root_dir'));
	
		
		$task = new PhpThumbCCTask($this->dispatcher, new sfFormatter());
		ob_start();
		$returnCode = $task->run();
		ob_end_clean();
		chdir($currentDir);
		$this->setLayout(false);
		return sfView::NONE;
		
	}else{
		echo 'Utente non autorizzato';
	}

  }
}
