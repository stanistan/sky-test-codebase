<?

// default

global $sky_storage_path;

$this->title = 'Welcome To SkyPHP';

$loader = new Twig_Loader_Filesystem(__DIR__);
$twig = new Twig_Environment($loader, array(
	'cache' => $sky_storage_path . 'templates'
));

$t = $twig->loadTemplate('page.html');

$this->template('html5', 'top');

echo $t->render(array('title' => $this->title ));

$this->template('html5', 'bottom');
