<?php

function truncate($text, $length)
{
    $length = abs((int)$length);

    if (strlen($text) > $length) {
        $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
    }

    return $text;
}

function limitText($text)
{
    return truncate($text, 75);
}

function textToMarkdown($text)
{
    $filter = new \Anax\TextFilter\TextFilter();
    return html_entity_decode($filter->parse($text, ["markdown"])->text);
}
