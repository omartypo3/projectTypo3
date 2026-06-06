<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Controller;

use Psr\Http\Message\ResponseInterface;
use Stratis\StratisSocialAuth\Domain\Repository\ConfigurationRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Class AbstractController
 * @package Stratis\StratisSocialAuth\Controller
 */
class AbstractController extends ActionController
{
    /**
     * AbstractController constructor.
     * @param ConfigurationRepository $configurationRepository
     */
    public function __construct(protected ConfigurationRepository $configurationRepository)
    {
    }

    /**
     * List buttons for authentication
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        $configuration = $this->configurationRepository->findByUid($this->settings['configuration']);
        $this->view->assign('configuration', $configuration);

        return $this->htmlResponse();
    }
}
