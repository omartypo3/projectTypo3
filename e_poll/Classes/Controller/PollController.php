<?php
namespace Emagineurs\EPoll\Controller;

/***************************************************************
*  Copyright notice
*
*  (c) 2016 Le Sommer Léo-Robin <llesommer@e-magineurs.com>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

use Emagineurs\EPoll\Domain\Model\Poll;
use Emagineurs\EPoll\Domain\Model\Vote;
use Emagineurs\EPoll\Domain\Repository\PollRepository;
use Emagineurs\EPoll\Domain\Repository\OptionRepository;
use Emagineurs\EPoll\Domain\Repository\VoteRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Base controller
 *
 * @package e_poll
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PollController extends ActionController {
    
    /**
     * @param PollRepository $pollRepository
     * @param OptionRepository $optionRepository
     * @param VoteRepository $voteRepository
     * @param PersistenceManagerInterface $persistenceManager
     */
    public function __construct(
        protected readonly PollRepository $pollRepository,
        protected readonly OptionRepository $optionRepository,
        protected readonly VoteRepository $voteRepository,
        protected readonly PersistenceManagerInterface $persistenceManager
    ) {
    }

    /**
     * action show
     *
     * @param Poll|null $poll
     * @return ResponseInterface
     */
    public function showAction(Poll $poll = null): ResponseInterface {
        if(empty($poll)) {
            if(!empty($this->settings['singlePoll'])) {
                $pollUid = $this->extractUidFromGroupValue($this->settings['singlePoll']);
                $poll = $this->pollRepository->findByUid($pollUid);
            } else {
                throw new \RuntimeException('Poll not found.', 1234567890);
            }
        }

        $this->view->assign('vote', new Vote());
        $this->view->assign('settings', $this->settings);
        $this->view->assign('poll', $poll);
        
        return $this->htmlResponse();
    }

    /**
     * List poll action
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface {
        $polls = $this->pollRepository->findBySettings($this->settings);

        $this->view->assign('vote', new Vote());
        $this->view->assign('settings', $this->settings);
        $this->view->assign('polls', $polls);
        
        return $this->htmlResponse();
    }

    /**
     * Display poll result
     *
     * @param Poll|null $poll
     * @return ResponseInterface
     */
    public function resultAction(Poll $poll = null): ResponseInterface {
        if(empty($poll)) {
            if(!empty($this->settings['singlePoll'])) {
                $pollUid = $this->extractUidFromGroupValue($this->settings['singlePoll']);
                $poll = $this->pollRepository->findByUid($pollUid);
            } else {
                throw new \RuntimeException('Poll not found.', 1234567891);
            }
        }

        $this->view->assign('vote', new Vote());
        $this->view->assign('settings', $this->settings);
        $this->view->assign('poll', $poll);
        
        return $this->htmlResponse();
    }

    /**
     * Vote for a poll
     *
     * @param Vote|null $vote
     * @param Poll|null $poll
     * @return ResponseInterface
     */
    public function voteAction(?Vote $vote = null, ?Poll $poll = null): ResponseInterface {
        // If vote or poll is missing, redirect to show or result
        if ($vote === null || $poll === null) {
            if ($poll !== null) {
                return $this->redirect('show', null, null, ['poll' => $poll]);
            }
            // Try to get poll from settings
            if (!empty($this->settings['singlePoll'])) {
                $pollUid = $this->extractUidFromGroupValue($this->settings['singlePoll']);
                $poll = $this->pollRepository->findByUid($pollUid);
                if ($poll !== null) {
                    return $this->redirect('show', null, null, ['poll' => $poll]);
                }
            }
            // If poll is still missing, redirect to list
            return $this->redirect('list');
        }

        if($poll->hasAlreadyVoted($this->settings['verificationType'], (int)($this->settings['verificationPeriod'] ?? 0))) {
            return $this->redirect('result', null, null, ['poll' => $poll]);
        }

        //Set the feuser
        $request = $this->request->getAttribute('frontend.user');
        if($request !== null && !empty($request->user)) {
            $vote->setFeuser((int)$request->user['uid']);
        }

        $vote->setIp($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');

        if(!empty($this->settings['verificationType']) && $this->settings['verificationType'] == 'cookie') {
            $period = !empty($this->settings['verificationPeriod']) ? $this->settings['verificationPeriod'] : 3600 * 24 * 30;
            setcookie('t3_tx_epoll_' . $vote->getPoll()->getUid(), 'voted:yes', time() + $period);
        }

        $vote->setPid($poll->getPid());

        $this->voteRepository->add($vote);
        $this->persistenceManager->persistAll();

        return $this->redirect('result', null, null, ['poll' => $poll]);
    }

    /**
     * Extract UID from group field value
     *
     * @param string|int $value
     * @return int
     */
    protected function extractUidFromGroupValue($value): int
    {
        if (is_numeric($value)) {
            return (int)$value;
        }
        
        if (is_string($value) && str_contains($value, '_')) {
            $parts = explode('_', $value);
            $uid = (int)end($parts);
            if ($uid > 0) {
                return $uid;
            }
        }
        
        return (int)$value;
    }
}
