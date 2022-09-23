<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel;


use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\Rowid;

final class Create
{

    private Rowid $author;
    private \DateTimeImmutable $at;

    private function __construct(Rowid $author, \DateTimeImmutable $at)
    {
        $this->author = $author;
        $this->at = $at;
    }

    public static function now(Rowid $author): self
    {
        return new self($author, new \DateTimeImmutable());
    }

    public static function create(Rowid $author, string $at): self
    {
        return new self($author, new \DateTimeImmutable($at));
    }

    public function author(): Rowid
    {
        return $this->author;
    }

    public function at(): \DateTimeImmutable
    {
        return $this->at;
    }


}