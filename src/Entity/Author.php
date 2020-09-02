<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 * @ApiResource()
 */
class Author {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Groups({"get:books:with_publishers_and_authors", "get:book:with_publishers_and_authors", "get:books:with_content"})
	 */
	private $fullName;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $language;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $nationality;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $birthPlace;

	/**
	 * @ORM\Column(type="date", nullable=true)
	 */
	private $birthDate;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Book", mappedBy="authors")
	 */
	private $books;

	/**
	 * @ORM\Column(type="date", nullable=true)
	 */
	private $diedDate;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $diePlace;

	public function __construct() {
		$this->books = new ArrayCollection();
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getFullName(): ?string {
		return $this->fullName;
	}

	public function setFullName(string $fullName): self {
		$this->fullName = $fullName;

		return $this;
	}

	public function getLanguage(): ?string {
		return $this->language;
	}

	public function setLanguage(?string $language): self {
		$this->language = $language;

		return $this;
	}

	public function getNationality(): ?string {
		return $this->nationality;
	}

	public function setNationality(?string $nationality): self {
		$this->nationality = $nationality;

		return $this;
	}

	public function getBirthPlace(): ?string {
		return $this->birthPlace;
	}

	public function setBirthPlace(?string $birthPlace): self {
		$this->birthPlace = $birthPlace;

		return $this;
	}

	public function getBirthDate(): ?\DateTimeInterface {
		return $this->birthDate;
	}

	public function setBirthDate(?\DateTimeInterface $birthDate): self {
		$this->birthDate = $birthDate;

		return $this;
	}

	/**
	 * @return Collection|Book[]
	 */
	public function getBooks(): Collection {
		return $this->books;
	}

	public function addBook(Book $book): self {
		if (!$this->books->contains($book)) {
			$this->books[] = $book;
			$book->addAuthor($this);
		}

		return $this;
	}

	public function removeBook(Book $book): self {
		if ($this->books->contains($book)) {
			$this->books->removeElement($book);
			$book->removeAuthor($this);
		}

		return $this;
	}

	public function __toString() {
		return $this->getFullName();
	}

	public function getDiedDate(): ?\DateTimeInterface {
		return $this->diedDate;
	}

	public function setDiedDate(?\DateTimeInterface $diedDate): self {
		$this->diedDate = $diedDate;

		return $this;
	}

	public function getDiePlace(): ?string {
		return $this->diePlace;
	}

	public function setDiePlace(?string $diePlace): self {
		$this->diePlace = $diePlace;

		return $this;
	}

}
