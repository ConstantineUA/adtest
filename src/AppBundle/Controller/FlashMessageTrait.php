<?php

namespace AppBundle\Controller;

/**
 * Trait simplifies the adding of status flash messages (info, error etc...)
 *
 * @author constantine
 *
 */
trait FlashMessageTrait
{
    /**
     * Adds a new flash message
     *
     * @param string $key a key to fetch message status
     * @param string $message a key to fetch message translation
     * @throws \InvalidArgumentException
     */
    public function flash($key, $message)
    {
        $twig = $this->container->get('twig');
        $globals = $twig->getGlobals();

        if (!array_key_exists($key, $globals)) {
            throw new \InvalidArgumentException(
                'Attempt to fetch a non-existing Twig global variable while setting a flash message'
            );
        }

        $this->addFlash($globals[$key], $this->get('translator')->trans($message));
    }
}
