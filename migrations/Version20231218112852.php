<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218112852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE atelier_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE competence_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE intervenant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE lycee_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE lyceen_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE metier_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE question_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE questionnaire_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reponse_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ressource_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE salle_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE secteur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sponsor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE atelier (id INT NOT NULL, secteur_id INT NOT NULL, salle_id INT NOT NULL, nom VARCHAR(255) NOT NULL, heure VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E1BB18239F7E4405 ON atelier (secteur_id)');
        $this->addSql('CREATE INDEX IDX_E1BB1823DC304035 ON atelier (salle_id)');
        $this->addSql('CREATE TABLE atelier_intervenant (atelier_id INT NOT NULL, intervenant_id INT NOT NULL, PRIMARY KEY(atelier_id, intervenant_id))');
        $this->addSql('CREATE INDEX IDX_DAC6F4282E2CF35 ON atelier_intervenant (atelier_id)');
        $this->addSql('CREATE INDEX IDX_DAC6F42AB9A1716 ON atelier_intervenant (intervenant_id)');
        $this->addSql('CREATE TABLE competence (id INT NOT NULL, metier_id INT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_94D4687FED16FA20 ON competence (metier_id)');
        $this->addSql('CREATE TABLE intervenant (id INT NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, entreprise VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE lycee (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE lyceen (id INT NOT NULL, lycee_id INT NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, date_inscription DATE NOT NULL, section VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EF396EA7D1DC61BF ON lyceen (lycee_id)');
        $this->addSql('CREATE TABLE lyceen_atelier (lyceen_id INT NOT NULL, atelier_id INT NOT NULL, PRIMARY KEY(lyceen_id, atelier_id))');
        $this->addSql('CREATE INDEX IDX_670326181E0D401B ON lyceen_atelier (lyceen_id)');
        $this->addSql('CREATE INDEX IDX_6703261882E2CF35 ON lyceen_atelier (atelier_id)');
        $this->addSql('CREATE TABLE metier (id INT NOT NULL, atelier_id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_51A00D8C82E2CF35 ON metier (atelier_id)');
        $this->addSql('CREATE TABLE question (id INT NOT NULL, intitule VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE questionnaire (id INT NOT NULL, annee DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE questionnaire_question (questionnaire_id INT NOT NULL, question_id INT NOT NULL, PRIMARY KEY(questionnaire_id, question_id))');
        $this->addSql('CREATE INDEX IDX_28CC40C3CE07E8FF ON questionnaire_question (questionnaire_id)');
        $this->addSql('CREATE INDEX IDX_28CC40C31E27F6BF ON questionnaire_question (question_id)');
        $this->addSql('CREATE TABLE reponse (id INT NOT NULL, question_id INT NOT NULL, lyceen_id INT NOT NULL, contenu VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5FB6DEC71E27F6BF ON reponse (question_id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC71E0D401B ON reponse (lyceen_id)');
        $this->addSql('CREATE TABLE ressource (id INT NOT NULL, atelier_id INT NOT NULL, type VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_939F454482E2CF35 ON ressource (atelier_id)');
        $this->addSql('CREATE TABLE salle (id INT NOT NULL, nom VARCHAR(255) NOT NULL, etage INT NOT NULL, capacite INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE secteur (id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE sponsor (id INT NOT NULL, logo VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, annee INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB18239F7E4405 FOREIGN KEY (secteur_id) REFERENCES secteur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB1823DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE atelier_intervenant ADD CONSTRAINT FK_DAC6F4282E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE atelier_intervenant ADD CONSTRAINT FK_DAC6F42AB9A1716 FOREIGN KEY (intervenant_id) REFERENCES intervenant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687FED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lyceen ADD CONSTRAINT FK_EF396EA7D1DC61BF FOREIGN KEY (lycee_id) REFERENCES lycee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lyceen_atelier ADD CONSTRAINT FK_670326181E0D401B FOREIGN KEY (lyceen_id) REFERENCES lyceen (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lyceen_atelier ADD CONSTRAINT FK_6703261882E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier ADD CONSTRAINT FK_51A00D8C82E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questionnaire_question ADD CONSTRAINT FK_28CC40C3CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questionnaire_question ADD CONSTRAINT FK_28CC40C31E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71E0D401B FOREIGN KEY (lyceen_id) REFERENCES lyceen (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F454482E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE atelier_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE competence_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE intervenant_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE lycee_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE lyceen_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE metier_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE question_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE questionnaire_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reponse_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ressource_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE salle_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE secteur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sponsor_id_seq CASCADE');
        $this->addSql('ALTER TABLE atelier DROP CONSTRAINT FK_E1BB18239F7E4405');
        $this->addSql('ALTER TABLE atelier DROP CONSTRAINT FK_E1BB1823DC304035');
        $this->addSql('ALTER TABLE atelier_intervenant DROP CONSTRAINT FK_DAC6F4282E2CF35');
        $this->addSql('ALTER TABLE atelier_intervenant DROP CONSTRAINT FK_DAC6F42AB9A1716');
        $this->addSql('ALTER TABLE competence DROP CONSTRAINT FK_94D4687FED16FA20');
        $this->addSql('ALTER TABLE lyceen DROP CONSTRAINT FK_EF396EA7D1DC61BF');
        $this->addSql('ALTER TABLE lyceen_atelier DROP CONSTRAINT FK_670326181E0D401B');
        $this->addSql('ALTER TABLE lyceen_atelier DROP CONSTRAINT FK_6703261882E2CF35');
        $this->addSql('ALTER TABLE metier DROP CONSTRAINT FK_51A00D8C82E2CF35');
        $this->addSql('ALTER TABLE questionnaire_question DROP CONSTRAINT FK_28CC40C3CE07E8FF');
        $this->addSql('ALTER TABLE questionnaire_question DROP CONSTRAINT FK_28CC40C31E27F6BF');
        $this->addSql('ALTER TABLE reponse DROP CONSTRAINT FK_5FB6DEC71E27F6BF');
        $this->addSql('ALTER TABLE reponse DROP CONSTRAINT FK_5FB6DEC71E0D401B');
        $this->addSql('ALTER TABLE ressource DROP CONSTRAINT FK_939F454482E2CF35');
        $this->addSql('DROP TABLE atelier');
        $this->addSql('DROP TABLE atelier_intervenant');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE intervenant');
        $this->addSql('DROP TABLE lycee');
        $this->addSql('DROP TABLE lyceen');
        $this->addSql('DROP TABLE lyceen_atelier');
        $this->addSql('DROP TABLE metier');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE questionnaire');
        $this->addSql('DROP TABLE questionnaire_question');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE ressource');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE sponsor');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
