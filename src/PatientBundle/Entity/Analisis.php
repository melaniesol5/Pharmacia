<?php

namespace PatientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Analisis
 *
 * @ORM\Table(name="analisis")
 * @ORM\Entity(repositoryClass="PatientBundle\Repository\AnalisisRepository")
 */
class Analisis
{
    /**
    *@ORM\ManyToMany(targetEntity="Patient", mappedBy="analisis")
    *@ORM\JoinTable(name="Patient_analisis")
    */
     private $patients=null;
    public function __construct()
    {
        $this->patients=new ArrayCollection();
    }
    public function getAnalisis()
    {
        return $this->patients;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Analisis
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

