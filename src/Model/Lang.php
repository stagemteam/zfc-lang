<?php

namespace Stagem\ZfcLang\Model;

use Doctrine\ORM\Mapping as ORM;
use Popov\ZfcCore\Model\DomainAwareTrait;

/**
 * @ORM\Entity(repositoryClass="Stagem\ZfcLang\Model\Repository\LangRepository")
 * @ORM\Table(name="lang")
 */
class Lang {

	use DomainAwareTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

	/**
	 * @ORM\Column(type="string", unique=true, length=191, nullable=false)
	 * @var string
	 */
	private $mnemo;

    /**
     * @ORM\Column(type="string", unique=false, nullable=false)
     * @var string
     */
    private $locale;

    /**
     * @ORM\Column(type="string", unique=false, nullable=true)
     * @var string
     */
    private $name;

    /**
     * var integer
     * @ORM\Column(type="integer", nullable=true, options={"default":"0"})
     */
    private $isActive = 0;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getMnemo()
    {
        return $this->mnemo;
    }

    /**
     * @param string $mnemo
     */
    public function setMnemo($mnemo)
    {
        $this->mnemo = $mnemo;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

}