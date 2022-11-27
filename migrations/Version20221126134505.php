<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221126134505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE settings (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', `key` VARCHAR(255) NOT NULL, value VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site_settings (id INT AUTO_INCREMENT NOT NULL, favicon_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', site_name VARCHAR(255) DEFAULT \'Default site name\' NOT NULL, site_description LONGTEXT NOT NULL, enable_registration TINYINT(1) DEFAULT 1 NOT NULL, default_registration_role VARCHAR(255) DEFAULT \'ROLE_STUDENT\' NOT NULL, enable_forum TINYINT(1) DEFAULT 1 NOT NULL, enable_messages TINYINT(1) DEFAULT 1 NOT NULL, send_notifications TINYINT(1) DEFAULT 1 NOT NULL, site_keywords VARCHAR(255) DEFAULT \'\', UNIQUE INDEX UNIQ_E9081F1FD78119FD (favicon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE site_settings ADD CONSTRAINT FK_E9081F1FD78119FD FOREIGN KEY (favicon_id) REFERENCES storage (id)');
        $this->addSql('DROP TABLE page_settings');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_settings (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', `key` VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, value VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE site_settings DROP FOREIGN KEY FK_E9081F1FD78119FD');
        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP TABLE site_settings');
    }
}
