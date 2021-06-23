<?php

namespace App\Library\Markup;

use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;
use League\CommonMark\Environment;

use League\CommonMark\Renderer\Block\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Block\Element\AbstractBlock;

/**
 * single pattern:
 * |+ {header element}\n
 * {markdown content}\n
 * +accorion-id|\n
 *
 * wrap pattern:
 * ...\n
 * \n
 * |++\n
 * |+ {header element}\n
 * {markdown content}\n
 * +|\n
 * ++{id}|\n
 * \n
 *
 * Note: If a `single pattern` inside a `wrap pattern` has an id applied, it will be ignored. To handle counting??
 */
class Markup extends AbstractBlock
{
    private $context;

    private $headerElement = 2;
    private $headerContent = "";

    private $accordionId = "";
    private $contentLists = [];

    public function __construct(ContextInterface $context, Cursor $cursor)
    {
        $this->context = $context;
        // ddd($context);
        $this->setStartLine($this->context->getLineNumber());
        $this->setLastLineBlank(true);

        // $preHeader = substr($cursor->getLine(), 3);
        list($ele1, $content, $ele2) = explode(" ", $cursor->getLine(), 3);

        $this->headerContent = $content;
        $this->headerElement = "h2";
    }

    public function element(ElementRendererInterface $htmlRenderer)
    {
        $hElem   = $this->headerElement;
        // $hFormat = '<%s class="quiz-head" id="quiz%s">%s</%s>';
        $hFormat = "\n" . '<%s class="quiz-head text-2xl font-bold" id="quiz%s">%s</%s>' . "\n";

        $bId      = $this->accordionId;
        $bContent = $this->headerContent;
        // $bFormat  = '<button id="%s" onclick="efToggleAccordion(event)" aria-controls="%s" aria-expanded="true">%s</button>';
        $bFormat  = '<button id="%s" onclick="efToggleAccordion(event)" aria-controls="%s" aria-expanded="true">%s</button>';

        $pId      = $bId . "-panel";
        $pContent = $htmlRenderer->renderBlocks($this->children());
        // ddd($pContent);
        // $pFormat  = '<div is="accordion-panel" role="region" id="%s" tabindex="-1" aria-hidden="false" aria-labelledby="%s">%s</div>';
        $pFormat  = '<div is="accordion-panel" role="region" id="%s" tabindex="-1" aria-hidden="false" aria-labelledby="%s">%s</div>' . "\n";


        $bString = sprintf($bFormat, $bId, $pId, $bContent);
        $hString = sprintf($hFormat, $hElem, $pId, $bString, $hElem);
        $pString = sprintf($pFormat, $pId, $bId, $pContent);

        $listString = "";
        foreach ($this->contentLists as $contentList) {
            $listString .= $contentList;
        }

        // ddd($htmlRenderer->renderBlocks($this->contentLists));
        return $hString . $pString . "リスト＆" . $listString . "リスト<br><br>";
        // return $hString . $pString;
    }

    public function canContain(AbstractBlock $block): bool
    {
        // Can't have child accordion
        return !$block instanceof Markup;
    }

    public function isCode(): bool
    {
        return false;
    }

    public function matchesNextLine(Cursor $cursor): bool
    {
        $endContainerRegex = "/^\>\>/";
        $containerEnd = $cursor->match($endContainerRegex);

        // $lines = $container->getStrings();

        if (empty($containerEnd)) {
            return true;
        }
        return false;
    }

    // // block closer
    // $endContainerRegex = "/^\>\>/";
    // $containerEnd = $cursor->match($endContainerRegex);
    // if (empty($containerEnd)) {
    //     return true;
    // }
    // return false;

    // // block closer
    // $endContainerRegex = "/^\+\+\|/";
    // $containerEnd = $cursor->match($endContainerRegex);
    // if (empty($containerEnd)) {
    //     return true;
    // }
    // return false;

    // // 回答かどうかをマッチング
    // $regex = "/^(\( \)|\(x\)) .+/";
    // $matchFlag = $cursor->match($regex);

    // // もしマッチしたら新しい回答の行を続行
    // if ($matchFlag) {
    //     // ddd($matchFlag);
    //     $this->contentLists[] =  $matchFlag;

    //     return true;
    // }
    // // $this->accordionId = substr($cursor->getLine(), 1, -1);
    // return false;
}
