<?php
namespace App\Controllers;

use App\Core\Cache;
use App\Core\Controller;
use App\Core\CSRF;
use App\Models\ContentModel;
use App\Models\Setting;

class PageController extends Controller
{
    private ContentModel $content;

    public function __construct()
    {
        $this->content = new ContentModel();
    }

    private function siteData(string $title, string $description): array
    {
        $settings = (new Setting())->allKeyed();
        return [
            'metaTitle' => $title,
            'metaDescription' => $description,
            'settings' => $settings,
        ];
    }

    public function home(): void
    {
        $projects = Cache::remember('home_projects', 300, fn () => $this->content->getAll('projects', 6));
        $services = Cache::remember('home_services', 300, fn () => $this->content->getAll('services', 6));
        $this->view('pages/home', array_merge($this->siteData('Home', 'Leading contracting and general supplies solutions.'), compact('projects', 'services')));
    }

    public function about(): void { $this->view('pages/about', $this->siteData('About', 'About Al Alameya.')); }
    public function services(): void { $services = $this->content->getAll('services'); $this->view('pages/services', array_merge($this->siteData('Services', 'Our contracting and supply services.'), compact('services'))); }
    public function projects(): void { $projects = $this->content->getAll('projects'); $this->view('pages/projects', array_merge($this->siteData('Projects', 'Delivered projects portfolio.'), compact('projects'))); }
    public function blog(): void { $posts = $this->content->getPublishedBlog(); $this->view('pages/blog', array_merge($this->siteData('Blog', 'Corporate news and insights.'), compact('posts'))); }
    public function careers(): void { $this->view('pages/careers', $this->siteData('Careers', 'Join our team.')); }

    public function contact(): void
    {
        $data = array_merge($this->siteData('Contact', 'Get in touch with Al Alameya.'), ['csrfToken' => CSRF::token(), 'message' => $_SESSION['flash'] ?? null]);
        unset($_SESSION['flash']);
        $this->view('pages/contact', $data);
    }

    public function submitContact(): void
    {
        if (!CSRF::verify($_POST['csrf_token'] ?? null)) {
            http_response_code(419);
            exit('Invalid CSRF token');
        }

        $payload = [
            'name' => $this->sanitize($_POST['name'] ?? ''),
            'email' => filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL) ?: '',
            'phone' => $this->sanitize($_POST['phone'] ?? ''),
            'subject' => $this->sanitize($_POST['subject'] ?? ''),
            'message' => $this->sanitize($_POST['message'] ?? ''),
        ];

        if ($payload['name'] && $payload['email'] && $payload['message']) {
            $this->content->saveMessage($payload);
            $_SESSION['flash'] = 'Your message has been sent successfully.';
        } else {
            $_SESSION['flash'] = 'Please complete all required fields.';
        }

        header('Location: /contact');
    }
}
