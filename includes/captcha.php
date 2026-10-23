<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function mq_captcha_generate(): array
{
    $digits = '';
    $html = '<div class="contact-captcha-display" aria-hidden="true">' . PHP_EOL;

    for ($i = 0; $i < 6; $i++) {
        $d = (string) random_int(0, 9);
        $digits .= $d;
        $rotate = random_int(-12, 40);
        $html .= '      <span class="contact-captcha-digit" style="--rotate: ' . $rotate . 'deg;">' . $d . '</span>' . PHP_EOL;
    }

    $html .= '  </div>' . PHP_EOL;
    $secret = bin2hex(random_bytes(32));
    $_SESSION['captcha_code'] = $digits;
    $_SESSION['captcha_secret'] = $secret;
    $html .= '<input type="hidden" name="captcha_secret" id="captcha_secret" value="' . htmlspecialchars($secret, ENT_QUOTES, 'UTF-8') . '">';

    return ['html' => $html, 'code' => $digits];
}

function mq_captcha_verify(string $input, string $secret): bool
{
    $expected = $_SESSION['captcha_code'] ?? '';
    $expectedSecret = $_SESSION['captcha_secret'] ?? '';
    unset($_SESSION['captcha_code'], $_SESSION['captcha_secret']);

    return $expected !== ''
        && $expectedSecret !== ''
        && hash_equals($expectedSecret, $secret)
        && hash_equals($expected, $input);
}
