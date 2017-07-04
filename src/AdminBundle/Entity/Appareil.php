<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Appareil
 *
 * @ORM\Table(name="appareil")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\AppareilRepository")
 */
class Appareil
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_appareil", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=255)
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer")
     */
    private $prix;

    /**
     * Plusieurs appareils sont au même auteur
     * @ORM\ManyToOne(targetEntity="Auteur", inversedBy="appareils")
     * @ORM\JoinColumn(name="id_auteur", referencedColumnName="id_auteur")
     */
    private $auteur;

    /**
     * Un appareil possède plusieurs photos
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="appareil")
     */
    private $lesPhotosPrises;

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
     * Appareil constructor.
     */
    public function __construct()
    {
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
     * @return mixed
     */
    public function getLesPhotosPrises()
    {
        return $this->lesPhotosPrises;
    }

    /**
     * @param mixed $lesPhotosPrises
     */
    public function setLesPhotosPrises($lesPhotosPrises)
    {
        $this->lesPhotosPrises = $lesPhotosPrises;
    }

    /**
     * Set marque
     *
     * @param string $marque
     *
     * @return Appareil
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return string
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Appareil
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set prix
     *
     * @param integer $prix
     *
     * @return Appareil
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    public function __toString() {
        return $this->libelle;
    }

}

