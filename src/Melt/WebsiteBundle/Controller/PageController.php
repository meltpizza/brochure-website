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
     * @Route("/")
     * @Cache(expires="+2 days", public="true")
     * @Template()
     */
    public function indexAction()
    {
        $media = $this->getDoctrine()->getRepository('WebsiteBundle:Media')->findByActive(1);

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
