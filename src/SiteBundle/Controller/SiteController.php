<?php

namespace SiteBundle\Controller;

use SiteBundle\Entity\Photo;
use SiteBundle\Entity\Appareil;
use SiteBundle\Form\AppareilType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SiteController extends Controller
{
    public function indexAction()
    {
        $me = $this->getUser();
        $photos = $this->getDoctrine()
            ->getRepository('SiteBundle:Photo')
            ->findBy(array(), array('publishedAt' => 'desc'));

        $table = [1,2,3,4,5];

        return $this->render('SiteBundle:Site:index.html.twig', array(
            "photos" =>$photos,
            "me" => $me
            ));
    }

    public function newAppareilAction (Request $request)
    {
        $appareil= new Appareil();
        $form = $this->createForm(AppareilType::class, $appareil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appareil->setLibelle($form->get('libelle')->getData());
            $appareil->setMarque($form->get('marque')->getData());
            $appareil->setPrix($form->get('prix')->getData());
            $appareil->setAuteur($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($appareil);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('SiteBundle:Appareil:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function deleteAppareilAction($id) {
        $suppression = false;

        $appareil = $this->getDoctrine()
            ->getRepository('SiteBundle:Appareil')
            ->findOneBy(array('id'=>$id));

        if ($appareil->getAuteur() == $this->getUser()){


            $em = $this->getDoctrine()->getManager();
            $em->remove($appareil);
            $em->flush();
            $suppression = true;
        }

        return $this->render('SiteBundle:Appareil:suppression.html.twig', array(
            "supression" => $suppression,
        ));

    }
}
