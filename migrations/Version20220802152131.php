<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220802152131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE buyer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE countries_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE engine_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE province_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ticket_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ztl_pass_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE buyer (id INT NOT NULL, country_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, cap VARCHAR(5) NOT NULL, mail VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, phone2 VARCHAR(255) DEFAULT NULL, p_iva VARCHAR(255) NOT NULL, c_fis VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_84905FB3F92F3E70 ON buyer (country_id)');
        $this->addSql('CREATE TABLE countries (id INT NOT NULL, name VARCHAR(255) NOT NULL, abbreviation VARCHAR(2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE engine_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE province (id INT NOT NULL, name VARCHAR(255) NOT NULL, abbreviation VARCHAR(2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ticket (id INT NOT NULL, pass_type_id INT NOT NULL, engine_type_id INT NOT NULL, country_id INT NOT NULL, province_id INT NOT NULL, buyer_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, car_registration VARCHAR(255) NOT NULL, business VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_97A0ADA3CEB37D6F ON ticket (pass_type_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3577F21F8 ON ticket (engine_type_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3F92F3E70 ON ticket (country_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3E946114A ON ticket (province_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA36C755722 ON ticket (buyer_id)');
        $this->addSql('CREATE TABLE ztl_pass_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, price_low INT NOT NULL, price_high INT NOT NULL, PRIMARY KEY(id))');
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
        $this->addSql('ALTER TABLE buyer ADD CONSTRAINT FK_84905FB3F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3CEB37D6F FOREIGN KEY (pass_type_id) REFERENCES ztl_pass_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3577F21F8 FOREIGN KEY (engine_type_id) REFERENCES engine_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3E946114A FOREIGN KEY (province_id) REFERENCES province (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA36C755722 FOREIGN KEY (buyer_id) REFERENCES buyer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA36C755722');
        $this->addSql('ALTER TABLE buyer DROP CONSTRAINT FK_84905FB3F92F3E70');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA3F92F3E70');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA3577F21F8');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA3E946114A');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA3CEB37D6F');
        $this->addSql('DROP SEQUENCE buyer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE countries_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE engine_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE province_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ticket_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ztl_pass_type_id_seq CASCADE');
        $this->addSql('DROP TABLE buyer');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE engine_type');
        $this->addSql('DROP TABLE province');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE ztl_pass_type');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
