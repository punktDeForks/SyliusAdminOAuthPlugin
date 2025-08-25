<?php

declare(strict_types=1);

namespace Synolia\SyliusAdminOauthPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250730150140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Keycloak id to user';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sylius_admin_user ADD keycloak_id VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sylius_admin_user DROP keycloak_id');
    }
}
