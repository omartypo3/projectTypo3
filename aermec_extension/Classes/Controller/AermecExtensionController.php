<?php

namespace AermecExtension\AermecExtension\Controller;


/**
 * AermecExtensionController
 */
class AermecExtensionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * aermecExtensionRepository
     *
     * @var \AermecExtension\AermecExtension\Domain\Repository\AermecExtensionRepository
     * @inject
     */
    protected $aermecExtensionRepository = NULL;

    public $api_host = "https://apis.aermec.com/mi7";
    public $catalogue = "CAT_50HZ_UE";
    public $language = "en";


    public $languages = array(
        'it' => 'Italiano',
        'en' => 'English',
        'fr' => 'Français',
        'de' => 'Deutsch',
        'es' => 'Español',
        'pl' => 'Polskie',
        'cs' => 'Čeština'
    );

    public $catalogues = array(
        'CAT_50HZ' => 'Global (50Hz)',
        'CAT_60HZ' => 'Global (60Hz)',
        'CAT_50HZ_UE' => 'European Union (50Hz)',
        'CAT_60HZ_NA' => 'North America (60Hz)',
        'CAT_50HZ_SA' => 'South America (50Hz)',
        'CAT_60HZ_SA' => 'South America (60Hz)',
    );

    public $translations = array(
        'it' => array(
            'pr' => 'Prodotti',
            'cat' => 'Catalogo',
            'lng' => 'Lingua'
        ),
        'en' => array(
            'pr' => 'Products',
            'cat' => 'Catalog',
            'lng' => 'Language'
        ),
        'fr' => array(
            'pr' => 'Produits',
            'cat' => 'Catalogue',
            'lng' => 'Langue'
        ),
        'de' => array(
            'pr' => 'Produkte',
            'cat' => 'Katalog',
            'lng' => 'Sprache'
        ),
        'es' => array(
            'pr' => 'Productos',
            'cat' => 'Catálogo',
            'lng' => 'Idioma'
        ),
        'pl' => array(
            'pr' => 'Produkty',
            'cat' => 'Katalog',
            'lng' => 'Język'
        ),
        'cs' => array(
            'pr' => 'Produkty',
            'cat' => 'Katalog',
            'lng' => 'Jazyk'
        ),
    );


    public function listAction()
    {
        $api_url = $this->api_host . '/' . $this->getLanguageAction() . "/" . $this->getCatalogueAction();

        $menu_link = $api_url . "/menu/";
        $menuArray = json_decode(file_get_contents($menu_link));

        // $aermecExtensions = $this->aermecExtensionRepository->findAll();
        $this->view->assign('menus', $menuArray);
        $this->view->assign('catalogues', $this->catalogues);
        $this->view->assign('languages', $this->languages);
        $this->view->assign('lang', $this->getLanguageAction());
        $this->view->assign('translations', $this->translations[$this->getLanguageAction()]);

    }

    /**
     * @param string $code
     * @param string $categoryCode
     * @param string $subcategoryCode
     */
    public function showAction($code, $categoryCode, $subcategoryCode)
    {
        $api_url = $this->api_host . '/' . $this->getLanguageAction() . "/" . $this->getCatalogueAction();

        $product_link = $api_url . "/detail/category/" . $categoryCode . "/sub/" . $subcategoryCode . "/serie/" . $code . "/";
        $productArray = json_decode(file_get_contents($product_link));

        $menu_link = $api_url . "/menu/";
        $menuArray = json_decode(file_get_contents($menu_link));


        $this->view->assign('data', $productArray[0]);
        $this->view->assign('menus', $menuArray);
        $this->view->assign('catalogues', $this->catalogues);
        $this->view->assign('languages', $this->languages);
        $this->view->assign('lang', $this->getLanguageAction());
        $this->view->assign('translations', $this->translations[$this->getLanguageAction()]);
    }


    public function getLanguageAction()
    {
		$cl = $GLOBALS['TSFE']->sys_language_uid ;
		$langs[0] = 'de';
		$langs[1] = 'fr';
		$langs[2] = 'it';
		$langs[3] = 'en';
/*
        $data_session = $GLOBALS['TSFE']->fe_user->getKey('ses', 'aermecdata');
        return $data_session['lang'] ? $data_session['lang'] : $this->language;*/
		return $langs[$cl];
    }

    public function getCatalogueAction()
    {
        $data_session = $GLOBALS['TSFE']->fe_user->getKey('ses', 'aermecdata');
        return $data_session['catalogue'] ? $data_session['catalogue'] : $this->catalogue;

    }

    /**
     * @param string $lang
     * @param string $code
     * @param string $categoryCode
     * @param string $subcategoryCode
     */
    public function setLanguageAction($lang, $code = null, $categoryCode = null, $subcategoryCode = null)
    {
        $data = $GLOBALS['TSFE']->fe_user->getKey('ses', 'aermecdata');
        $data['lang'] = $lang;
        $GLOBALS['TSFE']->fe_user->setKey('ses', 'aermecdata', $data);


        if (isset($code)) {
            $this->redirect("show", null, null, array('code' => $code, 'categoryCode' => $categoryCode, 'subcategoryCode' => $subcategoryCode));
        } else {
            $this->redirect("list");
        }
    }

    /**
     * @param string $catalogue
     * @param string $code
     * @param string $categoryCode
     * @param string $subcategoryCode
     */
    public function setCatalogueAction($catalogue, $code = null, $categoryCode = null, $subcategoryCode = null)
    {
        $data = $GLOBALS['TSFE']->fe_user->getKey('ses', 'aermecdata');
        $data['catalogue'] = $catalogue;
        $GLOBALS['TSFE']->fe_user->setKey('ses', 'aermecdata', $data);

        $this->redirect("list");
    }


}