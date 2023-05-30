<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230529022207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE localidad_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE oficina_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE persona_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE turno_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE localidad (id INT NOT NULL, localidad VARCHAR(120) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE oficina (id INT NOT NULL, localidad_id INT NOT NULL, oficina VARCHAR(120) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_543A5AC67707C89 ON oficina (localidad_id)');
        $this->addSql('CREATE TABLE persona (id INT NOT NULL, nombre VARCHAR(120) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE turno (id INT NOT NULL, oficina_id INT DEFAULT NULL, persona_id INT DEFAULT NULL, fecha TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E79767628A8639B7 ON turno (oficina_id)');
        $this->addSql('CREATE INDEX IDX_E7976762F5F88DB9 ON turno (persona_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE oficina ADD CONSTRAINT FK_543A5AC67707C89 FOREIGN KEY (localidad_id) REFERENCES localidad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE turno ADD CONSTRAINT FK_E79767628A8639B7 FOREIGN KEY (oficina_id) REFERENCES oficina (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE turno ADD CONSTRAINT FK_E7976762F5F88DB9 FOREIGN KEY (persona_id) REFERENCES persona (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE localidad_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE oficina_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE persona_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE turno_id_seq CASCADE');
        $this->addSql('ALTER TABLE oficina DROP CONSTRAINT FK_543A5AC67707C89');
        $this->addSql('ALTER TABLE turno DROP CONSTRAINT FK_E79767628A8639B7');
        $this->addSql('ALTER TABLE turno DROP CONSTRAINT FK_E7976762F5F88DB9');
        $this->addSql('DROP TABLE localidad');
        $this->addSql('DROP TABLE oficina');
        $this->addSql('DROP TABLE persona');
        $this->addSql('DROP TABLE turno');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
