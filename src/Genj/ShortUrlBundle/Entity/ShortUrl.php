<?php

namespace Genj\ShortUrlBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ShortUrl
 *
 * @ORM\MappedSuperclass
 * @ORM\Entity(repositoryClass="Genj\ShortUrlBundle\Entity\ShortUrlRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="genj_short_url",
 *     indexes={
 *         @ORM\Index(name="is_public_source_idx", columns={"source", "publish_at", "expires_at"})
 *     }
 * )
 *
 * @package Genj\ShortUrlBundle\Entity
 */
class ShortUrl
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $source;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $target;

    /**
     * @ORM\Column(name="http_status_code", type="integer")
     */
    protected $httpStatusCode;

    /**
     * @ORM\Column(name="hit_count", type="integer", nullable=true)
     */
    protected $hitCount;

    /**
     * @ORM\Column(name="publish_at", type="datetime")
     */
    protected $publishAt;

    /**
     * @ORM\Column(name="expires_at", type="datetime", nullable=true)
     */
    protected $expiresAt;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

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
     * Set source
     *
     * @param string $source
     *
     * @return ShortUrl
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set target
     *
     * @param string $target
     *
     * @return ShortUrl
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set httpStatusCode
     *
     * @param integer $httpStatusCode
     *
     * @return ShortUrl
     */
    public function setHttpStatusCode($httpStatusCode)
    {
        $this->httpStatusCode = $httpStatusCode;

        return $this;
    }

    /**
     * Get httpStatusCode
     *
     * @return integer
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * Set hitCount
     *
     * @param integer $hitCount
     *
     * @return ShortUrl
     */
    public function setHitCount($hitCount)
    {
        $this->hitCount = $hitCount;

        return $this;
    }

    /**
     * Get hitCount
     *
     * @return integer
     */
    public function getHitCount()
    {
        return $this->hitCount;
    }

    /**
     * Set publishAt
     *
     * @param \DateTime $publishAt
     *
     * @return ShortUrl
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
     * @return ShortUrl
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
     * @return ShortUrl
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
     * @return ShortUrl
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
     * Returns a string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return 'Redirect ' . $this->getSource() . ' to ' . $this->getTarget();
    }
}
