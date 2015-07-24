<?php

namespace PROCERGS\LoginCidadao\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * AgentPublic
 *
 * @ORM\Table(name="agent_public")
 * @ORM\Entity(repositoryClass="PROCERGS\LoginCidadao\CoreBundle\Entity\AgentPublicRepository")
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
	 * @Assert\File(
	 * 		maxSize="2M",
	 * 		maxSizeMessage="The maxmimum allowed file size is 2MB.",
	 * 		mimeTypes={"application/pdf"},
	 * 		mimeTypeMessage="Only PDF file are allowed."
	 * )
	 * @Vich\UploadableField(mapping="agent_public_file", filenameProperty="fileOfficialDiary")
	 *
	 * @var File $fileOfficialDiary
	 * @JMS\Since("1.0.2")
	 */
	private $fileOfficialDiary;


	/**
	 * @Assert\File(
	 * 		maxSize="2M",
	 * 		maxSizeMessage="The maxmimum allowed file size is 2MB.",
	 * 		mimeTypes={"application/pdf"},
	 * 		mimeTypeMessage="Only PDF file are allowed."
	 * )
	 * @Vich\UploadableField(mapping="agent_public_file", filenameProperty="fileOcupation")
	 *
	 * @var File $fileOcupation
	 * @JMS\Since("1.0.2")
	 */
	private $fileOcupation;

	/**
	 * @JMS\Expose
	 * @JMS\Groups({"registration"})
	 * @ORM\Column(type="string", nullable=false)
	 * @Assert\NotBlank(message="Please enter your registration.")
	 */
	private $registration;

	/**
	 * @JMS\Expose
	 * @JMS\Groups({"dateNomination"})
	 * @ORM\Column(type="date", nullable=false)
	 * @JMS\Since("1.0")
	 */
	private $dateNomination;


	/**
	 * @JMS\Expose
	 * @JMS\Groups({"dateStartRole"})
	 * @ORM\Column(type="date", nullable=false)
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
}
