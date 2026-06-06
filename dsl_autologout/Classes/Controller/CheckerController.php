<?php
namespace DslFactory\DslAutologout\Controller;

/***
 *
 * This file is part of the "Logout Checker" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017
 *
 ***/

/**
 * CheckerController
 */
class CheckerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * action checkForLogin
     * 
     * @return void
     */
    public function checkForLoginAction()
    {
		
		
		$time = new \DateTime();
		if($this->request->hasArgument('ajax')){
		//	sleep(5);
			if(!\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser()) die;
			echo $time->getTimestamp();
			die;
			//die;
		}
		
		$uriBuilder = $this->controllerContext->getUriBuilder();
		$uriBuilder->reset();
		$uriBuilder->setTargetPageUid($this->settings["redirectPid"]);
		
		$this->view->assign('redirectUri', $uriBuilder->build());
		$this->view->assign('timestamp', $time->getTimestamp());
		//return "bla";
		/*echo 2;
die;*/
    }
}
