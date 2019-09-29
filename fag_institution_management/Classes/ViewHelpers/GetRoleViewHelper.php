<?php

namespace FRONTAL\FagInstitutionManagement\ViewHelpers;

/***************************************************************
 * = Examples =
 *
 *  {namespace fagsvg=FRONTAL\FagSvg\ViewHelpers}
 *  <fag:svgToHtml path="{f:uri.image(src:file.uid, treatIdAsReference:1, absolute:1)}" />
 *
 ***************************************************************/

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\DebugUtility;

class GetRoleViewHelper extends AbstractViewHelper
{


    /**
     * @param int $user
     * @param int $institution
     * @return mixed
     */
    public function render($user, $institution)
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $roleRepository= $objectManager->get('FRONTAL\\FagInstitutionManagement\\Domain\\Repository\\RoleRepository');
        $roleObjects = $roleRepository->findByUserAndInstitution($user , $institution);
        return $roleObjects;
    }
}
