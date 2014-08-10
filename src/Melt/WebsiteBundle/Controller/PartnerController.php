<?php

namespace Melt\WebsiteBundle\Controller;

use Melt\WebsiteBundle\Entity\Media;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * @Route("/partners")
 */
class PartnerController extends Controller
{
    /**
     * @Route("/")
     * @Cache(expires="+2 days", public="true")
     * @Template()
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('page_home'));
    }

    /**
     * @Route("/{partner_code}")
     * @Template()
     */
    public function partnerAction()
    {
        return array();
    }
}//PartnerController
