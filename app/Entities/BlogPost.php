<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

/**
 * Product
 *
 * @ORM\Table(name="blog_post")
 * @ORM\Entity
 */
class BlogPost
{
    use Timestamps;

    public const ID = 'id';
    public const URL_CODE = 'urlCode';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private string $title;

    /**
     * @var string
     *
     * @ORM\Column(name="url_code", type="string", length=255, nullable=false)
     */
    private string $urlCode;

    /**
     * @var string
     *
     * @ORM\Column(name="short_content", type="string", nullable=false)
     */
    private string $shortContent;

    /**
     * @var string
     *
     * @ORM\Column(name="full_content", type="string", nullable=false)
     */
    private string $fullContent;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getUrlCode(): string
    {
        return $this->urlCode;
    }

    /**
     * @return string
     */
    public function getShortContent(): string
    {
        return $this->shortContent;
    }

    /**
     * @return string
     */
    public function getFullContent(): string
    {
        return $this->fullContent;
    }
}
