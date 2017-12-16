<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Location
 *
 * @ORM\Table(name="location")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LocationRepository")
 */
class Location
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
     * @Assert\NotBlank(message="Please provide Destination Name.")
     * @ORM\Column(name="destinationName", type="string", length=255)
     */
    private $destinationName;

    /**
     * @var int
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Packages", mappedBy="location")
     */
    private $packages;
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
     * Set destinationName
     *
     * @param string $destinationName
     *
     * @return Location
     */
    public function setDestinationName($destinationName)
    {
        $this->destinationName = $destinationName;
        return $this;
    }
    /**
     * Get destinationName
     *
     * @return string
     */
    public function getDestinationName()
    {
        return $this->destinationName;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->packages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add package
     *
     * @param \AppBundle\Entity\Packages $package
     *
     * @return Location
     */
    public function addPackage(\AppBundle\Entity\Packages $package)
    {
        $this->packages[] = $package;

        return $this;
    }

    /**
     * Remove package
     *
     * @param \AppBundle\Entity\Packages $package
     */
    public function removePackage(\AppBundle\Entity\Packages $package)
    {
        $this->packages->removeElement($package);
    }

    /**
     * Get packages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPackages()
    {
        return $this->packages;
    }

    public function __toString()
    {
        return $this->getDestinationName();
    }
}
