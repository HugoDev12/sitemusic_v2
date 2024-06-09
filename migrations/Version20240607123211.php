<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240607123211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE advertisement DROP FOREIGN KEY FK_C95F6AEE9D86650F');
        $this->addSql('DROP INDEX IDX_C95F6AEE9D86650F ON advertisement');
        $this->addSql('ALTER TABLE advertisement CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE advertisement ADD CONSTRAINT FK_C95F6AEEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C95F6AEEA76ED395 ON advertisement (user_id)');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E962B6945EC');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E966061F7CF');
        $this->addSql('DROP INDEX IDX_DB021E962B6945EC ON messages');
        $this->addSql('DROP INDEX IDX_DB021E966061F7CF ON messages');
        $this->addSql('ALTER TABLE messages ADD sender_id INT NOT NULL, ADD recipient_id INT NOT NULL, DROP sender_id_id, DROP recipient_id_id');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96F624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96E92F8F78 FOREIGN KEY (recipient_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DB021E96F624B39D ON messages (sender_id)');
        $this->addSql('CREATE INDEX IDX_DB021E96E92F8F78 ON messages (recipient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE advertisement DROP FOREIGN KEY FK_C95F6AEEA76ED395');
        $this->addSql('DROP INDEX IDX_C95F6AEEA76ED395 ON advertisement');
        $this->addSql('ALTER TABLE advertisement CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE advertisement ADD CONSTRAINT FK_C95F6AEE9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C95F6AEE9D86650F ON advertisement (user_id_id)');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96F624B39D');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96E92F8F78');
        $this->addSql('DROP INDEX IDX_DB021E96F624B39D ON messages');
        $this->addSql('DROP INDEX IDX_DB021E96E92F8F78 ON messages');
        $this->addSql('ALTER TABLE messages ADD sender_id_id INT NOT NULL, ADD recipient_id_id INT NOT NULL, DROP sender_id, DROP recipient_id');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E962B6945EC FOREIGN KEY (recipient_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E966061F7CF FOREIGN KEY (sender_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DB021E962B6945EC ON messages (recipient_id_id)');
        $this->addSql('CREATE INDEX IDX_DB021E966061F7CF ON messages (sender_id_id)');
    }
}
