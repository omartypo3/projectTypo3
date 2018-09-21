<?php
/**
 * Created by PhpStorm.
 * User: Oussama
 * Date: 12/07/2018
 * Time: 13:55
 */

namespace DLD\Dld\ViewHelpers;


use TYPO3\CMS\Core\Utility\DebugUtility;

class PeopleDisplayTagsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @param string $tags
     * @return array
     */
    public function render($tags) {

        $tags = substr($tags, 1, -1);
        $tagarray = explode(',',$tags);
        return $tagarray;
    }
}