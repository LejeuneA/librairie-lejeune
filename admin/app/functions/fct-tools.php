<?php

/*
|--------------------------------------------------------------------------
| Input filtering
|--------------------------------------------------------------------------
*/

function filterInputs($data)
{
    if (is_array($data)) {
        return array_map(
            'filterInputs',
            $data
        );
    }

    if ($data === null) {
        return '';
    }

    return trim(
        strip_tags(
            (string) $data
        )
    );
}

/*
|--------------------------------------------------------------------------
| HTML escaping
|--------------------------------------------------------------------------
*/

function uiEscape($value): string
{
    if (
        !is_scalar($value)
        && !(
            is_object($value)
            && method_exists(
                $value,
                '__toString'
            )
        )
    ) {
        return '';
    }

    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}

/*
|--------------------------------------------------------------------------
| Safe asset URLs
|--------------------------------------------------------------------------
*/

function safeAssetUrl($path): string
{
    $path = trim(
        (string) $path
    );

    if ($path === '') {
        return '';
    }

    /*
     * Tam URL ise yalnızca HTTP ve HTTPS
     * protokollerine izin veriyoruz.
     */

    if (
        filter_var(
            $path,
            FILTER_VALIDATE_URL
        )
    ) {
        $scheme = strtolower(
            (string) parse_url(
                $path,
                PHP_URL_SCHEME
            )
        );

        if (
            in_array(
                $scheme,
                ['http', 'https'],
                true
            )
        ) {
            return $path;
        }

        return '';
    }

    $path = str_replace(
        '\\',
        '/',
        $path
    );

    $path = preg_replace(
        '#^\./+#',
        '',
        $path
    );

    $path = ltrim(
        (string) $path,
        '/'
    );

    /*
     * Dizin dışına çıkmayı engeller.
     */

    if (
        $path === ''
        || str_contains(
            $path,
            '..'
        )
        || preg_match(
            '#^\s*(javascript|data|vbscript):#i',
            $path
        )
    ) {
        return '';
    }

    return rtrim(
        DOMAIN,
        '/'
    ) . '/' . $path;
}

/*
|--------------------------------------------------------------------------
| Rich text sanitization
|--------------------------------------------------------------------------
*/

function sanitizeRichTextNode(
    DOMNode $node,
    array $allowedTags
): void {
    $children = [];

    foreach ($node->childNodes as $child) {
        $children[] = $child;
    }

    foreach ($children as $child) {
        if ($child instanceof DOMElement) {
            sanitizeRichTextNode(
                $child,
                $allowedTags
            );

            $tagName = strtolower(
                $child->tagName
            );

            if (
                !in_array(
                    $tagName,
                    $allowedTags,
                    true
                )
            ) {
                /*
                 * Yasak etiketi kaldır,
                 * içindeki güvenli metni koru.
                 */

                $parent = $child->parentNode;

                if ($parent !== null) {
                    while (
                        $child->firstChild
                        !== null
                    ) {
                        $parent->insertBefore(
                            $child->firstChild,
                            $child
                        );
                    }

                    $parent->removeChild(
                        $child
                    );
                }

                continue;
            }

            /*
             * TinyMCE içeriğindeki class, style,
             * onclick ve benzeri tüm özellikleri kaldır.
             */

            while (
                $child->attributes->length > 0
            ) {
                $attribute =
                    $child->attributes->item(0);

                if ($attribute !== null) {
                    $child->removeAttributeNode(
                        $attribute
                    );
                }
            }
        } elseif (
            !($child instanceof DOMText)
            && !($child instanceof DOMEntityReference)
        ) {
            if ($child->parentNode !== null) {
                $child->parentNode->removeChild(
                    $child
                );
            }
        }
    }
}

function sanitizeRichText($html): string
{
    $html = trim(
        (string) $html
    );

    if ($html === '') {
        return '';
    }

    $html = html_entity_decode(
        $html,
        ENT_QUOTES | ENT_HTML5,
        'UTF-8'
    );

    /*
     * DOM uzantısı bulunmuyorsa güvenli
     * düz metin gösterimine geri dön.
     */

    if (!class_exists('DOMDocument')) {
        return nl2br(
            uiEscape(
                strip_tags($html)
            )
        );
    }

    $document = new DOMDocument(
        '1.0',
        'UTF-8'
    );

    $previousSetting =
        libxml_use_internal_errors(true);

    $loaded = $document->loadHTML(
        '<?xml encoding="UTF-8">'
            . '<div id="safe-rich-text">'
            . $html
            . '</div>',
        LIBXML_HTML_NOIMPLIED
            | LIBXML_HTML_NODEFDTD
    );

    libxml_clear_errors();

    libxml_use_internal_errors(
        $previousSetting
    );

    if (!$loaded) {
        return nl2br(
            uiEscape(
                strip_tags($html)
            )
        );
    }

    $root = $document->getElementById(
        'safe-rich-text'
    );

    if ($root === null) {
        return nl2br(
            uiEscape(
                strip_tags($html)
            )
        );
    }

    $allowedTags = [
        'div',
        'p',
        'br',
        'strong',
        'b',
        'em',
        'i',
        'u',
        'ul',
        'ol',
        'li',
        'h2',
        'h3',
        'h4',
        'blockquote',
    ];

    sanitizeRichTextNode(
        $root,
        $allowedTags
    );

    $safeHtml = '';

    foreach ($root->childNodes as $child) {
        $safeHtml .= $document->saveHTML(
            $child
        );
    }

    return $safeHtml;
}

/*
|--------------------------------------------------------------------------
| Product excerpt
|--------------------------------------------------------------------------
*/

function createTextExcerpt(
    $content,
    int $maximumLength = 350
): string {
    $plainText = html_entity_decode(
        (string) $content,
        ENT_QUOTES | ENT_HTML5,
        'UTF-8'
    );

    $plainText = strip_tags(
        $plainText
    );

    $plainText = preg_replace(
        '/\s+/u',
        ' ',
        $plainText
    );

    $plainText = trim(
        (string) $plainText
    );

    if (
        mb_strlen($plainText)
        <= $maximumLength
    ) {
        return $plainText;
    }

    return rtrim(
        mb_substr(
            $plainText,
            0,
            $maximumLength
        )
    ) . '…';
}

/*
|--------------------------------------------------------------------------
| Debug helper
|--------------------------------------------------------------------------
*/

function disp_ar(
    $array,
    $info = null,
    $type = 'PR'
): void {
    if (
        defined('DEBUG')
        && DEBUG !== true
    ) {
        return;
    }

    echo '<pre>';

    if ($info !== null) {
        echo '<strong>'
            . uiEscape($info)
            . '</strong>'
            . PHP_EOL;
    }

    ob_start();

    if ($type === 'VD') {
        var_dump($array);
    } else {
        print_r($array);
    }

    $output = ob_get_clean();

    echo uiEscape($output);

    echo '</pre>';
}
