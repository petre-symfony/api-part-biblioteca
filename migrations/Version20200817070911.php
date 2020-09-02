<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200817070911 extends AbstractMigration {
	public function getDescription() : string {
		return '';
	}

	public function up(Schema $schema) : void {
		// this up() migration is auto-generated, please modify it to your needs
		$this->addSql('CREATE TABLE publisher (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, genre_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT \'unknown\' NOT NULL, location VARCHAR(255) DEFAULT NULL, subject VARCHAR(255) DEFAULT NULL, volume INT DEFAULT NULL, book_published_year INT DEFAULT NULL, other VARCHAR(255) DEFAULT NULL, first_published_year INT DEFAULT NULL,  isbn VARCHAR(30) DEFAULT NULL, complete TINYINT(1) DEFAULT \'1\', missing_pages VARCHAR(255) DEFAULT \'NONE\', pages INT DEFAULT NULL, language VARCHAR(255) DEFAULT \'romana\', format VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_CBE5A3314296D31F (genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE book_author (book_id INT NOT NULL, author_id INT NOT NULL, INDEX IDX_9478D34516A2B381 (book_id), INDEX IDX_9478D345F675F31B (author_id), PRIMARY KEY(book_id, author_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE book_publisher (book_id INT NOT NULL, publisher_id INT NOT NULL, INDEX IDX_8E46C30016A2B381 (book_id), INDEX IDX_8E46C30040C86FCE (publisher_id), PRIMARY KEY(book_id, publisher_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, language VARCHAR(255) DEFAULT NULL, nationality VARCHAR(255) DEFAULT NULL, birth_place VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, died_date DATE DEFAULT NULL, die_place VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE sub_category (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_BCE3F798C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3314296D31F FOREIGN KEY (genre_id) REFERENCES sub_category (id)');
		$this->addSql('ALTER TABLE book_author ADD CONSTRAINT FK_9478D34516A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
		$this->addSql('ALTER TABLE book_author ADD CONSTRAINT FK_9478D345F675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE');
		$this->addSql('ALTER TABLE book_publisher ADD CONSTRAINT FK_8E46C30016A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
		$this->addSql('ALTER TABLE book_publisher ADD CONSTRAINT FK_8E46C30040C86FCE FOREIGN KEY (publisher_id) REFERENCES publisher (id) ON DELETE CASCADE');
		$this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F798C54C8C93 FOREIGN KEY (type_id) REFERENCES category (id)');
	}

	public function down(Schema $schema) : void {
		// this down() migration is auto-generated, please modify it to your needs
		$this->addSql('ALTER TABLE book_author DROP FOREIGN KEY FK_9478D345F675F31B');
		$this->addSql('ALTER TABLE book_author DROP FOREIGN KEY FK_9478D34516A2B381');
		$this->addSql('ALTER TABLE book_publisher DROP FOREIGN KEY FK_8E46C30016A2B381');
		$this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F798C54C8C93');
		$this->addSql('ALTER TABLE book_publisher DROP FOREIGN KEY FK_8E46C30040C86FCE');
		$this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3314296D31F');
		$this->addSql('DROP TABLE author');
		$this->addSql('DROP TABLE book');
		$this->addSql('DROP TABLE book_author');
		$this->addSql('DROP TABLE book_publisher');
		$this->addSql('DROP TABLE category');
		$this->addSql('DROP TABLE publisher');
		$this->addSql('DROP TABLE sub_category');
	}
}
