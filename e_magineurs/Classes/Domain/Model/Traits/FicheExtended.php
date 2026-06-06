<?php

namespace Emagineurs\EAnnuaires\Domain\Model\Traits;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Marvin MARCHAND <mmarchand@e-magineurs.com>
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
 * ************************************************************* */

trait FicheExtended {

    /**
     * direction
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EMagineurs\Domain\Model\Direction>
     */
    protected $direction;

    /**
     * cadreemploi
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EMagineurs\Domain\Model\Cadreemploi>
     */
    protected $cadreemploi;

    /**
     * grade
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EMagineurs\Domain\Model\Grade>
     */
    protected $grade;

    /**
     * metier
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EMagineurs\Domain\Model\Metier>
     */
    protected $metier;

    /**
     * Returns the direction
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EMagineurs\Domain\Model\Direction> $direction
     */
    function getDirection() {
        return $this->direction;
    }

    /**
     * Returns the cadreemploi
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EMagineurs\Domain\Model\Cadreemploi> $cadreemploi
     */
    function getCadreemploi() {
        return $this->cadreemploi;
    }

    /**
     * Returns the grade
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EMagineurs\Domain\Model\Grade> $grade
     */
    function getGrade() {
        return $this->grade;
    }

    /**
     * Returns the metier
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EMagineurs\Domain\Model\Metier> $metier
     */
    function getMetier() {
        return $this->metier;
    }

    /**
     * Sets the direction
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EMagineurs\Domain\Model\Direction> $direction
     * @return void
     */
    function setDirection(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $direction) {
        $this->direction = $direction;
    }

    /**
     * Sets the cadreemploi
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EMagineurs\Domain\Model\Cadreemploi> $cadreemploi
     * @return void
     */
    function setCadreemploi($cadreemploi) {
        $this->cadreemploi = $cadreemploi;
    }

    /**
     * Sets the grade
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EMagineurs\Domain\Model\Grade> $grade
     * @return void
     */
    function setGrade($grade) {
        $this->grade = $grade;
    }

    /**
     * Sets the metier
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EMagineurs\Domain\Model\Metier> $metier
     * @return void
     */
    function setMetier($metier) {
        $this->metier = $metier;
    }

}
