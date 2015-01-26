<?php

namespace Genj\ShortUrlBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class ShortUrlRepository
 *
 * @package Genj\ShortUrlBundle\Entity
 */
class ShortUrlRepository extends EntityRepository
{
    /**
     * @param string $source
     *
     * @return ShortUrl|null
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function retrievePublicBySource($source)
    {
        $query = $this->createQueryBuilder('s')
            ->where('s.source = :source')
            ->andWhere('s.publishAt <= :publishAt')
            ->andWhere('(s.expiresAt IS NULL OR s.expiresAt >= :expiresAt)');

        $query = $query->getQuery();

        $query->setParameter('source', $source);
        $query->setParameter('publishAt', date('Y-m-d H:i:s'));
        $query->setParameter('expiresAt', date('Y-m-d H:i:s'));

        return $query->getOneOrNullResult();
    }
}
