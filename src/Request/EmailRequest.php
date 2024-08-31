<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class EmailRequest
{
    #[Assert\NotBlank(message: "Subject is required.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Subject cannot be longer than {{ limit }} characters."
    )]
    private ?string $subject = null;

    #[Assert\NotBlank(message: "Message content is required.")]
    private ?string $message = null;

    #[Assert\NotBlank(message: "At least one category must be selected.")]
    #[Assert\Count(
        min: 1,
        minMessage: "You must select at least one category."
    )]
    private array $categories = [];

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): void
    {
        $this->subject = $subject;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }
}
