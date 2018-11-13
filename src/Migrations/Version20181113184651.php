<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181113184651 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE rule (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, action_name VARCHAR(100) NOT NULL, discount_amount DOUBLE PRECISION DEFAULT NULL, discount_step SMALLINT DEFAULT NULL)');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, sku VARCHAR(100) NOT NULL, price DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE TABLE product_rule (product_id INTEGER NOT NULL, rule_id INTEGER NOT NULL, PRIMARY KEY(product_id, rule_id))');
        $this->addSql('CREATE INDEX IDX_CB308E6D4584665A ON product_rule (product_id)');
        $this->addSql('CREATE INDEX IDX_CB308E6D744E0351 ON product_rule (rule_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE rule');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_rule');
    }
}
