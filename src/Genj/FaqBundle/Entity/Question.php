<?php

namespace Genj\FaqBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Question
 *
 * @ORM\MappedSuperclass
 * @ORM\Entity(repositoryClass="Genj\FaqBundle\Entity\QuestionRepository")
 * @ORM\Table(name="genj_faq_question")
 *
 * @ORM\HasLifecycleCallbacks()
 *
 * @JMS\ExclusionPolicy("ALL")
 *
 * @package Genj\FaqBundle\Entity
 */
class Question
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
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="questions")
     * @ORM\OrderBy({"rank" = "asc"})
     *
     * @JMS\Type("integer")
     * @JMS\Expose()
     * @JMS\Accessor(getter="getCategoryId", setter="setCategory")
     */
    protected $category;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @JMS\Expose()
     */
    protected $headline;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @JMS\Expose()
     */
    protected $body;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     *
     * @JMS\Expose()
     */
    protected $rank;

    /**
     * @ORM\Column(type="boolean", name="is_active")
     *
     * @JMS\Expose()
     */
    protected $isActive;

    /**
     * @ORM\Column( type="datetime", name="publish_at")
     *
     * @JMS\Expose()
     */
    protected $publishAt;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="expires_at")
     *
     * @JMS\Expose()
     */
    protected $expiresAt;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
     *
     * @JMS\Expose()
     */
    protected $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="updated_at")
     *
     * @JMS\Expose()
     */
    protected $updatedAt;

    /**
     * @Gedmo\Slug(fields={"headline"}, updatable=false)
     * @ORM\Column(type="string", length=100, unique=true)
     *
     * @JMS\Expose()
     */
    protected $slug;

    /**
     * @var Tag[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Genj\FaqBundle\Entity\Tag", mappedBy="questions")
     */
    protected $tags;

    /**
     * Question constructor.
     */
    public function __construct()
    {
        $this
            ->setCreatedAt(new \DateTime())
            ->setPublishAt(new \DateTime());

        $this->setTags(new ArrayCollection());
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
     * @return Question
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
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
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
     * @return Question
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Question
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return string
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set publishAt
     *
     * @param \DateTime $publishAt
     *
     * @return Question
     */
    public function setPublishAt($publishAt)
    {
        $this->publishAt = $publishAt;

        return $this;
    }

    /**
     * Get publishAt
     *
     * @return \DateTime
     */
    public function getPublishAt()
    {
        return $this->publishAt;
    }

    /**
     * Set expiresAt
     *
     * @param \DateTime $expiresAt
     *
     * @return Question
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * Get expiresAt
     *
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Question
     */
    public function setCreatedAt($createdAt)
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
     * @return Question
     */
    public function setUpdatedAt($updatedAt)
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
     * @return Question
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
     * Set category
     *
     * @param Category $category
     *
     * @return Question
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return ArrayCollection|Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param ArrayCollection|Tag[] $tags
     *
     * @return Question
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
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
     * Is visible for user?
     *
     * @return boolean
     */
    public function isPublic()
    {
        if ($this->getIsActive() && ($this->getPublishAt()->getTimestamp() < time()) && (!$this->getExpiresAt() || $this->getExpiresAt()->getTimestamp() > time())) {
            return true;
        }

        return false;
    }

    /**
     * Returns the route name for url generation
     *
     * @return string
     */
    public function getRouteName()
    {
        return 'genj_faq_question_show';
    }

    /**
     * Returns the route parameters for url generation
     *
     * @return array
     */
    public function getRouteParameters()
    {
        return array(
            'categorySlug' => $this->getCategory()->getSlug(),
            'slug'         => $this->getSlug()
        );
    }

    /**
     * Returns a string representation of the entity build out of BundleName + EntityName + EntityId
     *
     * @return string
     */
    public function getEntityIdentifier()
    {
        return 'GenjFaqBundle:Question:' . $this->getId();
    }

    /**
     * Get Category Id
     *
     * @return int
     */
    public function getCategoryId()
    {
        return $this->getCategory()->getId();
    }

    /**
     * @ORM\PreFlush()
     */
    public function preFlush()
    {
        $this->setUpdatedAt(new \DateTime());
    }
}
