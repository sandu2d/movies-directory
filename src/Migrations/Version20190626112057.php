<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190626112057 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE actor_award (id INT AUTO_INCREMENT NOT NULL, actor_id INT NOT NULL, award_id INT NOT NULL, award_category_id INT NOT NULL, INDEX IDX_AEDFC57310DAF24A (actor_id), INDEX IDX_AEDFC5733D5282CF (award_id), INDEX IDX_AEDFC573169396C4 (award_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE award (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, is_international TINYINT(1) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_8A5B2EE7F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actor (id INT AUTO_INCREMENT NOT NULL, nationality_id INT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, INDEX IDX_447556F91C9DA55 (nationality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(2) NOT NULL, nationality VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie_award (id INT AUTO_INCREMENT NOT NULL, movie_id INT NOT NULL, award_id INT NOT NULL, award_category_id INT NOT NULL, type VARCHAR(3) NOT NULL, INDEX IDX_F419347B8F93B6FC (movie_id), INDEX IDX_F419347B3D5282CF (award_id), INDEX IDX_F419347B169396C4 (award_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE director_award (id INT AUTO_INCREMENT NOT NULL, director_id INT NOT NULL, award_id INT NOT NULL, award_category_id INT NOT NULL, INDEX IDX_705CB135899FB366 (director_id), INDEX IDX_705CB1353D5282CF (award_id), INDEX IDX_705CB135169396C4 (award_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, year INT NOT NULL, imdb_rate DOUBLE PRECISION DEFAULT NULL, box_office VARCHAR(255) DEFAULT NULL, language INT DEFAULT NULL, poster VARCHAR(255) NOT NULL, INDEX IDX_1D5EF26FF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie_genre (movie_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_FD1229648F93B6FC (movie_id), INDEX IDX_FD1229644296D31F (genre_id), PRIMARY KEY(movie_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie_actor (movie_id INT NOT NULL, actor_id INT NOT NULL, INDEX IDX_3A374C658F93B6FC (movie_id), INDEX IDX_3A374C6510DAF24A (actor_id), PRIMARY KEY(movie_id, actor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie_director (movie_id INT NOT NULL, director_id INT NOT NULL, INDEX IDX_C266487D8F93B6FC (movie_id), INDEX IDX_C266487D899FB366 (director_id), PRIMARY KEY(movie_id, director_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE award_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE director (id INT AUTO_INCREMENT NOT NULL, nationality_id INT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, INDEX IDX_1E90D3F01C9DA55 (nationality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actor_award ADD CONSTRAINT FK_AEDFC57310DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id)');
        $this->addSql('ALTER TABLE actor_award ADD CONSTRAINT FK_AEDFC5733D5282CF FOREIGN KEY (award_id) REFERENCES award (id)');
        $this->addSql('ALTER TABLE actor_award ADD CONSTRAINT FK_AEDFC573169396C4 FOREIGN KEY (award_category_id) REFERENCES award_category (id)');
        $this->addSql('ALTER TABLE award ADD CONSTRAINT FK_8A5B2EE7F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE actor ADD CONSTRAINT FK_447556F91C9DA55 FOREIGN KEY (nationality_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE movie_award ADD CONSTRAINT FK_F419347B8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id)');
        $this->addSql('ALTER TABLE movie_award ADD CONSTRAINT FK_F419347B3D5282CF FOREIGN KEY (award_id) REFERENCES award (id)');
        $this->addSql('ALTER TABLE movie_award ADD CONSTRAINT FK_F419347B169396C4 FOREIGN KEY (award_category_id) REFERENCES award_category (id)');
        $this->addSql('ALTER TABLE director_award ADD CONSTRAINT FK_705CB135899FB366 FOREIGN KEY (director_id) REFERENCES director (id)');
        $this->addSql('ALTER TABLE director_award ADD CONSTRAINT FK_705CB1353D5282CF FOREIGN KEY (award_id) REFERENCES award (id)');
        $this->addSql('ALTER TABLE director_award ADD CONSTRAINT FK_705CB135169396C4 FOREIGN KEY (award_category_id) REFERENCES award_category (id)');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26FF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE movie_genre ADD CONSTRAINT FK_FD1229648F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_genre ADD CONSTRAINT FK_FD1229644296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_actor ADD CONSTRAINT FK_3A374C658F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_actor ADD CONSTRAINT FK_3A374C6510DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_director ADD CONSTRAINT FK_C266487D8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_director ADD CONSTRAINT FK_C266487D899FB366 FOREIGN KEY (director_id) REFERENCES director (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE director ADD CONSTRAINT FK_1E90D3F01C9DA55 FOREIGN KEY (nationality_id) REFERENCES country (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actor_award DROP FOREIGN KEY FK_AEDFC5733D5282CF');
        $this->addSql('ALTER TABLE movie_award DROP FOREIGN KEY FK_F419347B3D5282CF');
        $this->addSql('ALTER TABLE director_award DROP FOREIGN KEY FK_705CB1353D5282CF');
        $this->addSql('ALTER TABLE actor_award DROP FOREIGN KEY FK_AEDFC57310DAF24A');
        $this->addSql('ALTER TABLE movie_actor DROP FOREIGN KEY FK_3A374C6510DAF24A');
        $this->addSql('ALTER TABLE award DROP FOREIGN KEY FK_8A5B2EE7F92F3E70');
        $this->addSql('ALTER TABLE actor DROP FOREIGN KEY FK_447556F91C9DA55');
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26FF92F3E70');
        $this->addSql('ALTER TABLE director DROP FOREIGN KEY FK_1E90D3F01C9DA55');
        $this->addSql('ALTER TABLE movie_award DROP FOREIGN KEY FK_F419347B8F93B6FC');
        $this->addSql('ALTER TABLE movie_genre DROP FOREIGN KEY FK_FD1229648F93B6FC');
        $this->addSql('ALTER TABLE movie_actor DROP FOREIGN KEY FK_3A374C658F93B6FC');
        $this->addSql('ALTER TABLE movie_director DROP FOREIGN KEY FK_C266487D8F93B6FC');
        $this->addSql('ALTER TABLE actor_award DROP FOREIGN KEY FK_AEDFC573169396C4');
        $this->addSql('ALTER TABLE movie_award DROP FOREIGN KEY FK_F419347B169396C4');
        $this->addSql('ALTER TABLE director_award DROP FOREIGN KEY FK_705CB135169396C4');
        $this->addSql('ALTER TABLE movie_genre DROP FOREIGN KEY FK_FD1229644296D31F');
        $this->addSql('ALTER TABLE director_award DROP FOREIGN KEY FK_705CB135899FB366');
        $this->addSql('ALTER TABLE movie_director DROP FOREIGN KEY FK_C266487D899FB366');
        $this->addSql('DROP TABLE actor_award');
        $this->addSql('DROP TABLE award');
        $this->addSql('DROP TABLE actor');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE movie_award');
        $this->addSql('DROP TABLE director_award');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE movie_genre');
        $this->addSql('DROP TABLE movie_actor');
        $this->addSql('DROP TABLE movie_director');
        $this->addSql('DROP TABLE award_category');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE director');
    }
}
