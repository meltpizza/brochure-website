<?php

namespace Melt\AdminBundle\Controller;

use Melt\WebsiteBundle\Entity\Partner;
use Melt\WebsiteBundle\Entity\PartnerEntry;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/admin/partner")
 */
class PartnerController extends Controller
{
    /**
     * @Route("/", name="admin_partner_index")
     * @Template()
     */
    public function indexAction()
    {
        $partners = $this->getDoctrine()->getRepository('WebsiteBundle:Partner')->findAll();

        return array(
            'partners' => $partners
        );
    }//indexAction

    /**
     * @Route("/edit/{id}", name="admin_partner_edit", defaults={"id":null})
     * @Template()
     */
    public function editAction($id)
    {
        if($id) {
            $partner = $this->getDoctrine()->getRepository('WebsiteBundle:Partner')->find($id);
        } else  {
            $partner = new Partner();
        }

        $years[] = date('Y');
        for($i=1; $i<=3; $i++) {
            $years[$i] = $years[$i-1]+1;
        }

        $form = $this->createFormBuilder($partner)
                     ->setAction($this->generateUrl('admin_partner_save', array('id'=>$id)))
                     ->add('name'        , 'text')
                     ->add('code'        , 'text')
                     ->add('event_date'  , 'date', array('years' => $years) )
                     ->add('description' , 'textarea')
                     ->add('link'        , 'text')
                     ->add('save'        , 'submit')
                     ->getForm();

        return array(
            'form'  => $form->createView(),
            'partner' => $partner
        );
    }//editAction


    /**
     * @Route("/save/order", name="admin_partner_save_order" )
     * @Template()
     */
    public function saveOrderAction() {
        $order_array = Array();

        $request = $this->getRequest();
        $order_array = $request->get('order');

        foreach($order_array as $item_id => $order) {
            $partner = $this->getDoctrine()->getRepository('WebsiteBundle:Partner')->find($item_id);
            $partner->setOrdering($order);

            $em = $this->getDoctrine()->getManager();
            $em->persist($partner);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('success', 'partner ordering saved');
        return $this->redirect($this->generateUrl('admin_partner_index'));
    }


    /**
     * @Route("/save/{id}", name="admin_partner_save", defaults={"id":null} )
     * @Template()
     */
    public function saveAction($id)
    {
        $request = $this->getRequest();

        if($id) {
            $partner = $this->getDoctrine()->getRepository('WebsiteBundle:Partner')->find($id);
        } else  {
            $partner = new Partner();
        }

        $form = $this->createFormBuilder($partner)
                     ->setAction($this->generateUrl('admin_partner_save', array('id'=>$id)))
                     ->add('name'        , 'text')
                     ->add('code'        , 'text')
                     ->add('description' , 'textarea')
                     ->add('link'        , 'text')
                     ->add('save'        , 'submit')
                     ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $partner->setActive(1);
            $partner->setCreated(new \DateTime());
            $partner->setModified(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($partner);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Partner saved');
            return $this->redirect($this->generateUrl('admin_partner_index'));
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Partner could not be saved. Some errors occurred.');
            return $this->redirect($this->generateUrl('admin_partner_edit', array('id' => $partner->getId())) );
        }
    }//saveAction


    /**
     * @Route("/toggle/{id}", name="admin_partner_toggle" )
     * @Template()
     */
    public function toggleAction($id)
    {
        $partner = $this->getDoctrine()->getRepository('WebsiteBundle:Partner')->find($id);
        $partner->setActive( !$partner->getActive() );
        $em = $this->getDoctrine()->getManager();
        $em->persist($partner);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_partner_index'));
    }//toggleAction



}//PartnerController
