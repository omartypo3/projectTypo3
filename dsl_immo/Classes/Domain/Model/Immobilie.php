<?php
namespace DslFactory\DslImmo\Domain\Model;

/***
 *
 * This file is part of the "immo" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017
 *
 ***/
use TYPO3\CMS\Extbase\Annotation as Extbase;

/**
 * Immobilies
 */
class Immobilie extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var int
     */
    protected $crdate = null;

    /**
     * @var int
     */
    protected $tstamp = null;

    /**
     * starttime
     * 
     * @var \DateTime
     */
    protected $starttime = null;

    /**
     * endtime
     * 
     * @var \DateTime
     */
    protected $endtime = null;

    /**
     * objekttitel
     * 
     * @var string
     */
    protected $objekttitel = '';

    /**
     * dreizeiler
     * 
     * @var string
     */
    protected $dreizeiler = '';

    /**
     * lage
     * 
     * @var string
     */
    protected $lage = '';

    /**
     * ausstattbeschr
     * 
     * @var string
     */
    protected $ausstattbeschr = '';

    /**
     * objektbeschreibung
     * 
     * @var string
     */
    protected $objektbeschreibung = '';

    /**
     * sonstigeangaben
     * 
     * @var string
     */
    protected $sonstigeangaben = '';

    /**
     * objektNrintern
     * 
     * @var string
     */
    protected $objektNrintern = '';

    /**
     * objektNrextern
     * 
     * @var string
     */
    protected $objektNrextern = '';

    /**
     * openimmoobid
     * 
     * @var string
     */
    protected $openimmoobid = '';

    /**
     * standVom
     * 
     * @var \DateTime
     */
    protected $standVom = null;

    /**
     * nutzungsArt
     * 
     * @var int
     */
    protected $nutzungsArt = 0;

    /**
     * vermarktungsArt
     * 
     * @var int
     */
    protected $vermarktungsArt = 0;

    /**
     * objektArtWohnungTyp
     * 
     * @var int
     */
    protected $objektArtWohnungTyp = 0;

    /**
     * geoPlz
     * 
     * @var string
     */
    protected $geoPlz = '';

    /**
     * geoOrt
     * 
     * @var string
     */
    protected $geoOrt = '';

    /**
     * geoStrasse
     * 
     * @var string
     */
    protected $geoStrasse = '';

    /**
     * geoHausnummer
     * 
     * @var string
     */
    protected $geoHausnummer = '';

    /**
     * geoEtage
     * 
     * @var string
     */
    protected $geoEtage = '';

    /**
     * geoAnzahlEtagen
     * 
     * @var string
     */
    protected $geoAnzahlEtagen = '';

    /**
     * geoLageImBau
     * 
     * @var string
     */
    protected $geoLageImBau = '';

    /**
     * geoLageGebiet
     * 
     * @var string
     */
    protected $geoLageGebiet = '';

    /**
     * geoLand
     * 
     * @var string
     */
    protected $geoLand = '';

    /**
     * geoKoordinatenBreitengrad
     * 
     * @var float
     */
    protected $geoKoordinatenBreitengrad = 0.0;

    /**
     * geoKoordinatenLaengengrad
     * 
     * @var float
     */
    protected $geoKoordinatenLaengengrad = 0.0;

    /**
     * geoRegionalerZusatz
     * 
     * @var string
     */
    protected $geoRegionalerZusatz = '';

    /**
     * preiseKaltmiete
     * 
     * @var float
     */
    protected $preiseKaltmiete = 0.0;

    /**
     * preiseWarmmiete
     * 
     * @var float
     */
    protected $preiseWarmmiete = 0.0;

    /**
     * preiseNebenkosten
     * 
     * @var float
     */
    protected $preiseNebenkosten = 0.0;

    /**
     * preiseKaution
     * 
     * @var float
     */
    protected $preiseKaution = 0.0;

    /**
     * flaechenWohnflaeche
     * 
     * @var float
     */
    protected $flaechenWohnflaeche = 0.0;

    /**
     * flaechenAnzahlZimmer
     * 
     * @var float
     */
    protected $flaechenAnzahlZimmer = 0.0;

    /**
     * flaechenAnzahlBalkone
     * 
     * @var float
     */
    protected $flaechenAnzahlBalkone = 0.0;

    /**
     * flaechenAnzahlTerassen
     * 
     * @var float
     */
    protected $flaechenAnzahlTerassen = 0.0;

    /**
     * flaechenAnzahlLogia
     * 
     * @var float
     */
    protected $flaechenAnzahlLogia = 0.0;

    /**
     * zustandBaujahr
     * 
     * @var string
     */
    protected $zustandBaujahr = '';

    /**
     * zustandArt
     * 
     * @var int
     */
    protected $zustandArt = 0;

    /**
     * energiepassEpart
     * 
     * @var string
     */
    protected $energiepassEpart = '';

    /**
     * energiepassEnergieverbrauchkennwert
     * 
     * @var string
     */
    protected $energiepassEnergieverbrauchkennwert = '';

    /**
     * energiepassEndenergiebedarf
     * 
     * @var string
     */
    protected $energiepassEndenergiebedarf = '';

    /**
     * energiepassGebaeudeart
     * 
     * @var string
     */
    protected $energiepassGebaeudeart = '';

    /**
     * objektadresseFreigeben
     * 
     * @var bool
     */
    protected $objektadresseFreigeben = false;

    /**
     * verfuegbarAb
     * 
     * @var string
     */
    protected $verfuegbarAb = '';

    /**
     * vermietet
     * 
     * @var bool
     */
    protected $vermietet = false;

    /**
     * denkmalgeschuetzt
     * 
     * @var bool
     */
    protected $denkmalgeschuetzt = false;

    /**
     * ausstattungWggeeignet
     * 
     * @var bool
     */
    protected $ausstattungWggeeignet = false;

    /**
     * ausstattungRaeumeveraenderbar
     * 
     * @var bool
     */
    protected $ausstattungRaeumeveraenderbar = false;

    /**
     * ausstattungKamin
     * 
     * @var bool
     */
    protected $ausstattungKamin = false;

    /**
     * ausstattungKlimatisiert
     * 
     * @var bool
     */
    protected $ausstattungKlimatisiert = false;

    /**
     * ausstattungGartennutzung
     * 
     * @var bool
     */
    protected $ausstattungGartennutzung = false;

    /**
     * ausstattungRollstuhlgerecht
     * 
     * @var bool
     */
    protected $ausstattungRollstuhlgerecht = false;

    /**
     * ausstattungKabelsattv
     * 
     * @var bool
     */
    protected $ausstattungKabelsattv = false;

    /**
     * ausstattungDvbt
     * 
     * @var bool
     */
    protected $ausstattungDvbt = false;

    /**
     * ausstattungBarrierefrei
     * 
     * @var bool
     */
    protected $ausstattungBarrierefrei = false;

    /**
     * ausstattungSauna
     * 
     * @var bool
     */
    protected $ausstattungSauna = false;

    /**
     * ausstattungSwimmingpool
     * 
     * @var bool
     */
    protected $ausstattungSwimmingpool = false;

    /**
     * ausstattungWaschTrockenraum
     * 
     * @var bool
     */
    protected $ausstattungWaschTrockenraum = false;

    /**
     * ausstattungWintergarten
     * 
     * @var bool
     */
    protected $ausstattungWintergarten = false;

    /**
     * ausstattungDvverkabelung
     * 
     * @var bool
     */
    protected $ausstattungDvverkabelung = false;

    /**
     * ausstattungRampe
     * 
     * @var bool
     */
    protected $ausstattungRampe = false;

    /**
     * ausstattungHebebuehne
     * 
     * @var bool
     */
    protected $ausstattungHebebuehne = false;

    /**
     * ausstattungKran
     * 
     * @var bool
     */
    protected $ausstattungKran = false;

    /**
     * ausstattungGastterrasse
     * 
     * @var bool
     */
    protected $ausstattungGastterrasse = false;

    /**
     * ausstattungKantinecafeteria
     * 
     * @var bool
     */
    protected $ausstattungKantinecafeteria = false;

    /**
     * ausstattungTeekueche
     * 
     * @var bool
     */
    protected $ausstattungTeekueche = false;

    /**
     * ausstattungBrauereibindung
     * 
     * @var bool
     */
    protected $ausstattungBrauereibindung = false;

    /**
     * ausstattungSporteinrichtungen
     * 
     * @var bool
     */
    protected $ausstattungSporteinrichtungen = false;

    /**
     * ausstattungWellnessbereich
     * 
     * @var bool
     */
    protected $ausstattungWellnessbereich = false;

    /**
     * ausstattungTelefonferienimmobilie
     * 
     * @var bool
     */
    protected $ausstattungTelefonferienimmobilie = false;

    /**
     * ausstattungUmtsempfang
     * 
     * @var bool
     */
    protected $ausstattungUmtsempfang = false;

    /**
     * ausstattungAbstellraum
     * 
     * @var bool
     */
    protected $ausstattungAbstellraum = false;

    /**
     * ausstattungBibliothek
     * 
     * @var bool
     */
    protected $ausstattungBibliothek = false;

    /**
     * ausstattungDachboden
     * 
     * @var bool
     */
    protected $ausstattungDachboden = false;

    /**
     * ausstattungGaestewc
     * 
     * @var bool
     */
    protected $ausstattungGaestewc = false;

    /**
     * ausstattungKabelkanaele
     * 
     * @var bool
     */
    protected $ausstattungKabelkanaele = false;

    /**
     * ausstattungSeniorengerecht
     * 
     * @var bool
     */
    protected $ausstattungSeniorengerecht = false;

    /**
     * ausstattungFahrradraum
     * 
     * @var bool
     */
    protected $ausstattungFahrradraum = false;

    /**
     * ausstattungRolladen
     * 
     * @var bool
     */
    protected $ausstattungRolladen = false;

    /**
     * ausstattungBad
     * 
     * @var string
     */
    protected $ausstattungBad = 0;

    /**
     * ausstattungKueche
     * 
     * @var string
     */
    protected $ausstattungKueche = 0;

    /**
     * ausstattungBoden
     * 
     * @var string
     */
    protected $ausstattungBoden = 0;

    /**
     * ausstattungHeizungsart
     * 
     * @var string
     */
    protected $ausstattungHeizungsart = '';

    /**
     * ausstattungBefeuerung
     * 
     * @var string
     */
    protected $ausstattungBefeuerung = '';

    /**
     * ausstattungFahrstuhl
     * 
     * @var string
     */
    protected $ausstattungFahrstuhl = '';

    /**
     * ausstattungStellplatzart
     * 
     * @var string
     */
    protected $ausstattungStellplatzart = '';

    /**
     * ausstattungAusrichtBalkonTerasse
     * 
     * @var string
     */
    protected $ausstattungAusrichtBalkonTerasse = '';

    /**
     * ausstattungAngeschlGastronomie
     * 
     * @var string
     */
    protected $ausstattungAngeschlGastronomie = '';

    /**
     * ausstattungServiceleistungen
     * 
     * @var string
     */
    protected $ausstattungServiceleistungen = '';

    /**
     * ausstattungSicherheitstechnik
     * 
     * @var string
     */
    protected $ausstattungSicherheitstechnik = '';

    /**
     * ausstattungMoebliert
     * 
     * @var int
     */
    protected $ausstattungMoebliert = 0;

    /**
     * ausstattungKategorie
     * 
     * @var int
     */
    protected $ausstattungKategorie = 0;

    /**
     * ausstattungDachform
     * 
     * @var string
     */
    protected $ausstattungDachform = '';

    /**
     * ausstattungBauweise
     * 
     * @var string
     */
    protected $ausstattungBauweise = '';

    /**
     * ausstattungAusbaustufe
     * 
     * @var string
     */
    protected $ausstattungAusbaustufe = '';

    /**
     * ausstattungEnergietyp
     * 
     * @var string
     */
    protected $ausstattungEnergietyp = '';

    /**
     * ausstattungUnterkellert
     * 
     * @var int
     */
    protected $ausstattungUnterkellert = 0;

    /**
     * ausstattungHallenhoehe
     * 
     * @var string
     */
    protected $ausstattungHallenhoehe = '';

    /**
     * ausstattungStromanschlusswert
     * 
     * @var string
     */
    protected $ausstattungStromanschlusswert = '';

    /**
     * energiepassGueltigBis
     * 
     * @var string
     */
    protected $energiepassGueltigBis = '';

    /**
     * energiepassMitwarmwasser
     * 
     * @var string
     */
    protected $energiepassMitwarmwasser = '';

    /**
     * energiepassPrimaerenergietraeger
     * 
     * @var string
     */
    protected $energiepassPrimaerenergietraeger = '';

    /**
     * energiepassStromwert
     * 
     * @var string
     */
    protected $energiepassStromwert = '';

    /**
     * energiepassWaermewert
     * 
     * @var string
     */
    protected $energiepassWaermewert = '';

    /**
     * energiepassWertklasse
     * 
     * @var string
     */
    protected $energiepassWertklasse = '';

    /**
     * energiepassAusstelldatum
     * 
     * @var string
     */
    protected $energiepassAusstelldatum = '';

    /**
     * energiepassJahrgang
     * 
     * @var string
     */
    protected $energiepassJahrgang = '';

    /**
     * highlight
     * 
     * @var int
     */
    protected $highlight = 0;

    /**
     * objektArtZimmerTyp
     * 
     * @var int
     */
    protected $objektArtZimmerTyp = 0;

    /**
     * objektArtHausTyp
     * 
     * @var int
     */
    protected $objektArtHausTyp = 0;

    /**
     * objektArtGrundstueckTyp
     * 
     * @var int
     */
    protected $objektArtGrundstueckTyp = 0;

    /**
     * objektArtBueroPraxenTyp
     * 
     * @var int
     */
    protected $objektArtBueroPraxenTyp = 0;

    /**
     * objektArtEinzelhandelTyp
     * 
     * @var int
     */
    protected $objektArtEinzelhandelTyp = 0;

    /**
     * objektArtGastgewerbeTyp
     * 
     * @var int
     */
    protected $objektArtGastgewerbeTyp = 0;

    /**
     * objektArtHallenLagerProduktionTyp
     * 
     * @var int
     */
    protected $objektArtHallenLagerProduktionTyp = 0;

    /**
     * objektArtLandForstwirtschaftTyp
     * 
     * @var int
     */
    protected $objektArtLandForstwirtschaftTyp = 0;

    /**
     * objektArtParkenTyp
     * 
     * @var int
     */
    protected $objektArtParkenTyp = 0;

    /**
     * objektArtSonstigeTyp
     * 
     * @var int
     */
    protected $objektArtSonstigeTyp = 0;

    /**
     * objektArtFreizeitimmobilieGewerblichTyp
     * 
     * @var int
     */
    protected $objektArtFreizeitimmobilieGewerblichTyp = 0;

    /**
     * objektArtZinshausRenditeobjektTyp
     * 
     * @var int
     */
    protected $objektArtZinshausRenditeobjektTyp = 0;

    /**
     * flaechenSonstflaeche
     * 
     * @var float
     */
    protected $flaechenSonstflaeche = 0.0;

    /**
     * flaechenVermietbareFlaeche
     * 
     * @var float
     */
    protected $flaechenVermietbareFlaeche = 0.0;

    /**
     * flaechenAnzahlGewerbeeinheiten
     * 
     * @var int
     */
    protected $flaechenAnzahlGewerbeeinheiten = 0;

    /**
     * flaechenNutzflaeche
     * 
     * @var float
     */
    protected $flaechenNutzflaeche = 0.0;

    /**
     * flaechenGesamtflaeche
     * 
     * @var float
     */
    protected $flaechenGesamtflaeche = 0.0;

    /**
     * flaechenBueroflaeche
     * 
     * @var float
     */
    protected $flaechenBueroflaeche = 0.0;

    /**
     * flaechenGrundstuecksflaeche
     * 
     * @var float
     */
    protected $flaechenGrundstuecksflaeche = 0.0;

    /**
     * flaechenAnzahlBadezimmer
     * 
     * @var int
     */
    protected $flaechenAnzahlBadezimmer = 0;

    /**
     * flaechenAnzahlSchlafzimmer
     * 
     * @var int
     */
    protected $flaechenAnzahlSchlafzimmer = 0;

    /**
     * preiseKaufpreis
     * 
     * @var float
     */
    protected $preiseKaufpreis = 0.0;

    /**
     * preiseProvisionspflichtig
     * 
     * @var bool
     */
    protected $preiseProvisionspflichtig = false;

    /**
     * preiseAussenCourtage
     * 
     * @var string
     */
    protected $preiseAussenCourtage = 0.0;

    /**
     * preiseAussenCourtageMitMwst
     * 
     * @var bool
     */
    protected $preiseAussenCourtageMitMwst = false;

    /**
     * preiseWaehrungIsoWaehrung
     * 
     * @var string
     */
    protected $preiseWaehrungIsoWaehrung = '';

    /**
     * preiseMwstSatz
     * 
     * @var float
     */
    protected $preiseMwstSatz = 0.0;

    /**
     * preiseMieteinnahmenIst
     * 
     * @var float
     */
    protected $preiseMieteinnahmenIst = 0.0;

    /**
     * preiseStpFreiplatzAnzahl
     * 
     * @var int
     */
    protected $preiseStpFreiplatzAnzahl = 0;

    /**
     * preiseStpSonstigeAnzahl
     * 
     * @var int
     */
    protected $preiseStpSonstigeAnzahl = 0;

    /**
     * preiseStpSonstigePlatzart
     * 
     * @var string
     */
    protected $preiseStpSonstigePlatzart = '';

    /**
     * searchVermarktung
     * 
     * @var string
     */
    protected $searchVermarktung = '';

    /**
     * searchObjektTyp
     * 
     * @var string
     */
    protected $searchObjektTyp = '';

    /**
     * searchZimmer
     * 
     * @var float
     */
    protected $searchZimmer = 0.0;

    /**
     * searchFlaeche
     * 
     * @var float
     */
    protected $searchFlaeche = 0.0;

    /**
     * searchPreis
     * 
     * @var float
     */
    protected $searchPreis = 0.0;

    /**
     * searchWohngebiet
     * 
     * @var string
     */
    protected $searchWohngebiet = '';

    /**
     * geoAdresseGesperrtKoordinatenBreitengrad
     * 
     * @var float
     */
    protected $geoAdresseGesperrtKoordinatenBreitengrad = 0.0;

    /**
     * geoAdresseGesperrtKoordinatenLaengengrad
     * 
     * @var float
     */
    protected $geoAdresseGesperrtKoordinatenLaengengrad = 0.0;

    /**
     * haustiere
     * 
     * @var bool
     */
    protected $haustiere = false;

    /**
     * additionalHtmlField
     * 
     * @var string
     */
    protected $additionalHtmlField = '';

    /**
     * modernerGrundriss
     * 
     * @var bool
     */
    protected $modernerGrundriss = false;

    /**
     * energieAusweisLinkExtern
     * 
     * @var string
     */
    protected $energieAusweisLinkExtern = '';

    /**
     * anhaenge
     * 
     * @Extbase\ORM\Lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslImmo\Domain\Model\Anhang>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
     */
    protected $anhaenge = null;

    /**
     * importe
     * 
     * @Extbase\ORM\Lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslImmo\Domain\Model\Import>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
     */
    protected $importe = null;

    /**
     * kontaktperson
     * 
     * @var \DslFactory\DslImmo\Domain\Model\Kontaktperson
     */
    protected $kontaktperson = null;

    /**
     * titelBild
     * 
     * @var \DslFactory\DslImmo\Domain\Model\Anhang
     */
    protected $titelBild = null;

    /**
     * Returns the starttime
     * 
     * @return DateTime $starttime
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * Sets the starttime
     * 
     * @param \DateTime $starttime
     * @return void
     */
    public function setStarttime(\DateTime $starttime = NULL)
    {
        $this->starttime = $starttime;
    }

    /**
     * Returns the endtime
     * 
     * @return DateTime $endtime
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * Sets the endtime
     * 
     * @param \DateTime $endtime
     * @return void
     */
    public function setEndtime(\DateTime $endtime = NULL)
    {
        $this->endtime = $endtime;
    }

    /**
     * Returns the objekttitel
     * 
     * @return string $objekttitel
     */
    public function getObjekttitel()
    {
        if (!$this->objekttitel) {
            if ($this->getObjektadressefreigeben()) {
                if ($this->getStrasseHausnummer()) {
                    return $this->getStrasseHausnummer();
                }
            }
        }
        return $this->objekttitel;
    }

    /**
     * Sets the objekttitel
     * 
     * @param string $objekttitel
     * @return void
     */
    public function setObjekttitel($objekttitel)
    {
        $this->objekttitel = $objekttitel;
    }

    /**
     * Returns the dreizeiler
     * 
     * @return string $dreizeiler
     */
    public function getDreizeiler()
    {
        return $this->dreizeiler;
    }

    /**
     * Sets the dreizeiler
     * 
     * @param string $dreizeiler
     * @return void
     */
    public function setDreizeiler($dreizeiler)
    {
        $this->dreizeiler = $dreizeiler;
    }

    /**
     * Returns the lage
     * 
     * @return string $lage
     */
    public function getLage()
    {
        return $this->lage;
    }

    /**
     * Sets the lage
     * 
     * @param string $lage
     * @return void
     */
    public function setLage($lage)
    {
        $this->lage = $lage;
    }

    /**
     * Returns the ausstattbeschr
     * 
     * @return string $ausstattbeschr
     */
    public function getAusstattbeschr()
    {
        return $this->ausstattbeschr;
    }

    /**
     * Sets the ausstattbeschr
     * 
     * @param string $ausstattbeschr
     * @return void
     */
    public function setAusstattbeschr($ausstattbeschr)
    {
        $this->ausstattbeschr = $ausstattbeschr;
    }

    /**
     * Returns the ausstattbeschrArray
     * 
     * @return mixed $ausstattbeschrArray
     */
    public function getAusstattbeschrArray()
    {
        $array = explode('\\r\\n', $this->ausstattbeschr);
        if (is_array($array)) {
            if (!$array[0]) {
                return array();
            }
        }
        //var_dump(explode('\r\n',$this->ausstattbeschr));die;
        return $array;
    }

    /**
     * Returns the objektbeschreibung
     * 
     * @return string $objektbeschreibung
     */
    public function getObjektbeschreibung()
    {
        return $this->objektbeschreibung;
    }

    /**
     * Sets the objektbeschreibung
     * 
     * @param string $objektbeschreibung
     * @return void
     */
    public function setObjektbeschreibung($objektbeschreibung)
    {
        $this->objektbeschreibung = $objektbeschreibung;
    }

    /**
     * Returns the sonstigeangaben
     * 
     * @return string $sonstigeangaben
     */
    public function getSonstigeangaben()
    {
        return $this->sonstigeangaben;
    }

    /**
     * Sets the sonstigeangaben
     * 
     * @param string $sonstigeangaben
     * @return void
     */
    public function setSonstigeangaben($sonstigeangaben)
    {
        $this->sonstigeangaben = $sonstigeangaben;
    }

    /**
     * Returns the openimmoobid
     * 
     * @return string $openimmoobid
     */
    public function getOpenimmoobid()
    {
        return $this->openimmoobid;
    }

    /**
     * Sets the openimmoobid
     * 
     * @param string $openimmoobid
     * @return void
     */
    public function setOpenimmoobid($openimmoobid)
    {
        $this->openimmoobid = $openimmoobid;
    }

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     * 
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->anhaenge = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->importe = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a Anhang
     * 
     * @param \DslFactory\DslImmo\Domain\Model\Anhang $anhaenge
     * @return void
     */
    public function addAnhaenge(\DslFactory\DslImmo\Domain\Model\Anhang $anhaenge)
    {
        $this->anhaenge->attach($anhaenge);
    }

    /**
     * Removes a Anhang
     * 
     * @param \DslFactory\DslImmo\Domain\Model\Anhang $anhaengeToRemove The Anhang to be removed
     * @return void
     */
    public function removeAnhaenge(\DslFactory\DslImmo\Domain\Model\Anhang $anhaengeToRemove)
    {
        $this->anhaenge->detach($anhaengeToRemove);
    }

    /**
     * Returns the anhaenge
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslImmo\Domain\Model\Anhang> $anhaenge
     */
    public function getAnhaenge()
    {
        return $this->anhaenge;
    }

    /**
     * Sets the anhaenge
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslImmo\Domain\Model\Anhang> $anhaenge
     * @return void
     */
    public function setAnhaenge(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $anhaenge)
    {
        $this->anhaenge = $anhaenge;
    }

    /**
     * Returns the crdate
     * 
     * @return int
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * Returns the tstamp
     * 
     * @return int
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * Adds a Import
     * 
     * @param \DslFactory\DslImmo\Domain\Model\Import $importe
     * @return void
     */
    public function addImporte(\DslFactory\DslImmo\Domain\Model\Import $importe)
    {
        $this->importe->attach($importe);
    }

    /**
     * Removes a Import
     * 
     * @param \DslFactory\DslImmo\Domain\Model\Import $importeToRemove The Import to be removed
     * @return void
     */
    public function removeImporte(\DslFactory\DslImmo\Domain\Model\Import $importeToRemove)
    {
        $this->importe->detach($importeToRemove);
    }

    /**
     * Returns the importe
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslImmo\Domain\Model\Import> $importe
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Sets the importe
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslImmo\Domain\Model\Import> $importe
     * @return void
     */
    public function setImporte(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $importe)
    {
        $this->importe = $importe;
    }

    /**
     * Returns the kontaktperson
     * 
     * @return \DslFactory\DslImmo\Domain\Model\Kontaktperson $kontaktperson
     */
    public function getKontaktperson()
    {
        return $this->kontaktperson;
    }

    /**
     * Sets the kontaktperson
     * 
     * @param \DslFactory\DslImmo\Domain\Model\Kontaktperson $kontaktperson
     * @return void
     */
    public function setKontaktperson(\DslFactory\DslImmo\Domain\Model\Kontaktperson $kontaktperson)
    {
        $this->kontaktperson = $kontaktperson;
    }

    /**
     * Returns the boolean state of objektadressefreigeben
     * 
     * @return bool
     */
    public function isObjektadressefreigeben()
    {
        return $this->objektadressefreigeben;
    }

    /**
     * Returns the vermietet
     * 
     * @return bool $vermietet
     */
    public function getVermietet()
    {
        return $this->vermietet;
    }

    /**
     * Sets the vermietet
     * 
     * @param bool $vermietet
     * @return void
     */
    public function setVermietet($vermietet)
    {
        $this->vermietet = $vermietet;
    }

    /**
     * Returns the boolean state of vermietet
     * 
     * @return bool
     */
    public function isVermietet()
    {
        return $this->vermietet;
    }

    /**
     * Returns the denkmalgeschuetzt
     * 
     * @return bool $denkmalgeschuetzt
     */
    public function getDenkmalgeschuetzt()
    {
        return $this->denkmalgeschuetzt;
    }

    /**
     * Sets the denkmalgeschuetzt
     * 
     * @param bool $denkmalgeschuetzt
     * @return void
     */
    public function setDenkmalgeschuetzt($denkmalgeschuetzt)
    {
        $this->denkmalgeschuetzt = $denkmalgeschuetzt;
    }

    /**
     * Returns the boolean state of denkmalgeschuetzt
     * 
     * @return bool
     */
    public function isDenkmalgeschuetzt()
    {
        return $this->denkmalgeschuetzt;
    }

    /**
     * Returns the ausstattungWggeeignet
     * 
     * @return bool $ausstattungWggeeignet
     */
    public function getAusstattungWggeeignet()
    {
        return $this->ausstattungWggeeignet;
    }

    /**
     * Sets the ausstattungWggeeignet
     * 
     * @param bool $ausstattungWggeeignet
     * @return void
     */
    public function setAusstattungWggeeignet($ausstattungWggeeignet)
    {
        $this->ausstattungWggeeignet = $ausstattungWggeeignet;
    }

    /**
     * Returns the boolean state of ausstattungWggeeignet
     * 
     * @return bool
     */
    public function isAusstattungWggeeignet()
    {
        return $this->ausstattungWggeeignet;
    }

    /**
     * Returns the ausstattungRaeumeveraenderbar
     * 
     * @return bool $ausstattungRaeumeveraenderbar
     */
    public function getAusstattungRaeumeveraenderbar()
    {
        return $this->ausstattungRaeumeveraenderbar;
    }

    /**
     * Sets the ausstattungRaeumeveraenderbar
     * 
     * @param bool $ausstattungRaeumeveraenderbar
     * @return void
     */
    public function setAusstattungRaeumeveraenderbar($ausstattungRaeumeveraenderbar)
    {
        $this->ausstattungRaeumeveraenderbar = $ausstattungRaeumeveraenderbar;
    }

    /**
     * Returns the boolean state of ausstattungRaeumeveraenderbar
     * 
     * @return bool
     */
    public function isAusstattungRaeumeveraenderbar()
    {
        return $this->ausstattungRaeumeveraenderbar;
    }

    /**
     * Returns the ausstattungKamin
     * 
     * @return bool $ausstattungKamin
     */
    public function getAusstattungKamin()
    {
        return $this->ausstattungKamin;
    }

    /**
     * Sets the ausstattungKamin
     * 
     * @param bool $ausstattungKamin
     * @return void
     */
    public function setAusstattungKamin($ausstattungKamin)
    {
        $this->ausstattungKamin = $ausstattungKamin;
    }

    /**
     * Returns the boolean state of ausstattungKamin
     * 
     * @return bool
     */
    public function isAusstattungKamin()
    {
        return $this->ausstattungKamin;
    }

    /**
     * Returns the ausstattungKlimatisiert
     * 
     * @return bool $ausstattungKlimatisiert
     */
    public function getAusstattungKlimatisiert()
    {
        return $this->ausstattungKlimatisiert;
    }

    /**
     * Sets the ausstattungKlimatisiert
     * 
     * @param bool $ausstattungKlimatisiert
     * @return void
     */
    public function setAusstattungKlimatisiert($ausstattungKlimatisiert)
    {
        $this->ausstattungKlimatisiert = $ausstattungKlimatisiert;
    }

    /**
     * Returns the boolean state of ausstattungKlimatisiert
     * 
     * @return bool
     */
    public function isAusstattungKlimatisiert()
    {
        return $this->ausstattungKlimatisiert;
    }

    /**
     * Returns the ausstattungGartennutzung
     * 
     * @return bool $ausstattungGartennutzung
     */
    public function getAusstattungGartennutzung()
    {
        return $this->ausstattungGartennutzung;
    }

    /**
     * Sets the ausstattungGartennutzung
     * 
     * @param bool $ausstattungGartennutzung
     * @return void
     */
    public function setAusstattungGartennutzung($ausstattungGartennutzung)
    {
        $this->ausstattungGartennutzung = $ausstattungGartennutzung;
    }

    /**
     * Returns the boolean state of ausstattungGartennutzung
     * 
     * @return bool
     */
    public function isAusstattungGartennutzung()
    {
        return $this->ausstattungGartennutzung;
    }

    /**
     * Returns the ausstattungRollstuhlgerecht
     * 
     * @return bool $ausstattungRollstuhlgerecht
     */
    public function getAusstattungRollstuhlgerecht()
    {
        return $this->ausstattungRollstuhlgerecht;
    }

    /**
     * Sets the ausstattungRollstuhlgerecht
     * 
     * @param bool $ausstattungRollstuhlgerecht
     * @return void
     */
    public function setAusstattungRollstuhlgerecht($ausstattungRollstuhlgerecht)
    {
        $this->ausstattungRollstuhlgerecht = $ausstattungRollstuhlgerecht;
    }

    /**
     * Returns the boolean state of ausstattungRollstuhlgerecht
     * 
     * @return bool
     */
    public function isAusstattungRollstuhlgerecht()
    {
        return $this->ausstattungRollstuhlgerecht;
    }

    /**
     * Returns the ausstattungKabelsattv
     * 
     * @return bool $ausstattungKabelsattv
     */
    public function getAusstattungKabelsattv()
    {
        return $this->ausstattungKabelsattv;
    }

    /**
     * Sets the ausstattungKabelsattv
     * 
     * @param bool $ausstattungKabelsattv
     * @return void
     */
    public function setAusstattungKabelsattv($ausstattungKabelsattv)
    {
        $this->ausstattungKabelsattv = $ausstattungKabelsattv;
    }

    /**
     * Returns the boolean state of ausstattungKabelsattv
     * 
     * @return bool
     */
    public function isAusstattungKabelsattv()
    {
        return $this->ausstattungKabelsattv;
    }

    /**
     * Returns the ausstattungDvbt
     * 
     * @return bool $ausstattungDvbt
     */
    public function getAusstattungDvbt()
    {
        return $this->ausstattungDvbt;
    }

    /**
     * Sets the ausstattungDvbt
     * 
     * @param bool $ausstattungDvbt
     * @return void
     */
    public function setAusstattungDvbt($ausstattungDvbt)
    {
        $this->ausstattungDvbt = $ausstattungDvbt;
    }

    /**
     * Returns the boolean state of ausstattungDvbt
     * 
     * @return bool
     */
    public function isAusstattungDvbt()
    {
        return $this->ausstattungDvbt;
    }

    /**
     * Returns the ausstattungBarrierefrei
     * 
     * @return bool $ausstattungBarrierefrei
     */
    public function getAusstattungBarrierefrei()
    {
        return $this->ausstattungBarrierefrei;
    }

    /**
     * Sets the ausstattungBarrierefrei
     * 
     * @param bool $ausstattungBarrierefrei
     * @return void
     */
    public function setAusstattungBarrierefrei($ausstattungBarrierefrei)
    {
        $this->ausstattungBarrierefrei = $ausstattungBarrierefrei;
    }

    /**
     * Returns the boolean state of ausstattungBarrierefrei
     * 
     * @return bool
     */
    public function isAusstattungBarrierefrei()
    {
        return $this->ausstattungBarrierefrei;
    }

    /**
     * Returns the ausstattungSauna
     * 
     * @return bool $ausstattungSauna
     */
    public function getAusstattungSauna()
    {
        return $this->ausstattungSauna;
    }

    /**
     * Sets the ausstattungSauna
     * 
     * @param bool $ausstattungSauna
     * @return void
     */
    public function setAusstattungSauna($ausstattungSauna)
    {
        $this->ausstattungSauna = $ausstattungSauna;
    }

    /**
     * Returns the boolean state of ausstattungSauna
     * 
     * @return bool
     */
    public function isAusstattungSauna()
    {
        return $this->ausstattungSauna;
    }

    /**
     * Returns the ausstattungSwimmingpool
     * 
     * @return bool $ausstattungSwimmingpool
     */
    public function getAusstattungSwimmingpool()
    {
        return $this->ausstattungSwimmingpool;
    }

    /**
     * Sets the ausstattungSwimmingpool
     * 
     * @param bool $ausstattungSwimmingpool
     * @return void
     */
    public function setAusstattungSwimmingpool($ausstattungSwimmingpool)
    {
        $this->ausstattungSwimmingpool = $ausstattungSwimmingpool;
    }

    /**
     * Returns the boolean state of ausstattungSwimmingpool
     * 
     * @return bool
     */
    public function isAusstattungSwimmingpool()
    {
        return $this->ausstattungSwimmingpool;
    }

    /**
     * Returns the boolean state of ausstattungWaschTrockenraum
     * 
     * @return bool
     */
    public function isAusstattungWaschTrockenraum()
    {
        return $this->ausstattungWaschTrockenraum;
    }

    /**
     * Returns the ausstattungWintergarten
     * 
     * @return bool $ausstattungWintergarten
     */
    public function getAusstattungWintergarten()
    {
        return $this->ausstattungWintergarten;
    }

    /**
     * Sets the ausstattungWintergarten
     * 
     * @param bool $ausstattungWintergarten
     * @return void
     */
    public function setAusstattungWintergarten($ausstattungWintergarten)
    {
        $this->ausstattungWintergarten = $ausstattungWintergarten;
    }

    /**
     * Returns the boolean state of ausstattungWintergarten
     * 
     * @return bool
     */
    public function isAusstattungWintergarten()
    {
        return $this->ausstattungWintergarten;
    }

    /**
     * Returns the ausstattungDvverkabelung
     * 
     * @return bool $ausstattungDvverkabelung
     */
    public function getAusstattungDvverkabelung()
    {
        return $this->ausstattungDvverkabelung;
    }

    /**
     * Sets the ausstattungDvverkabelung
     * 
     * @param bool $ausstattungDvverkabelung
     * @return void
     */
    public function setAusstattungDvverkabelung($ausstattungDvverkabelung)
    {
        $this->ausstattungDvverkabelung = $ausstattungDvverkabelung;
    }

    /**
     * Returns the boolean state of ausstattungDvverkabelung
     * 
     * @return bool
     */
    public function isAusstattungDvverkabelung()
    {
        return $this->ausstattungDvverkabelung;
    }

    /**
     * Returns the ausstattungRampe
     * 
     * @return bool $ausstattungRampe
     */
    public function getAusstattungRampe()
    {
        return $this->ausstattungRampe;
    }

    /**
     * Sets the ausstattungRampe
     * 
     * @param bool $ausstattungRampe
     * @return void
     */
    public function setAusstattungRampe($ausstattungRampe)
    {
        $this->ausstattungRampe = $ausstattungRampe;
    }

    /**
     * Returns the boolean state of ausstattungRampe
     * 
     * @return bool
     */
    public function isAusstattungRampe()
    {
        return $this->ausstattungRampe;
    }

    /**
     * Returns the ausstattungHebebuehne
     * 
     * @return bool $ausstattungHebebuehne
     */
    public function getAusstattungHebebuehne()
    {
        return $this->ausstattungHebebuehne;
    }

    /**
     * Sets the ausstattungHebebuehne
     * 
     * @param bool $ausstattungHebebuehne
     * @return void
     */
    public function setAusstattungHebebuehne($ausstattungHebebuehne)
    {
        $this->ausstattungHebebuehne = $ausstattungHebebuehne;
    }

    /**
     * Returns the boolean state of ausstattungHebebuehne
     * 
     * @return bool
     */
    public function isAusstattungHebebuehne()
    {
        return $this->ausstattungHebebuehne;
    }

    /**
     * Returns the ausstattungKran
     * 
     * @return bool $ausstattungKran
     */
    public function getAusstattungKran()
    {
        return $this->ausstattungKran;
    }

    /**
     * Sets the ausstattungKran
     * 
     * @param bool $ausstattungKran
     * @return void
     */
    public function setAusstattungKran($ausstattungKran)
    {
        $this->ausstattungKran = $ausstattungKran;
    }

    /**
     * Returns the boolean state of ausstattungKran
     * 
     * @return bool
     */
    public function isAusstattungKran()
    {
        return $this->ausstattungKran;
    }

    /**
     * Returns the ausstattungGastterrasse
     * 
     * @return bool $ausstattungGastterrasse
     */
    public function getAusstattungGastterrasse()
    {
        return $this->ausstattungGastterrasse;
    }

    /**
     * Sets the ausstattungGastterrasse
     * 
     * @param bool $ausstattungGastterrasse
     * @return void
     */
    public function setAusstattungGastterrasse($ausstattungGastterrasse)
    {
        $this->ausstattungGastterrasse = $ausstattungGastterrasse;
    }

    /**
     * Returns the boolean state of ausstattungGastterrasse
     * 
     * @return bool
     */
    public function isAusstattungGastterrasse()
    {
        return $this->ausstattungGastterrasse;
    }

    /**
     * Returns the ausstattungKantinecafeteria
     * 
     * @return bool $ausstattungKantinecafeteria
     */
    public function getAusstattungKantinecafeteria()
    {
        return $this->ausstattungKantinecafeteria;
    }

    /**
     * Sets the ausstattungKantinecafeteria
     * 
     * @param bool $ausstattungKantinecafeteria
     * @return void
     */
    public function setAusstattungKantinecafeteria($ausstattungKantinecafeteria)
    {
        $this->ausstattungKantinecafeteria = $ausstattungKantinecafeteria;
    }

    /**
     * Returns the boolean state of ausstattungKantinecafeteria
     * 
     * @return bool
     */
    public function isAusstattungKantinecafeteria()
    {
        return $this->ausstattungKantinecafeteria;
    }

    /**
     * Returns the ausstattungTeekueche
     * 
     * @return bool $ausstattungTeekueche
     */
    public function getAusstattungTeekueche()
    {
        return $this->ausstattungTeekueche;
    }

    /**
     * Sets the ausstattungTeekueche
     * 
     * @param bool $ausstattungTeekueche
     * @return void
     */
    public function setAusstattungTeekueche($ausstattungTeekueche)
    {
        $this->ausstattungTeekueche = $ausstattungTeekueche;
    }

    /**
     * Returns the boolean state of ausstattungTeekueche
     * 
     * @return bool
     */
    public function isAusstattungTeekueche()
    {
        return $this->ausstattungTeekueche;
    }

    /**
     * Returns the ausstattungBrauereibindung
     * 
     * @return bool $ausstattungBrauereibindung
     */
    public function getAusstattungBrauereibindung()
    {
        return $this->ausstattungBrauereibindung;
    }

    /**
     * Sets the ausstattungBrauereibindung
     * 
     * @param bool $ausstattungBrauereibindung
     * @return void
     */
    public function setAusstattungBrauereibindung($ausstattungBrauereibindung)
    {
        $this->ausstattungBrauereibindung = $ausstattungBrauereibindung;
    }

    /**
     * Returns the boolean state of ausstattungBrauereibindung
     * 
     * @return bool
     */
    public function isAusstattungBrauereibindung()
    {
        return $this->ausstattungBrauereibindung;
    }

    /**
     * Returns the ausstattungSporteinrichtungen
     * 
     * @return bool $ausstattungSporteinrichtungen
     */
    public function getAusstattungSporteinrichtungen()
    {
        return $this->ausstattungSporteinrichtungen;
    }

    /**
     * Sets the ausstattungSporteinrichtungen
     * 
     * @param bool $ausstattungSporteinrichtungen
     * @return void
     */
    public function setAusstattungSporteinrichtungen($ausstattungSporteinrichtungen)
    {
        $this->ausstattungSporteinrichtungen = $ausstattungSporteinrichtungen;
    }

    /**
     * Returns the boolean state of ausstattungSporteinrichtungen
     * 
     * @return bool
     */
    public function isAusstattungSporteinrichtungen()
    {
        return $this->ausstattungSporteinrichtungen;
    }

    /**
     * Returns the ausstattungWellnessbereich
     * 
     * @return bool $ausstattungWellnessbereich
     */
    public function getAusstattungWellnessbereich()
    {
        return $this->ausstattungWellnessbereich;
    }

    /**
     * Sets the ausstattungWellnessbereich
     * 
     * @param bool $ausstattungWellnessbereich
     * @return void
     */
    public function setAusstattungWellnessbereich($ausstattungWellnessbereich)
    {
        $this->ausstattungWellnessbereich = $ausstattungWellnessbereich;
    }

    /**
     * Returns the boolean state of ausstattungWellnessbereich
     * 
     * @return bool
     */
    public function isAusstattungWellnessbereich()
    {
        return $this->ausstattungWellnessbereich;
    }

    /**
     * Returns the ausstattungTelefonferienimmobilie
     * 
     * @return bool $ausstattungTelefonferienimmobilie
     */
    public function getAusstattungTelefonferienimmobilie()
    {
        return $this->ausstattungTelefonferienimmobilie;
    }

    /**
     * Sets the ausstattungTelefonferienimmobilie
     * 
     * @param bool $ausstattungTelefonferienimmobilie
     * @return void
     */
    public function setAusstattungTelefonferienimmobilie($ausstattungTelefonferienimmobilie)
    {
        $this->ausstattungTelefonferienimmobilie = $ausstattungTelefonferienimmobilie;
    }

    /**
     * Returns the boolean state of ausstattungTelefonferienimmobilie
     * 
     * @return bool
     */
    public function isAusstattungTelefonferienimmobilie()
    {
        return $this->ausstattungTelefonferienimmobilie;
    }

    /**
     * Returns the ausstattungUmtsempfang
     * 
     * @return bool $ausstattungUmtsempfang
     */
    public function getAusstattungUmtsempfang()
    {
        return $this->ausstattungUmtsempfang;
    }

    /**
     * Sets the ausstattungUmtsempfang
     * 
     * @param bool $ausstattungUmtsempfang
     * @return void
     */
    public function setAusstattungUmtsempfang($ausstattungUmtsempfang)
    {
        $this->ausstattungUmtsempfang = $ausstattungUmtsempfang;
    }

    /**
     * Returns the boolean state of ausstattungUmtsempfang
     * 
     * @return bool
     */
    public function isAusstattungUmtsempfang()
    {
        return $this->ausstattungUmtsempfang;
    }

    /**
     * Returns the ausstattungAbstellraum
     * 
     * @return bool $ausstattungAbstellraum
     */
    public function getAusstattungAbstellraum()
    {
        return $this->ausstattungAbstellraum;
    }

    /**
     * Sets the ausstattungAbstellraum
     * 
     * @param bool $ausstattungAbstellraum
     * @return void
     */
    public function setAusstattungAbstellraum($ausstattungAbstellraum)
    {
        $this->ausstattungAbstellraum = $ausstattungAbstellraum;
    }

    /**
     * Returns the boolean state of ausstattungAbstellraum
     * 
     * @return bool
     */
    public function isAusstattungAbstellraum()
    {
        return $this->ausstattungAbstellraum;
    }

    /**
     * Returns the ausstattungBibliothek
     * 
     * @return bool $ausstattungBibliothek
     */
    public function getAusstattungBibliothek()
    {
        return $this->ausstattungBibliothek;
    }

    /**
     * Sets the ausstattungBibliothek
     * 
     * @param bool $ausstattungBibliothek
     * @return void
     */
    public function setAusstattungBibliothek($ausstattungBibliothek)
    {
        $this->ausstattungBibliothek = $ausstattungBibliothek;
    }

    /**
     * Returns the boolean state of ausstattungBibliothek
     * 
     * @return bool
     */
    public function isAusstattungBibliothek()
    {
        return $this->ausstattungBibliothek;
    }

    /**
     * Returns the ausstattungDachboden
     * 
     * @return bool $ausstattungDachboden
     */
    public function getAusstattungDachboden()
    {
        return $this->ausstattungDachboden;
    }

    /**
     * Sets the ausstattungDachboden
     * 
     * @param bool $ausstattungDachboden
     * @return void
     */
    public function setAusstattungDachboden($ausstattungDachboden)
    {
        $this->ausstattungDachboden = $ausstattungDachboden;
    }

    /**
     * Returns the boolean state of ausstattungDachboden
     * 
     * @return bool
     */
    public function isAusstattungDachboden()
    {
        return $this->ausstattungDachboden;
    }

    /**
     * Returns the ausstattungGaestewc
     * 
     * @return bool $ausstattungGaestewc
     */
    public function getAusstattungGaestewc()
    {
        return $this->ausstattungGaestewc;
    }

    /**
     * Sets the ausstattungGaestewc
     * 
     * @param bool $ausstattungGaestewc
     * @return void
     */
    public function setAusstattungGaestewc($ausstattungGaestewc)
    {
        $this->ausstattungGaestewc = $ausstattungGaestewc;
    }

    /**
     * Returns the boolean state of ausstattungGaestewc
     * 
     * @return bool
     */
    public function isAusstattungGaestewc()
    {
        return $this->ausstattungGaestewc;
    }

    /**
     * Returns the ausstattungKabelkanaele
     * 
     * @return bool $ausstattungKabelkanaele
     */
    public function getAusstattungKabelkanaele()
    {
        return $this->ausstattungKabelkanaele;
    }

    /**
     * Sets the ausstattungKabelkanaele
     * 
     * @param bool $ausstattungKabelkanaele
     * @return void
     */
    public function setAusstattungKabelkanaele($ausstattungKabelkanaele)
    {
        $this->ausstattungKabelkanaele = $ausstattungKabelkanaele;
    }

    /**
     * Returns the boolean state of ausstattungKabelkanaele
     * 
     * @return bool
     */
    public function isAusstattungKabelkanaele()
    {
        return $this->ausstattungKabelkanaele;
    }

    /**
     * Returns the ausstattungSeniorengerecht
     * 
     * @return bool $ausstattungSeniorengerecht
     */
    public function getAusstattungSeniorengerecht()
    {
        return $this->ausstattungSeniorengerecht;
    }

    /**
     * Sets the ausstattungSeniorengerecht
     * 
     * @param bool $ausstattungSeniorengerecht
     * @return void
     */
    public function setAusstattungSeniorengerecht($ausstattungSeniorengerecht)
    {
        $this->ausstattungSeniorengerecht = $ausstattungSeniorengerecht;
    }

    /**
     * Returns the boolean state of ausstattungSeniorengerecht
     * 
     * @return bool
     */
    public function isAusstattungSeniorengerecht()
    {
        return $this->ausstattungSeniorengerecht;
    }

    /**
     * Returns the ausstattungFahrradraum
     * 
     * @return bool $ausstattungFahrradraum
     */
    public function getAusstattungFahrradraum()
    {
        return $this->ausstattungFahrradraum;
    }

    /**
     * Sets the ausstattungFahrradraum
     * 
     * @param bool $ausstattungFahrradraum
     * @return void
     */
    public function setAusstattungFahrradraum($ausstattungFahrradraum)
    {
        $this->ausstattungFahrradraum = $ausstattungFahrradraum;
    }

    /**
     * Returns the boolean state of ausstattungFahrradraum
     * 
     * @return bool
     */
    public function isAusstattungFahrradraum()
    {
        return $this->ausstattungFahrradraum;
    }

    /**
     * Returns the ausstattungRolladen
     * 
     * @return bool $ausstattungRolladen
     */
    public function getAusstattungRolladen()
    {
        return $this->ausstattungRolladen;
    }

    /**
     * Sets the ausstattungRolladen
     * 
     * @param bool $ausstattungRolladen
     * @return void
     */
    public function setAusstattungRolladen($ausstattungRolladen)
    {
        $this->ausstattungRolladen = $ausstattungRolladen;
    }

    /**
     * Returns the boolean state of ausstattungRolladen
     * 
     * @return bool
     */
    public function isAusstattungRolladen()
    {
        return $this->ausstattungRolladen;
    }

    /**
     * Returns the objektNrintern
     * 
     * @return string objektNrintern
     */
    public function getObjektNrintern()
    {
        return $this->objektNrintern;
    }

    /**
     * Sets the objektNrintern
     * 
     * @param string $objektNrintern
     * @return void
     */
    public function setObjektNrintern($objektNrintern)
    {
        $this->objektNrintern = $objektNrintern;
    }

    /**
     * Returns the objektNrextern
     * 
     * @return string objektNrextern
     */
    public function getObjektNrextern()
    {
        return $this->objektNrextern;
    }

    /**
     * Sets the objektNrextern
     * 
     * @param string $objektNrextern
     * @return void
     */
    public function setObjektNrextern($objektNrextern)
    {
        $this->objektNrextern = $objektNrextern;
    }

    /**
     * Returns the standVom
     * 
     * @return \DateTime standVom
     */
    public function getStandVom()
    {
        return $this->standVom;
    }

    /**
     * Sets the standVom
     * 
     * @param \DateTime $standVom
     * @return void
     */
    public function setStandVom(\DateTime $standVom)
    {
        //speichern im UTC wegen Timezone fehler ?! wenn das format in der Datenbank 0000-00-00 ist
        $this->standVom = new \DateTime($standVom->format('Y-m-d'), new \DateTimeZone('UTC'));
    }

    /**
     * Returns the nutzungsArt
     * 
     * @return int nutzungsArt
     */
    public function getNutzungsArt()
    {
        return $this->nutzungsArt;
    }

    /**
     * Sets the nutzungsArt
     * 
     * @param int $nutzungsArt
     * @return void
     */
    public function setNutzungsArt($nutzungsArt)
    {
        $this->nutzungsArt = $nutzungsArt;
    }

    /**
     * Returns the vermarktungsArt
     * 
     * @return int vermarktungsArt
     */
    public function getVermarktungsArt()
    {
        return $this->vermarktungsArt;
    }

    /**
     * Sets the vermarktungsArt
     * 
     * @param int $vermarktungsArt
     * @return void
     */
    public function setVermarktungsArt($vermarktungsArt)
    {
        $this->vermarktungsArt = $vermarktungsArt;
    }

    /**
     * Returns the geoPlz
     * 
     * @return string geoPlz
     */
    public function getGeoPlz()
    {
        return $this->geoPlz;
    }

    /**
     * Sets the geoPlz
     * 
     * @param string $geoPlz
     * @return void
     */
    public function setGeoPlz($geoPlz)
    {
        $this->geoPlz = $geoPlz;
    }

    /**
     * Returns the geoOrt
     * 
     * @return string geoOrt
     */
    public function getGeoOrt()
    {
        return $this->geoOrt;
    }

    /**
     * Sets the geoOrt
     * 
     * @param string $geoOrt
     * @return void
     */
    public function setGeoOrt($geoOrt)
    {
        $this->geoOrt = $geoOrt;
    }

    /**
     * Returns the geoStrasse
     * 
     * @return string geoStrasse
     */
    public function getGeoStrasse()
    {
        return $this->geoStrasse;
    }

    /**
     * Sets the geoStrasse
     * 
     * @param string $geoStrasse
     * @return void
     */
    public function setGeoStrasse($geoStrasse)
    {
        $this->geoStrasse = $geoStrasse;
    }

    /**
     * Returns the geoHausnummer
     * 
     * @return string geoHausnummer
     */
    public function getGeoHausnummer()
    {
        return $this->geoHausnummer;
    }

    /**
     * Sets the geoHausnummer
     * 
     * @param string $geoHausnummer
     * @return void
     */
    public function setGeoHausnummer($geoHausnummer)
    {
        $this->geoHausnummer = $geoHausnummer;
    }

    /**
     * Returns the geoEtage
     * 
     * @return string geoEtage
     */
    public function getGeoEtage()
    {
        return $this->geoEtage;
    }

    /**
     * Sets the geoEtage
     * 
     * @param string $geoEtage
     * @return void
     */
    public function setGeoEtage($geoEtage)
    {
        $this->geoEtage = $geoEtage;
    }

    /**
     * Returns the geoAnzahlEtagen
     * 
     * @return string geoAnzahlEtagen
     */
    public function getGeoAnzahlEtagen()
    {
        return $this->geoAnzahlEtagen;
    }

    /**
     * Sets the geoAnzahlEtagen
     * 
     * @param string $geoAnzahlEtagen
     * @return void
     */
    public function setGeoAnzahlEtagen($geoAnzahlEtagen)
    {
        $this->geoAnzahlEtagen = $geoAnzahlEtagen;
    }

    /**
     * Returns the geoLand
     * 
     * @return string geoLand
     */
    public function getGeoLand()
    {
        return $this->geoLand;
    }

    /**
     * Sets the geoLand
     * 
     * @param string $geoLand
     * @return void
     */
    public function setGeoLand($geoLand)
    {
        $this->geoLand = $geoLand;
    }

    /**
     * Returns the geoKoordinatenBreitengrad
     * 
     * @return float geoKoordinatenBreitengrad
     */
    public function getGeoKoordinatenBreitengrad()
    {
        return $this->geoKoordinatenBreitengrad;
    }

    /**
     * Sets the geoKoordinatenBreitengrad
     * 
     * @param float $geoKoordinatenBreitengrad
     * @return void
     */
    public function setGeoKoordinatenBreitengrad($geoKoordinatenBreitengrad)
    {
        $this->geoKoordinatenBreitengrad = $geoKoordinatenBreitengrad;
    }

    /**
     * Returns the geoKoordinatenLaengengrad
     * 
     * @return float geoKoordinatenLaengengrad
     */
    public function getGeoKoordinatenLaengengrad()
    {
        return $this->geoKoordinatenLaengengrad;
    }

    /**
     * Sets the geoKoordinatenLaengengrad
     * 
     * @param float $geoKoordinatenLaengengrad
     * @return void
     */
    public function setGeoKoordinatenLaengengrad($geoKoordinatenLaengengrad)
    {
        $this->geoKoordinatenLaengengrad = $geoKoordinatenLaengengrad;
    }

    /**
     * Returns the preiseKaltmiete
     * 
     * @return float preiseKaltmiete
     */
    public function getPreiseKaltmiete()
    {
        return $this->preiseKaltmiete;
    }

    /**
     * Sets the preiseKaltmiete
     * 
     * @param float $preiseKaltmiete
     * @return void
     */
    public function setPreiseKaltmiete($preiseKaltmiete)
    {
        $this->preiseKaltmiete = $preiseKaltmiete;
    }

    /**
     * Returns the preiseWarmmiete
     * 
     * @return float preiseWarmmiete
     */
    public function getPreiseWarmmiete()
    {
        return $this->preiseWarmmiete;
    }

    /**
     * Sets the preiseWarmmiete
     * 
     * @param float $preiseWarmmiete
     * @return void
     */
    public function setPreiseWarmmiete($preiseWarmmiete)
    {
        $this->preiseWarmmiete = $preiseWarmmiete;
    }

    /**
     * Returns the preiseNebenkosten
     * 
     * @return float preiseNebenkosten
     */
    public function getPreiseNebenkosten()
    {
        return $this->preiseNebenkosten;
    }

    /**
     * Sets the preiseNebenkosten
     * 
     * @param float $preiseNebenkosten
     * @return void
     */
    public function setPreiseNebenkosten($preiseNebenkosten)
    {
        $this->preiseNebenkosten = $preiseNebenkosten;
    }

    /**
     * Returns the preiseKaution
     * 
     * @return float preiseKaution
     */
    public function getPreiseKaution()
    {
        return $this->preiseKaution;
    }

    /**
     * Sets the preiseKaution
     * 
     * @param float $preiseKaution
     * @return void
     */
    public function setPreiseKaution($preiseKaution)
    {
        $this->preiseKaution = $preiseKaution;
    }

    /**
     * Returns the flaechenWohnflaeche
     * 
     * @return float flaechenWohnflaeche
     */
    public function getFlaechenWohnflaeche()
    {
        return $this->flaechenWohnflaeche;
    }

    /**
     * Sets the flaechenWohnflaeche
     * 
     * @param float $flaechenWohnflaeche
     * @return void
     */
    public function setFlaechenWohnflaeche($flaechenWohnflaeche)
    {
        $this->flaechenWohnflaeche = $flaechenWohnflaeche;
    }

    /**
     * Returns the flaechenAnzahlZimmer
     * 
     * @return float flaechenAnzahlZimmer
     */
    public function getFlaechenAnzahlZimmer()
    {
        return $this->flaechenAnzahlZimmer;
    }

    /**
     * Sets the flaechenAnzahlZimmer
     * 
     * @param float $flaechenAnzahlZimmer
     * @return void
     */
    public function setFlaechenAnzahlZimmer($flaechenAnzahlZimmer)
    {
        $this->flaechenAnzahlZimmer = $flaechenAnzahlZimmer;
    }

    /**
     * Returns the flaechenAnzahlBalkone
     * 
     * @return float flaechenAnzahlBalkone
     */
    public function getFlaechenAnzahlBalkone()
    {
        return $this->flaechenAnzahlBalkone;
    }

    /**
     * Sets the flaechenAnzahlBalkone
     * 
     * @param float $flaechenAnzahlBalkone
     * @return void
     */
    public function setFlaechenAnzahlBalkone($flaechenAnzahlBalkone)
    {
        $this->flaechenAnzahlBalkone = $flaechenAnzahlBalkone;
    }

    /**
     * Returns the flaechenAnzahlTerassen
     * 
     * @return float flaechenAnzahlTerassen
     */
    public function getFlaechenAnzahlTerassen()
    {
        return $this->flaechenAnzahlTerassen;
    }

    /**
     * Sets the flaechenAnzahlTerassen
     * 
     * @param float $flaechenAnzahlTerassen
     * @return void
     */
    public function setFlaechenAnzahlTerassen($flaechenAnzahlTerassen)
    {
        $this->flaechenAnzahlTerassen = $flaechenAnzahlTerassen;
    }

    /**
     * Returns the flaechenAnzahlLogia
     * 
     * @return float flaechenAnzahlLogia
     */
    public function getFlaechenAnzahlLogia()
    {
        return $this->flaechenAnzahlLogia;
    }

    /**
     * Sets the flaechenAnzahlLogia
     * 
     * @param float $flaechenAnzahlLogia
     * @return void
     */
    public function setFlaechenAnzahlLogia($flaechenAnzahlLogia)
    {
        $this->flaechenAnzahlLogia = $flaechenAnzahlLogia;
    }

    /**
     * Returns the zustandBaujahr
     * 
     * @return string zustandBaujahr
     */
    public function getZustandBaujahr()
    {
        return $this->zustandBaujahr;
    }

    /**
     * Sets the zustandBaujahr
     * 
     * @param string $zustandBaujahr
     * @return void
     */
    public function setZustandBaujahr($zustandBaujahr)
    {
        $this->zustandBaujahr = $zustandBaujahr;
    }

    /**
     * Returns the zustandArt
     * 
     * @return int zustandArt
     */
    public function getZustandArt()
    {
        return $this->zustandArt;
    }

    /**
     * Sets the zustandArt
     * 
     * @param int $zustandArt
     * @return void
     */
    public function setZustandArt($zustandArt)
    {
        $this->zustandArt = $zustandArt;
    }

    /**
     * Returns the energiepassEpart
     * 
     * @return string energiepassEpart
     */
    public function getEnergiepassEpart()
    {
        return $this->energiepassEpart;
    }

    /**
     * Sets the energiepassEpart
     * 
     * @param string $energiepassEpart
     * @return void
     */
    public function setEnergiepassEpart($energiepassEpart)
    {
        $this->energiepassEpart = $energiepassEpart;
    }

    /**
     * Returns the energiepassEnergieverbrauchkennwert
     * 
     * @return string energiepassEnergieverbrauchkennwert
     */
    public function getEnergiepassEnergieverbrauchkennwert()
    {
        return $this->energiepassEnergieverbrauchkennwert;
    }

    /**
     * Sets the energiepassEnergieverbrauchkennwert
     * 
     * @param string $energiepassEnergieverbrauchkennwert
     * @return void
     */
    public function setEnergiepassEnergieverbrauchkennwert($energiepassEnergieverbrauchkennwert)
    {
        $this->energiepassEnergieverbrauchkennwert = $energiepassEnergieverbrauchkennwert;
    }

    /**
     * Returns the energiepassEndenergiebedarf
     * 
     * @return string energiepassEndenergiebedarf
     */
    public function getEnergiepassEndenergiebedarf()
    {
        return $this->energiepassEndenergiebedarf;
    }

    /**
     * Sets the energiepassEndenergiebedarf
     * 
     * @param string $energiepassEndenergiebedarf
     * @return void
     */
    public function setEnergiepassEndenergiebedarf($energiepassEndenergiebedarf)
    {
        $this->energiepassEndenergiebedarf = $energiepassEndenergiebedarf;
    }

    /**
     * Returns the energiepassGebaeudeart
     * 
     * @return string energiepassGebaeudeart
     */
    public function getEnergiepassGebaeudeart()
    {
        return $this->energiepassGebaeudeart;
    }

    /**
     * Sets the energiepassGebaeudeart
     * 
     * @param string $energiepassGebaeudeart
     * @return void
     */
    public function setEnergiepassGebaeudeart($energiepassGebaeudeart)
    {
        $this->energiepassGebaeudeart = $energiepassGebaeudeart;
    }

    /**
     * Returns the objektadresseFreigeben
     * 
     * @return bool objektadresseFreigeben
     */
    public function getObjektadresseFreigeben()
    {
        return $this->objektadresseFreigeben;
    }

    /**
     * Sets the objektadresseFreigeben
     * 
     * @param bool $objektadresseFreigeben
     * @return void
     */
    public function setObjektadresseFreigeben($objektadresseFreigeben)
    {
        $this->objektadresseFreigeben = $objektadresseFreigeben;
    }

    /**
     * Returns the verfuegbarAb
     * 
     * @return string verfuegbarAb
     */
    public function getVerfuegbarAb()
    {
        return $this->verfuegbarAb;
    }

    /**
     * Sets the verfuegbarAb
     * 
     * @param string $verfuegbarAb
     * @return void
     */
    public function setVerfuegbarAb($verfuegbarAb)
    {
        $this->verfuegbarAb = $verfuegbarAb;
    }

    /**
     * Returns the ausstattungBad
     * 
     * @return string ausstattungBad
     */
    public function getAusstattungBad()
    {
        return $this->ausstattungBad;
    }

    /**
     * Sets the ausstattungBad
     * 
     * @param string $ausstattungBad
     * @return void
     */
    public function setAusstattungBad($ausstattungBad)
    {
        $this->ausstattungBad = $ausstattungBad;
    }

    /**
     * Returns the ausstattungKueche
     * 
     * @return string ausstattungKueche
     */
    public function getAusstattungKueche()
    {
        return $this->ausstattungKueche;
    }

    /**
     * Sets the ausstattungKueche
     * 
     * @param string $ausstattungKueche
     * @return void
     */
    public function setAusstattungKueche($ausstattungKueche)
    {
        $this->ausstattungKueche = $ausstattungKueche;
    }

    /**
     * Returns the ausstattungBoden
     * 
     * @return string ausstattungBoden
     */
    public function getAusstattungBoden()
    {
        return $this->ausstattungBoden;
    }

    /**
     * Sets the ausstattungBoden
     * 
     * @param string $ausstattungBoden
     * @return void
     */
    public function setAusstattungBoden($ausstattungBoden)
    {
        $this->ausstattungBoden = $ausstattungBoden;
    }

    /**
     * Returns the ausstattungHeizungsart
     * 
     * @return string $ausstattungHeizungsart
     */
    public function getAusstattungHeizungsart()
    {
        return $this->ausstattungHeizungsart;
    }

    /**
     * Sets the ausstattungHeizungsart
     * 
     * @param string $ausstattungHeizungsart
     * @return void
     */
    public function setAusstattungHeizungsart($ausstattungHeizungsart)
    {
        $this->ausstattungHeizungsart = $ausstattungHeizungsart;
    }

    /**
     * Returns the ausstattungBefeuerung
     * 
     * @return string $ausstattungBefeuerung
     */
    public function getAusstattungBefeuerung()
    {
        return $this->ausstattungBefeuerung;
    }

    /**
     * Sets the ausstattungBefeuerung
     * 
     * @param string $ausstattungBefeuerung
     * @return void
     */
    public function setAusstattungBefeuerung($ausstattungBefeuerung)
    {
        $this->ausstattungBefeuerung = $ausstattungBefeuerung;
    }

    /**
     * Returns the ausstattungFahrstuhl
     * 
     * @return string $ausstattungFahrstuhl
     */
    public function getAusstattungFahrstuhl()
    {
        return $this->ausstattungFahrstuhl;
    }

    /**
     * Sets the ausstattungFahrstuhl
     * 
     * @param string $ausstattungFahrstuhl
     * @return void
     */
    public function setAusstattungFahrstuhl($ausstattungFahrstuhl)
    {
        $this->ausstattungFahrstuhl = $ausstattungFahrstuhl;
    }

    /**
     * Returns the ausstattungStellplatzart
     * 
     * @return string $ausstattungStellplatzart
     */
    public function getAusstattungStellplatzart()
    {
        return $this->ausstattungStellplatzart;
    }

    /**
     * Sets the ausstattungStellplatzart
     * 
     * @param string $ausstattungStellplatzart
     * @return void
     */
    public function setAusstattungStellplatzart($ausstattungStellplatzart)
    {
        $this->ausstattungStellplatzart = $ausstattungStellplatzart;
    }

    /**
     * Returns the ausstattungAusrichtBalkonTerasse
     * 
     * @return string $ausstattungAusrichtBalkonTerasse
     */
    public function getAusstattungAusrichtBalkonTerasse()
    {
        return $this->ausstattungAusrichtBalkonTerasse;
    }

    /**
     * Sets the ausstattungAusrichtBalkonTerasse
     * 
     * @param string $ausstattungAusrichtBalkonTerasse
     * @return void
     */
    public function setAusstattungAusrichtBalkonTerasse($ausstattungAusrichtBalkonTerasse)
    {
        $this->ausstattungAusrichtBalkonTerasse = $ausstattungAusrichtBalkonTerasse;
    }

    /**
     * Returns the ausstattungAngeschlGastronomie
     * 
     * @return string $ausstattungAngeschlGastronomie
     */
    public function getAusstattungAngeschlGastronomie()
    {
        return $this->ausstattungAngeschlGastronomie;
    }

    /**
     * Sets the ausstattungAngeschlGastronomie
     * 
     * @param string $ausstattungAngeschlGastronomie
     * @return void
     */
    public function setAusstattungAngeschlGastronomie($ausstattungAngeschlGastronomie)
    {
        $this->ausstattungAngeschlGastronomie = $ausstattungAngeschlGastronomie;
    }

    /**
     * Returns the ausstattungServiceleistungen
     * 
     * @return string $ausstattungServiceleistungen
     */
    public function getAusstattungServiceleistungen()
    {
        return $this->ausstattungServiceleistungen;
    }

    /**
     * Sets the ausstattungServiceleistungen
     * 
     * @param string $ausstattungServiceleistungen
     * @return void
     */
    public function setAusstattungServiceleistungen($ausstattungServiceleistungen)
    {
        $this->ausstattungServiceleistungen = $ausstattungServiceleistungen;
    }

    /**
     * Returns the ausstattungSicherheitstechnik
     * 
     * @return string $ausstattungSicherheitstechnik
     */
    public function getAusstattungSicherheitstechnik()
    {
        return $this->ausstattungSicherheitstechnik;
    }

    /**
     * Sets the ausstattungSicherheitstechnik
     * 
     * @param string $ausstattungSicherheitstechnik
     * @return void
     */
    public function setAusstattungSicherheitstechnik($ausstattungSicherheitstechnik)
    {
        $this->ausstattungSicherheitstechnik = $ausstattungSicherheitstechnik;
    }

    /**
     * Returns the ausstattungMoebliert
     * 
     * @return int $ausstattungMoebliert
     */
    public function getAusstattungMoebliert()
    {
        return $this->ausstattungMoebliert;
    }

    /**
     * Sets the ausstattungMoebliert
     * 
     * @param int $ausstattungMoebliert
     * @return void
     */
    public function setAusstattungMoebliert($ausstattungMoebliert)
    {
        $this->ausstattungMoebliert = $ausstattungMoebliert;
    }

    /**
     * Returns the ausstattungKategorie
     * 
     * @return int $ausstattungKategorie
     */
    public function getAusstattungKategorie()
    {
        return $this->ausstattungKategorie;
    }

    /**
     * Sets the ausstattungKategorie
     * 
     * @param int $ausstattungKategorie
     * @return void
     */
    public function setAusstattungKategorie($ausstattungKategorie)
    {
        $this->ausstattungKategorie = $ausstattungKategorie;
    }

    /**
     * Returns the ausstattungDachform
     * 
     * @return string $ausstattungDachform
     */
    public function getAusstattungDachform()
    {
        return $this->ausstattungDachform;
    }

    /**
     * Sets the ausstattungDachform
     * 
     * @param string $ausstattungDachform
     * @return void
     */
    public function setAusstattungDachform($ausstattungDachform)
    {
        $this->ausstattungDachform = $ausstattungDachform;
    }

    /**
     * Returns the ausstattungBauweise
     * 
     * @return string $ausstattungBauweise
     */
    public function getAusstattungBauweise()
    {
        return $this->ausstattungBauweise;
    }

    /**
     * Sets the ausstattungBauweise
     * 
     * @param string $ausstattungBauweise
     * @return void
     */
    public function setAusstattungBauweise($ausstattungBauweise)
    {
        $this->ausstattungBauweise = $ausstattungBauweise;
    }

    /**
     * Returns the ausstattungAusbaustufe
     * 
     * @return string $ausstattungAusbaustufe
     */
    public function getAusstattungAusbaustufe()
    {
        return $this->ausstattungAusbaustufe;
    }

    /**
     * Sets the ausstattungAusbaustufe
     * 
     * @param string $ausstattungAusbaustufe
     * @return void
     */
    public function setAusstattungAusbaustufe($ausstattungAusbaustufe)
    {
        $this->ausstattungAusbaustufe = $ausstattungAusbaustufe;
    }

    /**
     * Returns the ausstattungEnergietyp
     * 
     * @return string $ausstattungEnergietyp
     */
    public function getAusstattungEnergietyp()
    {
        return $this->ausstattungEnergietyp;
    }

    /**
     * Sets the ausstattungEnergietyp
     * 
     * @param string $ausstattungEnergietyp
     * @return void
     */
    public function setAusstattungEnergietyp($ausstattungEnergietyp)
    {
        $this->ausstattungEnergietyp = $ausstattungEnergietyp;
    }

    /**
     * Returns the ausstattungUnterkellert
     * 
     * @return int $ausstattungUnterkellert
     */
    public function getAusstattungUnterkellert()
    {
        return $this->ausstattungUnterkellert;
    }

    /**
     * Sets the ausstattungUnterkellert
     * 
     * @param int $ausstattungUnterkellert
     * @return void
     */
    public function setAusstattungUnterkellert($ausstattungUnterkellert)
    {
        $this->ausstattungUnterkellert = $ausstattungUnterkellert;
    }

    /**
     * Returns the ausstattungHallenhoehe
     * 
     * @return string $ausstattungHallenhoehe
     */
    public function getAusstattungHallenhoehe()
    {
        return $this->ausstattungHallenhoehe;
    }

    /**
     * Sets the ausstattungHallenhoehe
     * 
     * @param string $ausstattungHallenhoehe
     * @return void
     */
    public function setAusstattungHallenhoehe($ausstattungHallenhoehe)
    {
        $this->ausstattungHallenhoehe = $ausstattungHallenhoehe;
    }

    /**
     * Returns the ausstattungStromanschlusswert
     * 
     * @return string $ausstattungStromanschlusswert
     */
    public function getAusstattungStromanschlusswert()
    {
        return $this->ausstattungStromanschlusswert;
    }

    /**
     * Sets the ausstattungStromanschlusswert
     * 
     * @param string $ausstattungStromanschlusswert
     * @return void
     */
    public function setAusstattungStromanschlusswert($ausstattungStromanschlusswert)
    {
        $this->ausstattungStromanschlusswert = $ausstattungStromanschlusswert;
    }

    /**
     * Returns the strasseHausnummer
     * 
     * @return string strassehausnummer
     */
    public function getStrasseHausnummer()
    {
        if ($this->geoHausnummer) {
            return $this->geoStrasse . ' ' . $this->geoHausnummer;
        }
        return $this->geoStrasse;
    }

    /**
     * Returns the plzOrt
     * 
     * @return string plzOrt
     */
    public function getPlzOrt()
    {
        $retArr = array();
        if ($this->geoPlz) {
            $retArr[] = $this->geoPlz;
        }
        if ($this->geoOrt) {
            $retArr[] = $this->geoOrt;
        }
        return implode(' ', $retArr);
    }

    /**
     * Returns the adresse für pins
     * 
     * @return string adresse
     */
    public function getAdresseFuerMaps()
    {
        $adressArr = array();
        if ($this->objektadresseFreigeben) {
            if ($this->getStrasseHausnummer()) {
                $adressArr[] = $this->getStrasseHausnummer();
            }
            if ($this->getGeoPlz()) {
                $adressArr[] = $this->getGeoPlz();
            }
            if ($this->getGeoOrt()) {
                $adressArr[] = $this->getGeoOrt();
            }
        } else {
            if ($this->getGeoRegionalerZusatz()) {
                $adressArr[] = $this->getGeoRegionalerZusatz();
            }
        }
        return implode(' ', $adressArr);
    }

    /**
     * Returns the etage
     * 
     * @return string etage
     */
    public function getEtage()
    {
        if ($this->getObjektArtWohnungTyp() == 20) {
            return 'DG';
        }
        if ($this->getObjektArtWohnungTyp() == 80) {
            return 'EG';
        }
        $etage = $this->geoEtage;
        //$ivmSettings = \DslFactory\DslImmo\Utility\SettingsUtility::init()->getSettingBackendFor('ivm');
        //$this->url = $ivmSettings["url"];
        //$this->geoLageGebietField = $ivmSettings["geoLageGebietField"];
        /*if($ivmSettings["geoEtageAdd"]!=1){
                			$etage=$etage+$ivmSettings["geoEtageAdd"];
                		}*/

        if ($etage == '0' || $etage == '-1') {
            return 'KG';
        }
        if ($etage == '1') {
            return 'EG';
        }
        if ($etage) {
            return (int) $etage - 1 . '. OG';
        }
        return '';
    }

    /**
     * Returns the geoLageImBau
     * 
     * @return string geoLageImBau
     */
    public function getGeoLageImBau()
    {
        return $this->geoLageImBau;
    }

    /**
     * Sets the geoLageImBau
     * 
     * @param string $geoLageImBau
     * @return void
     */
    public function setGeoLageImBau($geoLageImBau)
    {
        $this->geoLageImBau = $geoLageImBau;
    }

    /**
     * Returns the titelBilder
     * 
     * @return mixed titelBilder
     */
    public function getTitelBilder()
    {
        $titelBilder = array();
        if ($this->anhaenge) {
            if (count($this->anhaenge)) {
                foreach ($this->anhaenge as $anhang) {
                    if ($anhang->getType() == 10) {
                        $titelBilder[] = $anhang;
                    }
                }
                if (!count($titelBilder)) {
                    foreach ($this->anhaenge as $anhang) {
                        if ($anhang->getType() == 30 || $anhang->getType() == 20 || $anhang->getType() == 70) {
                            $titelBilder[] = $anhang;
                            break;
                        }
                    }
                }
            }
        }
        if (count($titelBilder)) {
            return $titelBilder;
        }
        return false;
    }

    /**
     * Returns the Bilder
     * 
     * @return mixed Bilder
     */
    public function getBilder()
    {
        $bilder = array();
        if ($this->anhaenge) {
            if (count($this->anhaenge)) {
                foreach ($this->anhaenge as $anhang) {
                    if ($anhang->getType() == 10 || $anhang->getType() == 30 || $anhang->getType() == 20 || $anhang->getType() == 70) {
                        $bilder[] = $anhang;
                    }
                }
            }
        }
        if (count($bilder)) {
            return $bilder;
        }
        return false;
    }

    /**
     * Returns the GrundrissBilder
     * 
     * @return mixed GrundrissBilder
     */
    public function getGrundrissBilder()
    {
        $bilder = array();
        if ($this->anhaenge) {
            if (count($this->anhaenge)) {
                foreach ($this->anhaenge as $anhang) {
                    if ($anhang->getType() == 40) {
                        $bilder[] = $anhang;
                    }
                }
            }
        }
        if (count($bilder)) {
            return $bilder;
        }
        return false;
    }

    /**
     * Returns the Bilder
     * 
     * @return mixed Bilder
     */
    public function getBilderInklusiveGrundrisse()
    {
        $bilder = array();
        if ($this->anhaenge) {
            if (count($this->anhaenge)) {
                foreach ($this->anhaenge as $anhang) {
                    if ($anhang->getType() == 10 || $anhang->getType() == 30 || $anhang->getType() == 20 || $anhang->getType() == 70 || $anhang->getType() == 40) {
                        $bilder[] = $anhang;
                    }
                }
            }
        }
        if (count($bilder)) {
            return $bilder;
        }
        return false;
    }

    /**
     * Returns the geoLageGebiet
     * 
     * @return string $geoLageGebiet
     */
    public function getGeoLageGebiet()
    {
        return $this->geoLageGebiet;
    }

    /**
     * Sets the geoLageGebiet
     * 
     * @param string $geoLageGebiet
     * @return void
     */
    public function setGeoLageGebiet($geoLageGebiet)
    {
        $this->geoLageGebiet = $geoLageGebiet;
    }

    /**
     * Returns the energiepassGueltigBis
     * 
     * @return string $energiepassGueltigBis
     */
    public function getEnergiepassGueltigBis()
    {
        return $this->energiepassGueltigBis;
    }

    /**
     * Sets the energiepassGueltigBis
     * 
     * @param string $energiepassGueltigBis
     * @return void
     */
    public function setEnergiepassGueltigBis($energiepassGueltigBis)
    {
        $this->energiepassGueltigBis = $energiepassGueltigBis;
    }

    /**
     * Returns the energiepassMitwarmwasser
     * 
     * @return string $energiepassMitwarmwasser
     */
    public function getEnergiepassMitwarmwasser()
    {
        return $this->energiepassMitwarmwasser;
    }

    /**
     * Sets the energiepassMitwarmwasser
     * 
     * @param string $energiepassMitwarmwasser
     * @return void
     */
    public function setEnergiepassMitwarmwasser($energiepassMitwarmwasser)
    {
        $this->energiepassMitwarmwasser = $energiepassMitwarmwasser;
    }

    /**
     * Returns the energiepassPrimaerenergietraeger
     * 
     * @return string $energiepassPrimaerenergietraeger
     */
    public function getEnergiepassPrimaerenergietraeger()
    {
        return $this->energiepassPrimaerenergietraeger;
    }

    /**
     * Sets the energiepassPrimaerenergietraeger
     * 
     * @param string $energiepassPrimaerenergietraeger
     * @return void
     */
    public function setEnergiepassPrimaerenergietraeger($energiepassPrimaerenergietraeger)
    {
        $this->energiepassPrimaerenergietraeger = $energiepassPrimaerenergietraeger;
    }

    /**
     * Returns the energiepassStromwert
     * 
     * @return string $energiepassStromwert
     */
    public function getEnergiepassStromwert()
    {
        return $this->energiepassStromwert;
    }

    /**
     * Sets the energiepassStromwert
     * 
     * @param string $energiepassStromwert
     * @return void
     */
    public function setEnergiepassStromwert($energiepassStromwert)
    {
        $this->energiepassStromwert = $energiepassStromwert;
    }

    /**
     * Returns the energiepassWaermewert
     * 
     * @return string $energiepassWaermewert
     */
    public function getEnergiepassWaermewert()
    {
        return $this->energiepassWaermewert;
    }

    /**
     * Sets the energiepassWaermewert
     * 
     * @param string $energiepassWaermewert
     * @return void
     */
    public function setEnergiepassWaermewert($energiepassWaermewert)
    {
        $this->energiepassWaermewert = $energiepassWaermewert;
    }

    /**
     * Returns the energiepassWertklasse
     * 
     * @return string $energiepassWertklasse
     */
    public function getEnergiepassWertklasse()
    {
        return $this->energiepassWertklasse;
    }

    /**
     * Sets the energiepassWertklasse
     * 
     * @param string $energiepassWertklasse
     * @return void
     */
    public function setEnergiepassWertklasse($energiepassWertklasse)
    {
        $this->energiepassWertklasse = $energiepassWertklasse;
    }

    /**
     * Returns the energiepassAusstelldatum
     * 
     * @return string $energiepassAusstelldatum
     */
    public function getEnergiepassAusstelldatum()
    {
        return $this->energiepassAusstelldatum;
    }

    /**
     * Sets the energiepassAusstelldatum
     * 
     * @param string $energiepassAusstelldatum
     * @return void
     */
    public function setEnergiepassAusstelldatum($energiepassAusstelldatum)
    {
        $this->energiepassAusstelldatum = $energiepassAusstelldatum;
    }

    /**
     * Returns the energiepassJahrgang
     * 
     * @return string $energiepassJahrgang
     */
    public function getEnergiepassJahrgang()
    {
        return $this->energiepassJahrgang;
    }

    /**
     * Sets the energiepassJahrgang
     * 
     * @param string $energiepassJahrgang
     * @return void
     */
    public function setEnergiepassJahrgang($energiepassJahrgang)
    {
        $this->energiepassJahrgang = $energiepassJahrgang;
    }

    /**
     * Returns the highlight
     * 
     * @return int $highlight
     */
    public function getHighlight()
    {
        return $this->highlight;
    }

    /**
     * Sets the highlight
     * 
     * @param int $highlight
     * @return void
     */
    public function setHighlight($highlight)
    {
        $this->highlight = $highlight;
    }

    /**
     * Returns the flaechenAnzahlBalkoneTerassenLogia
     * 
     * @return float flaechenAnzahlAnzahlBalkoneTerassenLogia
     */
    public function getFlaechenAnzahlBalkoneTerassenLogia()
    {
        return $this->flaechenAnzahlTerassen + $this->flaechenAnzahlLogia + $this->flaechenAnzahlBalkone;
    }

    /**
     * Returns the objektArtWohnungTyp
     * 
     * @return int objektArtWohnungTyp
     */
    public function getObjektArtWohnungTyp()
    {
        return $this->objektArtWohnungTyp;
    }

    /**
     * Sets the objektArtWohnungTyp
     * 
     * @param int $objektArtWohnungTyp
     * @return void
     */
    public function setObjektArtWohnungTyp($objektArtWohnungTyp)
    {
        $this->objektArtWohnungTyp = $objektArtWohnungTyp;
    }

    /**
     * Returns the objektArtZimmerTyp
     * 
     * @return int $objektArtZimmerTyp
     */
    public function getObjektArtZimmerTyp()
    {
        return $this->objektArtZimmerTyp;
    }

    /**
     * Sets the objektArtZimmerTyp
     * 
     * @param int $objektArtZimmerTyp
     * @return void
     */
    public function setObjektArtZimmerTyp($objektArtZimmerTyp)
    {
        $this->objektArtZimmerTyp = $objektArtZimmerTyp;
    }

    /**
     * Returns the objektArtHausTyp
     * 
     * @return int $objektArtHausTyp
     */
    public function getObjektArtHausTyp()
    {
        return $this->objektArtHausTyp;
    }

    /**
     * Sets the objektArtHausTyp
     * 
     * @param int $objektArtHausTyp
     * @return void
     */
    public function setObjektArtHausTyp($objektArtHausTyp)
    {
        $this->objektArtHausTyp = $objektArtHausTyp;
    }

    /**
     * Returns the objektArtGrundstueckTyp
     * 
     * @return int $objektArtGrundstueckTyp
     */
    public function getObjektArtGrundstueckTyp()
    {
        return $this->objektArtGrundstueckTyp;
    }

    /**
     * Sets the objektArtGrundstueckTyp
     * 
     * @param int $objektArtGrundstueckTyp
     * @return void
     */
    public function setObjektArtGrundstueckTyp($objektArtGrundstueckTyp)
    {
        $this->objektArtGrundstueckTyp = $objektArtGrundstueckTyp;
    }

    /**
     * Returns the objektArtBueroPraxenTyp
     * 
     * @return int $objektArtBueroPraxenTyp
     */
    public function getObjektArtBueroPraxenTyp()
    {
        return $this->objektArtBueroPraxenTyp;
    }

    /**
     * Sets the objektArtBueroPraxenTyp
     * 
     * @param int $objektArtBueroPraxenTyp
     * @return void
     */
    public function setObjektArtBueroPraxenTyp($objektArtBueroPraxenTyp)
    {
        $this->objektArtBueroPraxenTyp = $objektArtBueroPraxenTyp;
    }

    /**
     * Returns the objektArtEinzelhandelTyp
     * 
     * @return int $objektArtEinzelhandelTyp
     */
    public function getObjektArtEinzelhandelTyp()
    {
        return $this->objektArtEinzelhandelTyp;
    }

    /**
     * Sets the objektArtEinzelhandelTyp
     * 
     * @param int $objektArtEinzelhandelTyp
     * @return void
     */
    public function setObjektArtEinzelhandelTyp($objektArtEinzelhandelTyp)
    {
        $this->objektArtEinzelhandelTyp = $objektArtEinzelhandelTyp;
    }

    /**
     * Returns the objektArtGastgewerbeTyp
     * 
     * @return int $objektArtGastgewerbeTyp
     */
    public function getObjektArtGastgewerbeTyp()
    {
        return $this->objektArtGastgewerbeTyp;
    }

    /**
     * Sets the objektArtGastgewerbeTyp
     * 
     * @param int $objektArtGastgewerbeTyp
     * @return void
     */
    public function setObjektArtGastgewerbeTyp($objektArtGastgewerbeTyp)
    {
        $this->objektArtGastgewerbeTyp = $objektArtGastgewerbeTyp;
    }

    /**
     * Returns the objektArtHallenLagerProduktionTyp
     * 
     * @return int $objektArtHallenLagerProduktionTyp
     */
    public function getObjektArtHallenLagerProduktionTyp()
    {
        return $this->objektArtHallenLagerProduktionTyp;
    }

    /**
     * Sets the objektArtHallenLagerProduktionTyp
     * 
     * @param int $objektArtHallenLagerProduktionTyp
     * @return void
     */
    public function setObjektArtHallenLagerProduktionTyp($objektArtHallenLagerProduktionTyp)
    {
        $this->objektArtHallenLagerProduktionTyp = $objektArtHallenLagerProduktionTyp;
    }

    /**
     * Returns the objektArtLandForstwirtschaftTyp
     * 
     * @return int $objektArtLandForstwirtschaftTyp
     */
    public function getObjektArtLandForstwirtschaftTyp()
    {
        return $this->objektArtLandForstwirtschaftTyp;
    }

    /**
     * Sets the objektArtLandForstwirtschaftTyp
     * 
     * @param int $objektArtLandForstwirtschaftTyp
     * @return void
     */
    public function setObjektArtLandForstwirtschaftTyp($objektArtLandForstwirtschaftTyp)
    {
        $this->objektArtLandForstwirtschaftTyp = $objektArtLandForstwirtschaftTyp;
    }

    /**
     * Returns the objektArtParkenTyp
     * 
     * @return int $objektArtParkenTyp
     */
    public function getObjektArtParkenTyp()
    {
        return $this->objektArtParkenTyp;
    }

    /**
     * Sets the objektArtParkenTyp
     * 
     * @param int $objektArtParkenTyp
     * @return void
     */
    public function setObjektArtParkenTyp($objektArtParkenTyp)
    {
        $this->objektArtParkenTyp = $objektArtParkenTyp;
    }

    /**
     * Returns the objektArtSonstigeTyp
     * 
     * @return int $objektArtSonstigeTyp
     */
    public function getObjektArtSonstigeTyp()
    {
        return $this->objektArtSonstigeTyp;
    }

    /**
     * Sets the objektArtSonstigeTyp
     * 
     * @param int $objektArtSonstigeTyp
     * @return void
     */
    public function setObjektArtSonstigeTyp($objektArtSonstigeTyp)
    {
        $this->objektArtSonstigeTyp = $objektArtSonstigeTyp;
    }

    /**
     * Returns the objektArtZinshausRenditeobjektTyp
     * 
     * @return int $objektArtZinshausRenditeobjektTyp
     */
    public function getObjektArtZinshausRenditeobjektTyp()
    {
        return $this->objektArtZinshausRenditeobjektTyp;
    }

    /**
     * Sets the objektArtZinshausRenditeobjektTyp
     * 
     * @param int $objektArtZinshausRenditeobjektTyp
     * @return void
     */
    public function setObjektArtZinshausRenditeobjektTyp($objektArtZinshausRenditeobjektTyp)
    {
        $this->objektArtZinshausRenditeobjektTyp = $objektArtZinshausRenditeobjektTyp;
    }

    /**
     * Returns the ausstattungKuecheArray
     * 
     * @return mixed ausstattungKuecheArray
     */
    public function getAusstattungKuecheArray()
    {
        return explode(',', $this->ausstattungKueche);
    }

    /**
     * Returns the ausstattungWaschTrockenraum
     * 
     * @return bool ausstattungWaschTrockenraum
     */
    public function getAusstattungWaschTrockenraum()
    {
        return $this->ausstattungWaschTrockenraum;
    }

    /**
     * Sets the ausstattungWaschTrockenraum
     * 
     * @param bool $ausstattungWaschTrockenraum
     * @return void
     */
    public function setAusstattungWaschTrockenraum($ausstattungWaschTrockenraum)
    {
        $this->ausstattungWaschTrockenraum = $ausstattungWaschTrockenraum;
    }

    /**
     * Returns the objektArtFreizeitimmobilieGewerblichTyp
     * 
     * @return int objektArtFreizeitimmobilieGewerblichTyp
     */
    public function getObjektArtFreizeitimmobilieGewerblichTyp()
    {
        return $this->objektArtFreizeitimmobilieGewerblichTyp;
    }

    /**
     * Sets the objektArtFreizeitimmobilieGewerblichTyp
     * 
     * @param int $objektArtFreizeitimmobilieGewerblichTyp
     * @return void
     */
    public function setObjektArtFreizeitimmobilieGewerblichTyp($objektArtFreizeitimmobilieGewerblichTyp)
    {
        $this->objektArtFreizeitimmobilieGewerblichTyp = $objektArtFreizeitimmobilieGewerblichTyp;
    }

    /**
     * Returns the objekttyp
     * 
     * @return string $objekttyp
     */
    public function getObjekttyp()
    {
        /*evtn nicht genutzt*/
        if ($this->getObjektArtWohnungTyp() != 0) {
            return 'Wohnung';
        }
        if ($this->getObjektArtHausTyp() != 0) {
            return 'Haus';
        }
        if ($this->getObjektArtGrundstueckTyp() != 0) {
            return 'Grundstueck';
        }
        if ($this->getObjektArtBueroPraxenTyp() != 0 || $this->getObjektArtEinzelhandelTyp() != 0 || $this->getObjektArtGastgewerbeTyp() != 0 || $this->getObjektArtHallenLagerProduktionTyp() != 0 || $this->getObjektArtLandForstwirtschaftTyp() != 0 || $this->getObjektArtSonstigeTyp() != 0 || $this->getObjektArtFreizeitimmobilieGewerblichTyp() != 0 || $this->getObjektArtZinshausRenditeobjektTyp() != 0) {
            return 'Gewerbe/Buero';
        }
        if ($this->getObjektArtParkenTyp() != 0) {
            return 'Garage/Stellplatz';
        }
        /*
        		
        		
        		<v:form.select.option value="s1010">Wohnung</v:form.select.option>
        		<v:form.select.option value="s1020">Haus</v:form.select.option>
        		<v:form.select.option value="s1030">Grundstück</v:form.select.option>
        		<v:form.select.option value="s1040">Gewerbe/Büro</v:form.select.option>
        		<v:form.select.option value="s1050">Garage/Stellplatz</v:form.select.option>
        		
        		
        		case 's1000':    //Wohnung // nicht genutzt?!
                               	$andConstraints[] = $query->logicalNot($query->equals('objekt_art_zimmer_typ', 0));//$query->logicalNot
                                break;
                            case 's1010':    //Wohnung
                                $andConstraints[] = $query->logicalNot($query->equals('objekt_art_wohnung_typ', 0));//$query->logicalNot
                                break;
        					case 's1020':    //Haus
                                $andConstraints[] = $query->logicalNot($query->equals('objekt_art_haus_typ', 0));//$query->logicalNot
                                break;
                            case 's1030':    //Grundstück
        $andConstraints[] = $query->logicalNot($query->equals('objekt_art_grundstueck_typ', 0));//$query->logicalNot
                                //$andConstraints[] = $query->equals('geo_lage_gebiet', 'Neubaugebiet "West"');
                                break;
                            case 's1040':    //Gewerbe/Büro
        //$andConstraints[] = $query->logicalNot($query->equals('objekt_art_buero_praxen_typ', 0));//$query->logicalNot
        
        $andConstraints[] = $query->logicalOr(array(
        		$query->logicalNot($query->equals('objekt_art_buero_praxen_typ', 0)),
        		$query->logicalNot($query->equals('objekt_art_einzelhandel_typ', 0)),
        		$query->logicalNot($query->equals('objekt_art_gastgewerbe_typ', 0)),
        		$query->logicalNot($query->equals('objekt_art_hallen_lager_produktion_typ', 0)),
        		$query->logicalNot($query->equals('objekt_art_land_forstwirtschaft_typ', 0)),
        		$query->logicalNot($query->equals('objekt_art_sonstige_typ', 0)),
        		$query->logicalNot($query->equals('objekt_art_freizeitimmobilie_gewerblich_typ', 0)),
        		$query->logicalNot($query->equals('objekt_art_zinshaus_renditeobjekt_typ', 0)),
        ));
        //and ()
        //objekt_art_einzelhandel_typ  objekt_art_gastgewerbe_typ objekt_art_hallen_lager_produktion_typ objekt_art_land_forstwirtschaft_typ objekt_art_sonstige_typ objekt_art_freizeitimmobilie_gewerblich_typ objekt_art_zinshaus_renditeobjekt_typ 
                                //$andConstraints[] = $query->equals('geo_lage_gebiet', 'Altbau');
                                break;
                            case 's1050':    //Garage/Stellplatz
        $andConstraints[] = $query->logicalNot($query->equals('objekt_art_parken_typ', 0));//$query->logicalNot
        
                                //$andConstraints[] = $query->equals('geo_lage_gebiet', 'Neubaugebiet "West"');
                                break;
        */

        return 'anderes';
    }

    /**
     * Returns the flaechenSonstflaeche
     * 
     * @return float $flaechenSonstflaeche
     */
    public function getFlaechenSonstflaeche()
    {
        return $this->flaechenSonstflaeche;
    }

    /**
     * Sets the flaechenSonstflaeche
     * 
     * @param float $flaechenSonstflaeche
     * @return void
     */
    public function setFlaechenSonstflaeche($flaechenSonstflaeche)
    {
        $this->flaechenSonstflaeche = $flaechenSonstflaeche;
    }

    /**
     * Returns the flaechenVermietbareFlaeche
     * 
     * @return float $flaechenVermietbareFlaeche
     */
    public function getFlaechenVermietbareFlaeche()
    {
        return $this->flaechenVermietbareFlaeche;
    }

    /**
     * Sets the flaechenVermietbareFlaeche
     * 
     * @param float $flaechenVermietbareFlaeche
     * @return void
     */
    public function setFlaechenVermietbareFlaeche($flaechenVermietbareFlaeche)
    {
        $this->flaechenVermietbareFlaeche = $flaechenVermietbareFlaeche;
    }

    /**
     * Returns the flaechenAnzahlGewerbeeinheiten
     * 
     * @return int flaechenAnzahlGewerbeeinheiten
     */
    public function getFlaechenAnzahlGewerbeeinheiten()
    {
        return $this->flaechenAnzahlGewerbeeinheiten;
    }

    /**
     * Sets the flaechenAnzahlGewerbeeinheiten
     * 
     * @param int $flaechenAnzahlGewerbeeinheiten
     * @return void
     */
    public function setFlaechenAnzahlGewerbeeinheiten($flaechenAnzahlGewerbeeinheiten)
    {
        $this->flaechenAnzahlGewerbeeinheiten = $flaechenAnzahlGewerbeeinheiten;
    }

    /**
     * Returns the flaechenNutzflaeche
     * 
     * @return float $flaechenNutzflaeche
     */
    public function getFlaechenNutzflaeche()
    {
        return $this->flaechenNutzflaeche;
    }

    /**
     * Sets the flaechenNutzflaeche
     * 
     * @param float $flaechenNutzflaeche
     * @return void
     */
    public function setFlaechenNutzflaeche($flaechenNutzflaeche)
    {
        $this->flaechenNutzflaeche = $flaechenNutzflaeche;
    }

    /**
     * Returns the flaechenGesamtflaeche
     * 
     * @return float $flaechenGesamtflaeche
     */
    public function getFlaechenGesamtflaeche()
    {
        return $this->flaechenGesamtflaeche;
    }

    /**
     * Sets the flaechenGesamtflaeche
     * 
     * @param float $flaechenGesamtflaeche
     * @return void
     */
    public function setFlaechenGesamtflaeche($flaechenGesamtflaeche)
    {
        $this->flaechenGesamtflaeche = $flaechenGesamtflaeche;
    }

    /**
     * Returns the flaechenBueroflaeche
     * 
     * @return float $flaechenBueroflaeche
     */
    public function getFlaechenBueroflaeche()
    {
        return $this->flaechenBueroflaeche;
    }

    /**
     * Sets the flaechenBueroflaeche
     * 
     * @param float $flaechenBueroflaeche
     * @return void
     */
    public function setFlaechenBueroflaeche($flaechenBueroflaeche)
    {
        $this->flaechenBueroflaeche = $flaechenBueroflaeche;
    }

    /**
     * Returns the flaechenAnzahlBadezimmer
     * 
     * @return int $flaechenAnzahlBadezimmer
     */
    public function getFlaechenAnzahlBadezimmer()
    {
        return $this->flaechenAnzahlBadezimmer;
    }

    /**
     * Sets the flaechenAnzahlBadezimmer
     * 
     * @param int $flaechenAnzahlBadezimmer
     * @return void
     */
    public function setFlaechenAnzahlBadezimmer($flaechenAnzahlBadezimmer)
    {
        $this->flaechenAnzahlBadezimmer = $flaechenAnzahlBadezimmer;
    }

    /**
     * Returns the preiseProvisionspflichtig
     * 
     * @return bool $preiseProvisionspflichtig
     */
    public function getPreiseProvisionspflichtig()
    {
        return $this->preiseProvisionspflichtig;
    }

    /**
     * Sets the preiseProvisionspflichtig
     * 
     * @param bool $preiseProvisionspflichtig
     * @return void
     */
    public function setPreiseProvisionspflichtig($preiseProvisionspflichtig)
    {
        $this->preiseProvisionspflichtig = $preiseProvisionspflichtig;
    }

    /**
     * Returns the boolean state of preiseProvisionspflichtig
     * 
     * @return bool
     */
    public function isPreiseProvisionspflichtig()
    {
        return $this->preiseProvisionspflichtig;
    }

    /**
     * Returns the preiseAussenCourtageMitMwst
     * 
     * @return bool $preiseAussenCourtageMitMwst
     */
    public function getPreiseAussenCourtageMitMwst()
    {
        return $this->preiseAussenCourtageMitMwst;
    }

    /**
     * Sets the preiseAussenCourtageMitMwst
     * 
     * @param bool $preiseAussenCourtageMitMwst
     * @return void
     */
    public function setPreiseAussenCourtageMitMwst($preiseAussenCourtageMitMwst)
    {
        $this->preiseAussenCourtageMitMwst = $preiseAussenCourtageMitMwst;
    }

    /**
     * Returns the boolean state of preiseAussenCourtageMitMwst
     * 
     * @return bool
     */
    public function isPreiseAussenCourtageMitMwst()
    {
        return $this->preiseAussenCourtageMitMwst;
    }

    /**
     * Returns the preiseWaehrungIsoWaehrung
     * 
     * @return string $preiseWaehrungIsoWaehrung
     */
    public function getPreiseWaehrungIsoWaehrung()
    {
        return $this->preiseWaehrungIsoWaehrung;
    }

    /**
     * Sets the preiseWaehrungIsoWaehrung
     * 
     * @param string $preiseWaehrungIsoWaehrung
     * @return void
     */
    public function setPreiseWaehrungIsoWaehrung($preiseWaehrungIsoWaehrung)
    {
        $this->preiseWaehrungIsoWaehrung = $preiseWaehrungIsoWaehrung;
    }

    /**
     * Returns the preiseMwstSatz
     * 
     * @return float $preiseMwstSatz
     */
    public function getPreiseMwstSatz()
    {
        return $this->preiseMwstSatz;
    }

    /**
     * Sets the preiseMwstSatz
     * 
     * @param float $preiseMwstSatz
     * @return void
     */
    public function setPreiseMwstSatz($preiseMwstSatz)
    {
        $this->preiseMwstSatz = $preiseMwstSatz;
    }

    /**
     * Returns the preiseMieteinnahmenIst
     * 
     * @return float $preiseMieteinnahmenIst
     */
    public function getPreiseMieteinnahmenIst()
    {
        return $this->preiseMieteinnahmenIst;
    }

    /**
     * Sets the preiseMieteinnahmenIst
     * 
     * @param float $preiseMieteinnahmenIst
     * @return void
     */
    public function setPreiseMieteinnahmenIst($preiseMieteinnahmenIst)
    {
        $this->preiseMieteinnahmenIst = $preiseMieteinnahmenIst;
    }

    /**
     * Returns the preiseStpFreiplatzAnzahl
     * 
     * @return int $preiseStpFreiplatzAnzahl
     */
    public function getPreiseStpFreiplatzAnzahl()
    {
        return $this->preiseStpFreiplatzAnzahl;
    }

    /**
     * Sets the preiseStpFreiplatzAnzahl
     * 
     * @param int $preiseStpFreiplatzAnzahl
     * @return void
     */
    public function setPreiseStpFreiplatzAnzahl($preiseStpFreiplatzAnzahl)
    {
        $this->preiseStpFreiplatzAnzahl = $preiseStpFreiplatzAnzahl;
    }

    /**
     * Returns the preiseKaufpreis
     * 
     * @return float preiseKaufpreis
     */
    public function getPreiseKaufpreis()
    {
        return $this->preiseKaufpreis;
    }

    /**
     * Sets the preiseKaufpreis
     * 
     * @param float $preiseKaufpreis
     * @return void
     */
    public function setPreiseKaufpreis($preiseKaufpreis)
    {
        $this->preiseKaufpreis = $preiseKaufpreis;
    }

    /**
     * Returns the preiseAussenCourtage
     * 
     * @return string preiseAussenCourtage
     */
    public function getPreiseAussenCourtage()
    {
        return $this->preiseAussenCourtage;
    }

    /**
     * Sets the preiseAussenCourtage
     * 
     * @param float $preiseAussenCourtage
     * @return void
     */
    public function setPreiseAussenCourtage($preiseAussenCourtage)
    {
        $this->preiseAussenCourtage = $preiseAussenCourtage;
    }

    /**
     * Returns the preiseStpSonstigeAnzahl
     * 
     * @return int $preiseStpSonstigeAnzahl
     */
    public function getPreiseStpSonstigeAnzahl()
    {
        return $this->preiseStpSonstigeAnzahl;
    }

    /**
     * Sets the preiseStpSonstigeAnzahl
     * 
     * @param int $preiseStpSonstigeAnzahl
     * @return void
     */
    public function setPreiseStpSonstigeAnzahl($preiseStpSonstigeAnzahl)
    {
        $this->preiseStpSonstigeAnzahl = $preiseStpSonstigeAnzahl;
    }

    /**
     * Returns the preiseStpSonstigePlatzart
     * 
     * @return string $preiseStpSonstigePlatzart
     */
    public function getPreiseStpSonstigePlatzart()
    {
        return $this->preiseStpSonstigePlatzart;
    }

    /**
     * Sets the preiseStpSonstigePlatzart
     * 
     * @param string $preiseStpSonstigePlatzart
     * @return void
     */
    public function setPreiseStpSonstigePlatzart($preiseStpSonstigePlatzart)
    {
        $this->preiseStpSonstigePlatzart = $preiseStpSonstigePlatzart;
    }

    /**
     * Returns the searchVermarktung
     * 
     * @return string $searchVermarktung
     */
    public function getSearchVermarktung()
    {
        return $this->searchVermarktung;
    }

    /**
     * Sets the searchVermarktung
     * 
     * @param string $searchVermarktung
     * @return void
     */
    public function setSearchVermarktung($searchVermarktung)
    {
        $this->searchVermarktung = $searchVermarktung;
    }

    /**
     * Returns the searchObjektTyp
     * 
     * @return string $searchObjektTyp
     */
    public function getSearchObjektTyp()
    {
        return $this->searchObjektTyp;
    }

    /**
     * Sets the searchObjektTyp
     * 
     * @param string $searchObjektTyp
     * @return void
     */
    public function setSearchObjektTyp($searchObjektTyp)
    {
        $this->searchObjektTyp = $searchObjektTyp;
    }

    /**
     * Returns the searchZimmer
     * 
     * @return float $searchZimmer
     */
    public function getSearchZimmer()
    {
        return $this->searchZimmer;
    }

    /**
     * Sets the searchZimmer
     * 
     * @param float $searchZimmer
     * @return void
     */
    public function setSearchZimmer($searchZimmer)
    {
        $this->searchZimmer = $searchZimmer;
    }

    /**
     * Returns the searchFlaeche
     * 
     * @return float $searchFlaeche
     */
    public function getSearchFlaeche()
    {
        return $this->searchFlaeche;
    }

    /**
     * Sets the searchFlaeche
     * 
     * @param float $searchFlaeche
     * @return void
     */
    public function setSearchFlaeche($searchFlaeche)
    {
        $this->searchFlaeche = $searchFlaeche;
    }

    /**
     * Returns the searchPreis
     * 
     * @return float $searchPreis
     */
    public function getSearchPreis()
    {
        return $this->searchPreis;
    }

    /**
     * Sets the searchPreis
     * 
     * @param float $searchPreis
     * @return void
     */
    public function setSearchPreis($searchPreis)
    {
        $this->searchPreis = $searchPreis;
    }

    /**
     * Returns the searchWohngebiet
     * 
     * @return string $searchWohngebiet
     */
    public function getSearchWohngebiet()
    {
        return $this->searchWohngebiet;
    }

    /**
     * Sets the searchWohngebiet
     * 
     * @param string $searchWohngebiet
     * @return void
     */
    public function setSearchWohngebiet($searchWohngebiet)
    {
        $this->searchWohngebiet = $searchWohngebiet;
    }

    public function refreshSearchVars()
    {
        if ($this->getVermarktungsArt() == 10) {
            //kaufen
            $this->setSearchPreis($this->getPreiseKaufpreis());
            $this->setSearchVermarktung('s1020');
        }
        if ($this->getVermarktungsArt() == 20) {
            //mieten (wohnen/gewerbe)
            $this->setSearchPreis($this->getPreiseKaltmiete());
            $this->setSearchVermarktung('s1010');
        }
        if ($this->getNutzungsArt() == 10) {
            //wohnen
            $this->setSearchFlaeche($this->getFlaechenWohnflaeche());
            if ($this->getObjektArtHausTyp()) {
                //haus
                $this->setSearchObjektTyp('s1020');
            } else {
                if ($this->getAusstattungWggeeignet()) {
                    $this->setSearchObjektTyp('s1070');
                } else {
                    //wohnung
                    $this->setSearchObjektTyp('s1010');
                }
            }
        }
        if (!$this->getNutzungsArt() && $this->getObjektArtParkenTyp()) {
            //Parken
            $this->setSearchObjektTyp('s1050');
        }
        if ($this->getNutzungsArt() == 30 || $this->getNutzungsArt() == 20) {
            //Gewerbe/Büro // 20 = Gewerbe / 30 Anlage
            $this->setSearchFlaeche($this->getFlaechenNutzflaeche());
        }
        if ($this->getNutzungsArt() == 20) {
            //Gewerbe/Büro
            $this->setSearchObjektTyp('s1040');
        }
        if ($this->getNutzungsArt() == 30) {
            //Anlage
            $this->setSearchObjektTyp('s1060');
        }
        $this->setSearchZimmer($this->getFlaechenAnzahlZimmer());
        if (!$this->getGeoLageGebiet()) {
            $this->setGeoLageGebiet($this->getGeoOrt());
        }
    }

    /**
     * Returns the geoRegionalerZusatz
     * 
     * @return string $geoRegionalerZusatz
     */
    public function getGeoRegionalerZusatz()
    {
        return $this->geoRegionalerZusatz;
    }

    /**
     * Sets the geoRegionalerZusatz
     * 
     * @param string $geoRegionalerZusatz
     * @return void
     */
    public function setGeoRegionalerZusatz($geoRegionalerZusatz)
    {
        $this->geoRegionalerZusatz = $geoRegionalerZusatz;
    }

    /**
     * Returns the flaechenGrundstuecksflaeche
     * 
     * @return float $flaechenGrundstuecksflaeche
     */
    public function getFlaechenGrundstuecksflaeche()
    {
        return $this->flaechenGrundstuecksflaeche;
    }

    /**
     * Sets the flaechenGrundstuecksflaeche
     * 
     * @param float $flaechenGrundstuecksflaeche
     * @return void
     */
    public function setFlaechenGrundstuecksflaeche($flaechenGrundstuecksflaeche)
    {
        $this->flaechenGrundstuecksflaeche = $flaechenGrundstuecksflaeche;
    }

    /**
     * Returns the flaechenAnzahlSchlafzimmer
     * 
     * @return int $flaechenAnzahlSchlafzimmer
     */
    public function getFlaechenAnzahlSchlafzimmer()
    {
        return $this->flaechenAnzahlSchlafzimmer;
    }

    /**
     * Sets the flaechenAnzahlSchlafzimmer
     * 
     * @param int $flaechenAnzahlSchlafzimmer
     * @return void
     */
    public function setFlaechenAnzahlSchlafzimmer($flaechenAnzahlSchlafzimmer)
    {
        $this->flaechenAnzahlSchlafzimmer = $flaechenAnzahlSchlafzimmer;
    }

    /**
     * Returns the geoAdresseGesperrtKoordinatenBreitengrad
     * 
     * @return float $geoAdresseGesperrtKoordinatenBreitengrad
     */
    public function getGeoAdresseGesperrtKoordinatenBreitengrad()
    {
        return $this->geoAdresseGesperrtKoordinatenBreitengrad;
    }

    /**
     * Sets the geoAdresseGesperrtKoordinatenBreitengrad
     * 
     * @param float $geoAdresseGesperrtKoordinatenBreitengrad
     * @return void
     */
    public function setGeoAdresseGesperrtKoordinatenBreitengrad($geoAdresseGesperrtKoordinatenBreitengrad)
    {
        $this->geoAdresseGesperrtKoordinatenBreitengrad = $geoAdresseGesperrtKoordinatenBreitengrad;
    }

    /**
     * Returns the geoAdresseGesperrtKoordinatenLaengengrad
     * 
     * @return float $geoAdresseGesperrtKoordinatenLaengengrad
     */
    public function getGeoAdresseGesperrtKoordinatenLaengengrad()
    {
        return $this->geoAdresseGesperrtKoordinatenLaengengrad;
    }

    /**
     * Sets the geoAdresseGesperrtKoordinatenLaengengrad
     * 
     * @param float $geoAdresseGesperrtKoordinatenLaengengrad
     * @return void
     */
    public function setGeoAdresseGesperrtKoordinatenLaengengrad($geoAdresseGesperrtKoordinatenLaengengrad)
    {
        $this->geoAdresseGesperrtKoordinatenLaengengrad = $geoAdresseGesperrtKoordinatenLaengengrad;
    }

    /**
     * Returns the haustiere
     * 
     * @return bool $haustiere
     */
    public function getHaustiere()
    {
        return $this->haustiere;
    }

    /**
     * Sets the haustiere
     * 
     * @param bool $haustiere
     * @return void
     */
    public function setHaustiere($haustiere)
    {
        $this->haustiere = $haustiere;
    }

    /**
     * Returns the boolean state of haustiere
     * 
     * @return bool
     */
    public function isHaustiere()
    {
        return $this->haustiere;
    }

    /**
     * Returns the boolean state of Nutzungsart Gewerbe
     * 
     * @return bool
     */
    public function isGewerbe()
    {
        if ($this->getNutzungsArt() == 20) {
            return true;
        }
        return false;
    }

    /**
     * Returns the boolean state of Nutzungsart Wohnen
     * 
     * @return bool
     */
    public function isWohnen()
    {
        if ($this->getNutzungsArt() == 10) {
            return true;
        }
        return false;
    }

    /**
     * Returns the boolean state of besonderheiten
     * 
     * @return bool
     */
    public function isBesonderheiten()
    {
        if ($this->getFlaechenAnzahlBalkone()) {
            return true;
        }
        if ($this->getFlaechenAnzahlTerassen()) {
            return true;
        }
        if ($this->getFlaechenAnzahlLogia()) {
            return true;
        }
        if ($this->getAusstattungFahrstuhl()) {
            return true;
        }
        if ($this->getAusstattungKueche()) {
            return true;
        }
        if ($this->getAusstattungGaestewc()) {
            return true;
        }
        if ($this->getAusstattungGartennutzung()) {
            return true;
        }
        if ($this->getAusstattungUnterkellert()) {
            return true;
        }
        if ($this->getPreiseStpSonstigeAnzahl()) {
            return true;
        }
        if ($this->getPreiseStpFreiplatzAnzahl()) {
            return true;
        }
        return false;
    }

    /**
     * Returns the additionalHtmlField
     * 
     * @return string $additionalHtmlField
     */
    public function getAdditionalHtmlField()
    {
        return $this->additionalHtmlField;
    }

    /**
     * Sets the additionalHtmlField
     * 
     * @param string $additionalHtmlField
     * @return void
     */
    public function setAdditionalHtmlField($additionalHtmlField)
    {
        $this->additionalHtmlField = $additionalHtmlField;
    }

    /**
     * Returns the modernerGrundriss
     * 
     * @return bool $modernerGrundriss
     */
    public function getModernerGrundriss()
    {
        return $this->modernerGrundriss;
    }

    /**
     * Sets the modernerGrundriss
     * 
     * @param bool $modernerGrundriss
     * @return void
     */
    public function setModernerGrundriss($modernerGrundriss)
    {
        $this->modernerGrundriss = $modernerGrundriss;
    }

    /**
     * Returns the boolean state of modernerGrundriss
     * 
     * @return bool
     */
    public function isModernerGrundriss()
    {
        return $this->modernerGrundriss;
    }

    /**
     * Returns the energieAusweisLinkExtern
     * 
     * @return string $energieAusweisLinkExtern
     */
    public function getEnergieAusweisLinkExtern()
    {
        return $this->energieAusweisLinkExtern;
    }

    /**
     * Returns the energieAusweisLinkExternFilename
     * 
     * @return string $energieAusweisLinkExternFilename
     */
    public function getEnergieAusweisLinkExternFilename()
    {
        $pathinfo = pathinfo($this->energieAusweisLinkExtern);
        return $pathinfo['basename'];
    }

    /**
     * Sets the energieAusweisLinkExtern
     * 
     * @param string $energieAusweisLinkExtern
     * @return void
     */
    public function setEnergieAusweisLinkExtern($energieAusweisLinkExtern)
    {
        $this->energieAusweisLinkExtern = $energieAusweisLinkExtern;
    }

    /**
     * Returns the titelBild
     * 
     * @return \DslFactory\DslImmo\Domain\Model\Anhang $titelBild
     */
    public function getTitelBild()
    {
        return $this->titelBild;
    }

    /**
     * Sets the titelBild
     * 
     * @param \DslFactory\DslImmo\Domain\Model\Anhang $titelBild
     * @return void
     */
    public function setTitelBild(\DslFactory\DslImmo\Domain\Model\Anhang $titelBild = NULL)
    {
        $this->titelBild = $titelBild;
    }
}
