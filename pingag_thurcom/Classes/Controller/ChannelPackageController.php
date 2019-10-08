<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 16.08.2017
 * Time: 11:14
 */

namespace Pingag\PingagThurcom\Controller;

use Pingag\PingagThurcom\Domain\Model\ChannelPackage;

class ChannelPackageController extends BaseController
{
	/**
     * @var \Pingag\PingagThurcom\Domain\Repository\ChannelPackageRepository
     * @inject
     */
    protected $channelPackageRepo;

	
    /**
     * @var \Pingag\PingagThurcom\Domain\Repository\ChannelRepository
     * @inject
     */
    protected $channelRepo;


    public function listAction()
    {
		$zusatzpaket = $this->getFlexformSetting('zusatzpaket');
		$channelPackages = $this->channelPackageRepo->findByUid($zusatzpaket);
		
		$sender = $channelPackages->getChannels();
		$kanaele = explode(',', $sender);
		$senderliste = $this->channelRepo->findByUids($kanaele);
		
		$this->view->assign('senderliste', $senderliste);           
		
		$this->view->assign('package', $channelPackages);
        return $this->view->render();			
    }
	
	public function listOrderAction()
    {
		$channelPackages = $this->channelPackageRepo->findAll();          
		
		$this->view->assign('package', $channelPackages);
        return $this->view->render();			
    }
	
}