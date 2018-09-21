<?php

namespace Theme\ViewHelpers;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class UserViewHelper  extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{

    /**
     * User Repository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $userRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
     * @inject
     */
    protected $frontendUserGroupRepository;
    /**
     *
     * @param string $redirect
     *
     */
    public function render($redirect) {

        $id = $GLOBALS['TSFE']->fe_user->user['uid'];

        $fields = '*';
        $table = 'tx_dld_domain_model_application';
        $where = "`user_id` LIKE '".$id."'";//pid IN (' . $indexerConfig['sysfolder'] . ') AND
        //if($pids != '') $where .= ' AND uid IN ('.$variantens.')';
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields,$table,$where,$groupBy,$orderBy,$limit);
        $resCount = $GLOBALS['TYPO3_DB']->sql_num_rows($res);


        return $resCount;
    }
}