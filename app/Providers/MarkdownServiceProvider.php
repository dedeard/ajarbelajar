<?php

namespace App\Providers;

use App\MarkdownExtensions\MinimalMarkdownExtension;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension;
use League\CommonMark\MarkdownConverter;
use Torchlight\Commonmark\V2\TorchlightExtension;

class MarkdownServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function boot(): void
    {
        // Define a macro for converting Markdown based on type
        $self = $this;
        Str::macro('marked', function (string $value, string $type = 'full') use ($self) {
            return $self->convertMarkdown($value, $type);
        });
    }

    /**
     * Convert Markdown content based on type.
     *
     * @param string $value
     * @param string $type
     * @return string
     */
    public function convertMarkdown(string $value, string $type)
    {
        // Create the Markdown environment
        $environment = $this->createEnvironment();

        // Add necessary extensions based on type
        $this->addExtensions($environment, $type);

        // Convert Markdown to HTML using the configured environment
        $converter = new MarkdownConverter($environment);
        return $converter->convert($value)->getContent();
    }

    /**
     * Create the Markdown environment with common settings.
     *
     * @return Environment
     */
    protected function createEnvironment(): Environment
    {
        return new Environment([
            'html_input' => 'strip',
            'external_link' => [
                'internal_hosts' => config('app.url'),
                'open_in_new_window' => true,
                'nofollow' => 'external',
                'noopener' => 'external',
                'noreferrer' => 'external',
            ],
            'smartpunct' => [
                'double_quote_opener' => '“',
                'double_quote_closer' => '”',
                'single_quote_opener' => '‘',
                'single_quote_closer' => '’',
            ],
        ]);
    }

    /**
     * Add Markdown extensions to the environment based on type.
     *
     * @param Environment $environment
     * @param string $type
     * @return void
     */
    protected function addExtensions(Environment $environment, string $type): void
    {
        switch ($type) {
            case 'minimal':
                $environment->addExtension(new MinimalMarkdownExtension);
                $environment->addExtension(new Extension\Autolink\AutolinkExtension);
                $environment->addExtension(new Extension\ExternalLink\ExternalLinkExtension);
                $environment->addExtension(new Extension\SmartPunct\SmartPunctExtension);
                $environment->addExtension(new Extension\Strikethrough\StrikethroughExtension);
                $environment->addExtension(new TorchlightExtension);
                break;

            case 'inline':
                $environment->addExtension(new Extension\InlinesOnly\InlinesOnlyExtension);
                break;

            default:
                $environment->addExtension(new Extension\CommonMark\CommonMarkCoreExtension);
                $environment->addExtension(new Extension\Autolink\AutolinkExtension);
                $environment->addExtension(new Extension\ExternalLink\ExternalLinkExtension);
                $environment->addExtension(new Extension\SmartPunct\SmartPunctExtension);
                $environment->addExtension(new Extension\Strikethrough\StrikethroughExtension);
                $environment->addExtension(new Extension\Table\TableExtension);
                $environment->addExtension(new Extension\TaskList\TaskListExtension);
                $environment->addExtension(new TorchlightExtension);
                break;
        }
    }
}
