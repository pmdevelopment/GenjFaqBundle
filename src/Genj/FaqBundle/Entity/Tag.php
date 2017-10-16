<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 16.10.2017
 * Time: 14:33
 */

namespace Genj\FaqBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Tag
 *
 * @ORM\MappedSuperclass
 * @ORM\Entity(repositoryClass="Genj\FaqBundle\Entity\TagRepository")
 * @ORM\Table(name="genj_faq_tag")
 *
 * @package Genj\FaqBundle\Entity
 */
class Tag
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     * @ORM\Column(type="string", length=100, unique=true)
     */
    protected $slug;

    /**
     * @var Question
     *
     * @ORM\ManyToMany(targetEntity="Genj\FaqBundle\Entity\Question", inversedBy="tags")
     * @ORM\JoinTable(name="genj_faq_tag_question_mapping")
     */
    protected $questions;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     *
     * @return Tag
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

}