<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211112150249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, customer_number VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, create_date DATETIME NOT NULL, update_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, create_date DATETIME NOT NULL, update_date DATETIME NOT NULL, sum DOUBLE PRECISION NOT NULL, vat DOUBLE PRECISION NOT NULL, order_number VARCHAR(255) NOT NULL, INDEX IDX_F52993989395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, related_order_id INT NOT NULL, product_number VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, amount INT NOT NULL, price_total DOUBLE PRECISION NOT NULL, title VARCHAR(255) NOT NULL, vat DOUBLE PRECISION NOT NULL, create_date DATETIME NOT NULL, update_date DATETIME NOT NULL, INDEX IDX_52EA1F092B1C2395 (related_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F092B1C2395 FOREIGN KEY (related_order_id) REFERENCES `order` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F092B1C2395');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_item');
    }
}
