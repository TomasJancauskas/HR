<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="employees")
 */
class Employee
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(length=64, nullable=false)
     * @Assert\NotBlank(message="First Name cannot be empty")
     */
    private $firstname;

    /**
     * @ORM\Column(length=64, nullable=false)
     * @Assert\NotBlank(message="Last name cannot be empty")
     */
    private $lastname;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Location", inversedBy="employees", cascade={"persist"})
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Job", cascade={"persist"})
     */
    private $job;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $joinedAt;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vacation", mappedBy="employee", cascade={"remove", "persist"})
     */
    private $vacations;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Employee
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Employee
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return Employee
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set joinedAt
     *
     * @param \DateTime $joinedAt
     *
     * @return Employee
     */
    public function setJoinedAt($joinedAt)
    {
        $this->joinedAt = $joinedAt;

        return $this;
    }

    /**
     * Get joinedAt
     *
     * @return \DateTime
     */
    public function getJoinedAt()
    {
        return $this->joinedAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Employee
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Employee
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

    public function getFullname()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getRemainingVacationdays()
    {
        /** @var \DateInterval $diff */
        $diff = $this->joinedAt->diff(new \DateTime());
        $months = $diff->m + 12*$diff->y;
        $total = floor($months*28/12);
        $remaining = $total - $this->getUsedVacationDays();
        return $remaining;
    }

    public function getUsedVacationDays()
    {
        $total = 0;
        /** @var Vacation $vacation */
        foreach ($this->vacations as $vacation) {
            $total += $vacation->getStartsAt()->diff($vacation->getEndsAt())->d;
        }

        return $total;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vacations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set location
     *
     * @param \AppBundle\Entity\Location $location
     *
     * @return Employee
     */
    public function setLocation(\AppBundle\Entity\Location $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \AppBundle\Entity\Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Add vacation
     *
     * @param \AppBundle\Entity\Vacation $vacation
     *
     * @return Employee
     */
    public function addVacation(\AppBundle\Entity\Vacation $vacation)
    {
        $this->vacations[] = $vacation;

        return $this;
    }

    /**
     * Remove vacation
     *
     * @param \AppBundle\Entity\Vacation $vacation
     */
    public function removeVacation(\AppBundle\Entity\Vacation $vacation)
    {
        $this->vacations->removeElement($vacation);
    }

    /**
     * Get vacations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVacations()
    {
        return $this->vacations;
    }

    /**
     * Set job
     *
     * @param \AppBundle\Entity\Job $job
     *
     * @return Employee
     */
    public function setJob(\AppBundle\Entity\Job $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return \AppBundle\Entity\Job
     */
    public function getJob()
    {
        return $this->job;
    }
}
