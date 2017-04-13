<?php

namespace SiteBundle\Controller;

use SiteBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SiteController extends Controller
{
    public function indexAction()
    {
        $me = $this->getUser();
        $photos = $this->getDoctrine()
            ->getRepository('SiteBundle:Photo')
            ->findAll();

        return $this->render('SiteBundle:Site:index.html.twig', array(
            "photos" =>$photos,
            "me" => $me
            ));
    }
}
