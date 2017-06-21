<?php

namespace SiteBundle\Controller;

use Doctrine\ORM\Query\ResultSetMapping;
use SiteBundle\Entity\Auteur;
use SiteBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SiteBundle\Form\PhotoType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\MimeType;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AjaxController extends Controller
{
    public function createAction(Request $request)
    {
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo, array("autor" => $this->getUser()));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $file = $photo->getFichier();
            $ext = $file->getClientOriginalExtension();
            $fileName = md5(uniqid()) . '.' . $ext;
            $destination = $this->getParameter('photos_directory') . "/" . $fileName;
            $d = $this->compress($file, $destination, 68);

            $photo->setPublishedAt(date_create());
            $photo->setUpdatedAt(date_create());
            $photo->setFichier($fileName);
            $photo->setBlobFile(file_get_contents($destination));
            $photo->setExtension($ext);
            $photo->setTitre($form->get('titre')->getData());
            $photo->setDescription($form->get('description')->getData());
            $photo->setDate($form->get('date')->getData());
            $photo->setAuteur($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                return new JsonResponse(array('message' => 'Success!', 'success' => true, 'code' => 200), 200);
            }

            if ($request->isMethod('POST')) {
                return new JsonResponse(array('message' => 'Invalid form', 'success' => false), 400);
            }
        }

        return $this->render('SiteBundle:Photo:ajax_add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function compress($source, $destination, $quality) {

        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);

        imagejpeg($image, $destination, $quality);

        return $destination;
    }
}
