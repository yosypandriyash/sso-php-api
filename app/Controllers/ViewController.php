<?php namespace App\Controllers;

use App\Views\Models\Templates\DefaultTemplate;
use App\Views\Models\Templates\ViewTemplateInterface;

class ViewController extends BaseController
{
    public const DEV_ENVIRONMENT = 'DEVELOPMENT';
    public const DEV_PRODUCTION = 'PRODUCTION';

    private string $pageTitle;
    private string $pageMetaDescription;
    private string $pageLang;
    private string $publicPath;
    private string $page;

    public function __construct()
    {
        // on development mode compile less files and clear cache
        if (strtoupper(ENVIRONMENT) === self::DEV_ENVIRONMENT) {
            command('cache:clear');
            command('scss:compile');
        }

        $appConfig = config('App');

        $this->pageTitle = $appConfig->projectName;
        $this->pageMetaDescription = $appConfig->projectDescription;
        $this->pageLang = $appConfig->defaultLocale;

        $this->publicPath = $appConfig->baseURL;

        parent::__construct();
    }

    protected function view(ViewTemplateInterface $template = null): string
    {
        if (!$template) {
            $template = new DefaultTemplate();
        }
        return view($template->getTemplate(), get_object_vars($this));
    }

    /**
     * @param string $page
     */
    public function setPage(string $page): void
    {
        $this->page = $page;
    }

}
