<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Location;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;

class LocationToTextTransformer implements DataTransformerInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Transforms an object to a string.
     *
     * @param  Location|null $location
     * @return string
     */
    public function transform($location)
    {
        return $location;
    }

    /**
     * Transforms a string to an object.
     *
     * @param  string $locationText
     * @return Location
     */
    public function reverseTransform($locationText)
    {
         $location = $this->em
            ->getRepository('AppBundle:Location')
            // query for the issue with this id
            ->findOneByTitle($locationText);

        if (null === $location) {
            $location = new Location();
            $location->setTitle($locationText);
        }

        return $location;
    }
}