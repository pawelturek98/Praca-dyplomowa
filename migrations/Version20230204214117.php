<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230204214117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD profile_image_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649C4CF44DC FOREIGN KEY (profile_image_id) REFERENCES storage (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649C4CF44DC ON user (profile_image_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C4CF44DC');
        $this->addSql('DROP INDEX UNIQ_8D93D649C4CF44DC ON user');
        $this->addSql('ALTER TABLE user DROP profile_image_id');
    }
}
