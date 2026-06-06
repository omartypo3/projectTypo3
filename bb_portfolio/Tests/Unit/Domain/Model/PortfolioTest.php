<?php

namespace BravoBuero\BbPortfolio\Tests\Unit\Domain\Model;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use BravoBuero\BbPortfolio\Domain\Model\Portfolio;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use BravoBuero\BbPortfolio\Domain\Model\Kunden;
use BravoBuero\BbPortfolio\Domain\Model\Kategorien;
use BravoBuero\BbPortfolio\Domain\Model\Hashtags;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
/**
 * Test case for class \BravoBuero\BbPortfolio\Domain\Model\Portfolio.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PortfolioTest extends UnitTestCase
{
	/**
	 * @var \BravoBuero\BbPortfolio\Domain\Model\Portfolio
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new Portfolio();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getDatumReturnsInitialValueForDateTime()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getDatum()
		);
	}

	/**
	 * @test
	 */
	public function setDatumForDateTimeSetsDatum()
	{
		$dateTimeFixture = new \DateTime();
		$this->subject->setDatum($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'datum',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getAliasReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getAlias()
		);
	}

	/**
	 * @test
	 */
	public function setAliasForStringSetsAlias()
	{
		$this->subject->setAlias('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'alias',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTitelReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getTitel()
		);
	}

	/**
	 * @test
	 */
	public function setTitelForStringSetsTitel()
	{
		$this->subject->setTitel('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'titel',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getUntertitelReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getUntertitel()
		);
	}

	/**
	 * @test
	 */
	public function setUntertitelForStringSetsUntertitel()
	{
		$this->subject->setUntertitel('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'untertitel',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getBeschreibungReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getBeschreibung()
		);
	}

	/**
	 * @test
	 */
	public function setBeschreibungForStringSetsBeschreibung()
	{
		$this->subject->setBeschreibung('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'beschreibung',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getLinkReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getLink()
		);
	}

	/**
	 * @test
	 */
	public function setLinkForStringSetsLink()
	{
		$this->subject->setLink('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'link',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getZeitraumReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getZeitraum()
		);
	}

	/**
	 * @test
	 */
	public function setZeitraumForStringSetsZeitraum()
	{
		$this->subject->setZeitraum('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'zeitraum',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getSystemReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getSystem()
		);
	}

	/**
	 * @test
	 */
	public function setSystemForStringSetsSystem()
	{
		$this->subject->setSystem('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'system',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTeaserBildReturnsInitialValueForFileReference()
	{
		$newObjectStorage = new ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getTeaserBild()
		);
	}

	/**
	 * @test
	 */
	public function setTeaserBildForFileReferenceSetsTeaserBild()
	{
		$teaserBild = new FileReference();
		$objectStorageHoldingExactlyOneTeaserBild = new ObjectStorage();
		$objectStorageHoldingExactlyOneTeaserBild->attach($teaserBild);
		$this->subject->setTeaserBild($objectStorageHoldingExactlyOneTeaserBild);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneTeaserBild,
			'teaserBild',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addTeaserBildToObjectStorageHoldingTeaserBild()
	{
		$teaserBild = new FileReference();
		$teaserBildObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$teaserBildObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($teaserBild));
		$this->inject($this->subject, 'teaserBild', $teaserBildObjectStorageMock);

		$this->subject->addTeaserBild($teaserBild);
	}

	/**
	 * @test
	 */
	public function removeTeaserBildFromObjectStorageHoldingTeaserBild()
	{
		$teaserBild = new FileReference();
		$teaserBildObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$teaserBildObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($teaserBild));
		$this->inject($this->subject, 'teaserBild', $teaserBildObjectStorageMock);

		$this->subject->removeTeaserBild($teaserBild);

	}

	/**
	 * @test
	 */
	public function getYoutubeReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getYoutube()
		);
	}

	/**
	 * @test
	 */
	public function setYoutubeForStringSetsYoutube()
	{
		$this->subject->setYoutube('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'youtube',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getBilderReturnsInitialValueForFileReference()
	{
		$newObjectStorage = new ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getBilder()
		);
	}

	/**
	 * @test
	 */
	public function setBilderForFileReferenceSetsBilder()
	{
		$bilder = new FileReference();
		$objectStorageHoldingExactlyOneBilder = new ObjectStorage();
		$objectStorageHoldingExactlyOneBilder->attach($bilder);
		$this->subject->setBilder($objectStorageHoldingExactlyOneBilder);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneBilder,
			'bilder',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addBilderToObjectStorageHoldingBilder()
	{
		$bilder = new FileReference();
		$bilderObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$bilderObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($bilder));
		$this->inject($this->subject, 'bilder', $bilderObjectStorageMock);

		$this->subject->addBilder($bilder);
	}

	/**
	 * @test
	 */
	public function removeBilderFromObjectStorageHoldingBilder()
	{
		$bilder = new FileReference();
		$bilderObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$bilderObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($bilder));
		$this->inject($this->subject, 'bilder', $bilderObjectStorageMock);

		$this->subject->removeBilder($bilder);

	}

	/**
	 * @test
	 */
	public function getSeoKeywordsReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getSeoKeywords()
		);
	}

	/**
	 * @test
	 */
	public function setSeoKeywordsForStringSetsSeoKeywords()
	{
		$this->subject->setSeoKeywords('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'seoKeywords',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getSeoDescriptionReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getSeoDescription()
		);
	}

	/**
	 * @test
	 */
	public function setSeoDescriptionForStringSetsSeoDescription()
	{
		$this->subject->setSeoDescription('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'seoDescription',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getKundennameReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getKundenname()
		);
	}

	/**
	 * @test
	 */
	public function setKundennameForStringSetsKundenname()
	{
		$this->subject->setKundenname('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'kundenname',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getKundennamecheckReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setKundennamecheckForIntSetsKundennamecheck()
	{	}

	/**
	 * @test
	 */
	public function getKundeReturnsInitialValueForKunden()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getKunde()
		);
	}

	/**
	 * @test
	 */
	public function setKundeForKundenSetsKunde()
	{
		$kundeFixture = new Kunden();
		$this->subject->setKunde($kundeFixture);

		$this->assertAttributeEquals(
			$kundeFixture,
			'kunde',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getKategorieReturnsInitialValueForKategorien()
	{
		$newObjectStorage = new ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getKategorie()
		);
	}

	/**
	 * @test
	 */
	public function setKategorieForObjectStorageContainingKategorienSetsKategorie()
	{
		$kategorie = new Kategorien();
		$objectStorageHoldingExactlyOneKategorie = new ObjectStorage();
		$objectStorageHoldingExactlyOneKategorie->attach($kategorie);
		$this->subject->setKategorie($objectStorageHoldingExactlyOneKategorie);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneKategorie,
			'kategorie',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addKategorieToObjectStorageHoldingKategorie()
	{
		$kategorie = new Kategorien();
		$kategorieObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$kategorieObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($kategorie));
		$this->inject($this->subject, 'kategorie', $kategorieObjectStorageMock);

		$this->subject->addKategorie($kategorie);
	}

	/**
	 * @test
	 */
	public function removeKategorieFromObjectStorageHoldingKategorie()
	{
		$kategorie = new Kategorien();
		$kategorieObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$kategorieObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($kategorie));
		$this->inject($this->subject, 'kategorie', $kategorieObjectStorageMock);

		$this->subject->removeKategorie($kategorie);

	}

	/**
	 * @test
	 */
	public function getHashtagsReturnsInitialValueForHashtags()
	{
		$newObjectStorage = new ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getHashtags()
		);
	}

	/**
	 * @test
	 */
	public function setHashtagsForObjectStorageContainingHashtagsSetsHashtags()
	{
		$hashtag = new Hashtags();
		$objectStorageHoldingExactlyOneHashtags = new ObjectStorage();
		$objectStorageHoldingExactlyOneHashtags->attach($hashtag);
		$this->subject->setHashtags($objectStorageHoldingExactlyOneHashtags);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneHashtags,
			'hashtags',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addHashtagToObjectStorageHoldingHashtags()
	{
		$hashtag = new Hashtags();
		$hashtagsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$hashtagsObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($hashtag));
		$this->inject($this->subject, 'hashtags', $hashtagsObjectStorageMock);

		$this->subject->addHashtag($hashtag);
	}

	/**
	 * @test
	 */
	public function removeHashtagFromObjectStorageHoldingHashtags()
	{
		$hashtag = new Hashtags();
		$hashtagsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$hashtagsObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($hashtag));
		$this->inject($this->subject, 'hashtags', $hashtagsObjectStorageMock);

		$this->subject->removeHashtag($hashtag);

	}

	/**
	 * @test
	 */
	public function getRelatedReturnsInitialValueForPortfolio()
	{
		$newObjectStorage = new ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getRelated()
		);
	}

	/**
	 * @test
	 */
	public function setRelatedForObjectStorageContainingPortfolioSetsRelated()
	{
		$related = new Portfolio();
		$objectStorageHoldingExactlyOneRelated = new ObjectStorage();
		$objectStorageHoldingExactlyOneRelated->attach($related);
		$this->subject->setRelated($objectStorageHoldingExactlyOneRelated);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneRelated,
			'related',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addRelatedToObjectStorageHoldingRelated()
	{
		$related = new Portfolio();
		$relatedObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$relatedObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($related));
		$this->inject($this->subject, 'related', $relatedObjectStorageMock);

		$this->subject->addRelated($related);
	}

	/**
	 * @test
	 */
	public function removeRelatedFromObjectStorageHoldingRelated()
	{
		$related = new Portfolio();
		$relatedObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$relatedObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($related));
		$this->inject($this->subject, 'related', $relatedObjectStorageMock);

		$this->subject->removeRelated($related);

	}
}
