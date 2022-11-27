<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221120134956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE solution DROP FOREIGN KEY FK_9F3329DB9BB09753');
        $this->addSql('ALTER TABLE solution ADD CONSTRAINT FK_9F3329DB9BB09753 FOREIGN KEY (marks_dictionary_id) REFERENCES marks_dictionary (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE solution DROP FOREIGN KEY FK_9F3329DB9BB09753');
        $this->addSql('ALTER TABLE solution ADD CONSTRAINT FK_9F3329DB9BB09753 FOREIGN KEY (marks_dictionary_id) REFERENCES exercise (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
