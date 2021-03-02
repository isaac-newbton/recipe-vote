<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210302180319 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media_file (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, alt_text VARCHAR(1024) NOT NULL, mime_type VARCHAR(255) NOT NULL, path VARCHAR(1024) NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', created_date_time DATETIME NOT NULL, UNIQUE INDEX UNIQ_4FD8E9C3D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, main_image_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, entry_email VARCHAR(255) NOT NULL, entry_opt_in TINYINT(1) NOT NULL, published TINYINT(1) DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', created_date_time DATETIME NOT NULL, UNIQUE INDEX UNIQ_DA88B137D17F50A6 (uuid), INDEX IDX_DA88B137E4873418 (main_image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_media_file (recipe_id INT NOT NULL, media_file_id INT NOT NULL, INDEX IDX_6A66FA059D8A214 (recipe_id), INDEX IDX_6A66FA0F21CFF25 (media_file_id), PRIMARY KEY(recipe_id, media_file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_vote (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, voter_email VARCHAR(255) NOT NULL, voter_opt_in TINYINT(1) NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', created_date_time DATETIME NOT NULL, UNIQUE INDEX UNIQ_250BDFBBD17F50A6 (uuid), INDEX IDX_250BDFBB59D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137E4873418 FOREIGN KEY (main_image_id) REFERENCES media_file (id)');
        $this->addSql('ALTER TABLE recipe_media_file ADD CONSTRAINT FK_6A66FA059D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_media_file ADD CONSTRAINT FK_6A66FA0F21CFF25 FOREIGN KEY (media_file_id) REFERENCES media_file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_vote ADD CONSTRAINT FK_250BDFBB59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137E4873418');
        $this->addSql('ALTER TABLE recipe_media_file DROP FOREIGN KEY FK_6A66FA0F21CFF25');
        $this->addSql('ALTER TABLE recipe_media_file DROP FOREIGN KEY FK_6A66FA059D8A214');
        $this->addSql('ALTER TABLE recipe_vote DROP FOREIGN KEY FK_250BDFBB59D8A214');
        $this->addSql('DROP TABLE media_file');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE recipe_media_file');
        $this->addSql('DROP TABLE recipe_vote');
    }
}
