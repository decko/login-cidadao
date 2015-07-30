<?php

namespace PROCERGS\LoginCidadao\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="PROCERGS\LoginCidadao\CoreBundle\Entity\AgentPublicRepository")
 * @ORM\Table(name="agent_public")
 * @Vich\Uploadable
 */
class AgentPublic
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Person", inversedBy="agentPublic")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     **/
	private $person;

	/**
	 * @Assert\File(
	 * 		maxSize="4M",
	 * 		maxSizeMessage="The maxmimum allowed file size is 4MB.",
	 * 		mimeTypes={"application/pdf"},
	 * 		mimeTypesMessage="Only PDF file are allowed."
	 * )
	 * @Vich\UploadableField(mapping="agent_public_file", filenameProperty="fileOfficialDiaryName")
	 *
	 * @var File $fileOfficialDiary
	 * @JMS\Since("1.0.2")
	 */
	private $fileOfficialDiary;

    /**
     * @ORM\Column(type="string", length=255, name="file_officialdiary_name", nullable=true)
     *
     * @var string $fileOfficialDiaryName
     * @JMS\Since("1.0.2")
     */
    protected $fileOfficialDiaryName;

	/**
	 * @Assert\File(
	 * 		maxSize="4M",
	 * 		maxSizeMessage="The maxmimum allowed file size is 4MB.",
	 * 		mimeTypes={"application/pdf"},
	 * 		mimeTypesMessage="Only PDF file are allowed."
	 * )
	 * @Vich\UploadableField(mapping="agent_public_file", filenameProperty="fileOcupationName")
	 *
	 * @var File $fileOcupation
	 * @JMS\Since("1.0.2")
	 */
	private $fileOcupation;

    /**
     * @ORM\Column(type="string", length=255, name="file_ocupation_name", nullable=true)
     *
     * @var string $fileOcupationName
     * @JMS\Since("1.0.2")
     */
    protected $fileOcupationName;

	/**
	 * @JMS\Expose
	 * @JMS\Groups({"registration"})
	 * @ORM\Column(type="string", nullable=true)
	 * @Assert\NotBlank(message="Please enter your registration.")
	 */
	private $registration;

	/**
	 * @JMS\Expose
	 * @JMS\Groups({"dateNomination"})
	 * @ORM\Column(type="date", nullable=true)
	 * @JMS\Since("1.0")
	 */
	private $dateNomination;


	/**
	 * @JMS\Expose
	 * @JMS\Groups({"dateStartRole"})
	 * @ORM\Column(type="date", nullable=true)
	 * @JMS\Since("1.0")
	 */
	private $dateStartRole;


	/**
	 * @JMS\Expose
	 * @JMS\Groups({"active"})
	 * @ORM\Column(type="boolean", nullable=false)
	 * @JMS\Since("1.0")
	 */
	private $active = false;


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
     * Set registration
     *
     * @param string $registration
     * @return AgentPublic
     */
    public function setRegistration($registration)
    {
        $this->registration = $registration;

        return $this;
    }

    /**
     * Get registration
     *
     * @return string 
     */
    public function getRegistration()
    {
        return $this->registration;
    }

    /**
     * Set dateNomination
     *
     * @param \DateTime $dateNomination
     * @return AgentPublic
     */
    public function setDateNomination($dateNomination)
    {
        $this->dateNomination = $dateNomination;

        return $this;
    }

    /**
     * Get dateNomination
     *
     * @return \DateTime 
     */
    public function getDateNomination()
    {
        return $this->dateNomination;
    }

    /**
     * Set dateStartRole
     *
     * @param \DateTime $dateStartRole
     * @return AgentPublic
     */
    public function setDateStartRole($dateStartRole)
    {
        $this->dateStartRole = $dateStartRole;

        return $this;
    }

    /**
     * Get dateStartRole
     *
     * @return \DateTime 
     */
    public function getDateStartRole()
    {
        return $this->dateStartRole;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return AgentPublic
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
     * Set person
     *
     * @param \PROCERGS\LoginCidadao\CoreBundle\Entity\Person $person
     * @return AgentPublic
     */
    public function setPerson(\PROCERGS\LoginCidadao\CoreBundle\Entity\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \PROCERGS\LoginCidadao\CoreBundle\Entity\Person 
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set fileOfficialDiaryName
     *
     * @param string $fileOfficialDiaryName
     * @return AgentPublic
     */
    public function setFileOfficialDiaryName($fileOfficialDiaryName)
    {
        $this->fileOfficialDiaryName = $fileOfficialDiaryName;

        return $this;
    }

    /**
     * Get fileOfficialDiary
     *
     * @return string 
     */
    public function getFileOfficialDiary()
    {
        return $this->fileOfficialDiary;
    }

    /**
     * Set fileOfficialDiary
     *
     * @param string $fileOfficialDiary
     * @return AgentPublic
     */
    public function setFileOfficialDiary($fileOfficialDiary)
    {
        $this->fileOfficialDiary = $fileOfficialDiary;

        return $this;
    }

    /**
     * Get fileOcupation
     *
     * @return string 
     */
    public function getFileOcupation()
    {
        return $this->fileOcupation;
    }

    /**
     * Set fileOcupation
     *
     * @param string $fileOcupation
     * @return AgentPublic
     */
    public function setFileOcupation($fileOcupation)
    {
        $this->fileOcupation = $fileOcupation;

        return $this;
    }

    /**
     * Get fileOfficialDiaryName
     *
     * @return string 
     */
    public function getFileOfficialDiaryName()
    {
        return $this->fileOfficialDiaryName;
    }

    /**
     * Set fileOcupationName
     *
     * @param string $fileOcupationName
     * @return AgentPublic
     */
    public function setFileOcupationName($fileOcupationName)
    {
        $this->fileOcupationName = $fileOcupationName;

        return $this;
    }

    /**
     * Get fileOcupationName
     *
     * @return string 
     */
    public function getFileOcupationName()
    {
        return $this->fileOcupationName;
    }
}
