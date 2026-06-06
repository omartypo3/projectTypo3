<?php

namespace Emagineurs\EGmap\Ajax;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 SEBBAGH Ian <isebbagh@e-magineurs.com>, E-magineurs
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

class InfoPoiAjax
{

    public function main()
    {
        header('Content-Type: application/xml; charset=utf-8');

        #INIT TSFE
        $TSFE = \Emagineurs\EGmap\Lib\ELib::initAjax();

        $conf['vendor'] = 'Emagineurs';
        $conf['extensionName'] = 'EGmap';
        $conf['controller'] = 'Map';
        $conf['action'] = 'info';
        $conf['arguments'] = array();

        $content = \Emagineurs\EGmap\Lib\ELib::callExtbaseAction($conf);

        echo $content;
    }

}


