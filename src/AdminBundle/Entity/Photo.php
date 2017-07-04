<?php

namespace AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Photo
 *
 * @ORM\Table(name="photo")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_photo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publishedAt", type="datetime")
     */
    private $publishedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="fichier", type="text")
     */
    private $fichier;

    /**
     * @ORM\Column(name="fichier_blob", type="blob", nullable=true)
     */
    private $blobFile;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=255)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="coordonnees", type="string", length=255, nullable=true)
     */
    private $coordonnees;

    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer", nullable=true)
     */
    private $note;

    /**
     * @var int
     *
     * @ORM\Column(name="statut", type="integer")
     */
    private $statut;

    /**
     * Plusieurs photos sont au même auteur
     * @ORM\ManyToOne(targetEntity="Auteur", inversedBy="photos")
     * @ORM\JoinColumn(name="id_auteur", referencedColumnName="id_auteur")
     */
    private $auteur;

//    /**
//     * Inverse Side
//     *
//     * @ORM\ManyToMany(targetEntity="Tag", mappedBy="photos")
//     */
//    private $tags;

//    /**
//     * @ORM\ManyToMany(targetEntity="Categories", inversedBy="Blog", cascade={"persist"})
//     * @ORM\JoinTable(name="wc_posts_categories",
//     *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
//     *      inverseJoinColumns={@ORM\JoinColumn(name="categories_id", referencedColumnName="id")}
//     *      )
//     */

    /**
     * Many Photos have Many Tags.
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="photos")
     * @ORM\JoinTable(name="liaison_photo_tag",
         *      joinColumns={@ORM\JoinColumn(name="id_photo", referencedColumnName="id_photo")},
         *      inverseJoinColumns={@ORM\JoinColumn(name="id_tag", referencedColumnName="id_tag")}
         *      )
     */
    private $tags;

    /**
     * Plusieurs photos sont au même appareil
     * @ORM\ManyToOne(targetEntity="Appareil", inversedBy="lesPhotosPrises")
     * @ORM\JoinColumn(name="id_appareil", referencedColumnName="id_appareil")
     */
    private $appareil;


    /**
     * Plusieurs objectifs sont au même appareil
     * @ORM\ManyToOne(targetEntity="Objectif", inversedBy="lesPhotosPrises")
     * @ORM\JoinColumn(name="id_objectif", referencedColumnName="id_objectif")
     */
    private $objectif;


    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Photo
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set publishedAt
     *
     * @param \DateTime $publishedAt
     *
     * @return Photo
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Get publishedAt
     *
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Photo
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Photo
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set extension
     *
     * @param string $extension
     *
     * @return Photo
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set coordonnees
     *
     * @param string $coordonnees
     *
     * @return Photo
     */
    public function setCoordonnees($coordonnees)
    {
        $this->coordonnees = $coordonnees;

        return $this;
    }

    /**
     * Get coordonnees
     *
     * @return string
     */
    public function getCoordonnees()
    {
        return $this->coordonnees;
    }

    /**
     * Set note
     *
     * @param integer $note
     *
     * @return Photo
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @return int
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param int $statut
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    }

    /**
     * @return mixed
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * @param mixed $auteur
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getAppareil()
    {
        return $this->appareil;
    }

    /**
     * @param mixed $appareil
     */
    public function setAppareil($appareil)
    {
        $this->appareil = $appareil;
    }

    /**
     * @return mixed
     */
    public function getObjectif()
    {
        return $this->objectif;
    }

    /**
     * @param mixed $objectif
     */
    public function setObjectif($objectif)
    {
        $this->objectif = $objectif;
    }


    /**
     * @return string
     */
    public function getFichier()
    {
        return $this->fichier;
    }

    /**
     * @param string $fichier
     */
    public function setFichier($fichier)
    {
        $this->fichier = $fichier;
    }

    /**
     * @return mixed
     */
    public function getBlobFile()
    {
        return $this->blobFile;
    }

    /**
     * @param mixed $blobFile
     */
    public function setBlobFile($blobFile)
    {
        $this->blobFile = $blobFile;
    }

    public function getBlobFileRaw()
    {
        return base64_encode(stream_get_contents($this->blobFile));
    }

    /**
     * Add an Tag
     *
     * @param ArrayCollection $tags
     * @return Photo
     */
    public function setTags(ArrayCollection $tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * Add an Attachment
     *
     * @param Tag $tag
     * @return Photo
     */
    public function addTag(Tag $tag)
    {
        $tag->addPhoto($this); // synchronously updating inverse side
        $this->tags[] = $tag;
        return $this;
    }

    public function getTags()
    {
        return $this->tags;
    }
}

