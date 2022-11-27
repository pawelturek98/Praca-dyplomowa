<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221110172343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE lecture ADD lecture_file_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE lecture ADD CONSTRAINT FK_C1677948A58F2A38 FOREIGN KEY (lecture_file_id) REFERENCES storage (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C1677948A58F2A38 ON lecture (lecture_file_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE lecture DROP FOREIGN KEY FK_C1677948A58F2A38');
        $this->addSql('DROP INDEX UNIQ_C1677948A58F2A38 ON lecture');
        $this->addSql('ALTER TABLE lecture DROP lecture_file_id');
    }
}
