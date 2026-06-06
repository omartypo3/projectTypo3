<?php
declare(strict_types=1);

namespace Pingag\PingagAddress\Domain\Repository;

use In2code\Powermail\Domain\Model\Field;
use In2code\Powermail\Domain\Model\Form;
use In2code\Powermail\Domain\Model\Page;
use In2code\Powermail\Utility\BackendUtility;
use In2code\Powermail\Utility\DatabaseUtility;
use In2code\Powermail\Utility\ObjectUtility;
use TYPO3\CMS\Core\Database\QueryGenerator;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\Exception;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Class FormRepository
 */
class FormRepository extends \In2code\Powermail\Domain\Repository\FormRepository
{


    public function getTranslateFrom($uid, $sys_language_uid)
    {

        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_powermail_domain_model_form WHERE l10n_parent='.$uid.' AND sys_language_uid= '.$sys_language_uid);
        return $query->execute()->getFirst();
    }

    public function getTranslateFromNew($uid, $sys_language_uid)
    {

        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_powermail_domain_model_form WHERE deleted = 0 AND hidden = 0 AND t3_origuid='.$uid.' AND sys_language_uid= '.$sys_language_uid);
        return $query->execute();
    }

}
