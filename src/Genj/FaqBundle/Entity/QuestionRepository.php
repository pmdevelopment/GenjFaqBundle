<?php

namespace Genj\FaqBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class QuestionRepository
 *
 * @package Genj\FaqBundle\Entity
 */
class QuestionRepository extends EntityRepository
{
    /**
     * @param string $categorySlug
     *
     * @return Question|null
     */
    public function retrieveFirstByCategorySlug($categorySlug)
    {
        $query = $this->createQueryBuilder('q')
                      ->join('q.category', 'c')
                      ->where('c.slug = :categorySlug')
                      ->andWhere('q.isActive = :isActive')
                      ->andWhere('q.publishAt <= :publishAt')
                      ->andWhere('(q.expiresAt IS NULL OR q.expiresAt >= :expiresAt)')
                      ->orderBy('q.rank', 'ASC')
                      ->setMaxResults(1)
                      ->getQuery();

        $query->setParameter('categorySlug', $categorySlug);
        $query->setParameter('isActive', true);
        $query->setParameter('publishAt', date('Y-m-d H:i:s'));
        $query->setParameter('expiresAt', date('Y-m-d H:i:s'));

        return $query->getOneOrNullResult();
    }

    /**
     * @param int $max
     *
     * @return DoctrineCollection|null
     */
    public function retrieveMostRecent($max)
    {
        $query = $this->createQueryBuilder('q')
                      ->join('q.category', 'c')
                      ->where('q.isActive = :isActive')
                      ->andWhere('q.publishAt <= :publishAt')
                      ->andWhere('(q.expiresAt IS NULL OR q.expiresAt >= :expiresAt)')
                      ->orderBy('q.publishAt', 'DESC')
                      ->setMaxResults($max)
                      ->getQuery();

        $query->setParameter('isActive', true);
        $query->setParameter('publishAt', date('Y-m-d H:i:s'));
        $query->setParameter('expiresAt', date('Y-m-d H:i:s'));

        return $query->getResult();
    }

    /**
     * @param string $searchQuery
     * @param int    $max
     * @param array  $whereFields
     *
     * @return array|null
     */
    public function retrieveByQuery($searchQuery, $max, $whereFields = array(
        'headline',
        'body'
    ))
    {
        $sql = array();
        foreach ($whereFields as $field) {
            $sql[] = 'q.' . $field . ' like :searchQuery';
        }

        $where = implode(' or ', $sql);

        $query = $this->createQueryBuilder('q')
                      ->join('q.category', 'c')
                      ->where($where)
                      ->andWhere('q.isActive = :isActive')
                      ->andWhere('q.publishAt <= :publishAt')
                      ->andWhere('(q.expiresAt IS NULL OR q.expiresAt >= :expiresAt)')
                      ->orderBy('q.publishAt', 'DESC')
                      ->setMaxResults($max)
                      ->getQuery();

        $query->setParameter('searchQuery', '%' . $searchQuery . '%');
        $query->setParameter('isActive', true);
        $query->setParameter('publishAt', date('Y-m-d H:i:s'));
        $query->setParameter('expiresAt', date('Y-m-d H:i:s'));

        return $query->getResult();
    }

    /**
     * @param $slug
     *
     * @return Question|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function retrieveActiveBySlug($slug)
    {
        $query = $this->createQueryBuilder('q')
                      ->join('q.category', 'c')
                      ->where('q.slug = :slug')
                      ->andWhere('q.isActive = :isActive')
                      ->andWhere('q.publishAt <= :publishAt')
                      ->andWhere('(q.expiresAt IS NULL OR q.expiresAt >= :expiresAt)')
                      ->orderBy('q.publishAt', 'DESC')
                      ->setMaxResults(1)
                      ->getQuery();

        $query->setParameter('slug', $slug);
        $query->setParameter('isActive', true);
        $query->setParameter('publishAt', date('Y-m-d H:i:s'));
        $query->setParameter('expiresAt', date('Y-m-d H:i:s'));

        return $query->getOneOrNullResult();
    }

    /**
     * used for autocomplete in admin
     *
     * @param string $query
     *
     * @return array
     */
    public function retrieveByPartialHeadline($query)
    {
        $query = $this->createQueryBuilder('q')
                      ->select('q.id, q.headline')
                      ->where('q.headline LIKE :query')
                      ->orderBy('q.publishAt', 'DESC')
                      ->setParameter('query', '%' . $query . '%')
                      ->getQuery();

        return $query->getArrayResult();
    }

    /**
     * Find One By Slug
     *
     * @param string $slug
     *
     * @return null|Question
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