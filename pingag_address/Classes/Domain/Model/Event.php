<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_event_mgt" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Pingag\PingagAddress\Domain\Model;



/**
 * Event
 */
class Event extends \DERHANSEN\SfEventMgt\Domain\Model\Event
{
    /**
     * Goal
     *
     * @var string
     */
    protected $goal = '';

    /**
     * Requirements
     *
     * @var string
     */
    protected $requirements = '';

    /**
     * Vorkenntnisse
     *
     * @var string
     */
    protected $vorkenntnisse = '';

    /**
     * Comment
     *
     * @var string
     */
    protected $comment = '';

    /**
     * Infos
     *
     * @var string
     */
    protected $infos = '';

    /**
     * Zgroup
     *
     * @var string
     */
    protected $zgroup = '';

    /**
     * Leader
     *
     * @var string
     */
    protected $leader = '';

    /**
     * Pricetext
     *
     * @var string
     */
    protected $pricetext = '';

    /**
     * Dateextra
     *
     * @var string
     */
    protected $dateextra = '';

    /**
     * Otherdates
     *
     * @var string
     */
    protected $otherdates = '';

    /**
     * veranstaltung
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Veranstaltung>
     */
    protected $veranstaltung = null;
    /**
     * zielgruppe
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Zielgruppe>
     */
    protected $zielgruppe = null;
    /**
     * kursthemen
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Kursthemen>
     */
    protected $kursthemen = null;
    /**
     * sprache
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Sprache>
     */
    protected $sprache = null;

    /**
     * Returns the goal
     *
     * @return string $goal
     */
    public function getGoal() {
        return $this->goal;
    }

    /**
     * Sets the goal
     *
     * @param string $goal
     * @return void
     */
    public function setGoal($goal) {
        $this->goal = $goal;
    }

    /**
     * Returns the requirements
     *
     * @return string $requirements
     */
    public function getRequirements() {
        return $this->requirements;
    }

    /**
     * Sets the requirements
     *
     * @param string $requirements
     * @return void
     */
    public function setRequirements($requirements) {
        $this->requirements = $requirements;
    }

    /**
     * Returns the vorkenntnisse
     *
     * @return string $vorkenntnisse
     */
    public function getVorkenntnisse() {
        return $this->vorkenntnisse;
    }

    /**
     * Sets the vorkenntnisse
     *
     * @param string $vorkenntnisse
     * @return void
     */
    public function setVorkenntnisse($vorkenntnisse) {
        $this->vorkenntnisse = $vorkenntnisse;
    }

    /**
     * Returns the infos
     *
     * @return string $infos
     */
    public function getInfos() {
        return $this->infos;
    }

    /**
     * Sets the infos
     *
     * @param string $infos
     * @return void
     */
    public function setInfos($infos) {
        $this->infos = $infos;
    }

    /**
     * Returns the comment
     *
     * @return string $comment
     */
    public function getComment() {
        return $this->comment;
    }

    /**
     * Sets the comment
     *
     * @param string $comment
     * @return void
     */
    public function setComment($comment) {
        $this->comment = $comment;
    }

    /**
     * Returns the zgroup
     *
     * @return string $zgroup
     */
    public function getZgroup() {
        return $this->zgroup;
    }

    /**
     * Sets the zgroup
     *
     * @param string $zgroup
     * @return void
     */
    public function setZgroup($zgroup) {
        $this->zgroup = $zgroup;
    }

    /**
     * Returns the leader
     *
     * @return string $leader
     */
    public function getLeader() {
        return $this->leader;
    }

    /**
     * Sets the leader
     *
     * @param string $leader
     * @return void
     */
    public function setLeader($leader) {
        $this->leader = $leader;
    }

    /**
     * Returns the pricetext
     *
     * @return string $pricetext
     */
    public function getPricetext() {
        return $this->pricetext;
    }

    /**
     * Sets the pricetext
     *
     * @param string $pricetext
     * @return void
     */
    public function setPricetext($pricetext)
    {
        $this->pricetext = $pricetext;
    }
    /**
     * Returns the dateextra
     *
     * @return string $dateextra
     */
    public function getDateextra() {
        return $this->dateextra;
    }

    /**
     * Sets the dateextra
     *
     * @param string $dateextra
     */
    public function setDateextra($dateextra) {
        $this->dateextra = $dateextra;
    }

    /**
     * Returns the otherdates
     *
     * @return string $otherdates
     */
    public function getOtherdates() {
        return $this->otherdates;
    }

    /**
     * Sets the otherdates
     *
     * @param string $otherdates
     */
    public function setOtherdates($otherdates) {
        $this->otherdates = $otherdates;
    }
    /**
     * Adds a veranstaltung
     *
     * @param \Pingag\PingagAddress\Domain\Model\Veranstaltung $veranstaltung
     * @return void
     */
    public function addVeranstaltung(\Pingag\PingagAddress\Domain\Model\Veranstaltung $veranstaltung)
    {
        $this->veranstaltung->attach($veranstaltung);
    }
    /**
     * Adds a zielgruppe
     *
     * @param \Pingag\PingagAddress\Domain\Model\Zielgruppe $zielgruppe
     * @return void
     */
    public function addZielgruppe(\Pingag\PingagAddress\Domain\Model\Zielgruppe $zielgruppe)
    {
        $this->zielgruppe->attach($zielgruppe);
    }
    /**
     * Adds a kursthemen
     *
     * @param \Pingag\PingagAddress\Domain\Model\Kursthemen $kursthemen
     * @return void
     */
    public function addKursthemen(\Pingag\PingagAddress\Domain\Model\Kursthemen $kursthemen)
    {
        $this->kursthemen->attach($kursthemen);
    }
    /**
     * Adds a sprache
     *
     * @param \Pingag\PingagAddress\Domain\Model\Sprache $sprache
     * @return void
     */
    public function addSprache(\Pingag\PingagAddress\Domain\Model\Sprache $sprache)
    {
        $this->sprache->attach($sprache);
    }
    /**
     * Removes a veranstaltung
     *
     * @param \Pingag\PingagAddress\Domain\Model\Veranstaltung $veranstaltungToRemove The veranstaltung to be removed
     * @return void
     */
    public function removeVeranstaltung(\Pingag\PingagAddress\Domain\Model\Veranstaltung $veranstaltung)
    {
        $this->veranstaltung->detach($veranstaltung);
    }
    /**
     * Removes a zielgruppe
     *
     * @param \Pingag\PingagAddress\Domain\Model\Zielgruppe $zielgruppeToRemove The zielgruppe to be removed
     * @return void
     */
    public function removeZielgruppe(\Pingag\PingagAddress\Domain\Model\Zielgruppe $zielgruppeToRemove)
    {
        $this->zielgruppe->detach($zielgruppeToRemove);
    }
    /**
     * Removes a kursthemen
     *
     * @param \Pingag\PingagAddress\Domain\Model\Kursthemen $kursthemenToRemove The kursthemen to be removed
     * @return void
     */
    public function removeKursthemen(\Pingag\PingagAddress\Domain\Model\Kursthemen $kursthemenToRemove)
    {
        $this->kursthemen->detach($kursthemenToRemove);
    }
    /**
     * Removes a sprache
     *
     * @param \Pingag\PingagAddress\Domain\Model\Sprache $spracheToRemove The sprache to be removed
     * @return void
     */
    public function removeSprache(\Pingag\PingagAddress\Domain\Model\Sprache $spracheToRemove)
    {
        $this->sprache->detach($spracheToRemove);
    }
    /**
     * Returns the veranstaltung
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Veranstaltung>
     */
    public function getVeranstaltung()
    {
        return $this->veranstaltung;
    }
    /**
     * Returns the zielgruppe
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Zielgruppe>
     */
    public function getZielgruppe()
    {
        return $this->zielgruppe;
    }
    /**
     * Returns the kursthemen
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Kursthemen>
     */
    public function getKursthemen()
    {
        return $this->kursthemen;
    }
    /**
     * Returns the sprache
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Sprache>
     */
    public function getSprache()
    {
        return $this->sprache;
    }

    /**
     * Sets the veranstaltung
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Veranstaltung> $veranstaltung
     * @return void
     */
    public function setVeranstaltung(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $veranstaltung)
    {
        $this->veranstaltung = $veranstaltung;
    }
    /**
     * Sets the zielgruppe
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Zielgruppe> $zielgruppe
     * @return void
     */
    public function setZielgruppe(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $zielgruppe)
    {
        $this->zielgruppe = $zielgruppe;
    }

    /**
     * Sets the kursthemen
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Kursthemen> $kursthemen
     * @return void
     */
    public function setKursthemen(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $kursthemen)
    {
        $this->kursthemen = $kursthemen;
    }
    /**
     * Sets the sprache
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Sprache> $sprache
     * @return void
     */
    public function setSprache(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $sprache)
    {
        $this->sprache = $sprache;
    }
}
