<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211027174300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add github event type';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO event_type (id, label) values (1, 'CommitCommentEvent')");
        $this->addSql("INSERT INTO event_type (id, label) values (2, 'PullRequestReviewCommentEvent')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DELETE FROM event_type WHERE label = 'CommitCommentEvent'");
        $this->addSql("DELETE FROM event_type WHERE label = 'PullRequestReviewCommentEvent'");
    }
}
