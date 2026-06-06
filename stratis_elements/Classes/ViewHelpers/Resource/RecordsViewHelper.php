<?php

namespace Stratis\StratisElements\ViewHelpers\Resource;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;



/**
 * Class RecordsViewHelper
 * @package Stratis\StratisElements\ViewHelpers\Resource
 */
class RecordsViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('type', 'string', 'Record type (e.g., tt_content, pages, etc.)', true);
        $this->registerArgument('uidList', 'string', 'Comma-separated list of UIDs', false, '');
        $this->registerArgument('ignoreEnableFields', 'bool', 'Ignore enable fields', false, false);
        $this->registerArgument('respectSysLanguage', 'bool', 'Respect sys language', false, true);
        $this->registerArgument('limit', 'int', 'Limit number of results', false, 0);
    }

    public function render(): array
    {
        $type = $this->arguments['type'];
        $uidList = $this->arguments['uidList'];
        $ignoreEnableFields = $this->arguments['ignoreEnableFields'];
        $respectSysLanguage = $this->arguments['respectSysLanguage'];
        $limit = $this->arguments['limit'];

        $records = []; 
        if (empty($uidList)) {
            $uidList = (string)$this->renderChildren();
        }

        $uidListArray = GeneralUtility::trimExplode(',', $uidList, true);

        if (empty($uidListArray)) {
            return [];
        }

        $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $query = $persistenceManager->createQueryForType($type);
        $settings = $query->getQuerySettings();

        $settings->setRespectStoragePage(false);
        $settings->setIgnoreEnableFields($ignoreEnableFields);
        $settings->setRespectSysLanguage($respectSysLanguage);

        if ($limit > 0) {
            $query->setLimit($limit);
        }

        $constraints = [];
        foreach ($uidListArray as $uid) {
            $constraints[] = $query->equals('uid', (int)$uid);
        }

        $records = $query->matching($query->logicalOr(...$constraints))->execute()->toArray();

        usort($records, static function ($a, $b) use ($uidListArray): int {
            $aUid = ObjectAccess::getProperty($a, 'uid');
            $bUid = ObjectAccess::getProperty($b, 'uid');

            return array_search($aUid, $uidListArray, true) - array_search($bUid, $uidListArray, true);
        });


        return $records;
    }

}
