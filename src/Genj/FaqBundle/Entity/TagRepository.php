<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 16.10.2017
 * Time: 14:33
 */

namespace Genj\FaqBundle\Entity;

use Doctrine\ORM\EntityRepository;


/**
 * Class TagRepository
 *
 * @package Genj\FaqBundle\Entity
 */
class TagRepository extends EntityRepository
{
    /**
     * Find One By Name
     *
     * @param string $name
     *
     * @return null|Tag
     */
    public function findOneByName($name)
    {
        return $this->findOneBy(
            [
                'name' => $name,
            ]
        );
    }

    /**
     * Find One By Name
     *
     * @param string $slug
     *
     * @return null|Tag
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