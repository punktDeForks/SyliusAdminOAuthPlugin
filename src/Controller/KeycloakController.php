<?php

declare(strict_types=1);

namespace Synolia\SyliusAdminOauthPlugin\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final class KeycloakController extends AbstractController
{
    #[Route('/connect/keycloak', name: 'connect_admin_keycloak')]
    public function connectAction(ClientRegistry $clientRegistry): RedirectResponse
    {
        // Explicitly set the redirect_uri to match what's configured in Keycloak
        // Use the router to generate the absolute URL for the check route
        //$redirectUri = $this->generateUrl('connect_admin_keycloak_check', [], \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL);

        // Define the scopes we want to request from Keycloak
        $scopes = [
            'email',
            'profile',
            'openid',
            'roles'
        ];

        return $clientRegistry->getClient('keycloak')->redirect($scopes, []);
    }

    /**
     * After going to keycloak, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml
     */
    #[Route('/connect/keycloak/check', name: 'connect_admin_keycloak_check')]
    public function connectCheckAction(): void
    {
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
    }
}
