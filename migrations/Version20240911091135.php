<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240911091135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrateur_systeme (id INT NOT NULL, id_admin INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aidant (id INT NOT NULL, specialisation VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aidant_traitement (aidant_id INT NOT NULL, traitement_id INT NOT NULL, INDEX IDX_F1A6E0A085BB6C15 (aidant_id), INDEX IDX_F1A6E0A0DDA344B6 (traitement_id), PRIMARY KEY(aidant_id, traitement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicament (id INT AUTO_INCREMENT NOT NULL, ordonnance_id INT DEFAULT NULL, id_medicament INT NOT NULL, description VARCHAR(500) NOT NULL, posologie_ordonnance VARCHAR(255) NOT NULL, INDEX IDX_9A9C723A2BF23B8F (ordonnance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, pilulier_id INT DEFAULT NULL, id_notification INT NOT NULL, message LONGTEXT NOT NULL, INDEX IDX_BF5476CA8CB9D5EA (pilulier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification_aidant (notification_id INT NOT NULL, aidant_id INT NOT NULL, INDEX IDX_73A8A472EF1A9D84 (notification_id), INDEX IDX_73A8A47285BB6C15 (aidant_id), PRIMARY KEY(notification_id, aidant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordonnance (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, pilulier_id INT DEFAULT NULL, id_ordonnance INT NOT NULL, posologie VARCHAR(255) NOT NULL, frequence VARCHAR(255) NOT NULL, INDEX IDX_924B326C6B899279 (patient_id), INDEX IDX_924B326C8CB9D5EA (pilulier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT NOT NULL, pilulier_id INT DEFAULT NULL, historique_medical LONGTEXT NOT NULL, allergies JSON DEFAULT NULL, adresse_postale VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, INDEX IDX_1ADAD7EB8CB9D5EA (pilulier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pilulier (id INT AUTO_INCREMENT NOT NULL, activation_bouton_urgence TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE traitement (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, id_traitement INT NOT NULL, description VARCHAR(500) NOT NULL, posologie VARCHAR(255) NOT NULL, INDEX IDX_2A356D276B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrateur_systeme ADD CONSTRAINT FK_A22C4A73BF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aidant ADD CONSTRAINT FK_B70F5A2FBF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aidant_traitement ADD CONSTRAINT FK_F1A6E0A085BB6C15 FOREIGN KEY (aidant_id) REFERENCES aidant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aidant_traitement ADD CONSTRAINT FK_F1A6E0A0DDA344B6 FOREIGN KEY (traitement_id) REFERENCES traitement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medicament ADD CONSTRAINT FK_9A9C723A2BF23B8F FOREIGN KEY (ordonnance_id) REFERENCES ordonnance (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA8CB9D5EA FOREIGN KEY (pilulier_id) REFERENCES pilulier (id)');
        $this->addSql('ALTER TABLE notification_aidant ADD CONSTRAINT FK_73A8A472EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notification_aidant ADD CONSTRAINT FK_73A8A47285BB6C15 FOREIGN KEY (aidant_id) REFERENCES aidant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C8CB9D5EA FOREIGN KEY (pilulier_id) REFERENCES pilulier (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB8CB9D5EA FOREIGN KEY (pilulier_id) REFERENCES pilulier (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBBF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traitement ADD CONSTRAINT FK_2A356D276B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrateur_systeme DROP FOREIGN KEY FK_A22C4A73BF396750');
        $this->addSql('ALTER TABLE aidant DROP FOREIGN KEY FK_B70F5A2FBF396750');
        $this->addSql('ALTER TABLE aidant_traitement DROP FOREIGN KEY FK_F1A6E0A085BB6C15');
        $this->addSql('ALTER TABLE aidant_traitement DROP FOREIGN KEY FK_F1A6E0A0DDA344B6');
        $this->addSql('ALTER TABLE medicament DROP FOREIGN KEY FK_9A9C723A2BF23B8F');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA8CB9D5EA');
        $this->addSql('ALTER TABLE notification_aidant DROP FOREIGN KEY FK_73A8A472EF1A9D84');
        $this->addSql('ALTER TABLE notification_aidant DROP FOREIGN KEY FK_73A8A47285BB6C15');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326C6B899279');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326C8CB9D5EA');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB8CB9D5EA');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBBF396750');
        $this->addSql('ALTER TABLE traitement DROP FOREIGN KEY FK_2A356D276B899279');
        $this->addSql('DROP TABLE administrateur_systeme');
        $this->addSql('DROP TABLE aidant');
        $this->addSql('DROP TABLE aidant_traitement');
        $this->addSql('DROP TABLE medicament');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE notification_aidant');
        $this->addSql('DROP TABLE ordonnance');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE pilulier');
        $this->addSql('DROP TABLE traitement');
        $this->addSql('DROP TABLE utilisateur');
    }
}
