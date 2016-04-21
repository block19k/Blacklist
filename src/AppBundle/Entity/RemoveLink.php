<?php

namespace AppBundle\Entity;

class RemoveLink
{
	protected $linkId; 
	public function __construct()
    {
        $linkId = -1;
    }
	public function getLinkId()
    {
        return $this->linkId;
    }

    public function setLinkId($linkId)
    {
        $this->linkId = $linkId;
    }
}