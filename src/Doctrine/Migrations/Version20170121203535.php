<?php

namespace Emporium\Svc\Alert\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170121203535 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE subscriptions (id INT AUTO_INCREMENT NOT NULL, subscriber_id INT DEFAULT NULL, category VARCHAR(255) NOT NULL, severity VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_4778A017808B1AD (subscriber_id), INDEX created_at_index (created_at), INDEX category_index (category), INDEX severity_index (severity), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subscriptions ADD CONSTRAINT FK_4778A017808B1AD FOREIGN KEY (subscriber_id) REFERENCES subscribers (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE subscriptions');
    }
}
