<?

// default

$loader = new Twig_Loader_String();
$twig = new Twig_Environment($loader);

echo $twig->render('Hello {{name}}!', array('name' => 'Stan'));