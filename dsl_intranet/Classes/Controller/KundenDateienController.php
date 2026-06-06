<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Controller;


/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 
 */

/**
 * KundenDateienController
 */
class KundenDateienController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * kundenDateienRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\KundenDateienRepository
     */
    protected $kundenDateienRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\KundenDateienRepository $kundenDateienRepository
     */
    public function injectKundenDateienRepository(\DslFactory\DslIntranet\Domain\Repository\KundenDateienRepository $kundenDateienRepository)
    {
        $this->kundenDateienRepository = $kundenDateienRepository;
    }

    /**
     * action ajax
     *
     * @return void
     */
    public function ajaxAction()
    {
        if ($this->request->hasArgument('switch')) {
            switch ($this->request->getArgument('switch')) {
                case 'list':    //$kunde = $this->kundenRepository->findByName("pro haar");
                    //	echo "haaa";die;
                    //echo $kunde->getUid();
                    $retarray = $this->listJSONDataTable(array(60, 70, 80, 90, 100));//20, angebote raus genommen 10.07.2019
                    echo json_encode($retarray);
                    die;
                    break;
                case 'listrechnungen':    //$kunde = $this->kundenRepository->findByName("pro haar");
                    //	echo "haaa";die;
                    //echo $kunde->getUid();
                    $retarray = $this->listJSONDataTable(array(30,35), 'KundenDateien/ListRechnungenJSONDataTable.html', 'rechnungen');
                    // nur rechnungen
                    echo json_encode($retarray);
                    die;
                    break;
            }
        }
       // header('HTTP/1.1 400 Bad Request');
        return json_encode(array('error' => 'Bad request!'));
    }

    /**
     * @param $kunde $typeArr
     * @param $template
     * @param $orderMap
     */
    protected function listJSONDataTable($typeArr = false, $template = 'KundenDateien/ListJSONDataTable.html', $orderMap = false)
    {
        //\DslFactory\DslIntranet\Utility\MaintenanceUtility::init()->maintenanceDateienTempFields();
        $data = array();
        $benutzer = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        //$user = $GLOBALS['TSFE']->fe_user->user;
        //	echo $template;die;
        $settings = $benutzer->getSettingsDateien();
        if ($typeArr) {
            $settings['typens'] = $typeArr;
        }
        //nur rechnungen
        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView($template, $this->request->getControllerExtensionName());
        //echo $dbView->render();die;
        if (isset($_GET['start'])) {
            $start = intval($_GET['start']);
        } else {
            $start = 0;
        }
        if (isset($_GET['length'])) {
            $length = intval($_GET['length']);
        } else {
            $length = 10;
        }
        if (isset($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = array();
        }
        if (isset($_GET['search'])) {
            $search = $_GET['search']['value'];
        } else {
            $search = false;
        }
        $dateienAnzahlFiltered = count($this->kundenDateienRepository->findByFilter($settings, false, false, array(), false, false));
        $dateienAnzahl = $this->kundenDateienRepository->findByFilter($settings, false, false, array(), $search, false);
        if ($dateienAnzahlFiltered) {
            //wenn überhaupt aufträge vorhanden sind
            $sortInRepository = true;
            if ($order[0]['column'] == 3) {

            }
            if ($sortInRepository) {
                $dateiens = $this->kundenDateienRepository->findByFilter($settings, $start, $length, $order, $search, $orderMap);
                foreach ($dateiens as $dateien) {
                    //	echo $dateien->getUid();die;
                    $dbView->assign('dateien', $dateien);
                    $data[] = explode('<--break-->', $dbView->render());
                }
            }
        }
        $retarray = array(
            'draw' => $_GET['draw'],
            'recordsTotal' => $dateienAnzahlFiltered,
            'recordsFiltered' => count($dateienAnzahl),
            'data' => $data
        );
        return $retarray;
    }

    /**
     * action listrechnungen
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listrechnungenAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action listAuftragRechnungen
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAuftragRechnungenAction(\DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('auftraege', $auftraege);
        return $this->htmlResponse();
    }

    /**
     * action listAuftragAngebote
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAuftragAngeboteAction(\DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('auftraege', $auftraege);
        return $this->htmlResponse();
    }

    /**
     * action index
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
        $kundenDateiens = $this->kundenDateienRepository->findAll();
        $this->view->assign('kundenDateiens', $kundenDateiens);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenDateien $kundenDateien
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\KundenDateien $kundenDateien): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('kundenDateien', $kundenDateien);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenDateien $newKundenDateien
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\KundenDateien $newKundenDateien)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenDateienRepository->add($newKundenDateien);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenDateien $kundenDateien
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("kundenDateien")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\KundenDateien $kundenDateien): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('kundenDateien', $kundenDateien);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenDateien $kundenDateien
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\KundenDateien $kundenDateien)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenDateienRepository->update($kundenDateien);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenDateien $kundenDateien
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\KundenDateien $kundenDateien)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenDateienRepository->remove($kundenDateien);
        $this->redirect('list');
    }
}
