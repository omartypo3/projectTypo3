<?php

namespace Pingag\PingagRealEstate\Controller;

use Pingag\PingagRealEstate\Domain\Model\RealEstate;
use Pingag\PingagRealEstate\Domain\Repository\RealEstateRepository;
use Pingag\PingagRealEstate\Form\ContactForm;
use Pingag\PingagRealEstate\Form\RealEstateFilter;
use Pingag\PingagRealEstate\Service\MailerService;
use Pingag\PingagRealEstate\Service\RealEstateOptionFactory;
use Pingag\PingagRealEstate\Util\GeneralUtil;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;


class RealEstateController extends ActionController
{

    /**
     * @var \Pingag\PingagRealEstate\Domain\Repository\RealEstateRepository
     * @inject
     */
    protected $realEstateRepository;

    /**
     * @param RealEstateFilter|null $filter
     * @return string
     */
    public function listAction(RealEstateFilter $filter = null)
    {
        if(!$filter){
            $filter = new RealEstateFilter();
        }
        $filter->buildFilterOptions();
        $find = $this->realEstateRepository->findAll();
        foreach ($find as $findvlue){
            $zip = $findvlue->getObjectZip();
            if(empty($findvlue->getObjectX()) && empty($findvlue->getObjectY())){
                $uid1 = $findvlue->getUid();
                $adressXY = $this->realEstateRepository->getKm($zip);
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_pingag_real_estate', 'uid=' . intval($uid1),array('object_x' => $adressXY['0'] ,'object_y' => $adressXY['1']));
            }

        }
        $realEstateList = $this->realEstateRepository->findByFilter($filter);
        $this->view->assignMultiple([
            'realEstateList' => $realEstateList,
            'filter' => $filter,
            'value' => json_encode($filter->getSearchString())
        ]);
        
        return $this->view->render();
    }
    
    protected function getRealEstateFilterState()
    {
        if(isset($_COOKIE['realEstateFilterState'])){
            $cookies = json_decode($_COOKIE['realEstateFilterState'], true);
            return $cookies;      
        }
        return false;
    }

    /**
     * @return string
     */
    public function listNewBuildingsAction()
    {
        $realEstateList = $this->realEstateRepository->findNewBuildings();
        $this->view->assign('realEstateList', $realEstateList);
        return $this->view->render();
    }

    /**
     * @param \Pingag\PingagRealEstate\Domain\Model\RealEstate $realEstate
     * @param ContactForm|null $contactForm
     * @return string
     */
    public function showAction(RealEstate $realEstate, ContactForm $contactForm = null)
    {
        if(!$contactForm){
            $contactForm = GeneralUtility::makeInstance(ContactForm::class, $realEstate);
        }

        $this->addOpenGraphTags($realEstate);
        
        $this->view->assignMultiple([
            'realEstate' => $realEstate,
            'contactForm' => $contactForm,
        ]);
        
        return $this->view->render();
    }

    /**
     * @param ContactForm $contactForm
     * @return string
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function contactFormSuccessAction(ContactForm $contactForm)
    {
        /** @var MailerService $mailer */
        $mailer = GeneralUtility::makeInstance(MailerService::class);
        
        $mailer->sendTemplateEmail(
            [$contactForm->getRealEstate()->getAgencyEmail()],
            ['hevsg@pingag.ch' => 'HEV Verwaltungs AG'],
            'Immobilien-Anfrage',
            'RealEstate/Mail/ContactForm',
            ['contactForm' => $contactForm]
        );
        
        return $this->view->render();
    }
    
    protected function addOpenGraphTags(RealEstate $realEstate)
    {
        $this->addMetaTag('og:title', $realEstate->getObjectTitle());

        $description = str_replace('<br><br>', '. ', $realEstate->getObjectDescription());
        $description = strip_tags($description);
        $this->addMetaTag('og:description', $description);

        $pictures = $realEstate->getPictures()->toArray();
        if(isset($pictures[0])){
            $image = $realEstate->getPictures()->toArray()[0]->getOriginalResource();
            $this->addMetaTag('og:image',$image->getPublicUrl(true));
        }
    }
    
    protected function addMetaTag($name, $value)
    {
        $metaTagFormat = '<meta name="%s" content="%s" />';
        $this->response->addAdditionalHeaderData(sprintf($metaTagFormat, $name, $value));
    }
    
    protected function isAjaxRequest()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    
}