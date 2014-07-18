<?php

namespace Melt\AdminBundle\Controller;

use Melt\WebsiteBundle\Entity\Media;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/admin/media")
 */
class MediaController extends Controller
{
    /**
     * @Route("/", name="admin_media_index")
     * @Cache(expires="+2 days", public="true")
     * @Template()
     */
    public function indexAction()
    {
        $media = $this->getDoctrine()->getRepository('WebsiteBundle:Media')->findByActive(1);

        return array(
            'media' => $media
        );
    }//indexAction

    /**
     * @Route("/edit/{id}", name="admin_media_edit", defaults={"id":null})
     * @Cache(expires="+2 days", public="true")
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
                     ->add('title'   , 'text')
                     ->add('link'    , 'text')
                     ->add('author'  , 'text')
                     ->add('created' , 'text')
                     ->add('save'    , 'submit')
                     ->getForm();

        //print '<pre>'; print_r($media);
        //die;

        return array(
            'form'  => $form->createView(),
            'media' => $media
        );
    }//indexAction
}
