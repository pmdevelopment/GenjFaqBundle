<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 18.10.2017
 * Time: 12:15
 */

namespace Genj\FaqBundle\Component\Model;

use Genj\FaqBundle\Entity\Category;
use Genj\FaqBundle\Entity\Question;
use Genj\FaqBundle\Entity\Tag;
use JMS\Serializer\Annotation as JMS;

/**
 * Class ExportModel
 *
 * @package Genj\FaqBundle\Component\Model
 */
class ExportModel
{

    /**
     * @var Category[]
     *
     * @JMS\Type("array<Genj\FaqBundle\Entity\Category>")
     */
    private $categories;

    /**
     * @var Question[]
     *
     * @JMS\Type("array<Genj\FaqBundle\Entity\Question>")
     */
    private $questions;

    /**
     * @var Tag[]
     *
     * @JMS\Type("array<Genj\FaqBundle\Entity\Tag>")
     */
    private $tags;

    /**
     * @return Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag[] $tags
     *
     * @return ExportModel
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Category[] $categories
     *
     * @return ExportModel
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return Question[]
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param Question[] $questions
     *
     * @return ExportModel
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;

        return $this;
    }

}