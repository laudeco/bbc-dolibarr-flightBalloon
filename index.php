<?php


use Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ContainerControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Loader\ClosureLoader;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$res=0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (! $res && ! empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) $res=@include($_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php");
// Try main.inc.php into web root detected using web root caluclated from SCRIPT_FILENAME
$tmp=empty($_SERVER['SCRIPT_FILENAME'])?'':$_SERVER['SCRIPT_FILENAME'];$tmp2=realpath(__FILE__); $i=strlen($tmp)-1; $j=strlen($tmp2)-1;
while($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i]==$tmp2[$j]) { $i--; $j--; }
if (! $res && $i > 0 && file_exists(substr($tmp, 0, ($i+1))."/main.inc.php")) $res=@include(substr($tmp, 0, ($i+1))."/main.inc.php");
if (! $res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i+1)))."/main.inc.php")) $res=@include(dirname(substr($tmp, 0, ($i+1)))."/main.inc.php");
// Try main.inc.php using relative path
if (! $res && file_exists("../main.inc.php")) $res=@include("../main.inc.php");
if (! $res && file_exists("../../main.inc.php")) $res=@include("../../main.inc.php");
if (! $res && file_exists("../../../main.inc.php")) $res=@include("../../../main.inc.php");
if (! $res) die("Include of main fails");

require_once __DIR__ . '/vendor/autoload.php';

// Resolver
$configFiles = new FileLocator(__DIR__ . '/config');

// Container
$file = __DIR__ . '/cache/ProjectServiceContainer.php';

$containerConfigCache = new ConfigCache($file, true);
if (!$containerConfigCache->isFresh()) {

    $containerBuilder = new ContainerBuilder();
    $containerBuilder->setParameter('root_dir', __DIR__);

    $delegatingLoader = new \Symfony\Component\Config\Loader\DelegatingLoader(new LoaderResolver([
        new \Symfony\Component\DependencyInjection\Loader\YamlFileLoader($containerBuilder, $configFiles),
        new \Symfony\Component\DependencyInjection\Loader\XmlFileLoader($containerBuilder, $configFiles),
        new \Symfony\Component\DependencyInjection\Loader\GlobFileLoader($containerBuilder, $configFiles),
        new \Symfony\Component\DependencyInjection\Loader\ClosureLoader($containerBuilder),
        new \Symfony\Component\DependencyInjection\Loader\DirectoryLoader($containerBuilder, $configFiles),
        new \Symfony\Component\DependencyInjection\Loader\IniFileLoader($containerBuilder, $configFiles),
        new \Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, $configFiles),
    ]));
    $delegatingLoader->load('services.yaml');

    $containerBuilder->compile();

    $dumper = new PhpDumper($containerBuilder);
    $containerConfigCache->write(
        $dumper->dump([
            'class' => 'ProjectServiceContainer'
        ]),
        $containerBuilder->getResources()
    );
}

require_once $file;
$container = new ProjectServiceContainer();


// Routing
$delegationLoader = new DelegatingLoader(
    new LoaderResolver([
        new YamlFileLoader($configFiles),
        new ClosureLoader(),
    ])
);
$routes = $delegationLoader->load('routes.yaml');

// Kernel
$request = Request::createFromGlobals();

$matcher = new UrlMatcher($routes, new RequestContext());

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack()));

$controllerResolver = new ContainerControllerResolver($container);
$argumentResolver = new ArgumentResolver();


$kernel = new HttpKernel($dispatcher, $controllerResolver, new RequestStack(), $argumentResolver);

$response = $kernel->handle($request);

llxHeader('', $title, $help_url);

$response->send();

// End of page
llxFooter();

$kernel->terminate($request, $response);