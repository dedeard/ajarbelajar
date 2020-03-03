<?php

class Helper
{
  public static function compileEditorJs($data)
  {
    if($data) {
      $data = json_decode($data);
      // dd($data->blocks);
      $html = "";
      foreach($data->blocks as $block) {
        switch($block->type) {
          case "header" : 
            $html .= "<h" . $block->data->level . ">" . $block->data->text . "</h" . $block->data->level . ">";
          break;
          case "paragraph" :
            $html .= "<p>" . $block->data->text . "</p>";
          break;
          case "delimiter" :
            $html .= "<hr />";
          break;
          case "list" :
            if($block->data->style === 'ordered'){
              $html .= "<ol>";
            } else {
              $html .= "<ul>";
            }
            foreach($block->data->items as $item) {
              $html .= "<li>" . $item . "</li>";
            }
            if($block->data->style === 'ordered'){
              $html .= "</ol>";
            } else {
              $html .= "</ul>";
            }
          break;
          case "table":
            $html .= '<table class="table table-bordered"><tbody>';
            foreach($block->data->content as $row) {
              $html .= "<tr>";
              foreach($row as $item){
                $html .= "<td>" . $item . "</td>";
              }
              $html .= "</tr>";
            }
            $html .=  '</tbody></table>';
          break;
          case "quote":
            $html .= '<blockquote class="blockquote';
            if($block->data->alignment != "left") {
              $html .= " blockquote-reverse";
            }
            $html .= '">';
            $html .= $block->data->text;
            if($block->data->caption) {
              $html .= '<footer class="blockquote-footer">' . $block->data->caption . '</footer>';
            }
            $html .= '</blockquote>';
          break;
          case "checklist":
            $html .= '<ul class="list-group">';
            foreach($block->data->items as $item) {
              $html .= '<li class="list-group-item">';
              if($item->checked) {
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
            $html .= '<h4>'. $block->data->title .'</h4>';
            $html .= '<p>'. $block->data->message .'</p>';
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
        }
      }
      return $html;
    }
    return "";
  }
}
