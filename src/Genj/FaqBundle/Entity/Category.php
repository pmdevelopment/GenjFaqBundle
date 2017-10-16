<?php

namespace Genj\FaqBundle\Entity;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Category
 *
 * @ORM\MappedSuperclass
 * @ORM\Entity(repositoryClass="Genj\FaqBundle\Entity\CategoryRepository")
 * @ORM\Table(
 *     name="genj_faq_category",
 *     indexes={@ORM\Index(name="is_active_idx", columns={"is_active"})}
 * )
 *
 * @ORM\HasLifecycleCallbacks()
 *
 * @package Genj\FaqBundle\Entity
 */
class Category
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="category")
     */
    protected $questions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $headline;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $body;

    /**
     * @ORM\Column(type="integer")
     */
    protected $rank;

    /**
     * @ORM\Column(type="boolean", name="is_active")
     */
    protected $isActive;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="updated_at")
     */
    protected $updatedAt;

    /**
     * @Gedmo\Slug(fields={"headline"}, updatable=false)
     * @ORM\Column(type="string", length=100, unique=true)
     */
    protected $slug;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set headline
     *
     * @param string $headline
     *
     * @return Category
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;

        return $this;
    }

    /**
     * Get headline
     *
     * @return string
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Question
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get rank
     *
     * @return string
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set rank
     *
     * @param string $rank
     *
     * @return Category
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Set is_active
     *
     * @param boolean $isActive
     *
     * @return Category
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Category
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Category
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add question
     *
     * @param Question $question
     *
     * @return Category
     */
    public function addQuestion(Question $question)
    {
        $this->questions[] = $question;

        return $this;
    }

    /**
     * Remove question
     *
     * @param Question $question
     */
    public function removeQuestion(Question $question)
    {
        $this->questions->removeElement($question);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Get Sorted questions by Rank
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSortedQuestions()
    {
        $criteria = Criteria::create();
        $criteria->orderBy(array('rank' => 'ASC'));

        return $this->getQuestions()->matching($criteria);
    }

    /**
     * Returns a string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getHeadline();
    }

    /**
     * Returns the route name for url generation
     *
     * @return string
     */
    public function getRouteName()
    {
        return 'genj_faq_category_show';
    }

    /**
     * Returns the route parameters for url generation
     *
     * @return array
     */
    public function getRouteParameters()
    {
        return array(
            'slug' => $this->getSlug()
        );
    }

    /**
     * Set UpdatedAt
     *
     * @ORM\PreFlush()
     */
    public function preFlush()
    {
        $this->setUpdatedAt(new \DateTime());
    }

}
