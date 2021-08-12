<?php
show_admin_bar(false);

add_filter('tiny_mce_before_init', 'myextensionTinyMCE' );




function myextensionTinyMCE($init) {
	// Command separated string of extended elements
	$ext = 'span[id|name|class|style]';

	// Add to extended_valid_elements if it alreay exists
	if ( isset( $init['extended_valid_elements'] ) ) {
		$init['extended_valid_elements'] .= ',' . $ext;
	} else {
		$init['extended_valid_elements'] = $ext;
	}

	// Super important: return $init!
	return $init;
}


function custom_excerpt($article, $max_lendth = 20, $id='') {
	$l = strlen($article);
	$max_lendth = (int)$max_lendth;
	if($l > $max_lendth){
		$array = explode(' ', $article);
		$word_count = count($array);
		$text ='';
		for($i=0; $i < $max_lendth; $i++){
			$text .= $array[$i]. ' ';
		}
		$more='';
		if(!empty($id)){
			$more = ' ... <a href="'. get_permalink($id). '"><span class="read_more">Читати Далі</span></a>';
		}
		return  $text . $more;
	}else{
		$more='';
		if(!empty($id)){
			$more = ' ... <a href="'. get_permalink($id). '"><span class="read_more">Читати Далі</span></a>';
		}
		return  $article . $more;
	}
}


function force_get_post_thumbnail($id = 0, $size = 'medium'){
	$prod_img = get_post_thumbnail_id( $id);
	if($prod_img && !empty($prod_img)){
		$src_ = wp_get_attachment_image_src( $prod_img, $size);
		$src = $src_['0'];
	}else{
		$src = get_template_directory_uri() . '/img/no_image.png';
	}
	return $src;
}


function tel_href($str_phohe=''){
	if(!empty($str_phohe)){

		$tel = str_replace(' ', '', $str_phohe);
		$tel = str_replace('(', '', $tel);
		$tel = str_replace(')', '', $tel);
		$tel = str_replace('-', '', $tel);
		$tel = str_replace('–', '', $tel);
		$tel = str_replace('+', '', $tel);
		$tel = str_replace('#', '', $tel);

		return 'tel:'.$tel;
	}
}


function no_image($sq = false){
	if( $sq )
		return get_template_directory_uri() . '/img/no_image_500x500.png';
	else
		return get_template_directory_uri() . '/img/no_image.png';
}


function get_force_thumbnail($ID = 0, $size = 'large',$sq = false){
	if($ID){
		$thumbnail_id = get_post_thumbnail_id($ID);
		if($thumbnail_id){
			$src = wp_get_attachment_image_src( $thumbnail_id, $size);
			return $src[0];
		}else return no_image($sq);
	}else{
		$id = get_the_id();
		get_force_thumbnail($id);
	}
}


function lat_lng_str_to_array($str){
	if(!empty($str)){
		$ret = array();
		$a = explode(',', $str);
		foreach ($a as $k => $v) {
			$ret[] = trim($v);
		}

		$js = 'lat: '.$ret[0].', lng: '.$ret[0];
		$ret['js'] = $js;
		return $ret;
	}else return false;

}


/**
 * Cuts the specified text up to specified number of characters.
 * Strips any of shortcodes.
 *
 * @author Kama (wp-kama.ru)
 *
 * @version 2.7.1
 *
 * @param string|array $args {
 *     Optional. Arguments to customize output.
 *
 *     @type int       $maxchar            Макс. количество символов.
 *     @type string    $text               Текст который нужно обрезать. По умолчанию post_excerpt, если нет post_content.
 *                                         Если в тексте есть `<!--more-->`, то `maxchar` игнорируется и берется
 *                                         все до `<!--more-->` вместе с HTML.
 *     @type bool      $autop              Заменить переносы строк на `<p>` и `<br>` или нет?
 *     @type string    $more_text          Текст ссылки `Читать дальше`.
 *     @type string    $save_tags          Теги, которые нужно оставить в тексте. Например `'<strong><b><a>'`.
 *     @type string    $sanitize_callback  Функция очистки текста.
 *     @type bool      $ignore_more        Нужно ли игнорировать <!--more--> в контенте.
 *
 * }
 *
 * @return string HTML
 */
function kama_excerpt( $args = '' ): string {
	global $post;

	$default = array(
		'maxchar'   => 350,   // количество символов.
		'text'      => '',    // какой текст обрезать (по умолчанию post_excerpt, если нет post_content.
		// Если есть тег <!--more-->, то maxchar игнорируется и берется все до <!--more--> вместе с HTML
		'autop'     => true,  // Заменить переносы строк на <p> и <br> или нет
		'save_tags' => '',    // Теги, которые нужно оставить в тексте, например '<strong><b><a>'
		'more_text' => __('Читати далі', 'woocommerce'), // текст ссылки читать дальше
	);

	if( is_array($args) ) $_args = $args;
	else                  parse_str( $args, $_args );

	$rg = (object) array_merge( $default, $_args );
	if( ! $rg->text ) $rg->text = $post->post_excerpt ?: $post->post_content;
	$rg = apply_filters( 'kama_excerpt_args', $rg );

	$text = $rg->text;
	$text = preg_replace( '~\[([a-z0-9_-]+)[^\]]*\](?!\().*?\[/\1\]~is', '', $text ); // убираем блочные шорткоды: [foo]some data[/foo]. Учитывает markdown
	$text = preg_replace( '~\[/?[^\]]*\](?!\()~', '', $text ); // убираем шоткоды: [singlepic id=3]. Учитывает markdown
	$text = trim( $text );

	// <!--more-->
	if( strpos( $text, '<!--more-->') ){
		preg_match('/(.*)<!--more-->/s', $text, $mm );

		$text = trim($mm[1]);

		$text_append = ' <a href="'. get_permalink( $post->ID ) .'#more-'. $post->ID .'">'. $rg->more_text .'</a>';
	}
	// text, excerpt, content
	else {
		$text = trim( strip_tags($text, $rg->save_tags) );

		// Обрезаем
		if( mb_strlen($text) > $rg->maxchar ){
			$text = mb_substr( $text, 0, $rg->maxchar );
			$text = preg_replace('~(.*)\s[^\s]*$~s', '\\1 ...', $text ); // убираем последнее слово, оно 99% неполное
		}
	}

	// Сохраняем переносы строк. Упрощенный аналог wpautop()
	if( $rg->autop ){
		$text = preg_replace(
			array("~\r~", "~\n{2,}~", "~\n~",   '~</p><br ?/>~'),
			array('',     '</p><p>',  '<br />', '</p>'),
			$text
		);
	}

	$text = apply_filters( 'kama_excerpt', $text, $rg );

	if( isset($text_append) ) $text .= $text_append;

	return ($rg->autop && $text) ? "<p>$text</p>" : $text;
}


function lang_switcher () {
	$out = '';
	if ( function_exists('wpm_get_languages') ) {
		$languages  = wpm_get_languages();
		$current    = wpm_get_language();


		// Select other languages
		$out_sub = '<ul class="sub-menu">';
		foreach ($languages as $code => $language)
		{
			$toggle_url = esc_url( wpm_translate_current_url( $code ) );
			$css_classes = 'b-language-selector-link ';

			$attr = '';
			if ( $code !== $current ) {
				$out_sub .= '<li class="menu-item">';
				$out_sub .= '<a href="' . $toggle_url . '" class="' . $css_classes . ' " data-lang="' . esc_attr($code) . '">';
				$out_sub .= '<img loading="lazy" class="mr-1" alt="'.$code.'" height="20" width="30" src="'. get_stylesheet_directory_uri() .'/img/flags/'. $language['flag'] .'">';
				$out_sub .= $language['name'];
				$out_sub .= '</a>';
				$out_sub .= '</li>';
			}

		}
		$out_sub .= '</ul>';


		// Select current language
		$out .= '<ul class="lang-menu menu">';
		foreach ($languages as $code => $language)
		{
			$toggle_url = esc_url( wpm_translate_current_url( $code ) );
			$css_classes = 'b-language-selector-link ';

			$attr = '';
			if ( $code === $current ) {
				$out .= '<li class="menu-item menu-item-has-children">';
				$out .= '<a href="#" class="' . $css_classes . ' " data-lang="' . esc_attr($code) . '">';
				$out .= '<img loading="lazy" class="mr-1" alt="'.$code.'" height="20" width="30" src="'. get_stylesheet_directory_uri() .'/img/flags/'. $language['flag'] .'">';
				$out .= $language['name'];
				$out .= '</a>';
				$out .= $out_sub;
				$out .= '</li>';
			}

		}
		$out .= '</ul>';

	}
	return $out;
}


/**
 * Backend validate reCaptcha
 *
 * @param $request
 *
 * @return bool
 */
function ReCaptchaValidate( $request ): bool {

	if ( function_exists('get_field') ){
		$recaptcha_secret_key = get_field('recaptcha_secret_key', 'options');
	}

	if ( $request && $recaptcha_secret_key ) {

		$responseCaptcha = json_decode( file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$recaptcha_secret_key.'&response='.$request) );
		if( $responseCaptcha->success === true ) return true;

	}
	return false;
}
