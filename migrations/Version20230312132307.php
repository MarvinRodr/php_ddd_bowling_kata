<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230312132307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE launches (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', player_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', first_one INT DEFAULT 0 NOT NULL COMMENT \'The number of pins the player has bowled in the first throw\', second_one INT DEFAULT 0 NOT NULL COMMENT \'The number of pins the player has bowled in the second throw\', third_one INT DEFAULT 0 NOT NULL COMMENT \'The number of pins the player has bowled in the third throw\', num_frame INT NOT NULL COMMENT \'The number of frame\', INDEX IDX_C9B058399E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE players (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE launches ADD CONSTRAINT FK_C9B058399E6F5DF FOREIGN KEY (player_id) REFERENCES players (id)');

        // Create default player from migration
        $this->addSql(
            "
                INSERT INTO players
                (id, name)
                VALUES (
                    '9809905c-bf7c-11ed-a136-0242ac180003',
                    'Marvin From Migration'
                )
                "
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE launches DROP FOREIGN KEY FK_C9B058399E6F5DF');
        $this->addSql('DROP TABLE launches');
        $this->addSql('DROP TABLE players');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
