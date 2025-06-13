<?php

namespace App\Service;

use Exception;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class EmailService
{
    public function __construct(
        private MailerInterface $mailer
    ) {
    }

    public function sendVerificationCode(string $email): void
    {
        $code = rand(1000, 9999);
        $message = (new Email())
            ->from('viktorbellyakov@mail.ru')
            ->to($email)
            ->subject('Код подтверждения')
            ->html('<p>Ваш код: <strong>' . $code . '</strong></p>');

        $this->mailer->send($message);
    }
}
