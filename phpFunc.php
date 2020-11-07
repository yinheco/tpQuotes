/* ===> 随机引言 by https://yinhe.co , 修改自 wordpress 插件 RQuotes*/
function show_quotes() {
    global $show_quotes;
    // eot里面的就是随机显示的格言，可以自定义一句一行即可。
    $quotes = <<< eot
兴趣是最好的老师——爱因斯坦
想象力比知识更重要! 因为知识是有限的, 而想象力概括着世界的一切, 推动着进步, 并且是知识进化的源泉。——爱因斯坦
只有偏执狂才能生存!——Andy Grove 
控制风险的最好办法是深入思考, 而不是投资组合。——巴菲特
价值投资不能保证我们盈利, 但价值投资给我们提供了通向成功的唯一机会。——巴菲特
我从事投资时, 会观察一家公司的全貌; 而大多数投资人只盯着它的股价。——巴菲特
退潮时, 便可知道谁在裸泳。——巴菲特
在b进位制中，以数n起头的数出现的机率为logb(n + 1) − logb(n) —— 本福特定律
Don't misinform your Doctor nor your Lawyer. —— Benjamin Franklin
别向医生和律师提供错误的消息。—— 本杰明·富兰克林
知识上的投资总能得到最好的回报。——本杰明.富兰克林
640K对每一个人来说都已足够 —— 比尔盖茨
一个伟大的程序员, 其价值相当于普通程序员的1万倍!——比尔盖茨
计算机没什么用。他们只会告诉你答案。——毕加索
想想看吧，已经有一百万只猴子坐在一百万台打字机旁，可Usenet就是比不上莎士比。—— Blair Houghton
我向星星许了个愿。我并不是真的相信它，但是反正也是免费的，而且也没有证据证明它不灵。—— 加菲猫
要节约用水，尽量和女友一起洗澡——加菲猫
通往地狱的路，都是由善意铺成的——哈耶克
不管我们已经观察到多少只白天鹅，都不能确立“所有天鹅皆为白色”的理论。只要看见一只黑天鹅就可以驳倒它。——卡尔·波普尔
天地不仁，以万物为刍狗；圣人不仁，以百姓为刍狗。—— 老子
没有人足够完美，以至可以未经别人同意就支配别人。 ——林肯
你可以暂时地蒙骗所有人, 也可以永久地蒙骗部分人, 但不可能永久地蒙骗所有人。——林肯
实力永远意味着责任和危险。 —— 罗斯福. T.
大多数人宁愿死去, 也不愿思考。 -- 事实上他们也确实到死都没有思考。——罗素
如果你想走到高处，就要使用自己的两条腿！不要让别人把你抬到高处；不要坐在别人的背上和头上。—— 尼采
在认识一切事物之后，人才能认识自己，因为事物仅仅是人的界限。——尼采
我注意过，即便是那些声称一切都是命中注定的而且我们无力改变的人，在过马路之前都会左右看。——史提芬·霍金
Stay hungry. Stay foolish.——史蒂夫.乔布斯
这辈子没法做太多的事情, 所以每一件都要做到精彩绝伦!——史蒂夫.乔布斯
我每天都自问: '如果今天是我生命的最后一天, 我还会做今天打算做的事情吗?'——史蒂夫.乔布斯
领袖和跟风者的区别就在于创新!——史蒂夫.乔布斯
尊严不值钱，却是我唯一真正拥有的！—— V For Vendetta
你自己的代码如果超过6个月不看，再看的时候也一样像是别人写——伊格尔森定律
不要恐慌 ——《银河系漫游指南》
eot;

    // Here we split it into lines
    $quotes = explode("\n", $quotes);
    // 随机选择一行输出
    $show_quotes = wptexturize( $quotes[ mt_rand(0, count($quotes)-1 ) ] );
        //echo "<p class=\"blog-post\" style=\"text-align:center; \">".$show_quotes."</p>";
         echo $show_quotes;
}

// https://developer.wordpress.org/reference/functions/wptexturize/
function wptexturize( $text, $reset = false ) {
    global $wp_cockneyreplace, $shortcode_tags;
    static $static_characters            = null,
        $static_replacements             = null,
        $dynamic_characters              = null,
        $dynamic_replacements            = null,
        $default_no_texturize_tags       = null,
        $default_no_texturize_shortcodes = null,
        $run_texturize                   = true,
        $apos                            = null,
        $prime                           = null,
        $double_prime                    = null,
        $opening_quote                   = null,
        $closing_quote                   = null,
        $opening_single_quote            = null,
        $closing_single_quote            = null,
        $open_q_flag                     = '<!--oq-->',
        $open_sq_flag                    = '<!--osq-->',
        $apos_flag                       = '<!--apos-->';
 
    // If there's nothing to do, just stop.
    if ( empty( $text ) || false === $run_texturize ) {
        return $text;
    }
 
    // Set up static variables. Run once only.
    if ( $reset || ! isset( $static_characters ) ) {
        /**
         * Filters whether to skip running wptexturize().
         *
         * Returning false from the filter will effectively short-circuit wptexturize()
         * and return the original text passed to the function instead.
         *
         * The filter runs only once, the first time wptexturize() is called.
         *
         * @since 4.0.0
         *
         * @see wptexturize()
         *
         * @param bool $run_texturize Whether to short-circuit wptexturize().
         */
        $run_texturize = apply_filters( 'run_wptexturize', $run_texturize );
        if ( false === $run_texturize ) {
            return $text;
        }
 
        /* translators: Opening curly double quote. */
        $opening_quote = _x( '&#8220;', 'opening curly double quote' );
        /* translators: Closing curly double quote. */
        $closing_quote = _x( '&#8221;', 'closing curly double quote' );
 
        /* translators: Apostrophe, for example in 'cause or can't. */
        $apos = _x( '&#8217;', 'apostrophe' );
 
        /* translators: Prime, for example in 9' (nine feet). */
        $prime = _x( '&#8242;', 'prime' );
        /* translators: Double prime, for example in 9" (nine inches). */
        $double_prime = _x( '&#8243;', 'double prime' );
 
        /* translators: Opening curly single quote. */
        $opening_single_quote = _x( '&#8216;', 'opening curly single quote' );
        /* translators: Closing curly single quote. */
        $closing_single_quote = _x( '&#8217;', 'closing curly single quote' );
 
        /* translators: En dash. */
        $en_dash = _x( '&#8211;', 'en dash' );
        /* translators: Em dash. */
        $em_dash = _x( '&#8212;', 'em dash' );
 
        $default_no_texturize_tags       = array( 'pre', 'code', 'kbd', 'style', 'script', 'tt' );
        $default_no_texturize_shortcodes = array( 'code' );
 
        // If a plugin has provided an autocorrect array, use it.
        if ( isset( $wp_cockneyreplace ) ) {
            $cockney        = array_keys( $wp_cockneyreplace );
            $cockneyreplace = array_values( $wp_cockneyreplace );
        } else {
            /*
             * translators: This is a comma-separated list of words that defy the syntax of quotations in normal use,
             * for example... 'We do not have enough words yet'... is a typical quoted phrase. But when we write
             * lines of code 'til we have enough of 'em, then we need to insert apostrophes instead of quotes.
             */
            $cockney = explode(
                ',',
                _x(
                    "'tain't,'twere,'twas,'tis,'twill,'til,'bout,'nuff,'round,'cause,'em",
                    'Comma-separated list of words to texturize in your language'
                )
            );
 
            $cockneyreplace = explode(
                ',',
                _x(
                    '&#8217;tain&#8217;t,&#8217;twere,&#8217;twas,&#8217;tis,&#8217;twill,&#8217;til,&#8217;bout,&#8217;nuff,&#8217;round,&#8217;cause,&#8217;em',
                    'Comma-separated list of replacement words in your language'
                )
            );
        }
 
        $static_characters   = array_merge( array( '...', '``', '\'\'', ' (tm)' ), $cockney );
        $static_replacements = array_merge( array( '&#8230;', $opening_quote, $closing_quote, ' &#8482;' ), $cockneyreplace );
 
        // Pattern-based replacements of characters.
        // Sort the remaining patterns into several arrays for performance tuning.
        $dynamic_characters   = array(
            'apos'  => array(),
            'quote' => array(),
            'dash'  => array(),
        );
        $dynamic_replacements = array(
            'apos'  => array(),
            'quote' => array(),
            'dash'  => array(),
        );
        $dynamic              = array();
        $spaces               = wp_spaces_regexp();
 
        // '99' and '99" are ambiguous among other patterns; assume it's an abbreviated year at the end of a quotation.
        if ( "'" !== $apos || "'" !== $closing_single_quote ) {
            $dynamic[ '/\'(\d\d)\'(?=\Z|[.,:;!?)}\-\]]|&gt;|' . $spaces . ')/' ] = $apos_flag . '$1' . $closing_single_quote;
        }
        if ( "'" !== $apos || '"' !== $closing_quote ) {
            $dynamic[ '/\'(\d\d)"(?=\Z|[.,:;!?)}\-\]]|&gt;|' . $spaces . ')/' ] = $apos_flag . '$1' . $closing_quote;
        }
 
        // '99 '99s '99's (apostrophe)  But never '9 or '99% or '999 or '99.0.
        if ( "'" !== $apos ) {
            $dynamic['/\'(?=\d\d(?:\Z|(?![%\d]|[.,]\d)))/'] = $apos_flag;
        }
 
        // Quoted numbers like '0.42'.
        if ( "'" !== $opening_single_quote && "'" !== $closing_single_quote ) {
            $dynamic[ '/(?<=\A|' . $spaces . ')\'(\d[.,\d]*)\'/' ] = $open_sq_flag . '$1' . $closing_single_quote;
        }
 
        // Single quote at start, or preceded by (, {, <, [, ", -, or spaces.
        if ( "'" !== $opening_single_quote ) {
            $dynamic[ '/(?<=\A|[([{"\-]|&lt;|' . $spaces . ')\'/' ] = $open_sq_flag;
        }
 
        // Apostrophe in a word. No spaces, double apostrophes, or other punctuation.
        if ( "'" !== $apos ) {
            $dynamic[ '/(?<!' . $spaces . ')\'(?!\Z|[.,:;!?"\'(){}[\]\-]|&[lg]t;|' . $spaces . ')/' ] = $apos_flag;
        }
 
        $dynamic_characters['apos']   = array_keys( $dynamic );
        $dynamic_replacements['apos'] = array_values( $dynamic );
        $dynamic                      = array();
 
        // Quoted numbers like "42".
        if ( '"' !== $opening_quote && '"' !== $closing_quote ) {
            $dynamic[ '/(?<=\A|' . $spaces . ')"(\d[.,\d]*)"/' ] = $open_q_flag . '$1' . $closing_quote;
        }
 
        // Double quote at start, or preceded by (, {, <, [, -, or spaces, and not followed by spaces.
        if ( '"' !== $opening_quote ) {
            $dynamic[ '/(?<=\A|[([{\-]|&lt;|' . $spaces . ')"(?!' . $spaces . ')/' ] = $open_q_flag;
        }
 
        $dynamic_characters['quote']   = array_keys( $dynamic );
        $dynamic_replacements['quote'] = array_values( $dynamic );
        $dynamic                       = array();
 
        // Dashes and spaces.
        $dynamic['/---/'] = $em_dash;
        $dynamic[ '/(?<=^|' . $spaces . ')--(?=$|' . $spaces . ')/' ] = $em_dash;
        $dynamic['/(?<!xn)--/']                                       = $en_dash;
        $dynamic[ '/(?<=^|' . $spaces . ')-(?=$|' . $spaces . ')/' ]  = $en_dash;
 
        $dynamic_characters['dash']   = array_keys( $dynamic );
        $dynamic_replacements['dash'] = array_values( $dynamic );
    }
 
    // Must do this every time in case plugins use these filters in a context sensitive manner.
    /**
     * Filters the list of HTML elements not to texturize.
     *
     * @since 2.8.0
     *
     * @param string[] $default_no_texturize_tags An array of HTML element names.
     */
    $no_texturize_tags = apply_filters( 'no_texturize_tags', $default_no_texturize_tags );
    /**
     * Filters the list of shortcodes not to texturize.
     *
     * @since 2.8.0
     *
     * @param string[] $default_no_texturize_shortcodes An array of shortcode names.
     */
    $no_texturize_shortcodes = apply_filters( 'no_texturize_shortcodes', $default_no_texturize_shortcodes );
 
    $no_texturize_tags_stack       = array();
    $no_texturize_shortcodes_stack = array();
 
    // Look for shortcodes and HTML elements.
 
    preg_match_all( '@\[/?([^<>&/\[\]\x00-\x20=]++)@', $text, $matches );
    $tagnames         = array_intersect( array_keys( $shortcode_tags ), $matches[1] );
    $found_shortcodes = ! empty( $tagnames );
    $shortcode_regex  = $found_shortcodes ? _get_wptexturize_shortcode_regex( $tagnames ) : '';
    $regex            = _get_wptexturize_split_regex( $shortcode_regex );
 
    $textarr = preg_split( $regex, $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );
 
    foreach ( $textarr as &$curl ) {
        // Only call _wptexturize_pushpop_element if $curl is a delimiter.
        $first = $curl[0];
        if ( '<' === $first ) {
            if ( '<!--' === substr( $curl, 0, 4 ) ) {
                // This is an HTML comment delimiter.
                continue;
            } else {
                // This is an HTML element delimiter.
 
                // Replace each & with &#038; unless it already looks like an entity.
                $curl = preg_replace( '/&(?!#(?:\d+|x[a-f0-9]+);|[a-z1-4]{1,8};)/i', '&#038;', $curl );
 
                _wptexturize_pushpop_element( $curl, $no_texturize_tags_stack, $no_texturize_tags );
            }
        } elseif ( '' === trim( $curl ) ) {
            // This is a newline between delimiters. Performance improves when we check this.
            continue;
 
        } elseif ( '[' === $first && $found_shortcodes && 1 === preg_match( '/^' . $shortcode_regex . '$/', $curl ) ) {
            // This is a shortcode delimiter.
 
            if ( '[[' !== substr( $curl, 0, 2 ) && ']]' !== substr( $curl, -2 ) ) {
                // Looks like a normal shortcode.
                _wptexturize_pushpop_element( $curl, $no_texturize_shortcodes_stack, $no_texturize_shortcodes );
            } else {
                // Looks like an escaped shortcode.
                continue;
            }
        } elseif ( empty( $no_texturize_shortcodes_stack ) && empty( $no_texturize_tags_stack ) ) {
            // This is neither a delimiter, nor is this content inside of no_texturize pairs. Do texturize.
 
            $curl = str_replace( $static_characters, $static_replacements, $curl );
 
            if ( false !== strpos( $curl, "'" ) ) {
                $curl = preg_replace( $dynamic_characters['apos'], $dynamic_replacements['apos'], $curl );
                $curl = wptexturize_primes( $curl, "'", $prime, $open_sq_flag, $closing_single_quote );
                $curl = str_replace( $apos_flag, $apos, $curl );
                $curl = str_replace( $open_sq_flag, $opening_single_quote, $curl );
            }
            if ( false !== strpos( $curl, '"' ) ) {
                $curl = preg_replace( $dynamic_characters['quote'], $dynamic_replacements['quote'], $curl );
                $curl = wptexturize_primes( $curl, '"', $double_prime, $open_q_flag, $closing_quote );
                $curl = str_replace( $open_q_flag, $opening_quote, $curl );
            }
            if ( false !== strpos( $curl, '-' ) ) {
                $curl = preg_replace( $dynamic_characters['dash'], $dynamic_replacements['dash'], $curl );
            }
 
            // 9x9 (times), but never 0x9999.
            if ( 1 === preg_match( '/(?<=\d)x\d/', $curl ) ) {
                // Searching for a digit is 10 times more expensive than for the x, so we avoid doing this one!
                $curl = preg_replace( '/\b(\d(?(?<=0)[\d\.,]+|[\d\.,]*))x(\d[\d\.,]*)\b/', '$1&#215;$2', $curl );
            }
 
            // Replace each & with &#038; unless it already looks like an entity.
            $curl = preg_replace( '/&(?!#(?:\d+|x[a-f0-9]+);|[a-z1-4]{1,8};)/i', '&#038;', $curl );
        }
    }
 
    return implode( '', $textarr );
}


// https://developer.wordpress.org/reference/functions/apply_filters/
function apply_filters( $tag, $value ) {
    global $wp_filter, $wp_current_filter;
 
    $args = func_get_args();
 
    // Do 'all' actions first.
    if ( isset( $wp_filter['all'] ) ) {
        $wp_current_filter[] = $tag;
        _wp_call_all_hook( $args );
    }
 
    if ( ! isset( $wp_filter[ $tag ] ) ) {
        if ( isset( $wp_filter['all'] ) ) {
            array_pop( $wp_current_filter );
        }
        return $value;
    }
 
    if ( ! isset( $wp_filter['all'] ) ) {
        $wp_current_filter[] = $tag;
    }
 
    // Don't pass the tag name to WP_Hook.
    array_shift( $args );
 
    $filtered = $wp_filter[ $tag ]->apply_filters( $value, $args );
 
    array_pop( $wp_current_filter );
 
    return $filtered;
}

// https://developer.wordpress.org/reference/functions/_x/
function _x( $text, $context, $domain = 'default' ) {
    return translate_with_gettext_context( $text, $context, $domain );
}

// https://developer.wordpress.org/reference/functions/translate_with_gettext_context/
function translate_with_gettext_context( $text, $context, $domain = 'default' ) {
    $translations = get_translations_for_domain( $domain );
    $translation  = $translations->translate( $text, $context );
 
    /**
     * Filters text with its translation based on context information.
     *
     * @since 2.8.0
     *
     * @param string $translation Translated text.
     * @param string $text        Text to translate.
     * @param string $context     Context information for the translators.
     * @param string $domain      Text domain. Unique identifier for retrieving translated strings.
     */
    $translation = apply_filters( 'gettext_with_context', $translation, $text, $context, $domain );
 
    /**
     * Filters text with its translation based on context information for a domain.
     *
     * The dynamic portion of the hook, `$domain`, refers to the text domain.
     *
     * @since 5.5.0
     *
     * @param string $translation Translated text.
     * @param string $text        Text to translate.
     * @param string $context     Context information for the translators.
     * @param string $domain      Text domain. Unique identifier for retrieving translated strings.
     */
    $translation = apply_filters( "gettext_with_context_{$domain}", $translation, $text, $context, $domain );
 
    return $translation;
}

// https://developer.wordpress.org/reference/functions/get_translations_for_domain/
function get_translations_for_domain( $domain ) {
    global $l10n;
    if ( isset( $l10n[ $domain ] ) || ( _load_textdomain_just_in_time( $domain ) && isset( $l10n[ $domain ] ) ) ) {
        return $l10n[ $domain ];
    }
 
    static $noop_translations = null;
    if ( null === $noop_translations ) {
        $noop_translations = new NOOP_Translations;
    }
 
    return $noop_translations;
}

// https://developer.wordpress.org/reference/functions/_load_textdomain_just_in_time/
function _load_textdomain_just_in_time( $domain ) {
    global $l10n_unloaded;
 
    $l10n_unloaded = (array) $l10n_unloaded;
 
    // Short-circuit if domain is 'default' which is reserved for core.
    if ( 'default' === $domain || isset( $l10n_unloaded[ $domain ] ) ) {
        return false;
    }
 
    $translation_path = _get_path_to_translation( $domain );
    if ( false === $translation_path ) {
        return false;
    }
 
    return load_textdomain( $domain, $translation_path );
}

// https://developer.wordpress.org/reference/classes/noop_translations/
class NOOP_Translations {
    var $entries = array();
    var $headers = array();
 
    function add_entry( $entry ) {
        return true;
    }
 
    /**
     * @param string $header
     * @param string $value
     */
    function set_header( $header, $value ) {
    }
 
    /**
     * @param array $headers
     */
    function set_headers( $headers ) {
    }
 
    /**
     * @param string $header
     * @return false
     */
    function get_header( $header ) {
        return false;
    }
 
    /**
     * @param Translation_Entry $entry
     * @return false
     */
    function translate_entry( &$entry ) {
        return false;
    }
 
    /**
     * @param string $singular
     * @param string $context
     */
    function translate( $singular, $context = null ) {
        return $singular;
    }
 
    /**
     * @param int $count
     * @return bool
     */
    function select_plural_form( $count ) {
        return 1 == $count ? 0 : 1;
    }
 
    /**
     * @return int
     */
    function get_plural_forms_count() {
        return 2;
    }
 
    /**
     * @param string $singular
     * @param string $plural
     * @param int    $count
     * @param string $context
     */
    function translate_plural( $singular, $plural, $count, $context = null ) {
        return 1 == $count ? $singular : $plural;
    }
 
    /**
     * @param object $other
     */
    function merge_with( &$other ) {
    }
}

// https://developer.wordpress.org/reference/functions/wp_spaces_regexp/
function wp_spaces_regexp() {
    static $spaces = '';
 
    if ( empty( $spaces ) ) {
        /**
         * Filters the regexp for common whitespace characters.
         *
         * This string is substituted for the \s sequence as needed in regular
         * expressions. For websites not written in English, different characters
         * may represent whitespace. For websites not encoded in UTF-8, the 0xC2 0xA0
         * sequence may not be in use.
         *
         * @since 4.0.0
         *
         * @param string $spaces Regexp pattern for matching common whitespace characters.
         */
        $spaces = apply_filters( 'wp_spaces_regexp', '[\r\n\t ]|\xC2\xA0|&nbsp;' );
    }
 
    return $spaces;
}

// https://xref.trepmal.com/wptrunk/wp-includes/formatting.php.source.txt
function _get_wptexturize_split_regex( $shortcode_regex = '' ) {
	static $html_regex;

	if ( ! isset( $html_regex ) ) {
		// phpcs:disable Squiz.Strings.ConcatenationSpacing.PaddingFound -- don't remove regex indentation
		$comment_regex =
			'!'             // Start of comment, after the <.
			. '(?:'         // Unroll the loop: Consume everything until --> is found.
			.     '-(?!->)' // Dash not followed by end of comment.
			.     '[^\-]*+' // Consume non-dashes.
			. ')*+'         // Loop possessively.
			. '(?:-->)?';   // End of comment. If not found, match all input.

		$html_regex = // Needs replaced with wp_html_split() per Shortcode API Roadmap.
			'<'                  // Find start of element.
			. '(?(?=!--)'        // Is this a comment?
			.     $comment_regex // Find end of comment.
			. '|'
			.     '[^>]*>?'      // Find end of element. If not found, match all input.
			. ')';
		// phpcs:enable
	}

	if ( empty( $shortcode_regex ) ) {
		$regex = '/(' . $html_regex . ')/';
	} else {
		$regex = '/(' . $html_regex . '|' . $shortcode_regex . ')/';
	}

	return $regex;
}

// https://developer.wordpress.org/reference/functions/wptexturize_primes/
function wptexturize_primes( $haystack, $needle, $prime, $open_quote, $close_quote ) {
    $spaces           = wp_spaces_regexp();
    $flag             = '<!--wp-prime-or-quote-->';
    $quote_pattern    = "/$needle(?=\\Z|[.,:;!?)}\\-\\]]|&gt;|" . $spaces . ')/';
    $prime_pattern    = "/(?<=\\d)$needle/";
    $flag_after_digit = "/(?<=\\d)$flag/";
    $flag_no_digit    = "/(?<!\\d)$flag/";
 
    $sentences = explode( $open_quote, $haystack );
 
    foreach ( $sentences as $key => &$sentence ) {
        if ( false === strpos( $sentence, $needle ) ) {
            continue;
        } elseif ( 0 !== $key && 0 === substr_count( $sentence, $close_quote ) ) {
            $sentence = preg_replace( $quote_pattern, $flag, $sentence, -1, $count );
            if ( $count > 1 ) {
                // This sentence appears to have multiple closing quotes. Attempt Vulcan logic.
                $sentence = preg_replace( $flag_no_digit, $close_quote, $sentence, -1, $count2 );
                if ( 0 === $count2 ) {
                    // Try looking for a quote followed by a period.
                    $count2 = substr_count( $sentence, "$flag." );
                    if ( $count2 > 0 ) {
                        // Assume the rightmost quote-period match is the end of quotation.
                        $pos = strrpos( $sentence, "$flag." );
                    } else {
                        // When all else fails, make the rightmost candidate a closing quote.
                        // This is most likely to be problematic in the context of bug #18549.
                        $pos = strrpos( $sentence, $flag );
                    }
                    $sentence = substr_replace( $sentence, $close_quote, $pos, strlen( $flag ) );
                }
                // Use conventional replacement on any remaining primes and quotes.
                $sentence = preg_replace( $prime_pattern, $prime, $sentence );
                $sentence = preg_replace( $flag_after_digit, $prime, $sentence );
                $sentence = str_replace( $flag, $close_quote, $sentence );
            } elseif ( 1 == $count ) {
                // Found only one closing quote candidate, so give it priority over primes.
                $sentence = str_replace( $flag, $close_quote, $sentence );
                $sentence = preg_replace( $prime_pattern, $prime, $sentence );
            } else {
                // No closing quotes found. Just run primes pattern.
                $sentence = preg_replace( $prime_pattern, $prime, $sentence );
            }
        } else {
            $sentence = preg_replace( $prime_pattern, $prime, $sentence );
            $sentence = preg_replace( $quote_pattern, $close_quote, $sentence );
        }
        if ( '"' === $needle && false !== strpos( $sentence, '"' ) ) {
            $sentence = str_replace( '"', $close_quote, $sentence );
        }
    }
 
    return implode( $open_quote, $sentences );
}
/* <=== 随机引言 */
