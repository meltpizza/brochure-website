<?php

namespace Melt\WebsiteBundle\Controller;

use Melt\WebsiteBundle\Entity\Media;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PageController extends Controller
{
    /**
     * @Route("/", name="page_transit")
     * @Cache(expires="+2 days", public="true")
     * @Template()
     */
    public function transitionAction()
    {
        return array();
    }

    /**
     * @Route("/old", name="page_home")
     * @Cache(expires="+2 days", public="true")
     * @Template()
     */
    public function indexAction()
    {

        return $this->redirect('/');
        exit;

        $media = $this->getDoctrine()->getRepository('WebsiteBundle:Media')->findBy(array('active'=>1), array('ordering' => 'ASC'));

        return array(
            'media' => $media
        );
    }

    /**
     * @Route("/privacy", name="page_privacy")
     * @Cache(expires="+2 days", public="true")
     * @Template()
     */
    public function privacyAction()
    {
        return array();
    }

}
