<?php

namespace App\Markdown\CommentMarkdown;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\MarkdownConverter;
use Torchlight\Commonmark\V2\TorchlightExtension;

class CommentMarkdown
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
    ]);
  }

  public function registerExtensions()
  {
    $this->environment->addExtension(new CommentMarkdownExtension);
    $this->environment->addExtension(new ExternalLinkExtension);
    $this->environment->addExtension(new TorchlightExtension);
  }

  public function getContent()
  {
    return $this->converter->convert($this->input)->getContent();
  }

  public static function convert(string $input)
  {
    $instance = new self($input);
    return $instance->getContent();
  }
}
