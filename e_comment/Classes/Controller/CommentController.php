<?php

declare(strict_types=1);

namespace Emagineurs\EComment\Controller;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Extbase\Domain\Model\FileReference as ExtbaseFileReference;
use Emagineurs\EComment\Domain\Model\Demand;
use Emagineurs\EComment\Domain\Model\Message;
use Emagineurs\EComment\Domain\Repository\CategoryRepository;
use In2code\Femanager\Domain\Repository\UserRepository;
use Emagineurs\EComment\Domain\Repository\MessageRepository;
use Emagineurs\EComment\Event\NewMessageEvent;
use Emagineurs\EComment\Utility\BasicUtility;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Page\AssetCollector;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class CommentController extends ActionController
{
    protected MessageRepository $messageRepository;

    protected UserRepository $userRepository;

    protected CategoryRepository $categoryRepository;

    protected EventDispatcherInterface $eventDispatcher;

    protected ResourceFactory $resourceFactory;

    protected Context $context;

    public function __construct(
        MessageRepository $messageRepository,
        UserRepository $userRepository,
        CategoryRepository $categoryRepository,
        EventDispatcherInterface $eventDispatcher,
        Context $context,
        ResourceFactory $resourceFactory,

    ) {
        $this->messageRepository = $messageRepository;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->context = $context;
        $this->resourceFactory = $resourceFactory;
    }

    public function initializeAction(): void
    {
        $filterByParam = (string)($this->settings['filterByParam'] ?? '');

        if (empty(BasicUtility::getParamByStringPath($filterByParam)) && empty($this->settings['hideIfNoParam'] ?? null)) {
            $this->settings['filterByParam'] = 'id';
        }

        if (!empty($this->settings['formFieldDisplay'])) {
            $formFieldDisplay = (int)$this->settings['formFieldDisplay'];
            $this->settings['formFieldDisplay'] = [];

            if ($formFieldDisplay % 2 === 1) {
                $this->settings['formFieldDisplay']['title'] = true;
                --$formFieldDisplay;
            }

            $formFieldDisplay /= 2;

            if ($formFieldDisplay % 2 === 1) {
                $this->settings['formFieldDisplay']['email'] = true;
                --$formFieldDisplay;
            }

            $formFieldDisplay /= 2;

            if ($formFieldDisplay % 2 === 1) {
                $this->settings['formFieldDisplay']['name'] = true;
                --$formFieldDisplay;
            }

            $formFieldDisplay /= 2;

            if ($formFieldDisplay % 2 === 1) {
                $this->settings['formFieldDisplay']['firstname'] = true;
                --$formFieldDisplay;
            }

            $formFieldDisplay /= 2;

            if ($formFieldDisplay % 2 === 1) {
                $this->settings['formFieldDisplay']['category'] = true;
                --$formFieldDisplay;
            }

            $formFieldDisplay /= 2;

            if ($formFieldDisplay % 2 === 1) {
                $this->settings['formFieldDisplay']['replyForm'] = true;
                --$formFieldDisplay;
            }

            $formFieldDisplay /= 2;

            if ($formFieldDisplay % 2 === 1) {
                $this->settings['formFieldDisplay']['file'] = true;
            }
        } else {
            $this->settings['formFieldDisplay'] = [];
        }

        $this->settings['filterByValue'] = BasicUtility::getParamByStringPath((string)($this->settings['filterByParam'] ?? ''));

        if (!empty($this->settings['overwriteValidationModeratorEmail'])) {
            $this->settings['validation']['moderatorEmail'] = $this->settings['overwriteValidationModeratorEmail'];
            $this->settings['validation']['needValidation'] = true;
        }
    }

    public function commentAction(Demand $demand = null, Message $message = null): ResponseInterface
    {
        if ($this->shouldHideWhenNoParam()) {
            return $this->htmlResponse('');
        }

        $this->assignFrontendUser();
        $this->prepareAddData($message, 'comment');
        $this->prepareListData($demand);

        return $this->htmlResponse();
    }

    public function listAction(Demand $demand = null): ResponseInterface
    {
        if ($this->shouldHideWhenNoParam()) {
            return $this->htmlResponse('');
        }

        $this->assignFrontendUser();
        $this->prepareListData($demand);

        return $this->htmlResponse();
    }

    public function searchAction(Demand $demand = null): ResponseInterface
    {
        if ($this->shouldHideWhenNoParam()) {
            return $this->htmlResponse('');
        }

        $this->assignFrontendUser();

        $demand = $this->createDemand($demand);
        $incomingDemand = BasicUtility::getParamByStringPath('tx_ecomment_list[demand]');

        if (is_array($incomingDemand)) {
            if (isset($incomingDemand['searchKeywords'])) {
                $demand->setSearchKeywords($incomingDemand['searchKeywords']);
            }
            if (!empty($incomingDemand['category'])) {
                $categoryUid = (int)$incomingDemand['category'];
                if ($categoryUid > 0) {
                    /** @var PersistenceManager $persistenceManager */
                    $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
                    $category = $persistenceManager->getObjectByIdentifier($categoryUid, \TYPO3\CMS\Extbase\Domain\Model\Category::class, false);
                    if ($category instanceof \TYPO3\CMS\Extbase\Domain\Model\Category) {
                        $demand->setCategory($category);
                    }
                }
            }
        }
        $demand->completeWithSettings($this->settings);

        $this->view->assignMultiple([
            'demand' => $demand,
            'categories' => $this->resolveCategories(),
            'settings' => $this->settings,
        ]);

        return $this->htmlResponse();
    }

    public function addAction(Message $message = null, string $redirectAction = 'add'): ResponseInterface
    {
        if ($this->shouldHideWhenNoParam()) {
            return $this->htmlResponse('');
        }

        $this->assignFrontendUser();
        $this->prepareAddData($message, $redirectAction);

        return $this->htmlResponse();
    }

    public function validateAction(Message $message = null, string $token = '', ?bool $confirm = null): ResponseInterface
    {
        if ($message === null && $token !== '') {
            $message = $this->messageRepository->findOneByValidationToken($token);
        }

        if ($confirm === null && $this->request->hasArgument('confirm')) {
            $rawConfirm = $this->request->getArgument('confirm');
            $filteredConfirm = filter_var($rawConfirm, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            $confirm = $filteredConfirm ?? (bool)$rawConfirm;
        }

        $expectedToken = $message instanceof Message ? (string)$message->getValidationtoken() : '';
        $providedToken = (string)$token;

        $success = $message instanceof Message && $expectedToken !== '' && hash_equals($expectedToken, $providedToken);

        if ($success) {
            if ($confirm) {
                $message->setValidationtoken('');
                $this->messageRepository->update($message);
                $this->eventDispatcher->dispatch(new NewMessageEvent($message));
            } else {
                $this->messageRepository->remove($message);
            }
        }

        $this->view->assign('confirm', $confirm);
        $this->view->assign('success', $success);

        return $this->htmlResponse();
    }

    protected function isValidMessage(?Message $message): bool
    {
        $files = null;
        if ($message === null) {
            return false;
        }
        if ($this->request->hasArgument('file')) {
            $files = $this->request->getArgument('file');
        }

        if ($files !== null && count($files) > 0 && !empty($this->settings['maxFileSize'])) {
            $totalFileSize = 0;
            foreach ($files as $file) {
                $totalFileSize += $file->getSize();
            }

            if ($totalFileSize > (int)$this->settings['maxFileSize']) {
                $messageText = LocalizationUtility::translate('plugin.file_to_big', 'e_comment') ?? 'The uploaded file is too large.';
                $this->addFlashMessage($messageText, '', ContextualFeedbackSeverity::ERROR);
                return false;
            }
        }



        if (empty($message->getBodytext())) {
            return false;
        }
        $display = $this->settings['formFieldDisplay'] ?? [];
        if (!empty($display['title']) && empty($message->getTitle())) {
            return false;
        }
        if (!empty($display['name'])) {
            return $this->hasFrontendUser() || !empty($message->getName());
        }
        if (!empty($display['firstname']) && !$this->hasFrontendUser() && empty($message->getFirstname())) {
            return false;
        }
        if (!empty($display['email']) && !$this->hasFrontendUser()) {
            $email = trim((string)$message->getEmail());
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
        }
        if (!empty($display['category']) && $message->getParent() === null && $message->getCategory() === null) {
            return false;
        }
        return true;

        // return !empty($message->getBodytext()) && !(
        //     (!empty($this->settings['formFieldDisplay']['title']) && empty($message->getTitle())) ||
        //     (!empty($this->settings['formFieldDisplay']['name']) && !$this->hasFrontendUser() && empty($message->getName())) ||
        //     (!empty($this->settings['formFieldDisplay']['firstname']) && !$this->hasFrontendUser() && empty($message->getFirstname())) ||
        //     (!empty($this->settings['formFieldDisplay']['email']) && !$this->hasFrontendUser() && !filter_var((string)$message->getEmail(), FILTER_VALIDATE_EMAIL)) ||
        //     (!empty($this->settings['formFieldDisplay']['category']) && $message->getParent() === null && $message->getCategory() === null)
        // );
    }

    protected function includeFrontendAssets(): void
    {
        /** @var AssetCollector $assetCollector */
        $assetCollector = GeneralUtility::makeInstance(AssetCollector::class);
        $assetCollector->addJavaScript('e_comment', 'EXT:e_comment/Resources/Public/Js/ecomment.js');
    }

    protected function prepareAddData(?Message $message, string $redirectAction): void
    {
        $this->includeFrontendAssets();

        $categories = $this->resolveCategories();

        if ($this->isValidMessage($message)) {

            if ($this->settings['validation']['needValidation'] != 0) {
                $validationToken = BasicUtility::randomString(20);
                $message->setValidationtoken($validationToken);
            }

            if (!empty($this->settings['storagePid'])) {
                $rawValues = GeneralUtility::trimExplode(',', (string)$this->settings['storagePid'], true);
                $storagePids = [];
                foreach ($rawValues as $value) {
                    if (str_starts_with($value, 'pages_')) {
                        $value = substr($value, 6);
                    }
                    $pid = (int)$value;
                    if ($pid > 0) {
                        $storagePids[] = $pid;
                    }
                }

                if (!empty($storagePids)) {
                    ObjectAccess::setProperty($message, 'pid', $storagePids[0]);
                }
            }

            if ($this->hasFrontendUser()) {
                $userId = $this->context->getPropertyFromAspect('frontend.user', 'id');
                $userUid = (int)($userId ?? 0);
                if ($userUid > 0) {
                    $user = $this->userRepository->findByIdentifier((string)$userUid);
                    if ($user) {
                        $message->setFeuser($user);
                    }
                }
            }

            $message = $this->handleUploads($message);

            $this->messageRepository->add($message);
            
            GeneralUtility::makeInstance(PersistenceManager::class)->persistAll();

            if (!empty($this->settings['validation']['needValidation'])) {
                $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
                $templateRootPaths = (array)($extbaseFrameworkConfiguration['view']['templateRootPaths'] ?? []);
                $templateRootPath = (string)end($templateRootPaths);

                if ($templateRootPath === '') {
                    $templatePathAndFilename = GeneralUtility::getFileAbsFileName('EXT:e_comment/Resources/Private/Templates/Mail/ValidationMail.html');
                } else {
                    $templatePathAndFilename = GeneralUtility::getFileAbsFileName(
                        rtrim($templateRootPath, '/') . '/Mail/ValidationMail.html'
                    );
                }

                $validationPageUid = (int)($this->settings['validation']['validationPage'] ?? ($GLOBALS['TSFE']->id ?? 0));
                $confirmUri = $this->buildValidationUri($message, $validationPageUid, true);
                $declineUri = $this->buildValidationUri($message, $validationPageUid, false);

                $recipient = [
                    $this->settings['validation']['moderatorEmail'] => $this->settings['validation']['moderatorName']
                ];
                $sender = [
                    $this->settings['validation']['senderEmail'] => $this->settings['validation']['senderName']
                ];
                $subject = $this->settings['validation']['emailSubject'];

                BasicUtility::sendTemplateEmail(
                    $recipient,
                    $sender,
                    $subject,
                    $templatePathAndFilename,
                    [
                        'message' => $message,
                        'confirmUri' => $confirmUri,
                        'declineUri' => $declineUri
                    ]
                );
            } else {
                $this->eventDispatcher->dispatch(new NewMessageEvent($message));
            }

            return;
        }

        $messageForForm = $this->createFormMessage();

        $this->view->assignMultiple([
            'settings' => $this->settings,
            'categories' => $categories,
            'message' => $messageForForm,
        ]);
    }


    protected function buildValidationUri(Message $message, int $validationPageUid, bool $confirm): string
    {
        $uriBuilder = clone $this->uriBuilder;
        $uriBuilder
            ->reset()
            ->setCreateAbsoluteUri(true);

        if ($validationPageUid > 0) {
            $uriBuilder->setTargetPageUid($validationPageUid);
        }

        return (string)$uriBuilder->uriFor(
            'validate',
            [
                'message' => $message,
                'token' => $message->getValidationtoken(),
                'confirm' => $confirm ? 1 : 0,
            ],
            'Comment',
            'EComment',
            'Validate'
        );
    }

    protected function prepareListData(?Demand $demand): void
    {
        $resolvedDemand = $this->createDemand($demand);
        $resolvedDemand->completeWithSettings($this->settings);

        $messages = $this->messageRepository->findByDemand($resolvedDemand);
        $formMessage = $this->createFormMessage();

        $this->view->assignMultiple([
            'demand' => $resolvedDemand,
            'settings' => $this->settings,
            'formMessage' => $formMessage,
            'messages' => $messages,
        ]);
    }

    protected function resolveCategories()
    {
        $categorySetting = (string)($this->settings['categories'] ?? '');



        if ($categorySetting === '') {
            return [];
        }

        $categoryUids = GeneralUtility::intExplode(',', $categorySetting, true);

        if (empty($categoryUids)) {
            return [];
        }

        /** @var PersistenceManager $persistenceManager */
        $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $categories = [];
        foreach ($categoryUids as $uid) {
            $category = $persistenceManager->getObjectByIdentifier($uid, \TYPO3\CMS\Extbase\Domain\Model\Category::class, false);
            if ($category instanceof \TYPO3\CMS\Extbase\Domain\Model\Category) {
                $categories[$category->getUid()] = $category;
            }
        }

        return $categories;
    }

    protected function assignFrontendUser(): void
    {

        if (!$this->hasFrontendUser()) {
            return;
        }
        $userId = $this->context->getPropertyFromAspect('frontend.user', 'id');
        $userUid = (int)($userId ?? 0);

        if ($userUid <= 0) {
            return;
        }


        $user = $this->userRepository->findByIdentifier((string)$userUid);
        if ($user) {
            $this->view->assign('feuser', $user);
        }
    }

    protected function hasFrontendUser(): bool
    {

        return !empty($this->context->getPropertyFromAspect('frontend.user', 'id'));
    }

    protected function shouldHideWhenNoParam(): bool
    {
        return empty($this->settings['filterByValue']) && !empty($this->settings['hideIfNoParam']);
    }

    protected function createDemand(?Demand $demand): Demand
    {
        if ($demand instanceof Demand) {
            return $demand;
        }

        return GeneralUtility::makeInstance(Demand::class);
    }

    protected function createFormMessage(): Message
    {
        return GeneralUtility::makeInstance(Message::class);
    }


    protected function handleUploads($message): Message
    {
        //process image to message object 
        if ($this->request->hasArgument('file')) {
            $files = $this->request->getArgument('file');
            $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
            $storage = $resourceFactory->getDefaultStorage(); // or get a specific storage
            $imageObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage;
                foreach ($files as $file){
                    $tmpPath  = $file->getStream()->getMetadata('uri');
                    $filename  = $file->getClientFilename();
                    $fileObject = $storage->addFile($tmpPath, $storage->getFolder('/'), $filename);
                    // Build Extbase FileReference
                    $extbaseFileRef = GeneralUtility::makeInstance(ExtbaseFileReference::class);
                    $extbaseFileRef->setOriginalResource(
                    GeneralUtility::makeInstance(FileReference::class, [
                        'uid_local' => $fileObject->getUid()
                    ])
                    );
                    $imageObjectStorage->attach($extbaseFileRef);
                    // Attach to your property
                }
                    if($imageObjectStorage){
                $message->setFile($imageObjectStorage);
            }
        }
        return $message;
    }
    
}
