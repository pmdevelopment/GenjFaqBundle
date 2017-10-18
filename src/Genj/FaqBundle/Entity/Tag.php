<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 16.10.2017
 * Time: 14:33
 */

namespace Genj\FaqBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Tag
 *
 * @ORM\MappedSuperclass
 * @ORM\Entity(repositoryClass="Genj\FaqBundle\Entity\TagRepository")
 * @ORM\Table(name="genj_faq_tag")
 *
 * @package Genj\FaqBundle\Entity
 *
 * @JMS\ExclusionPolicy("ALL")
 */
class Tag
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose()
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @JMS\Expose()
     */
    protected $name;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     * @ORM\Column(type="string", length=100, unique=true)
     *
     * @JMS\Expose()
     */
    protected $slug;

    /**
     * @var Question[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Genj\FaqBundle\Entity\Question", inversedBy="tags")
     * @ORM\JoinTable(name="genj_faq_tag_question_mapping")
     *
     * @JMS\Type("array<string>")
     * @JMS\Expose()
     * @JMS\Accessor(getter="getQuestionSlugs", setter="setQuestions")
     */
    protected $questions;

    /**
     * Tag constructor.
     */
    public function __construct()
    {
        $this->setQuestions(new ArrayCollection());
    }

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

    /**
     * @return Question[]|ArrayCollection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param Question[]|ArrayCollection $questions
     *
     * @return Tag
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;

        return $this;
    }

    /**
     * Questions Ids
     *
     * @return array
     */
    public function getQuestionSlugs()
    {
        $ids = [];
        foreach ($this->getQuestions() as $question) {
            $ids[] = $question->getSlug();
        }

        return $ids;
    }

}