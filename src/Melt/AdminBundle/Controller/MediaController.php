<?php

namespace Melt\AdminBundle\Controller;

use Melt\WebsiteBundle\Entity\Media;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/admin/media")
 */
class MediaController extends Controller
{
    /**
     * @Route("/", name="admin_media_index")
     * @Template()
     */
    public function indexAction()
    {
        $media = $this->getDoctrine()->getRepository('WebsiteBundle:Media')->findBy(array(), array('order' => 'DESC'));

        return array(
            'media' => $media
        );
    }//indexAction

    /**
     * @Route("/edit/{id}", name="admin_media_edit", defaults={"id":null})
     * @Template()
     */
    public function editAction($id)
    {
        if($id) {
            $media = $this->getDoctrine()->getRepository('WebsiteBundle:Media')->find($id);
        } else  {
            $media = new Media();
        }

        $form = $this->createFormBuilder($media)
                     ->setAction($this->generateUrl('admin_media_save', array('id'=>$id)))
                     ->add('title'   , 'text')
                     ->add('link'    , 'text')
                     ->add('author'  , 'text')
                     ->add('created' , 'text')
                     ->add('save'    , 'submit')
                     ->getForm();

        return array(
            'form'  => $form->createView(),
            'media' => $media
        );
    }//editAction


    /**
     * @Route("/save/order", name="admin_media_save_order" )
     * @Template()
     */
    public function saveOrderAction() {
        $order_array = Array();

        $request = $this->getRequest();
        $order_array = $request->get('order');

        foreach($order_array as $order => $item_id) {
            $media = $this->getDoctrine()->getRepository('WebsiteBundle:Media')->find($item_id);
            $media->setOrder($order+1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('success', 'Media ordering saved');
        return $this->redirect($this->generateUrl('admin_media_index'));

        print '<pre>';
        print_r($order_array);
        print '</pre>';
        die;
    }


    /**
     * @Route("/save/{id}", name="admin_media_save", defaults={"id":null} )
     * @Template()
     */
    public function saveAction($id)
    {
        $request = $this->getRequest();

        if($id) {
            $media = $this->getDoctrine()->getRepository('WebsiteBundle:Media')->find($id);
        } else  {
            $media = new Media();
        }

        $form = $this->createFormBuilder($media)
                     ->add('title'   , 'text')
                     ->add('link'    , 'text')
                     ->add('author'  , 'text')
                     ->add('created' , 'text')
                     ->add('save'    , 'submit')
                     ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $media->setAuthorLink("");
            $media->setActive(1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Media saved');
            return $this->redirect($this->generateUrl('admin_media_index'));
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Media could not be saved. Some errors occurred.');
            return $this->redirect($this->generateUrl('admin_media_edit', array('id' => $media->getId())) );
        }
    }//saveAction


    /**
     * @Route("/toggle/{id}", name="admin_media_toggle" )
     * @Template()
     */
    public function toggleAction($id)
    {
        $media = $this->getDoctrine()->getRepository('WebsiteBundle:Media')->find($id);
        $media->setActive( !$media->getActive() );
        $em = $this->getDoctrine()->getManager();
        $em->persist($media);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_media_index'));
    }//toggleAction


}//MediaController
