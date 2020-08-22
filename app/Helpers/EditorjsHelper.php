<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class EditorjsHelper
{
    public static function compile($data)
    {
        if ($data) {
            $data = json_decode($data);
            if (!isset($data->blocks)) return "";
            $html = "";
            foreach ($data->blocks as $block) {
                switch ($block->type) {
                    case "header":
                        $html .= "<h" . $block->data->level . ">" . $block->data->text . "</h" . $block->data->level . ">";
                        break;
                    case "paragraph":
                        $html .= "<p>" . $block->data->text . "</p>";
                        break;
                    case "delimiter":
                        $html .= "<hr />";
                        break;
                    case "list":
                        if ($block->data->style === 'ordered') {
                            $html .= "<ol>";
                        } else {
                            $html .= "<ul>";
                        }
                        foreach ($block->data->items as $item) {
                            $html .= "<li>" . $item . "</li>";
                        }
                        if ($block->data->style === 'ordered') {
                            $html .= "</ol>";
                        } else {
                            $html .= "</ul>";
                        }
                        break;
                    case "table":
                        $html .= '<table class="table table-bordered"><tbody>';
                        foreach ($block->data->content as $row) {
                            $html .= "<tr>";
                            foreach ($row as $item) {
                                $html .= "<td>" . $item . "</td>";
                            }
                            $html .= "</tr>";
                        }
                        $html .=  '</tbody></table>';
                        break;
                    case "quote":
                        $html .= '<blockquote class="blockquote';
                        if ($block->data->alignment != "left") {
                            $html .= " blockquote-reverse";
                        }
                        $html .= '">';
                        $html .= $block->data->text;
                        if ($block->data->caption) {
                            $html .= '<footer class="blockquote-footer">' . $block->data->caption . '</footer>';
                        }
                        $html .= '</blockquote>';
                        break;
                    case "checklist":
                        $html .= '<ul class="list-group">';
                        foreach ($block->data->items as $item) {
                            $html .= '<li class="list-group-item">';
                            if ($item->checked) {
                                $html .= '<i class="icon wb-check-circle text-primary"></i> ';
                            } else {
                                $html .= '<i class="icon wb-minus-circle"></i> ';
                            }
                            $html .= $item->text;
                            $html .= '</li>';
                        }
                        $html .= '</ul>';
                        break;
                    case "warning":
                        $html .= '<div class="alert alert-alt alert-warning alert-dismissible">';
                        $html .= '<h4>' . $block->data->title . '</h4>';
                        $html .= '<p>' . $block->data->message . '</p>';
                        $html .= '</div>';
                        break;
                    case "code":
                        $html .= '<pre class="bg-light">';
                        $html .= htmlentities($block->data->code);
                        $html .= "</pre>";
                        break;
                    case "embed":
                        $html .= '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="' . $block->data->embed . '">';
                        $html .= '</iframe></div>';
                        break;
                    case "image":
                        $html .= '<figure>';
                        $html .= '<img';
                        if ($block->data->caption) $html .= ' alt="' . $block->data->caption . '"';
                        $html .= ' class="img-fluid img-rounded" src="' . $block->data->file->url . '">';
                        if ($block->data->caption) $html .= '<figcaption class="text-center">' . $block->data->caption . '</figcaption>';
                        $html .= '</figure>';
                        break;
                }
            }
            return $html;
        }
        return "";
    }

    public static function generateName()
    {
        $ext = config('image.article.extension');
        return now()->format('hisdmY') . Str::random(60) . $ext;
    }

    public static function uploadImage($data)
    {
        $name = self::generateName();
        $format = config('image.article.format');
        $dir = config('image.article.dir');
        $ext = config('image.article.extension');

        $tmp = Image::make($data);
        Storage::put($dir . $name, (string) $tmp->encode($format, 75));

        $tmp = Image::make($data)->resize(50, 50, function($constraint){
            $constraint->aspectRatio();
        });
        Storage::put($dir . $name . '.dot' . $ext, (string) $tmp->encode($format, 75));

        return ['name' => $name, "url" => "/storage/{$dir}{$name}"];
    }

    public static function deleteImage($name)
    {
        $dir = config('image.article.dir');
        $ext = config('image.article.extension');
        if (Storage::exists($dir . $name)) {
            Storage::delete($dir . $name);
        }
        if (Storage::exists($dir . $name . '.dot' . $ext)) {
            Storage::delete($dir . $name . '.dot' . $ext);
        }
    }

    public static function cleanImage($data, $images)
    {
        $body = json_decode($data);
        $dir = config('image.article.dir');
        $ext = config('image.article.extension');
        foreach ($images as $image) {
            $exists = false;
            foreach ($body->blocks as $block) {
                if ($block->type === 'image') {
                    if ($block->data->file->url === "/storage/{$dir}{$image->name}") $exists = true;
                }
            }
            if (!$exists) {
                if (Storage::exists($dir . $image->name)) {
                    Storage::delete($dir . $image->name);
                }
                if (Storage::exists($dir . $image->name . '.dot' . $ext)) {
                    Storage::delete($dir . $image->name . '.dot' . $ext);
                }
                $image->delete();
            }
        }
    }
}
