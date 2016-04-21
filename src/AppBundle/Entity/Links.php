<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Links
 *
 * @ORM\Table(name="links", indexes={@ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Links
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


    /**
     * @var string
     *
     * @ORM\Column(name="request_type", type="string", length=255, nullable=false)
     */
    private $request_type;

    /**
    * @var boolean
    *
    * @ORM\Column(name="blocked", type="boolean", nullable=false)
    */
    private $blocked;

    /**
    * @var boolean
    *
    * @ORM\Column(name="actionrequired", type="boolean", nullable=false)
    */
    private $actionrequired;

    
    public function __construct($requestType)
    {
        $this->active = false;
        $this->blocked = false;
        $this->actionrequired = true;
        $this->request_type = $requestType;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Links
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
     * Set description
     *
     * @param string $description
     *
     * @return Links
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Links
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Links
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\Users $user
     *
     * @return Links
     */
    public function setUser(\AppBundle\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set request_type
     *
     * @param string $request_type
     *
     * @return Links
     */
    public function setRequestType($request_type)
    {
        $this->request_type = $request_type;

        return $this;
    }

    

    /**
     * Get request_type
     *
     * @return string
     */
    public function getRequestType()
    {
        return $this->request_type;
    }

    /**
     * Get blocked
     *
     * @return string
     */
    public function getBlocked()
    {
        return $this->blocked;
    }

    /**
     * Set blocked
     *
     * @param string $blocked
     *
     * @return Links
     */
    public function setBlocked($blocked)
    {
        $this->blocked = $blocked;

        return $this;
    }

    /**
     * Get actionrequired
     *
     * @return string
     */
    public function getActionrequired()
    {
        return $this->actionrequired;
    }
    /**
     * Set actionrequired
     *
     * @param string $actionrequired
     *
     * @return Links
     */
    public function setActionrequired($actionrequired)
    {
        $this->actionrequired = $actionrequired;

        return $this;
    }

}
