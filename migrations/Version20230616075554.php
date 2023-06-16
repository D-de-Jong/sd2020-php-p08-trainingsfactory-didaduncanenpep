<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230616075554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE register ADD lesson_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE register ADD CONSTRAINT FK_5FF94014CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('CREATE INDEX IDX_5FF94014CDF80196 ON register (lesson_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE register DROP FOREIGN KEY FK_5FF94014CDF80196');
        $this->addSql('DROP INDEX IDX_5FF94014CDF80196 ON register');
        $this->addSql('ALTER TABLE register DROP lesson_id');
    }
}
