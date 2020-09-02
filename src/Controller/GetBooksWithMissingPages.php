<?php


namespace App\Controller;


use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetBooksWithMissingPages {
	/**
	 * @var ManagerRegistry
	 */
	private $registry;

	public function __construct(ManagerRegistry $registry) {
		$this->registry = $registry;
	}

	public function __invoke() {
		/** @var BookRepository $repository */
		$repository = $this->registry->getRepository(Book::class);
		$books = $repository->findBooksWithMissingFiles();

		return $books;
	}
}