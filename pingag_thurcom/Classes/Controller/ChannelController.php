<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 16.08.2017
 * Time: 11:14
 */

namespace Pingag\PingagThurcom\Controller;

use Pingag\PingagThurcom\Domain\Model\Channel;

class ChannelController extends BaseController
{
	/**
     * @var \Pingag\PingagThurcom\Domain\Repository\ChannelPackageRepository
     * @inject
     */
    protected $channelPackageRepo;
	
    public function listAction()
    {
        $channels = $this->channelRepo->findAll();

        $categories = [];
        /** @var Channel $channel */
        foreach ($channels as $channel) {
            foreach ($channel->getCategories() as $category) {
				$sortierung = $category->getSorting();
				$sortierung = sprintf("%04d", $sortierung);
                $categories[$sortierung.$category->getTitle()][$channel->getUid()] = $channel;
            }
        }
		ksort($categories);
        $this->view->assign('categories', $categories);
        return $this->view->render();
		
    }
	
	public function listPackagesAction()
    {
        $channels = $this->channelRepo->findAll();

        $senderliste = [];
        /** @var Channel $channel */
        foreach ($channels as $channel) {
            foreach ($channel->getPackages() as $category) {
				$kanal = $category;
                //$senderliste[$kanal->getName()][$channel->getUid()] = $channel;
            }
        }

        $this->view->assign('categories', $senderliste);
        return $this->view->render();
    }

    public function iconlistAction()
    {
        $channels = $this->channelRepo->findAll();

        $this->view->assign('channels', $channels);
        return $this->view->render();
    }
}