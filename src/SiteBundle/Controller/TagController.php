<?php

namespace SiteBundle\Controller;

use SiteBundle\Entity\Auteur;
use SiteBundle\Entity\Photo;
use SiteBundle\Entity\Tag;
use SiteBundle\Form\TagType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SiteBundle\Form\PhotoType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\MimeType;

class TagController extends Controller {

    public function listingTagAction(){
        $tags = $this->getDoctrine()
            ->getRepository('SiteBundle:Tag')
            ->findBy(array(),array('label' => 'ASC'));
        return $this->render('SiteBundle:Tag:listing.html.twig', array(
            "tags" => $tags
        ));
    }


    public function newTagAction(Request $request){
        $tag= new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);
        $tagsNotPersisted = array();

        // Verification si ça existe pas déjà en BDD
        if ($form->isSubmitted() && $form->isValid()) {

            // Decompose la chaine
            $listeTags = preg_split('/\s*,\s*/',$form->get('label')->getData());
            foreach ($listeTags as $t){
                $tagVerif = $this->getDoctrine()
                ->getRepository('SiteBundle:Tag')
                ->findOneBy(array("label" => $t));

                if($tagVerif == null) {
                    $tag= new Tag();
                    $tag->setLabel($t);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($tag);
                    $em->flush();
                }else{
                    array_push($tagsNotPersisted,$t);
                }
            }

            if (sizeof($tagsNotPersisted) == 0){
                return $this->redirectToRoute('new_tag');
            }else{
                return $this->render('SiteBundle:Tag:add.html.twig', array(
                    'form' => $form->createView(),
                    'error' => $listeTags,
                    'tagsError' => $tagsNotPersisted
                ));
            }
            
        }
        return $this->render('SiteBundle:Tag:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function deleteTagAction($id){
        $suppression = false;

        $tag = $this->getDoctrine()
            ->getRepository('SiteBundle:Tag')
            ->findOneBy(array('id'=>$id));

            $em = $this->getDoctrine()->getManager();
            $em->remove($tag);
            $em->flush();
            $suppression = true;


        return $this->render('SiteBundle:Tag:suppression.html.twig', array(
            "supression" => $suppression,
        ));
    }
}
