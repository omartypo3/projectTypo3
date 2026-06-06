<?php
declare(strict_types = 1);
namespace Pingag\PingagAddress\Domain\Repository;

use In2code\Powermail\Domain\Model\Form;
use In2code\Powermail\Domain\Model\Page;
use In2code\Powermail\Utility\DatabaseUtility;

/**
 * Class PageRepository
 */
class PageRepository extends \In2code\Powermail\Domain\Repository\PageRepository
{
    public function getTranslateFrom($uid, $sys_language_uid)
    {

        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_powermail_domain_model_page WHERE form ='.$uid.' AND sys_language_uid= '.$sys_language_uid);
        return $query->execute()->getFirst();
    }

    public function getFrom($uid)
    {

        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_powermail_domain_model_page WHERE form ='.$uid);
        return $query->execute()->getFirst();
    }
}
