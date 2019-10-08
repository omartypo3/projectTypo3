<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 15.09.2017
 * Time: 17:13
 */

namespace Pingag\PingagThurcom\Controller;

use Pingag\PingagThurcom\Domain\Model\ProductConsultation;

class ProductConsultationController extends BaseController
{

    /**
     * @return string
     */
    public function showAction()
    {
        $consultation = new ProductConsultation();
        $this->view->assign('consultation', $consultation);
		
		$consultationOptions = $this->productConsultationRepo->findAll();
        $this->view->assign('consultoption', $consultationOptions);
		$this->view->assign('current_url', $this->currentUrl());
       
        return $this->view->render();
    }
}