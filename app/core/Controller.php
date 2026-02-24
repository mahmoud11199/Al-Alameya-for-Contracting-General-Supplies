<?php
namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $viewPath = dirname(__DIR__) . '/views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            http_response_code(404);
            exit('View not found.');
        }

        require dirname(__DIR__) . '/views/layouts/header.php';
        require $viewPath;
        require dirname(__DIR__) . '/views/layouts/footer.php';
    }

    protected function sanitize(string $value): string
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
}
