<?php

namespace Tests\Unit\Helpers;

use App\Helpers\EditorjsHelper;
use Tests\TestCase;

class EditorjsHelperTest extends TestCase
{
  /** @test */
  public function it_normalizes_html_entities_in_a_string()
  {
    // Arrange
    $inputString = "&lt;b&gt;Hello&lt;/b&gt; &lt;i&gt;world&lt;/i&gt;";
    $expectedOutput = "<b>Hello</b> <i>world</i>";

    // Act
    $outputString = EditorjsHelper::normalize($inputString);

    // Assert
    $this->assertEquals($expectedOutput, $outputString);
  }

  /** @test */
  public function it_gets_the_first_paragraph_from_editorjs_data()
  {
    // Arrange
    $editorjsData = json_encode([
      "blocks" => [
        [
          "type" => "paragraph",
          "data" => [
            "text" => "This is the first paragraph.",
          ],
        ],
        [
          "type" => "heading",
          "data" => [
            "text" => "This is a heading.",
          ],
        ],
        [
          "type" => "paragraph",
          "data" => [
            "text" => "This is another paragraph.",
          ],
        ],
      ],
    ]);
    $expectedParagraph = "This is the first paragraph.";

    // Act
    $paragraph = EditorjsHelper::firstParagraph($editorjsData);

    // Assert
    $this->assertEquals($expectedParagraph, $paragraph);
  }

  /** @test */
  public function it_compiles_editorjs_data_into_html()
  {
    // Arrange
    $editorjsData = json_encode([
      "blocks" => [
        [
          "type" => "paragraph",
          "data" => [
            "text" => "This is a paragraph.",
          ],
        ],
        [
          "type" => "list",
          "data" => [
            "style" => "unordered",
            "items" => ["Item 1", "Item 2", "Item 3"],
          ],
        ],
        [
          "type" => "code",
          "data" => [
            "code" => "<?php echo 'Hello World'; ?>",
          ],
        ],
      ],
    ]);

    $expectedHtml = "<p>This is a paragraph.</p><ul><li>Item 1</li><li>Item 2</li><li>Item 3</li></ul><pre class=\"bg-light\">&lt;?php echo &#039;Hello World&#039;; ?&gt;</pre>";

    // Act
    $compiledHtml = EditorjsHelper::compile($editorjsData);

    // Assert
    $this->assertEquals($expectedHtml, $compiledHtml);
  }
}
