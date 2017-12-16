<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gallery
 *
 * @ORM\Table(name="gallery")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GalleryRepository")
 */
class Gallery
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title_name", type="string", length=255)
     */
    private $titleName;


    /**
     * @var int
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Images", mappedBy="gallery",cascade={"all"},orphanRemoval=true)
     */
    private $image;
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
     * Constructor
     */
    public function __construct()
    {
        $this->image = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set titleName
     *
     * @param string $titleName
     *
     * @return Gallery
     */
    public function setTitleName($titleName)
    {
        $this->titleName = $titleName;

        return $this;
    }

    /**
     * Get titleName
     *
     * @return string
     */
    public function getTitleName()
    {
        return $this->titleName;
    }

    /**
     * Add image
     *
     * @param \AppBundle\Entity\Images $image
     *
     * @return Gallery
     */
    public function addImage(\AppBundle\Entity\Images $image)
    {
        $this->image[] = $image;
        $image->setGallery($this);
        return $this;
    }

    /**
     * Remove image
     *
     * @param \AppBundle\Entity\Images $image
     */
    public function removeImage(\AppBundle\Entity\Images $image)
    {
        $this->image->removeElement($image);
    }

    /**
     * Get image
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImage()
    {
        return $this->image;
    }
}
