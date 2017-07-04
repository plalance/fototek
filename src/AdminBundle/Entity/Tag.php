<?php

namespace AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\TagRepository")
 */
class Tag
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_tag", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label_tag", type="string", length=255)
     */
    private $label;


//    /**
//     * Owning Side
//     *
//     * @ORM\ManyToMany(targetEntity="Photo", inversedBy="tags")
//     * @ORM\JoinTable(name="tags_photos",
//     *      joinColumns={@ORM\JoinColumn(name="id_tag", referencedColumnName="id_tag")},
//     *      inverseJoinColumns={@ORM\JoinColumn(name="id_photo", referencedColumnName="id_photo")}
//     *      )
//     */
//    private $photos;


    /**
     * Many Tags have Many photos.
     * @ORM\ManyToMany(targetEntity="Photo", mappedBy="tags")
     */
    private $photos;


    /**
     * Tag constructor.
     */
    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->label;
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
     * Set label
     *
     * @param string $label
     *
     * @return Tag
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }




    /**
     * Get associated photos
     *
     * @return ArrayCollection
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Add Photo to this Tag
     *
     * @return Tag
     */
    public function addPhoto(Photo $photo)
    {
        $this->photos[] = $photo;
        return $this;
    }

    /**
     * Add Photos to this Attachment
     *
     * @param ArrayCollection
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }
}

