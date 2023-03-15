<?php

namespace App\Helpers;

class EditorjsHelper extends Helper
{

    public static function normalize(string $string): string
    {
        $search  = ["&lt;i&gt;", "&lt;b&gt;", "&lt;/i&gt;", "&lt;/b&gt;"];
        $replace  = ["<i>", "<b>", "</i>", "</b>"];
        $subject = htmlentities($string);
        return str_replace($search, $replace, $subject);
    }

    public static function firstParagraph($data): string
    {
        if ($data) {
            try {
                $data = json_decode($data);
                if (!isset($data->blocks)) {
                    return "";
                }
            } catch (\Exception $e) {
                return "";
            }

            $paragraph = "";
            foreach ($data->blocks as $block) {
                if ($block->type === 'paragraph') {
                    $paragraph = self::normalize($block->data->text);
                    break;
                }
            }
            return $paragraph;
        }
        return "";
    }

    public static function compile($data): string
    {
        if ($data) {
            try {
                $data = json_decode($data);
                if (!isset($data->blocks)) {
                    return "";
                }
            } catch (\Exception $e) {
                return "";
            }

            $html = "";
            foreach ($data->blocks as $block) {
                switch ($block->type) {
                    case "paragraph":
                        $html .= "<p>" . self::normalize($block->data->text) . "</p>";
                        break;
                    case "list":
                        if ($block->data->style === 'ordered') {
                            $html .= "<ol>";
                        } else {
                            $html .= "<ul>";
                        }
                        foreach ($block->data->items as $item) {
                            $html .= "<li>" . self::normalize($item) . "</li>";
                        }
                        if ($block->data->style === 'ordered') {
                            $html .= "</ol>";
                        } else {
                            $html .= "</ul>";
                        }
                        break;
                    case "code":
                        $html .= '<pre class="bg-light">';
                        $html .= htmlentities($block->data->code);
                        $html .= "</pre>";
                        break;
                }
            }
            return $html;
        }
        return "";
    }
}
