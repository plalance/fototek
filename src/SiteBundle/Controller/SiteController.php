<?php

namespace SiteBundle\Controller;

use SiteBundle\Entity\Objectif;
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

            return $this->redirectToRoute('my_stuff');
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

    public function myStuffAction()
    {
        $me = $this->getUser();
        $appareils = $me->getAppareils();
        $lens = $me->getObjectifs();
        return $this->render('SiteBundle:Materiel:list.html.twig', array(
            "appareils"=>$appareils,
            "lens"=>$lens
        ));

    }

    public function newLensAction (Request $request)
    {
        $lens= new Objectif();
        $form = $this->createForm(AppareilType::class, $lens);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lens->setLibelle($form->get('libelle')->getData());
            $lens->setMarque($form->get('marque')->getData());
            $lens->setPrix($form->get('prix')->getData());
            $lens->setAuteur($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($lens);
            $em->flush();

            return $this->redirectToRoute('my_stuff');
        }

        return $this->render('SiteBundle:Objectif:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function deleteLensAction($id) {
        $suppression = false;

        $lens = $this->getDoctrine()
            ->getRepository('SiteBundle:Objectif')
            ->findOneBy(array('id'=>$id));

        if ($lens->getAuteur() == $this->getUser()){


            $em = $this->getDoctrine()->getManager();
            $em->remove($lens);
            $em->flush();
            $suppression = true;
        }

        return $this->render('SiteBundle:Objectif:suppression.html.twig', array(
            "supression" => $suppression,
        ));

    }

    public function debugPhotoAction($id){
        $me = $this->getUser();

        $photo = $this->getDoctrine()
            ->getRepository('SiteBundle:Photo')
            ->findOneBy(array('id'=>$id));
        $appareil = $this->getDoctrine()
            ->getRepository('SiteBundle:Appareil')
            ->findOneBy(array('id'=>2));

        return $this->render('SiteBundle:Site:debug.html.twig', array(
            "debug" => $photo,
            "appareil" => $appareil,
            "me" => $me
        ));
    }
}
