<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221107183119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9905F49E5');
        $this->addSql('DROP INDEX IDX_169E6FB9905F49E5 ON course');
        $this->addSql('ALTER TABLE course CHANGE leader_teacher_id leading_teacher_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB98711E58A FOREIGN KEY (leading_teacher_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB98711E58A ON course (leading_teacher_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB98711E58A');
        $this->addSql('DROP INDEX IDX_169E6FB98711E58A ON course');
        $this->addSql('ALTER TABLE course CHANGE leading_teacher_id leader_teacher_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9905F49E5 FOREIGN KEY (leader_teacher_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_169E6FB9905F49E5 ON course (leader_teacher_id)');
    }
}
