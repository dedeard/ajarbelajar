<?php

namespace App\Helpers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class EditorjsHelper extends Helper
{

    /**
     * define constant variable.
     */
    const FORMAT = 'jpg';
    const EXT = '.jpeg';
    const DIR = 'images/';

    /**
     * Get Disk driver.
     */
    static function disk() : Filesystem
    {
        return Storage::disk('gcs_public');
    }

    /**
     * Uploading the image and get name, relative url.
     */
    static function uploadImage($data) : Array
    {
        $format = self::FORMAT;
        $dir = self::DIR;
        $ext = self::EXT;
        $name = parent::uniqueName($ext);
        $dotName = "{$name}.dot{$ext}";

        $tmp = Image::make($data)->resize(640, 640, function($constraint){
            $constraint->aspectRatio();
        });
        self::disk()->put($dir . $name, (string) $tmp->encode($format, 80));

        $tmp = Image::make($data)->resize(50, 50, function($constraint){
            $constraint->aspectRatio();
        });
        self::disk()->put($dir . $dotName, (string) $tmp->encode($format, 75));

        return ['name' => $name, "url" => self::disk()->url("{$dir}{$name}")];
    }

    /**
     * Deleting the image.
     */
    static function deleteImage($name) : void
    {
        $dir = self::DIR;
        $ext = self::EXT;
        $dotName = "{$name}.dot{$ext}";

        if (self::disk()->exists($dir . $name)) {
            self::disk()->delete($dir . $name);
        }
        if (self::disk()->exists($dir . $dotName)) {
            self::disk()->delete($dir . $dotName);
        }
    }

    /**
     * Delete not used images.
     */
    static function cleanImage($data, $images)
    {
        $body = json_decode($data);
        $dir = self::DIR;
        foreach ($images as $image) {
            $exists = false;
            if(!!(array) $body) {
                foreach ($body->blocks as $block) {
                    if ($block->type === 'image') {
                        if ($block->data->file->url === self::disk()->url($dir . $image->name)) $exists = true;
                    }
                }
            }
            if (!$exists) {
                self::deleteImage($image->name);
                $image->delete();
            }
        }
    }

    /**
     * Compile editor.js Object to HTML.
     */
    static function compile($data) : String
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
}
