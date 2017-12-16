<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adventure
 *
 * @ORM\Table(name="adventure")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdventureRepository")
 */
class Adventure
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="imageurl", type="string", length=255)
     */
    private $imageurl;
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
     * Set title
     *
     * @param string $title
     *
     * @return Adventure
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * Set description
     *
     * @param string $description
     *
     * @return Adventure
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
     * Set imageurl
     *
     * @param string $imageurl
     *
     * @return Adventure
     */
    public function setImageurl($imageurl)
    {
        $this->imageurl = $imageurl;
        return $this;
    }
    /**
     * Get imageurl
     *
     * @return string
     */
    public function getImageurl()
    {
        return $this->imageurl;
    }
}

