<?php

namespace Melt\WebsiteBundle\Controller;

use Melt\WebsiteBundle\Entity\Partner;
use Melt\WebsiteBundle\Entity\PartnerEntry;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * @Route("/partners")
 */
class PartnerController extends Controller
{
    /**
     * @Route("/submit", name="partner_submit")
     * @Template()
     */
    public function partnerSubmitAction(Request $request)
    {
        $session = $this->get('session');
        $code    = $request->get('code');

        $partner = $this->getDoctrine()
                        ->getRepository('WebsiteBundle:Partner')
                        ->findOneBy(array('code'=>$code));

        if(!$partner || !$partner->getActive() ) {
            $session->getFlashBag()->add('notice', "Sorry but partner can't be found!");
            return $this->redirect($this->generateUrl('page_home'));
        }

        $entry = new PartnerEntry();
        $form  = $this->createFormBuilder($entry)
                      ->setAction($this->generateUrl('partner_submit', array('code' => $code)))
                      ->add('name'  , 'text')
                      ->add('email' , 'text')
                      ->add('submit', 'submit')
                      ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entry->setCreated(new \DateTime());
            $entry->setPartner($partner);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entry);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Your entry have been saved');
            return $this->redirect($this->generateUrl('partner_page', array('partner_code'=>$code)));

        } else {
            $session->getFlashBag()->add('notice', "Sorry but your entry cannot be saved.");
            return $this->redirect($this->generateUrl('page_home'));
        }
    }


    /**
     * @Route("/{partner_code}", name="partner_page")
     * @Template()
     */
    public function partnerAction($partner_code)
    {
        $session = $this->get('session');
        $partner = $this->getDoctrine()
                        ->getRepository('WebsiteBundle:Partner')
                        ->findOneBy(array('code'=>$partner_code));

        $entry   = new PartnerEntry();

        if(!$partner || !$partner->getActive() ) {
            return $this->redirect($this->generateUrl('page_home'));
        }

        $form = $this->createFormBuilder($entry)
                     ->setAction($this->generateUrl('partner_submit', array('code' => $partner_code)))
                     ->add('name'  , 'text')
                     ->add('email' , 'text')
                     ->add('submit', 'submit')
                     ->getForm();

        return array(
            'form'    => $form->createView(),
            'partner' => $partner
        );
    }

    /**
     * @Route("/", name="partner_index")
     * @Cache(expires="+2 days", public="true")
     * @Template()
     */
    public function indexAction()
    {
        //return $this->redirect($this->generateUrl('page_home'));
    }

}//PartnerController
