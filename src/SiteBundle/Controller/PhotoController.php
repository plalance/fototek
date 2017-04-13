<?php

namespace SiteBundle\Controller;

use SiteBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SiteBundle\Form\PhotoType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\MimeType;

class PhotoController extends Controller
{
    public function myPhotosAction()
    {
        return $this->render('SiteBundle:Photo:my-photos.html.twig', array(
        ));
    }

    public function newPhotoAction(Request $request)
    {
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $photo->getFichier();
            $ext = $file->getClientOriginalExtension();
            $fileName = md5(uniqid()).'.'.$ext;
            $file->move(
                $this->getParameter('photos_directory'),
                $fileName
            );

            $photo->setPublishedAt(date_create());
            $photo->setUpdatedAt(date_create());
            $photo->setFichier($fileName);
            $photo->setExtension($ext);
            $photo->setTitre($form->get('titre')->getData());
            $photo->setDescription($form->get('description')->getData());
            $photo->setDate($form->get('date')->getData());
            $photo->setAuteur($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('SiteBundle:Photo:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function onePhotoAction($id){

        $photo = $this->getDoctrine()
            ->getRepository('SiteBundle:Photo')
            ->findOneBy(array('id'=>$id));

        return $this->render('SiteBundle:Photo:one.html.twig', array(
            'photo' => $photo,
        ));
    }
}
