<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\GetBooksWithMissingPages;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\ExistsFilter;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 * @ApiResource(
 *   collectionOperations={
 *     "get" = {
 *       "normalization_context" = {
 *         "groups" = {"get:books:with_publishers_and_authors"}
 *	 		 }
 *	   },
 *     "get_books_with_missing_pages" = {
 *       "method"="GET",
 *       "path"="/get_books_with_missing_pages",
 *       "controller"=GetBooksWithMissingPages::class,
 *       "normalization_context" = {
 *         "groups" = {"get:books:with_publishers_and_authors"}
 *	 		 }
 *     }
 *	 },
 *   itemOperations={
 *     "get" = {
 *       "normalization_context" = {
 *         "groups" = {"get:book:with_publishers_and_authors"}
 *   		 }
 *	   }
 *	 }
 * )
 * @ApiFilter(SearchFilter::class, properties={"authors.fullName": "partial", "complete": "exact"})
 * @ApiFilter(ExistsFilter::class, properties={"Content"})
 */
class Book {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255, options={"default": "unknown"})
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors", "get:books:with_content"})
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors", "get:books:with_content"})
	 */
	private $location;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors"})
	 */
	private $subject;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\SubCategory", inversedBy="books")
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors"})
	 */
	private $genre;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Author", inversedBy="books")
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors", "get:books:with_content"})
	 */
	private $authors;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors", "get:books:with_content"})
	 */
	private $volume;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors", "get:books:with_content"})
	 */
	private $other;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors"})
	 */
	private $firstPublishedYear;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors", "get:books:with_content"})
	 */
	private $bookPublishedYear;

	/**
	 * @ORM\Column(type="string", length=30, nullable=true)
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors", "get:books:with_content"})
	 */
	private $ISBN;

  /**
   * @ORM\Column(type="boolean", nullable=true, options={"default": TRUE})
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors"})
   */
  private $complete;

  /**
   * @ORM\Column(type="string", length=255, nullable=true, options={"default": "NONE"})
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors"})
   */
  private $missingPages;

  /**
   * @ORM\Column(type="integer", nullable=true)
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors", "get:books:with_content"})
   */
  private $pages;

  /**
   * @ORM\Column(type="string", length=255, nullable=true, options={"default": "romana"})
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors"})
   */
  private $language;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors", "get:books:with_content"})
   */
  private $format;

  /**
   * @ORM\Column(type="text", nullable=true)
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors"})
   */
  private $Content;

  /**
   * @ORM\ManyToMany(targetEntity="App\Entity\Publisher", inversedBy="paperBooks")
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors", "get:books:with_content"})
   */
  private $publishers;

	public function __construct() {
    $this->authors = new ArrayCollection();
    $this->publishers = new ArrayCollection();
  }

	public function getId(): ?int {
    return $this->id;
  }

	public function getName(): ?string {
    return $this->name;
  }

	public function setName(string $name): self {
    $this->name = $name;

    return $this;
  }

	public function getLocation(): ?string {
    return $this->location;
  }

	public function setLocation(?string $location): self {
    $this->location = $location;

    return $this;
  }

	public function getSubject(): ?string {
    return $this->subject;
  }

	public function setSubject(?string $subject): self {
    $this->subject = $subject;

    return $this;
  }

	public function getGenre(): ?SubCategory {
    return $this->genre;
  }

	public function setGenre(?SubCategory $genre): self {
    $this->genre = $genre;

    return $this;
  }

	/**
	 * @return Collection|Author[]
	 */
	public function getAuthors(): Collection {
    return $this->authors;
  }

	public function addAuthor(Author $author): self {
    if (!$this->authors->contains($author)) {
      $this->authors[] = $author;
    }

    return $this;
  }

	public function removeAuthor(Author $author): self {
    if ($this->authors->contains($author)) {
      $this->authors->removeElement($author);
    }

    return $this;
  }

	public function getVolume(): ?int {
    return $this->volume;
  }

	public function setVolume(?int $volume): self {
    $this->volume = $volume;

    return $this;
  }


	public function getOther(): ?string {
    return $this->other;
  }

	public function setOther(?string $other): self {
    $this->other = $other;

    return $this;
  }

	public function __toString() {
    return $this->getName();
  }

	public function getFirstPublishedYear(): ?int {
    return $this->firstPublishedYear;
  }

	public function setFirstPublishedYear(?int $firstPublishedYear): self {
    $this->firstPublishedYear = $firstPublishedYear;

    return $this;
  }

	public function getBookPublishedYear(): ?int {
    return $this->bookPublishedYear;
  }

	public function setBookPublishedYear(?int $bookPublishedYear): self {
    $this->bookPublishedYear = $bookPublishedYear;

    return $this;
  }

	public function getISBN(): ?string {
    return $this->ISBN;
  }

	public function setISBN(?string $ISBN): self {
    $this->ISBN = $ISBN;

    return $this;
  }

  public function getComplete(): ?bool {
    return $this->complete;
  }

  public function setComplete(?bool $complete): self {
    $this->complete = $complete;

    return $this;
  }

  public function getMissingPages(): ?string {
    return $this->missingPages;
  }

  public function setMissingPages(?string $missingPages): self{
    $this->missingPages = $missingPages;

    return $this;
  }

  public function getPages(): ?int{
    return $this->pages;
  }

  public function setPages(?int $pages): self{
    $this->pages = $pages;

    return $this;
  }

  public function getLanguage(): ?string{
    return $this->language;
  }

  public function setLanguage(?string $language): self{
    $this->language = $language;

    return $this;
  }

  public function getFormat(): ?string {
    return $this->format;
  }

  public function setFormat(?string $format): self {
    $this->format = $format;

    return $this;
  }

  public function getContent(): ?string {
    return $this->Content;
  }

  public function setContent(?string $Content): self {
    $this->Content = $Content;

    return $this;
  }

  /**
   * @return Collection|Publisher[]
   */
  public function getPublishers(): Collection {
    return $this->publishers;
  }

  public function addPublisher(Publisher $publisher): self {
    if (!$this->publishers->contains($publisher)) {
      $this->publishers[] = $publisher;
    }

    return $this;
  }

  public function removePublisher(Publisher $publisher): self {
    if ($this->publishers->contains($publisher)) {
      $this->publishers->removeElement($publisher);
    }

    return $this;
  }
}
