<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Link
 *
 * @ORM\Table(name="links", indexes={@ORM\Index(name="id_imported_urls", columns={"id_imported_urls"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Link
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Imported Url.
     *
     * @var ImportedUrl
     *
     * @ORM\ManyToOne(targetEntity="ImportedUrl")
     *
     * @ORM\JoinColumn(name="id_imported_urls", referencedColumnName="id", nullable=false)
     */
    private ImportedUrl $importedUrl;

    /**
     * User whose created this link.
     *
     * @var User
     *
     * @Gedmo\Blameable(on="create")
     *
     * @ORM\ManyToOne(targetEntity="User")
     *
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private User $user;

    /**
     * @param ImportedUrl $importedUrl
     * @param User $user
     */
    public function __construct(ImportedUrl $importedUrl, User $user)
    {
        $this->importedUrl = $importedUrl;
        $this->user = $user;
    }

    /**
     * @return ImportedUrl
     */
    public function getImportedUrl(): ImportedUrl
    {
        return $this->importedUrl;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

}
