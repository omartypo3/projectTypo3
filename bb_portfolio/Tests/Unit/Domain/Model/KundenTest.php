<?php

namespace BravoBuero\BbPortfolio\Tests\Unit\Domain\Model;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use BravoBuero\BbPortfolio\Domain\Model\Kunden;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use BravoBuero\BbPortfolio\Domain\Model\Branchen;
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
 * Test case for class \BravoBuero\BbPortfolio\Domain\Model\Kunden.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class KundenTest extends UnitTestCase
{
	/**
	 * @var \BravoBuero\BbPortfolio\Domain\Model\Kunden
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new Kunden();
	}

	public function tearDown()
	{
		unset($this->subject);
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
	public function getNameReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getName()
		);
	}

	/**
	 * @test
	 */
	public function setNameForStringSetsName()
	{
		$this->subject->setName('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'name',
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
	public function getLogoReturnsInitialValueForFileReference()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getLogo()
		);
	}

	/**
	 * @test
	 */
	public function setLogoForFileReferenceSetsLogo()
	{
		$fileReferenceFixture = new FileReference();
		$this->subject->setLogo($fileReferenceFixture);

		$this->assertAttributeEquals(
			$fileReferenceFixture,
			'logo',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getOrtReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getOrt()
		);
	}

	/**
	 * @test
	 */
	public function setOrtForStringSetsOrt()
	{
		$this->subject->setOrt('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'ort',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getBetreuungReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getBetreuung()
		);
	}

	/**
	 * @test
	 */
	public function setBetreuungForStringSetsBetreuung()
	{
		$this->subject->setBetreuung('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'betreuung',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getUnternehmenGroesseReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setUnternehmenGroesseForIntSetsUnternehmenGroesse()
	{	}

	/**
	 * @test
	 */
	public function getLinkWebseiteReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getLinkWebseite()
		);
	}

	/**
	 * @test
	 */
	public function setLinkWebseiteForStringSetsLinkWebseite()
	{
		$this->subject->setLinkWebseite('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'linkWebseite',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getLinkFacebookReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getLinkFacebook()
		);
	}

	/**
	 * @test
	 */
	public function setLinkFacebookForStringSetsLinkFacebook()
	{
		$this->subject->setLinkFacebook('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'linkFacebook',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPrimaerFarbeReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getPrimaerFarbe()
		);
	}

	/**
	 * @test
	 */
	public function setPrimaerFarbeForStringSetsPrimaerFarbe()
	{
		$this->subject->setPrimaerFarbe('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'primaerFarbe',
			$this->subject
		);
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
	public function getBrancheReturnsInitialValueForBranchen()
	{
		$newObjectStorage = new ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getBranche()
		);
	}

	/**
	 * @test
	 */
	public function setBrancheForObjectStorageContainingBranchenSetsBranche()
	{
		$branche = new Branchen();
		$objectStorageHoldingExactlyOneBranche = new ObjectStorage();
		$objectStorageHoldingExactlyOneBranche->attach($branche);
		$this->subject->setBranche($objectStorageHoldingExactlyOneBranche);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneBranche,
			'branche',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addBrancheToObjectStorageHoldingBranche()
	{
		$branche = new Branchen();
		$brancheObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$brancheObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($branche));
		$this->inject($this->subject, 'branche', $brancheObjectStorageMock);

		$this->subject->addBranche($branche);
	}

	/**
	 * @test
	 */
	public function removeBrancheFromObjectStorageHoldingBranche()
	{
		$branche = new Branchen();
		$brancheObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$brancheObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($branche));
		$this->inject($this->subject, 'branche', $brancheObjectStorageMock);

		$this->subject->removeBranche($branche);

	}
}
