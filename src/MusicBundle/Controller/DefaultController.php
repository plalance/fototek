<?php

namespace MusicBundle\Controller;

use MusicBundle\Entity\Sound;
use MusicBundle\Form\SoundType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {

        $me = $this->getUser();
        $sons = $this->getDoctrine()
            ->getRepository('MusicBundle:Sound')
            ->findBy(array(), array('date' => 'desc'));

        return $this->render('MusicBundle:Default:index.html.twig',array(
            "sons" => $sons,
            "me" => $me
        ));
    }

    public function newSoundAction(Request $request)
    {
        $sound = new Sound();
        $form = $this->createForm(SoundType::class, $sound);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $sound->getFile();
            $ext = $file->getClientOriginalExtension();
            $fileName = md5(uniqid()).'.'.$ext;
            $file->move(
                $this->getParameter('sound_directory'),
                $fileName
            );

            $sound->setFile($fileName);
            $sound->setName($form->get('name')->getData());
            $sound->setDate(date_create());
            $sound->setAuteur($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($sound);
            $em->flush();

            return $this->redirectToRoute('music_home');
        }

        return $this->render('MusicBundle:Sound:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
