<?php

namespace AppBundle\Repository;

/**
 * AdventureRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PagesRepository extends \Doctrine\ORM\EntityRepository
{
    public function findHomeAboutUsAction(){
        $em = $this->getEntityManager();
        $about = $em->createQuery('SELECT a FROM AppBundle:Pages a WHERE a.id = 1')
        ->getResult()
        ;
        return $about;
    }
}
