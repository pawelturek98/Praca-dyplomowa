<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221020182829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', city VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, street_number VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, vat_number VARCHAR(255) DEFAULT NULL, pesel INT DEFAULT NULL, district VARCHAR(255) NOT NULL, province VARCHAR(255) NOT NULL, country_code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', leader_teacher_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, start_date DATETIME NOT NULL, close_date DATETIME NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_169E6FB9905F49E5 (leader_teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_attachment (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', storage_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', course_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_A6BD97385CC5DB90 (storage_id), INDEX IDX_A6BD9738591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercise (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', course_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', exercise_content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, close_date DATETIME NOT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_AEDAD51C591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', course_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', author_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_closed TINYINT(1) DEFAULT 0 NOT NULL, INDEX IDX_852BBECD591CC992 (course_id), INDEX IDX_852BBECDF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum_post (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', author_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', forum_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_996BCC5AF675F31B (author_id), INDEX IDX_996BCC5A29CCBAD0 (forum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lecture (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', course_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_C1677948591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marks_dictionary (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, position INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_settings (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', `key` VARCHAR(255) NOT NULL, value VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE solution (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', student_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', exercise_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', marks_dictionary_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', disposed_at DATETIME NOT NULL, is_saved TINYINT(1) NOT NULL, INDEX IDX_9F3329DBCB944F1A (student_id), INDEX IDX_9F3329DBE934951A (exercise_id), INDEX IDX_9F3329DB9BB09753 (marks_dictionary_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE solution_attachment (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', storage_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', solution_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_643E346C5CC5DB90 (storage_id), INDEX IDX_643E346C1C0BE183 (solution_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE storage (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_by_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, verbose_name VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, size INT NOT NULL, hash VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_547A1B34B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', address_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, graduation VARCHAR(255) DEFAULT NULL, degree VARCHAR(255) DEFAULT NULL, type INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, last_seen DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9905F49E5 FOREIGN KEY (leader_teacher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE course_attachment ADD CONSTRAINT FK_A6BD97385CC5DB90 FOREIGN KEY (storage_id) REFERENCES storage (id)');
        $this->addSql('ALTER TABLE course_attachment ADD CONSTRAINT FK_A6BD9738591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE exercise ADD CONSTRAINT FK_AEDAD51C591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECD591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECDF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE forum_post ADD CONSTRAINT FK_996BCC5AF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE forum_post ADD CONSTRAINT FK_996BCC5A29CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id)');
        $this->addSql('ALTER TABLE lecture ADD CONSTRAINT FK_C1677948591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE solution ADD CONSTRAINT FK_9F3329DBCB944F1A FOREIGN KEY (student_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE solution ADD CONSTRAINT FK_9F3329DBE934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id)');
        $this->addSql('ALTER TABLE solution ADD CONSTRAINT FK_9F3329DB9BB09753 FOREIGN KEY (marks_dictionary_id) REFERENCES exercise (id)');
        $this->addSql('ALTER TABLE solution_attachment ADD CONSTRAINT FK_643E346C5CC5DB90 FOREIGN KEY (storage_id) REFERENCES storage (id)');
        $this->addSql('ALTER TABLE solution_attachment ADD CONSTRAINT FK_643E346C1C0BE183 FOREIGN KEY (solution_id) REFERENCES solution (id)');
        $this->addSql('ALTER TABLE storage ADD CONSTRAINT FK_547A1B34B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9905F49E5');
        $this->addSql('ALTER TABLE course_attachment DROP FOREIGN KEY FK_A6BD97385CC5DB90');
        $this->addSql('ALTER TABLE course_attachment DROP FOREIGN KEY FK_A6BD9738591CC992');
        $this->addSql('ALTER TABLE exercise DROP FOREIGN KEY FK_AEDAD51C591CC992');
        $this->addSql('ALTER TABLE forum DROP FOREIGN KEY FK_852BBECD591CC992');
        $this->addSql('ALTER TABLE forum DROP FOREIGN KEY FK_852BBECDF675F31B');
        $this->addSql('ALTER TABLE forum_post DROP FOREIGN KEY FK_996BCC5AF675F31B');
        $this->addSql('ALTER TABLE forum_post DROP FOREIGN KEY FK_996BCC5A29CCBAD0');
        $this->addSql('ALTER TABLE lecture DROP FOREIGN KEY FK_C1677948591CC992');
        $this->addSql('ALTER TABLE solution DROP FOREIGN KEY FK_9F3329DBCB944F1A');
        $this->addSql('ALTER TABLE solution DROP FOREIGN KEY FK_9F3329DBE934951A');
        $this->addSql('ALTER TABLE solution DROP FOREIGN KEY FK_9F3329DB9BB09753');
        $this->addSql('ALTER TABLE solution_attachment DROP FOREIGN KEY FK_643E346C5CC5DB90');
        $this->addSql('ALTER TABLE solution_attachment DROP FOREIGN KEY FK_643E346C1C0BE183');
        $this->addSql('ALTER TABLE storage DROP FOREIGN KEY FK_547A1B34B03A8386');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F5B7AF75');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE course_attachment');
        $this->addSql('DROP TABLE exercise');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE forum_post');
        $this->addSql('DROP TABLE lecture');
        $this->addSql('DROP TABLE marks_dictionary');
        $this->addSql('DROP TABLE page_settings');
        $this->addSql('DROP TABLE solution');
        $this->addSql('DROP TABLE solution_attachment');
        $this->addSql('DROP TABLE storage');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
