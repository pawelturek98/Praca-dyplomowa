<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221024181541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course_student (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', course_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', student_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', marks_dictionary_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', is_active TINYINT(1) DEFAULT 1 NOT NULL, is_passed TINYINT(1) DEFAULT 0 NOT NULL, INDEX IDX_BFE0AADF591CC992 (course_id), INDEX IDX_BFE0AADFCB944F1A (student_id), INDEX IDX_BFE0AADF9BB09753 (marks_dictionary_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_student ADD CONSTRAINT FK_BFE0AADF591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE course_student ADD CONSTRAINT FK_BFE0AADFCB944F1A FOREIGN KEY (student_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE course_student ADD CONSTRAINT FK_BFE0AADF9BB09753 FOREIGN KEY (marks_dictionary_id) REFERENCES marks_dictionary (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_student DROP FOREIGN KEY FK_BFE0AADF591CC992');
        $this->addSql('ALTER TABLE course_student DROP FOREIGN KEY FK_BFE0AADFCB944F1A');
        $this->addSql('ALTER TABLE course_student DROP FOREIGN KEY FK_BFE0AADF9BB09753');
        $this->addSql('DROP TABLE course_student');
    }
}
