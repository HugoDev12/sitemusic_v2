<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240607122745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, sender_id_id INT NOT NULL, recipient_id_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, is_read TINYINT(1) DEFAULT NULL, INDEX IDX_DB021E966061F7CF (sender_id_id), INDEX IDX_DB021E962B6945EC (recipient_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E966061F7CF FOREIGN KEY (sender_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E962B6945EC FOREIGN KEY (recipient_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E966061F7CF');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E962B6945EC');
        $this->addSql('DROP TABLE messages');
    }
}
