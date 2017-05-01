<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use FOS\UserBundle\Model\User as BaseUser;

/**
 * Auteur
 *
 * @ORM\Table(name="auteur")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\AuteurRepository")
 */

class Auteur extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_auteur", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer", nullable=true)
     */
    protected $note;


    /**
     * Un auteur possède plusieurs photos
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="auteur")
     */
    protected $photos;

    /**
 * Un auteur possède plusieurs appareils
 * @ORM\OneToMany(targetEntity="Appareil", mappedBy="auteur")
 */
    protected $appareils;

    /**
     * Un auteur possède plusieurs objectifs
     * @ORM\OneToMany(targetEntity="Objectif", mappedBy="auteur")
     */
    protected $objectifs;

    /**
     * @return mixed
     */
    public function getObjectifs()
    {
        return $this->objectifs;
    }

    /**
     * @param mixed $objectifs
     */
    public function setObjectifs($objectifs)
    {
        $this->objectifs = $objectifs;
    }

    /**
     * @return mixed
     */
    public function getAppareils()
    {
        return $this->appareils;
    }

    /**
     * @param mixed $appareils
     */
    public function setAppareils($appareils)
    {
        $this->appareils = $appareils;
    }

    /**
     * Un auteur possède plusieurs sons
     * @ORM\OneToMany(targetEntity="MusicBundle\Entity\Sound", mappedBy="auteur")
     */
    protected $sounds;


    public function __construct()
    {
        parent::__construct();

    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param int $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @param mixed $photos
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }

    /**
     * @return mixed
     */
    public function getSounds()
    {
        return $this->sounds;
    }

    /**
     * @param mixed $sounds
     */
    public function setSounds($sounds)
    {
        $this->sounds = $sounds;
    }

}

