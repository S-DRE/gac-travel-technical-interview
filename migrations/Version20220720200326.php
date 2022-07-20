<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220720200326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY fk_products_category_id');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY fk_products_category_id');
        $this->addSql('ALTER TABLE products CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('DROP INDEX fk_products_category_id ON products');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A12469DE2 ON products (category_id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT fk_products_category_id FOREIGN KEY (category_id) REFERENCES categories (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE stock_historic DROP FOREIGN KEY fk_stock_historic_product_id');
        $this->addSql('ALTER TABLE stock_historic DROP FOREIGN KEY fk_stock_historic_user_id');
        $this->addSql('ALTER TABLE stock_historic DROP FOREIGN KEY fk_stock_historic_product_id');
        $this->addSql('ALTER TABLE stock_historic DROP FOREIGN KEY fk_stock_historic_user_id');
        $this->addSql('ALTER TABLE stock_historic CHANGE user_id user_id INT NOT NULL, CHANGE product_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE stock_historic ADD CONSTRAINT FK_E294BB14A76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE stock_historic ADD CONSTRAINT FK_E294BB144584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('DROP INDEX fk_stock_historic_user_id ON stock_historic');
        $this->addSql('CREATE INDEX IDX_E294BB14A76ED395 ON stock_historic (user_id)');
        $this->addSql('DROP INDEX fk_stock_historic_product_id ON stock_historic');
        $this->addSql('CREATE INDEX IDX_E294BB144584665A ON stock_historic (product_id)');
        $this->addSql('ALTER TABLE stock_historic ADD CONSTRAINT fk_stock_historic_product_id FOREIGN KEY (product_id) REFERENCES products (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE stock_historic ADD CONSTRAINT fk_stock_historic_user_id FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE users CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A12469DE2');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A12469DE2');
        $this->addSql('ALTER TABLE products CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE category_id category_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT fk_products_category_id FOREIGN KEY (category_id) REFERENCES categories (id) ON UPDATE CASCADE');
        $this->addSql('DROP INDEX idx_b3ba5a5a12469de2 ON products');
        $this->addSql('CREATE INDEX fk_products_category_id ON products (category_id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE stock_historic DROP FOREIGN KEY FK_E294BB14A76ED395');
        $this->addSql('ALTER TABLE stock_historic DROP FOREIGN KEY FK_E294BB144584665A');
        $this->addSql('ALTER TABLE stock_historic DROP FOREIGN KEY FK_E294BB14A76ED395');
        $this->addSql('ALTER TABLE stock_historic DROP FOREIGN KEY FK_E294BB144584665A');
        $this->addSql('ALTER TABLE stock_historic CHANGE user_id user_id INT UNSIGNED NOT NULL, CHANGE product_id product_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE stock_historic ADD CONSTRAINT fk_stock_historic_product_id FOREIGN KEY (product_id) REFERENCES products (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE stock_historic ADD CONSTRAINT fk_stock_historic_user_id FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE CASCADE');
        $this->addSql('DROP INDEX idx_e294bb14a76ed395 ON stock_historic');
        $this->addSql('CREATE INDEX fk_stock_historic_user_id ON stock_historic (user_id)');
        $this->addSql('DROP INDEX idx_e294bb144584665a ON stock_historic');
        $this->addSql('CREATE INDEX fk_stock_historic_product_id ON stock_historic (product_id)');
        $this->addSql('ALTER TABLE stock_historic ADD CONSTRAINT FK_E294BB14A76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE stock_historic ADD CONSTRAINT FK_E294BB144584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE `users` CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
