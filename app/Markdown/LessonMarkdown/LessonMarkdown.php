<?php

namespace App\Markdown\LessonMarkdown;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\MarkdownConverter;
use Torchlight\Commonmark\V2\TorchlightExtension;

class LessonMarkdown
{
    public string $input;

    public Environment $environment;

    public MarkdownConverter $converter;

    public function __construct(string $input)
    {
        $this->input = $input;
        $this->initializeEnvironment();
        $this->registerExtensions();
        $this->converter = new MarkdownConverter($this->environment);
    }

    public function initializeEnvironment()
    {
        $this->environment = new Environment([
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

    public function registerExtensions()
    {
        $this->environment->addExtension(new LessonMarkdownExtension);
        $this->environment->addExtension(new AutolinkExtension);
        $this->environment->addExtension(new ExternalLinkExtension);
        $this->environment->addExtension(new SmartPunctExtension);
        $this->environment->addExtension(new StrikethroughExtension);
        $this->environment->addExtension(new TableExtension);
        $this->environment->addExtension(new TorchlightExtension);
    }

    public function getContent(): string
    {
        return $this->converter->convert($this->input)->getContent();
    }

    public static function convert(string $input): string
    {
        $instance = new self($input);
        $outputString = str_replace('<h1>', '<h2>', $instance->getContent());
        $outputString = str_replace('</h1>', '</h2>', $outputString);

        return $outputString;
    }
}
