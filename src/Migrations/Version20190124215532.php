<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190124215532 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE movie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, year INT DEFAULT NULL, rated VARCHAR(64) NOT NULL, released VARCHAR(255) DEFAULT NULL, genre VARCHAR(255) DEFAULT NULL, director VARCHAR(255) NOT NULL, writer LONGTEXT DEFAULT NULL, actors LONGTEXT NOT NULL, plot VARCHAR(255) DEFAULT NULL, languages VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, awards VARCHAR(255) NOT NULL, poster VARCHAR(255) NOT NULL, rating LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', metascore INT NOT NULL, imdbrating DOUBLE PRECISION NOT NULL, imdb_votes DOUBLE PRECISION NOT NULL, imdb_id VARCHAR(255) NOT NULL, dvd DATETIME NOT NULL, boxoffice VARCHAR(255) NOT NULL, production VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE movie');
    }
}
