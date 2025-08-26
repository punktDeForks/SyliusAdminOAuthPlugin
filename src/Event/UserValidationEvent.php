<?php
declare(strict_types=1);

namespace Synolia\SyliusAdminOauthPlugin\Event;

use Stevenmaguire\OAuth2\Client\Provider\KeycloakResourceOwner;
use Symfony\Contracts\EventDispatcher\Event;

class UserValidationEvent extends Event
{
    public const NAME = 'synolia.sylius_admin_oauth_plugin.user_validation';

    /** @var string[] */
    private array $errors = [];

    public function __construct(private KeycloakResourceOwner $user)
    {
    }

    public function getUser(): KeycloakResourceOwner
    {
        return $this->user;
    }

    public function addError(string $message): void
    {
        $this->errors[] = $message;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}
