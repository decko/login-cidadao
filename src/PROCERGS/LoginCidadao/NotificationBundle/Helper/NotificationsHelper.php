<?php

namespace PROCERGS\LoginCidadao\NotificationBundle\Helper;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use PROCERGS\LoginCidadao\NotificationBundle\Model\NotificationInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityManager;
use PROCERGS\LoginCidadao\CoreBundle\Entity\Person;
use PROCERGS\LoginCidadao\NotificationBundle\Entity\Notification;
use PROCERGS\LoginCidadao\NotificationBundle\Entity\Category;
use PROCERGS\LoginCidadao\NotificationBundle\Exception\MissingCategoryException;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use PROCERGS\LoginCidadao\NotificationBundle\Form\NotificationType;
use JMS\Serializer\SerializationContext;
use PROCERGS\LoginCidadao\NotificationBundle\Handler\NotificationHandler;
use PROCERGS\LoginCidadao\NotificationBundle\Entity\Placeholder;

class NotificationsHelper
{

    const EMPTY_PASSWORD_TITLE = 'notification.empty.password.title';
    const EMPTY_PASSWORD_SHORT_TEXT = 'notification.empty.password.shortText';
    const EMPTY_PASSWORD_FULL_TEXT = 'notification.empty.password.text';
    const EMPTY_PASSWORD_CLICK = 'notification.empty.password.click.here';

    /**
     *
     * @var EntityManager
     */
    private $em;

    /**
     *
     * @var SecurityContext
     */
    private $context;

    /**
     * @var \Symfony\Component\Routing\Router
     */
    private $router;

    /**
     *
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    private $translator;
    private $container;
    private $unconfirmedEmailCategoryId;
    private $emptyPasswordCategoryId;

    public function __construct(EntityManager $em, SecurityContext $context, $container, $unconfirmedEmailCategoryId, $emptyPasswordCategoryId)
    {
        $this->em = $em;
        $this->context = $context;
        $this->container = $container;
        $this->router = $this->container->get('router');
        $this->translator = $this->container->get('translator');

        $this->unconfirmedEmailCategoryId = $unconfirmedEmailCategoryId;
        $this->emptyPasswordCategoryId = $emptyPasswordCategoryId;
    }

    private function getRepository()
    {
        return $this->em->getRepository("PROCERGSLoginCidadaoNotificationBundle:Notification");
    }

    public function getUser()
    {
        return $this->context->getToken()->getUser();
    }

    public function getUnread($level = null)
    {
        return $this->getRepository()->findAllUnread($this->getUser(), $level);
    }

    public function getTotalUnread()
    {
        return $this->getNotificationHandler()->countUnread($this->getUser());
    }

    public function send(NotificationInterface $notification)
    {
        if ($notification->canBeSent()) {
            $handler = $this->getNotificationHandler();

            $serializer = $this->container->get('jms_serializer');
            $context = SerializationContext::create()->setGroups('form');
            $array = json_decode($serializer->serialize($notification, 'json', $context), true);

            $handler->patch($notification, array());
        } else {
            $translator = $this->container->get('translator');
            throw new AccessDeniedException($translator->trans("This notification cannot be sent to this user. Check the notification level and whether the user has authorized the application."));
        }
    }

    protected function getDefaultNotification(Person $person, $title, $shortText, $text, $icon, Category $category, $notification = null, $parameters = null)
    {
        $persisted = $this->getRepository()->findOneBy(array('person' => $person, 'category' => $category));
        if ($persisted instanceof NotificationInterface) {
            return $persisted;
        }

        if (is_null($notification)) {
            $notification = new Notification();
        }

        $notification->setPerson($person)
            ->setIcon($icon)
            ->setTitle($title)
            ->setShortText($shortText)
            ->setCategory($category)
            ->setSender($category->getClient())
            ->setPlaceholders($parameters);

        return $notification;
    }

    protected function getEmptyPasswordNotification(Person $person)
    {
        $title = $this->translator->trans(self::EMPTY_PASSWORD_TITLE);
        $shortText = $this->translator->trans(self::EMPTY_PASSWORD_SHORT_TEXT);
        $text = $this->translator->trans(self::EMPTY_PASSWORD_FULL_TEXT);
        $icon = 'glyphicon glyphicon-exclamation-sign';
        $url = $this->container->get('router')
        ->generate('fos_user_change_password', array(), true);
        return $this->getDefaultNotification($person, $title, $shortText, $text, $icon, $this->getEmptyPasswordCategory(), new Notification(), array(new Placeholder('link', $url), new Placeholder('linktitle', $title), new Placeholder('linkclick', $this->translator->trans(self::EMPTY_PASSWORD_CLICK))));
    }

    /**
     * @deprecated since version 1.1.0
     * @param Person $person
     */
    public function enforceEmptyPasswordNotification(Person $person)
    {
        $category = $this->getEmptyPasswordCategory();
        $handler = $this->getNotificationHandler();

        $notification = $this->getEmptyPasswordNotification($person);
        if (!$notification->getCategory()) {
            $notification->setCategory($category);
        }
        $notification->setRead(false);
        $handler->patch($notification, array());
    }

    /**
     * @deprecated since version 1.1.0
     * @param Person $person
     */
    public function clearEmptyPasswordNotification(Person $person)
    {
        $handler = $this->getNotificationHandler();
        $notification = $this->getEmptyPasswordNotification($person);
        $notification->setRead(true);
        $handler->patch($notification, array());
    }

    private function getUnconfirmedEmailCategory()
    {
        $category = $this->em->getRepository('PROCERGSLoginCidadaoNotificationBundle:Category')->findOneByUid($this->unconfirmedEmailCategoryId);
        if (null === $category) {
            throw new MissingCategoryException("missing category for unconfirmed email, please configure your db");
        }
        return $category;
    }

    private function getEmptyPasswordCategory()
    {
        $category = $this->em->getRepository('PROCERGSLoginCidadaoNotificationBundle:Category')->findOneByUid($this->emptyPasswordCategoryId);
        if (null === $category) {
            throw new MissingCategoryException("Missing category id for empty password, please edit your parameters.yml");
        }
        return $category;
    }

    /**
     *
     * @return \PROCERGS\LoginCidadao\NotificationBundle\Handler\NotificationHandlerInterface
     */
    private function getNotificationHandler()
    {
        return $this->container->get('procergs.notification.handler');
    }

}