<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 18.10.2017
 * Time: 12:02
 */

namespace Genj\FaqBundle\Services;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Collections\ArrayCollection;
use Genj\FaqBundle\Component\Model\ExportModel;
use Genj\FaqBundle\Entity\Category;
use Genj\FaqBundle\Entity\Question;
use Genj\FaqBundle\Entity\Tag;
use JMS\Serializer\Serializer;


/**
 * Class JsonService
 *
 * @package Genj\FaqBundle\Services
 */
class JsonService
{
    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * JsonService constructor.
     *
     * @param Registry   $doctrine
     * @param Serializer $serializer
     */
    public function __construct(Registry $doctrine, Serializer $serializer)
    {
        $this->doctrine = $doctrine;
        $this->serializer = $serializer;
    }


    /**
     * @return Registry
     */
    public function getDoctrine()
    {
        return $this->doctrine;
    }

    /**
     * @return Serializer
     */
    public function getSerializer()
    {
        return $this->serializer;
    }

    /**
     * Export
     *
     * @return string
     */
    public function export()
    {
        $result = new ExportModel();

        $result
            ->setTags($this->getDoctrine()->getRepository(Tag::class)->findAll())
            ->setCategories($this->getDoctrine()->getRepository(Category::class)->findAll())
            ->setQuestions($this->getDoctrine()->getRepository(Question::class)->findAll());

        return $this->getSerializer()->serialize($result, 'json');
    }

    /**
     * Import
     *
     * @param string $json
     *
     * @return bool
     */
    public function import($json)
    {
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);
        $questionRepository = $this->getDoctrine()->getRepository(Question::class);

        /** @var ExportModel $export */
        $export = $this->getSerializer()->deserialize($json, ExportModel::class, 'json');

        /* Categories */
        foreach ($export->getCategories() as $category) {
            $existing = $categoryRepository->findOneBySlug($category->getSlug());
            if (null === $existing) {
                $this->getDoctrine()->getManager()->persist($category);

                continue;
            }

            $this->updateEntity($existing, $category);
        }
        $this->getDoctrine()->getManager()->flush();

        /* Questions */
        foreach ($export->getQuestions() as $question) {
            if (null !== $question->getCategory()) {
                $question->setCategory($categoryRepository->find($question->getCategory()));
            }

            $existing = $questionRepository->findOneBySlug($question->getSlug());
            if (null === $existing) {
                $this->getDoctrine()->getManager()->persist($question);

                continue;
            }

            $this->updateEntity($existing, $question);
        }
        $this->getDoctrine()->getManager()->flush();

        /* Tags */
        foreach ($export->getTags() as $tag) {
            $questions = $tag->getQuestions();
            if (true === is_array($questions) && 0 < count($questions)) {
                $tag->setQuestions(new ArrayCollection());

                foreach ($questions as $questionSlug) {
                    $question = $questionRepository->findOneBySlug($questionSlug);
                    if (null !== $question) {
                        $tag->getQuestions()->add($question);
                    }
                }
            }

            $existing = $this->getDoctrine()->getRepository(Tag::class)->findOneBySlug($tag->getSlug());
            if (null === $existing) {
                $this->getDoctrine()->getManager()->persist($tag);

                continue;
            }

            $existing
                ->setName($tag->getName())
                ->setQuestions($tag->getQuestions());

            $this->getDoctrine()->getManager()->persist($existing);
        }
        $this->getDoctrine()->getManager()->flush();

        return true;
    }

    /**
     * Update Entity
     *
     * @param Question|Category $existing
     * @param Question|Category $new
     */
    private function updateEntity($existing, $new)
    {
        $existing
            ->setIsActive($new->getIsActive())
            ->setBody($new->getBody())
            ->setHeadline($new->getHeadline())
            ->setRank($new->getRank());

        if ($existing instanceof Question) {
            $existing
                ->setPublishAt($new->getPublishAt());
        }

        $this->getDoctrine()->getManager()->persist($existing);
    }
}