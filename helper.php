<?php

function get_url_contents($url, &$http_status){
        $crl = curl_init();
        $timeout = 5;
        curl_setopt ($crl, CURLOPT_URL,$url);
        curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
        $ret = curl_exec($crl);
        $http_status = curl_getinfo($crl, CURLINFO_HTTP_CODE);
        curl_close($crl);
        return $ret;
}

function html_highlight($s, &$stats) {
    $html_tags=array(
        "a",
        "abbr",
        "address",
        "area",
        "article",
        "aside",
        "audio",
        "b",
        "base",
        "bdi",
        "bdo",
        "blockquote",
        "body",
        "br",
        "button",
        "canvas",
        "caption",
        "cite",
        "code",
        "col",
        "colgroup",
        "data",
        "datalist",
        "dd",
        "del",
        "details",
        "dfn",
        "dialog",
        "div",
        "dl",
        "dt",
        "em",
        "embed",
        "fieldset",
        "figcaption",
        "figure",
        "footer",
        "form",
        "h1",
        "h2",
        "h3",
        "h4",
        "h5",
        "h6",
        "head",
        "header",
        "hgroup",
        "hr",
        "html",
        "i",
        "iframe",
        "img",
        "input",
        "ins",
        "kbd",
        "keygen",
        "label",
        "legend",
        "li",
        "link",
        "main",
        "map",
        "mark",
        "menu",
        "menuitem",
        "meta",
        "meter",
        "nav",
        "noscript",
        "object",
        "ol",
        "optgroup",
        "option",
        "output",
        "p",
        "param",
        "pre",
        "progress",
        "q",
        "rb",
        "rp",
        "rt",
        "rtc",
        "ruby",
        "s",
        "samp",
        "script",
        "section",
        "select",
        "small",
        "source",
        "span",
        "strong",
        "style",
        "sub",
        "summary",
        "sup",
        "table",
        "tbody",
        "td",
        "template",
        "textarea",
        "tfoot",
        "th",
        "thead",
        "time",
        "title",
        "tr",
        "track",
        "u",
        "ul",
        "var",
        "video",
        "wbr",
        "acronym",
        "applet",
        "basefont",
        "big",
        "center",
        "dir",
        "font",
        "frame",
        "frameset",
        "isindex",
        "noframes",
        "strike",
        "tt"
    );

    $s = htmlentities($s);

    foreach($html_tags as $tag) {
        $count=0;
        //comment tags won't match the following pattern because we are searching
        //word boundaries
        //doctype
        $s = preg_replace("#&lt;!doctype(.*)&gt;#isU",
            "<span class=\"tgOpen hl_doctype\" title=\"doctype\">&lt;&#33;doctype\\1&gt;</span>",$s, -1, $count);
        if($count>0) {
            $stats["doctype"]=$count;
        }
        
        //comments
        $count=0;
        $s = preg_replace("#&lt;!(.*)&gt;#isU",
            "<span class=\"tgOpen hl_comment\" title=\"comment\">&lt;&#33;\\1&gt;</span>",$s, -1, $count);
        if($count>0) {
            $stats["comment"]=$count;
        }
        $count=0;
        //opening tags
        $s = preg_replace("#&lt;\b".$tag."\b(.*)&gt;#isU",
            "<span class=\"tgOpen hl_".$tag."\" title=\"".$tag."\">&lt;".$tag."\\1&gt;</span>",$s, -1, $count);
        if($count>0) {
            $stats[$tag]=$count;
        }
        //closing tags
        $s = preg_replace("#&lt;/\b".$tag."\b&gt;#isU",
            "<span class=\"tgClose hl_$tag\" title=\"".$tag."\">&lt;/".$tag."&gt;</span>",$s);
    }
    return nl2br($s);
}

?>