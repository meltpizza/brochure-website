<?php

namespace Melt\WebsiteBundle\Controller;

use Melt\WebsiteBundle\Entity\Partner;
use Melt\WebsiteBundle\Entity\PartnerEntry;

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
     * @Route("/", name="partner_index")
     * @Cache(expires="+2 days", public="true")
     * @Template()
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('page_home'));
    }

    /**
     * @Route("/{partner_code}", name="partner_page")
     * @Template()
     */
    public function partnerAction($partner_code)
    {
        $partner = $this->getDoctrine()->getRepository('WebsiteBundle:Partner')->findOneBy(array('code'=>$partner_code));
        $entry   = new PartnerEntry();

        if(!$partner || !$partner->getActive() ) {
            return $this->redirect($this->generateUrl('page_home'));
        }

        $form = $this->createFormBuilder($entry)
                     ->setAction($this->generateUrl('partner_page', array('partner_code'=>$partner_code)))
                     ->add('name'  , 'text')
                     ->add('email' , 'text')
                     ->add('save'  , 'submit')
                     ->getForm();

        return array(
            'form'    => $form->createView(),
            'partner' => $partner
        );
    }
}//PartnerController
