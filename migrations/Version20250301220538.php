<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250301220538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Spaces (id VARCHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, state BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE events (id VARCHAR(36) NOT NULL, organizer_id VARCHAR(36) NOT NULL, space_id VARCHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, state BOOLEAN NOT NULL, date_start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_end TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5387574A876C4DDA ON events (organizer_id)');
        $this->addSql('CREATE INDEX IDX_5387574A23575340 ON events (space_id)');
        $this->addSql('CREATE TABLE users (id VARCHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, surnames VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A876C4DDA FOREIGN KEY (organizer_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A23575340 FOREIGN KEY (space_id) REFERENCES Spaces (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('
            INSERT INTO public.users (id, name, surnames, email, roles, password, active, created_at, updated_at) 
            VALUES 
            (\'88cdb83b-086d-4469-a831-d7eb0731ec89\', \'Eimmy\', \'Merchan\', \'eimmy@gmail.com\', \'["ROLE_USER"]\', 
            \'$2y$13$.tTjGRh/bAUWySpz81tV/.SxhhrsDbWjspiug5by3pwrdYuiw..Zm\', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
            (\'7cc78db6-74f9-4357-a219-7bd54e118a32\', \'Josep\', \'Perez\', \'josep@gmail.com\', \'["ROLE_USER"]\', 
            \'$2y$13$QUtRAt/CCjpe4qSWzCv/ieOIw5ftcv6nTqFiyZPrFmlDQfhrQvex.\', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
            (\'e2db9911-b063-4bb5-8409-db246ed6e149\', \'Juli\', \'Aleph\', \'juli@gmail.com\', \'["ROLE_USER"]\', 
            \'$2y$13$sqI6RswDtu.kBlLHm6pHdO55Qw0O5u4ojlkhibuee9giiKwWEfWAy\', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
            (\'70ab2121-e118-425b-8a26-9e3e89aa2df0\', \'Flor\', \'Amerga\', \'flor@gmail.com\', \'["ROLE_USER"]\', 
            \'$2y$13$ridDhlIVo92wsaUOpbYEJ.ExriiB4PBZuC6PraqIwJ4wvRSiq1w/i\', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
            (\'c0ddbcf4-6412-40ef-bf1e-8d03df96f558\', \'Pedro\', \'Pelaes\', \'pedro@gmail.com\', \'["ROLE_USER"]\', 
            \'$2y$13$JxYK5xC0FkgUbT/z0ospjO0Jb3P61fFf06ctDSEuXJ86I/MdY62Mu\', true, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
        ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE events DROP CONSTRAINT FK_5387574A876C4DDA');
        $this->addSql('ALTER TABLE events DROP CONSTRAINT FK_5387574A23575340');
        $this->addSql('DROP TABLE Spaces');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE users');
    }
}
