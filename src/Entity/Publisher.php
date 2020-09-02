<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PublisherRepository")
 * @ApiResource()
 */
class Publisher {
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
	private $Name;

  /**
   * @ORM\ManyToMany(targetEntity="App\Entity\Book", mappedBy="publishers")
   */
  private $paperBooks;

	public function __construct() {
    $this->paperBooks = new ArrayCollection();
  }

	public function getId(): ?int {
    return $this->id;
  }

	public function getName(): ?string {
    return $this->Name;
  }

	public function setName(string $Name): self {
    $this->Name = $Name;

    return $this;
  }



	public function __toString() {
    return $this->getName();
  }

  /**
   * @return Collection|Book[]
   */
  public function getPaperBooks(): Collection {
    return $this->paperBooks;
  }

  public function addPaperBook(Book $paperBook): self {
    if (!$this->paperBooks->contains($paperBook)) {
        $this->paperBooks[] = $paperBook;
        $paperBook->addPublisher($this);
    }

    return $this;
  }

  public function removePaperBook(Book $paperBook): self{
    if ($this->paperBooks->contains($paperBook)) {
      $this->paperBooks->removeElement($paperBook);
      $paperBook->removePublisher($this);
    }

    return $this;
  }
}
