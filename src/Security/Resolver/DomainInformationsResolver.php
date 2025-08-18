<?php

declare(strict_types=1);

namespace Synolia\SyliusAdminOauthPlugin\Security\Resolver;

use League\OAuth2\Client\Provider\GoogleUser;
use Stevenmaguire\OAuth2\Client\Provider\KeycloakResourceOwner;
use Sylius\Component\Core\Model\AdminUser;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Synolia\SyliusAdminOauthPlugin\Factory\AdminUserFactory;
use TheNetworg\OAuth2\Client\Provider\AzureResourceOwner;

final readonly class DomainInformationsResolver
{
    public function __construct(
        private LocaleContextInterface $localeContext,
    ) {
    }

    /**
     * @return array<string, array<string, AdminUser|string|null>>
     */
    public function getDomainInformations(AzureResourceOwner|GoogleUser|KeycloakResourceOwner $user): array
    {
        if ($user instanceof AzureResourceOwner) {
            return [AzureResourceOwner::class => [
                'propertyName' => 'microsoftId',
                'userEmail' => $user->getUpn(),
                'newUser' => AdminUserFactory::createByMicrosoftAccount($user, $this->localeContext->getLocaleCode()),
            ]];
        }

        if ($user instanceof KeycloakResourceOwner) {
            return [KeycloakResourceOwner::class => [
                'propertyName' => 'keycloakId',
                'userEmail' => $user->getEmail(),
                'newUser' => AdminUserFactory::createByKeycloakAccount($user, $this->localeContext->getLocaleCode()),
            ]];
        }

        return [
            GoogleUser::class => [
                'propertyName' => 'googleId',
                'userEmail' => $user->getEmail(),
                'newUser' => AdminUserFactory::createByGoogleAccount($user, $this->localeContext->getLocaleCode()),
            ],
        ];
    }
}
