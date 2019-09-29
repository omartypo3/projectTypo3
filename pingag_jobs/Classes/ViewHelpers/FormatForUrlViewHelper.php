<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 19.07.2018
 * Time: 13:23
 */

namespace Pingag\PingagJobs\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class FormatForUrlViewHelper extends AbstractViewHelper
{

    /**
     * @param null|string $string
     * @return string
     */
    public function render($string = null)
    {
        if(!$string){
            $string = $this->renderChildren();
        }
        
        return self::formatForUrl($string);
    }

    /**
     * @param $string
     * @return string
     */
    public static function formatForUrl($string, $debug=false)
    {
        $string = trim($string);
        
        $string = strtolower($string);
        $string = strtr($string, [
            ' ' => '-',
            '.' => '-',
            ',' => '',
            '&' => '-',
            '%' => '-',
            '/' => '',
            'ä' => 'ae',
            'ö' => 'oe',
            'ü' => 'ue',
        ]);
        $string = str_replace('--', '-', $string);
        $string = trim($string, '-');
        
        return $string;
    }
    
}