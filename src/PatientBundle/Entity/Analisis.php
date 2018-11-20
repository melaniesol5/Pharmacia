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
     * @var string
     *
     * @ORM\Column(name="hemograma", type="string", length=255)
     */
    private $hemograma;

    /**
     * @var string
     *
     * @ORM\Column(name="rayosX", type="string", length=255)
     */
    private $rayosX;

    /**
     * @var string
     *
     * @ORM\Column(name="testPsicologico", type="string", length=255)
     */
    private $testPsicologico;


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

    /**
     * Set hemograma
     *
     * @param string $hemograma
     *
     * @return Analisis
     */
    public function setHemograma($hemograma)
    {
        $this->hemograma = $hemograma;

        return $this;
    }

    /**
     * Get hemograma
     *
     * @return string
     */
    public function getHemograma()
    {
        return $this->hemograma;
    }

    /**
     * Set rayosX
     *
     * @param string $rayosX
     *
     * @return Analisis
     */
    public function setRayosX($rayosX)
    {
        $this->rayosX = $rayosX;

        return $this;
    }

    /**
     * Get rayosX
     *
     * @return string
     */
    public function getRayosX()
    {
        return $this->rayosX;
    }

    /**
     * Set testPsicologico
     *
     * @param string $testPsicologico
     *
     * @return Analisis
     */
    public function setTestPsicologico($testPsicologico)
    {
        $this->testPsicologico = $testPsicologico;

        return $this;
    }

    /**
     * Get testPsicologico
     *
     * @return string
     */
    public function getTestPsicologico()
    {
        return $this->testPsicologico;
    }
}

