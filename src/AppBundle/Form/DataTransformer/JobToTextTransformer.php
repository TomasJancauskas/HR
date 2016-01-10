<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Job;
use AppBundle\Entity\Location;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;

class JobToTextTransformer implements DataTransformerInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Transforms an object to a string.
     *
     * @param  Job|null $job
     * @return string
     */
    public function transform($job)
    {
        return $job;
    }

    /**
     * Transforms a string to an object.
     *
     * @param  string $jobText
     * @return Location
     */
    public function reverseTransform($jobText)
    {
        $job = $this->em
            ->getRepository('AppBundle:Job')
            ->findOneByTitle($jobText);

        if (null === $job) {
            $job = new Job();
            $job->setTitle($jobText);
        }

        return $job;
    }
}