<?

global $jquery_version, $sky_storage_path;

$this->jquery_version = $jquery_version;

$this->template_js[] = '/lib/history.js-090911-edge/history.js';
$this->template_js[] = '/lib/history.js-090911-edge/history.html4.js';
$this->template_js[] = '/lib/history.js-090911-edge/history.adapter.jquery.js';
$this->template_js[] = '/lib/js/jquery.livequery.min.js';

$this->head = (is_array($this->head))
	? $this->head 
	: array($this->head);

$attrs  = '';
if ($this->html_attrs) {
    foreach ($this->html_attrs as $k => $v) {
        $attrs .= " {$k}=\"{$v}\"";
    }
}

$this->attrs = $attrs;

$loader = new Twig_Loader_Filesystem(__DIR__);
$twig = new Twig_Environment($loader, array(
	'cache' => $sky_storage_path . 'templates'
));

try {
	$t = $twig->loadTemplate($template_area . '.html');
} catch (Exception $e) {
	if ($template_area == 'hometop') $template_area = 'top';
	$t = $twig->loadTemplate($template_area . '.html');
}


$p = (array) $this;
$p['_object'] = $this;

echo $t->render( $p );