<?php

namespace PROCERGS\LoginCidadao\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PROCERGS\OAuthBundle\Entity\Client;

/**
 * @ORM\Entity
 * @ORM\Table(name="auth",uniqueConstraints={@ORM\UniqueConstraint(name="unique_person_client", columns={"person_id", "client_id"})})
 */
class Authorization
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="array")
     * @var array
     */
    protected $scope;

    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="authorizations")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id", nullable=false)
     */
    protected $person;

    /**
     * @ORM\ManyToOne(targetEntity="PROCERGS\OAuthBundle\Entity\Client", inversedBy="authorizations")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=false)
     */
    protected $client;

    /**
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param \PROCERGS\LoginCidadao\CoreBundle\Entity\Person $person
     */
    public function setPerson(Person $person = null)
    {
        $this->person = $person;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param \PROCERGS\OAuthBundle\Entity\Client $client
     */
    public function setClient(Client $client = null)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function getScope()
    {
        $scope = $this->enforcePublicProfileScope(array_filter($this->scope));

        return array_unique($scope);
    }

    /**
     * @param array $scope
     */
    public function setScope(array $scope)
    {
        $scope       = $this->enforcePublicProfileScope($scope);
        $this->scope = $scope;
    }

    /**
     * @param mixed $needed
     * @return boolean
     */
    public function hasScopes($needed)
    {
        if (!is_array($needed)) {
            $needed = array($needed);
        }

        foreach ($needed as $n) {
            if (array_search($n, $this->getScope()) === false) {
                return false;
            }
        }
        return true;
    }

    protected function enforcePublicProfileScope($scope)
    {
        if (array_search('public_profile', $scope) === false) {
            $scope[] = 'public_profile';
        }
        return $scope;
    }
}
