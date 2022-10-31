<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221031161518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, id_profil_id INT NOT NULL, image_name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_5A8A6C8DA76B6C5F (id_profil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_comment (id INT AUTO_INCREMENT NOT NULL, id_profil_id INT NOT NULL, id_post_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_A99CE55FA76B6C5F (id_profil_id), INDEX IDX_A99CE55F9514AA5C (id_post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_comment_like (id INT AUTO_INCREMENT NOT NULL, id_comment_id INT NOT NULL, id_profil_id INT NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_21689F8C5DE3FDC4 (id_comment_id), INDEX IDX_21689F8CA76B6C5F (id_profil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_like (id INT AUTO_INCREMENT NOT NULL, id_profil_id INT NOT NULL, id_post_id INT NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_653627B8A76B6C5F (id_profil_id), INDEX IDX_653627B89514AA5C (id_post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, image_name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, siret VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_E6D6B297A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE story (id INT AUTO_INCREMENT NOT NULL, id_profil_id INT NOT NULL, image_name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_EB560438A76B6C5F (id_profil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE story_like (id INT AUTO_INCREMENT NOT NULL, id_story_id INT NOT NULL, id_profil_id INT NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_3ACE2C9DFA86ACA3 (id_story_id), INDEX IDX_3ACE2C9DA76B6C5F (id_profil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76B6C5F FOREIGN KEY (id_profil_id) REFERENCES profil (id)');
        $this->addSql('ALTER TABLE post_comment ADD CONSTRAINT FK_A99CE55FA76B6C5F FOREIGN KEY (id_profil_id) REFERENCES profil (id)');
        $this->addSql('ALTER TABLE post_comment ADD CONSTRAINT FK_A99CE55F9514AA5C FOREIGN KEY (id_post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE post_comment_like ADD CONSTRAINT FK_21689F8C5DE3FDC4 FOREIGN KEY (id_comment_id) REFERENCES post_comment (id)');
        $this->addSql('ALTER TABLE post_comment_like ADD CONSTRAINT FK_21689F8CA76B6C5F FOREIGN KEY (id_profil_id) REFERENCES profil (id)');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B8A76B6C5F FOREIGN KEY (id_profil_id) REFERENCES profil (id)');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B89514AA5C FOREIGN KEY (id_post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE profil ADD CONSTRAINT FK_E6D6B297A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB560438A76B6C5F FOREIGN KEY (id_profil_id) REFERENCES profil (id)');
        $this->addSql('ALTER TABLE story_like ADD CONSTRAINT FK_3ACE2C9DFA86ACA3 FOREIGN KEY (id_story_id) REFERENCES story (id)');
        $this->addSql('ALTER TABLE story_like ADD CONSTRAINT FK_3ACE2C9DA76B6C5F FOREIGN KEY (id_profil_id) REFERENCES profil (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA76B6C5F');
        $this->addSql('ALTER TABLE post_comment DROP FOREIGN KEY FK_A99CE55FA76B6C5F');
        $this->addSql('ALTER TABLE post_comment DROP FOREIGN KEY FK_A99CE55F9514AA5C');
        $this->addSql('ALTER TABLE post_comment_like DROP FOREIGN KEY FK_21689F8C5DE3FDC4');
        $this->addSql('ALTER TABLE post_comment_like DROP FOREIGN KEY FK_21689F8CA76B6C5F');
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B8A76B6C5F');
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B89514AA5C');
        $this->addSql('ALTER TABLE profil DROP FOREIGN KEY FK_E6D6B297A76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB560438A76B6C5F');
        $this->addSql('ALTER TABLE story_like DROP FOREIGN KEY FK_3ACE2C9DFA86ACA3');
        $this->addSql('ALTER TABLE story_like DROP FOREIGN KEY FK_3ACE2C9DA76B6C5F');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_comment');
        $this->addSql('DROP TABLE post_comment_like');
        $this->addSql('DROP TABLE post_like');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE story');
        $this->addSql('DROP TABLE story_like');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
