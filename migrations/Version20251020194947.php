<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251020194947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE file_share (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', file_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', owner_id INT DEFAULT NULL, shared_with_id INT DEFAULT NULL, INDEX IDX_45852D6D93CB796C (file_id), INDEX IDX_45852D6D7E3C61F9 (owner_id), INDEX IDX_45852D6DD14FE63F (shared_with_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE folder_share (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', folder_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', owner_id INT DEFAULT NULL, shared_with_id INT DEFAULT NULL, INDEX IDX_82C2E697162CB942 (folder_id), INDEX IDX_82C2E6977E3C61F9 (owner_id), INDEX IDX_82C2E697D14FE63F (shared_with_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file_share ADD CONSTRAINT FK_45852D6D93CB796C FOREIGN KEY (file_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE file_share ADD CONSTRAINT FK_45852D6D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE file_share ADD CONSTRAINT FK_45852D6DD14FE63F FOREIGN KEY (shared_with_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE folder_share ADD CONSTRAINT FK_82C2E697162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id)');
        $this->addSql('ALTER TABLE folder_share ADD CONSTRAINT FK_82C2E6977E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE folder_share ADD CONSTRAINT FK_82C2E697D14FE63F FOREIGN KEY (shared_with_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file_share DROP FOREIGN KEY FK_45852D6D93CB796C');
        $this->addSql('ALTER TABLE file_share DROP FOREIGN KEY FK_45852D6D7E3C61F9');
        $this->addSql('ALTER TABLE file_share DROP FOREIGN KEY FK_45852D6DD14FE63F');
        $this->addSql('ALTER TABLE folder_share DROP FOREIGN KEY FK_82C2E697162CB942');
        $this->addSql('ALTER TABLE folder_share DROP FOREIGN KEY FK_82C2E6977E3C61F9');
        $this->addSql('ALTER TABLE folder_share DROP FOREIGN KEY FK_82C2E697D14FE63F');
        $this->addSql('DROP TABLE file_share');
        $this->addSql('DROP TABLE folder_share');
    }
}
