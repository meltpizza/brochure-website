<?php
namespace Melt\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="media")
 */
class Media
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=256)
     */
    protected $link;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $author;

    /**
     * @ORM\Column(type="string", length=256)
     */
    protected $author_link;

    /**
     * @ORM\Column(type="integer", length=5)
     */
    protected $order;

    /**
     * @ORM\Column(type="integer", length=1)
     */
    protected $active;

    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $created;


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
     * Set title
     *
     * @param string $title
     * @return Media
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Media
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Media
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set author_link
     *
     * @param string $authorLink
     * @return Media
     */
    public function setAuthorLink($authorLink)
    {
        $this->author_link = $authorLink;

        return $this;
    }

    /**
     * Get author_link
     *
     * @return string 
     */
    public function getAuthorLink()
    {
        return $this->author_link;
    }

    /**
     * Set active
     *
     * @param integer $active
     * @return Media
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Media
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set order
     *
     * @param integer $order
     * @return Media
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer 
     */
    public function getOrder()
    {
        return $this->order;
    }
}
