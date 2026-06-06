<?php
declare(strict_types = 1);
namespace Pingag\PingagAddress\Domain\Repository;


use In2code\Powermail\Domain\Model\Field;
use In2code\Powermail\Domain\Model\Page;
use In2code\Powermail\Utility\ConfigurationUtility;
use In2code\Powermail\Utility\DatabaseUtility;
use In2code\Powermail\Utility\ObjectUtility;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Extbase\Object\Exception;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Class FieldRepository
 */
class FieldRepository extends \In2code\Powermail\Domain\Repository\FieldRepository
{

    public function getTranslateFrom($uid, $sys_language_uid)
    {

        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_powermail_domain_model_field WHERE page ='.$uid.' AND sys_language_uid= '.$sys_language_uid);
        return $query->execute();
    }

    public function getFrom($uid)
    {

        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_powermail_domain_model_field WHERE page ='.$uid);
        return $query->execute();
    }

    public function getOrginalMarker($uid)
    {

        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_powermail_domain_model_field WHERE uid ='.$uid);
        return $query->execute()->getFirst();
    }
}
