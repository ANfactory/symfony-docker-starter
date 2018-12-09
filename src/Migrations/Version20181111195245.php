<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181111195245 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL COMMENT \'(DC2Type:msgphp_user_id)\', credential_email VARCHAR(255) NOT NULL, credential_password VARCHAR(255) NOT NULL, password_reset_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649A5D24B55 (credential_email), UNIQUE INDEX UNIQ_8D93D6496B7BA4B6 (password_reset_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (name VARCHAR(255) NOT NULL, PRIMARY KEY(name)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_role (user_id INT NOT NULL COMMENT \'(DC2Type:msgphp_user_id)\', role_name VARCHAR(255) NOT NULL, INDEX IDX_2DE8C6A3A76ED395 (user_id), INDEX IDX_2DE8C6A3E09C0C92 (role_name), PRIMARY KEY(user_id, role_name)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3E09C0C92 FOREIGN KEY (role_name) REFERENCES role (name) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3A76ED395');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3E09C0C92');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE user_role');
    }
}
