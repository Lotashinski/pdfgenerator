<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219131655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE api_key (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, service LONGTEXT NOT NULL, description LONGTEXT DEFAULT NULL, creator VARCHAR(255) NOT NULL, creator_tnn INT NOT NULL, UNIQUE INDEX UNIQ_C912ED9D1D775834 (value), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (tnn INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(tnn)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE api_key');
        $this->addSql('DROP TABLE `user`');
    }
}
