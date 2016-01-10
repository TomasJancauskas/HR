<?php

namespace AppBundle\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160110221008 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE employees (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, job_id INT DEFAULT NULL, firstname VARCHAR(64) NOT NULL, lastname VARCHAR(64) NOT NULL, birthdate DATETIME NOT NULL, joined_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_BA82C30064D218E (location_id), INDEX IDX_BA82C300BE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_fixtures (name VARCHAR(255) NOT NULL, PRIMARY KEY(name)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jobs (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locations (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, salt VARCHAR(48) NOT NULL, firstname VARCHAR(64) DEFAULT NULL, lastname VARCHAR(64) DEFAULT NULL, confirmation_token VARCHAR(48) DEFAULT NULL, roles INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, password VARCHAR(64) DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vacations (id INT AUTO_INCREMENT NOT NULL, employee_id INT DEFAULT NULL, starts_at DATETIME NOT NULL, ends_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_3B8290678C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employees ADD CONSTRAINT FK_BA82C30064D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE employees ADD CONSTRAINT FK_BA82C300BE04EA9 FOREIGN KEY (job_id) REFERENCES jobs (id)');
        $this->addSql('ALTER TABLE vacations ADD CONSTRAINT FK_3B8290678C03F15C FOREIGN KEY (employee_id) REFERENCES employees (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vacations DROP FOREIGN KEY FK_3B8290678C03F15C');
        $this->addSql('ALTER TABLE employees DROP FOREIGN KEY FK_BA82C300BE04EA9');
        $this->addSql('ALTER TABLE employees DROP FOREIGN KEY FK_BA82C30064D218E');
        $this->addSql('DROP TABLE employees');
        $this->addSql('DROP TABLE app_fixtures');
        $this->addSql('DROP TABLE jobs');
        $this->addSql('DROP TABLE locations');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE vacations');
    }
}
