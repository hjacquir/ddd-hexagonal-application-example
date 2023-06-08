<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230607063630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create user, githubEvent and githubEventType';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // idempotence : check table if exists for schema public
        $this->addSql('CREATE TABLE IF NOT EXISTS public.app_user (id INT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        // idempotence : we drop index and recreate it
        $this->addSql('DROP INDEX IF EXISTS UNIQ_BAF4046AA08CB10');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BAF4046AA08CB10 ON app_user (login)');
        // idempotence : check table if exists for schema public
        $this->addSql('CREATE TABLE IF NOT EXISTS public.github_event (id INT NOT NULL, body TEXT DEFAULT NULL, repos TEXT NOT NULL, uuid VARCHAR(255) NOT NULL, eventDate TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, eventHour INT NOT NULL, github_event_type_id INT DEFAULT NULL, PRIMARY KEY(id))');
        // idempotence : we drop index and recreate it
        $this->addSql('DROP INDEX IF EXISTS IDX_AAB8C46157912224');
        $this->addSql('CREATE INDEX IDX_AAB8C46157912224 ON github_event (github_event_type_id)');
        // idempotence : check table if exists for schema public
        $this->addSql('CREATE TABLE IF NOT EXISTS public.github_event_type (id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        // idempotence : we drop index and recreate it
        $this->addSql('DROP INDEX IF EXISTS UNIQ_903148FAEA750E8');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_903148FAEA750E8 ON github_event_type (label)');
        // idempotence : we drop constraint and recreate it
        $this->addSql('ALTER TABLE github_event DROP CONSTRAINT IF EXISTS FK_AAB8C46157912224');
        $this->addSql('ALTER TABLE github_event ADD CONSTRAINT FK_AAB8C46157912224 FOREIGN KEY (github_event_type_id) REFERENCES github_event_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        // we rename the indexes here because when we do a diff after the creation of the indexes they are renamed
        // in uppercase
        $this->addSql('ALTER INDEX uniq_baf4046aa08cb10 RENAME TO UNIQ_88BDF3E9AA08CB10');
        $this->addSql('ALTER INDEX idx_aab8c46157912224 RENAME TO IDX_EC5268AB52181794');
        $this->addSql('ALTER INDEX uniq_903148faea750e8 RENAME TO UNIQ_B56D1067EA750E8');

        // idempotence : we drop SEQUENCE and recreate it
        $this->addSql('DROP SEQUENCE IF EXISTS app_user_id_seq');
        $this->addSql('CREATE SEQUENCE app_user_id_seq');
        $this->addSql('SELECT setval(\'app_user_id_seq\', (SELECT MAX(id) FROM app_user))');
        $this->addSql('ALTER TABLE app_user ALTER id SET DEFAULT nextval(\'app_user_id_seq\')');
        // idempotence : we drop SEQUENCE and recreate it
        $this->addSql('DROP SEQUENCE IF EXISTS github_event_id_seq');
        $this->addSql('CREATE SEQUENCE github_event_id_seq');
        $this->addSql('SELECT setval(\'github_event_id_seq\', (SELECT MAX(id) FROM github_event))');
        $this->addSql('ALTER TABLE github_event ALTER id SET DEFAULT nextval(\'github_event_id_seq\')');
        // idempotence : we drop SEQUENCE and recreate it
        $this->addSql('DROP SEQUENCE IF EXISTS github_event_type_id_seq');
        $this->addSql('CREATE SEQUENCE github_event_type_id_seq');
        $this->addSql('SELECT setval(\'github_event_type_id_seq\', (SELECT MAX(id) FROM github_event_type))');
        $this->addSql('ALTER TABLE github_event_type ALTER id SET DEFAULT nextval(\'github_event_type_id_seq\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE app_user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE github_event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE github_event_type_id_seq CASCADE');
        $this->addSql('ALTER TABLE github_event DROP CONSTRAINT FK_AAB8C46157912224');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP TABLE github_event');
        $this->addSql('DROP TABLE github_event_type');
    }
}
