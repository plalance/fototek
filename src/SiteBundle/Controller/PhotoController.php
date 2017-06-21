<?php

namespace SiteBundle\Controller;

use Doctrine\ORM\Query\ResultSetMapping;
use SiteBundle\Entity\Auteur;
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
        $photos = $this->getUser()->getPhotos();
//        $autorId = $this->getUser()->getId();
//
//        $fileLoader = $this->container->getParameter('file_loader');
//
//        $photos = array();
//
//        $connection = $this->getDoctrine()->getManager()->getConnection();
//        $statement = $connection->prepare("SELECT * FROM getphotos()");
////        $statement->bindValue('idd', $autorId);
//        $statement->execute();
//
//        while ($row = $statement->fetch()) {
//            $obj = json_decode($row['getphotos']);
//            dump($obj);
//            $photo = new Photo();
//            $photo->setTitre($obj.titre);
//            $photo->setDescription($obj.descritpion);
//            $photo->setDate($obj.date);
//            $photo->setPublishedAt($obj.publishedat);
//            $photo->setUpdatedAt($obj.updatedat);
//            switch ($fileLoader){
//                case 'BLOB':
//                    $photo->setBlobFile($obj);
//                    break;
//                case 'FILE':
//                    break;
//            }
//        }
//        dump($var);
//        die;
        return $this->render('SiteBundle:Photo:my-photos.html.twig', array(
            "photos" => $photos,
        ));
    }

    public function newPhotoAction(Request $request)
    {
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo, array("autor" => $this->getUser()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $photo->getFichier();
            $ext = $file->getClientOriginalExtension();
            $fileName = md5(uniqid()).'.'.$ext;
//            $file->move(
//                $this->getParameter('photos_directory'),
//                $fileName
//            );
            $destination = $this->getParameter('photos_directory')."/".$fileName;
            $d = $this->compress($file, $destination, 68);

            $photo->setPublishedAt(date_create());
            $photo->setUpdatedAt(date_create());
            $photo->setFichier($fileName);
//            $photo->setBlobFile(file_get_contents($destination));
            $photo->setExtension($ext);
            $photo->setTitre($form->get('titre')->getData());
            $photo->setDescription($form->get('description')->getData());
            $photo->setDate($form->get('date')->getData());
            $photo->setAuteur($this->getUser());
            $photo->setTags($form->get('tags')->getData());

//            dump($photo);
//            die;

            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();
//
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

    public function deletePhotoAction($id){

        $suppression = false;

        $photo = $this->getDoctrine()
            ->getRepository('SiteBundle:Photo')
            ->findOneBy(array('id'=>$id));

        if ($photo->getAuteur() == $this->getUser()){

            unlink($this->getParameter('photos_directory')."/".$photo->getFichier());

            $em = $this->getDoctrine()->getManager();
            $em->remove($photo);
            $em->flush();
            $suppression = true;
        }

        return $this->render('SiteBundle:Photo:suppression.html.twig', array(
            "supression" => $suppression,
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
