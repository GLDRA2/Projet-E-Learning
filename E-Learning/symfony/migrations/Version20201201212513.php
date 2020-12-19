<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201201212513 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity ADD cour_id INT NOT NULL');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AB7942F03 FOREIGN KEY (cour_id) REFERENCES cour (id)');
        $this->addSql('CREATE INDEX IDX_AC74095AB7942F03 ON activity (cour_id)');
        $this->addSql('ALTER TABLE upload ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE upload ADD CONSTRAINT FK_17BDE61FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_17BDE61FA76ED395 ON upload (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AB7942F03');
        $this->addSql('DROP INDEX IDX_AC74095AB7942F03 ON activity');
        $this->addSql('ALTER TABLE activity DROP cour_id');
        $this->addSql('ALTER TABLE upload DROP FOREIGN KEY FK_17BDE61FA76ED395');
        $this->addSql('DROP INDEX IDX_17BDE61FA76ED395 ON upload');
        $this->addSql('ALTER TABLE upload DROP user_id');
    }
}
