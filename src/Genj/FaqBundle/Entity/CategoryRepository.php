<?php

namespace Genj\FaqBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class CategoryRepository
 *
 * @package Genj\FaqBundle\Entity
 */
class CategoryRepository extends EntityRepository
{
    /**
     * Retrieve Active
     *
     * @return Category[]
     */
    public function retrieveActive()
    {
        $query = $this
            ->retrieveActiveQueryBuilder()
            ->getQuery();

        return $query->execute();
    }

    /**
     * Retrieve Active Query Builder
     *
     * @param string $alias
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function retrieveActiveQueryBuilder($alias = 'category')
    {
        return $this
            ->createQueryBuilder($alias)
            ->where(sprintf('%s.isActive = :isActive', $alias))
            ->orderBy(sprintf('%s.rank', $alias), 'ASC')
            ->setParameter('isActive', true);
    }

    /**
     * @param string $slug
     *
     * @return mixed|Category|null
     */
    public function retrieveActiveBySlug($slug)
    {
        $query = $this->createQueryBuilder('c')
                      ->where('c.isActive = :isActive')
                      ->andWhere('c.slug = :slug')
                      ->orderBy('c.rank', 'ASC')
                      ->setMaxResults(1)
                      ->getQuery();

        $query->setParameter('isActive', true);
        $query->setParameter('slug', $slug);

        return $query->getOneOrNullResult();
    }

    /**
     * @return Category|null
     */
    public function retrieveFirst()
    {
        $query = $this->createQueryBuilder('c')
                      ->where('c.isActive = :isActive')
                      ->orderBy('c.rank', 'ASC')
                      ->setMaxResults(1)
                      ->getQuery();

        $query->setParameter('isActive', true);

        return $query->getOneOrNullResult();
    }

    /**
     * Find One By Slug
     *
     * @param string $slug
     *
     * @return null|Category
     */
    public function findOneBySlug($slug)
    {
        return $this->findOneBy(
            [
                'slug' => $slug,
            ]
        );
    }
}