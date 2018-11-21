<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181121052959 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE record (id INT AUTO_INCREMENT NOT NULL, account VARCHAR(255) NOT NULL COMMENT \'账户\', description VARCHAR(255) NOT NULL COMMENT \'描述\', category VARCHAR(255) NOT NULL COMMENT \'分类\', datetime DATETIME NOT NULL COMMENT \'日期时间\', amount DOUBLE PRECISION NOT NULL COMMENT \'金额\', currency VARCHAR(255) NOT NULL COMMENT \'货币\', tags VARCHAR(255) NOT NULL COMMENT \'标签\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE record');
    }
}
