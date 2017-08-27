<?php

use Aws\Lambda\LambdaClient;
use Spot\Config;
use Spot\Locator;

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

require_once(__DIR__ . '/../vendor/autoload.php');
Dotenv::load(__DIR__ . '/../');

session_start();

$app = new \Slim\Slim([
    'templates.path' => __DIR__ . '/../views',
    'debug' => false
]);

$loader = new Twig_Loader_Filesystem(__DIR__ . '/../views');
$twig = new Twig_Environment($loader);


$cfg = new Config();
$cfg->addConnection(
    'mysql',
    'mysql://' . $_ENV['DATABASE_USER'] . ':' . $_ENV['DATABASE_PASSWORD'] . '@localhost/helpmeabstract'
);

$spot = new Locator($cfg);

/** @var HelpMeAbstract\Entity\Mapper\Volunteer $volunteerMapper */
$volunteerMapper = $spot->mapper('HelpMeAbstract\Entity\Volunteer');

/** @var HelpMeAbstract\Entity\Mapper\Proposal $proposalMapper */
$proposalMapper = $spot->mapper('HelpMeAbstract\Entity\Proposal');

$app->notFound(function () use ($app) {
    $app->redirect('/error');
});

$app->get('/', function () use ($twig, $volunteerMapper) {
    $volunteers = $volunteerMapper->getForHomePage();

    echo $twig->render('index.php', ['volunteers' => $volunteers]);
});

$app->get('/volunteer', function () use ($twig) {
    echo $twig->render('volunteer.php');
});

$app->post('/submitVolunteer', function () use ($twig, $volunteerMapper) {
    $field_errors = $volunteerMapper->verifyFields();

    if (empty($field_errors)) {
        if ($volunteerMapper->findByEmail($_POST['email']) == 0) {
            try {
                $entity = $volunteerMapper->build([
                    'fullname' => $_POST['name'],
                    'twitter_username' => $_POST['twitter'],
                    'github_username' => $_POST['github'],
                    'email' => $_POST['email'],
                ]);

                $volunteerMapper->save($entity);
                echo $twig->render('volunteer_thankyou.php');

            } catch (\Exception $e) {
                $error = "uh oh, something went wrong";

                echo $twig->render('volunteer.php', ['error' => $error]);
            }
        } else {
            if (empty($field_errors)) {
                echo $twig->render('volunteer.php', ['error' => "You're already signed up!"]);
            }
        }
    } else {
        $error = (!empty($field_error)) ? $field_error : "uh oh, something went wrong";

        echo $twig->render('volunteer.php', ['error' => $error]);
    }

});


$app->post('/submitAbstract', function () use ($twig, $proposalMapper, $volunteerMapper) {

    $field_errors = $proposalMapper->verifyFields();

    if (count($field_errors) == 0) {
        try {
            $proposal = $proposalMapper->build([
                'fullname' => $_POST['name'],
                'email' => $_POST['email'],
                'link' => $_POST['link'],
                'max_chars' => $_POST['max_chars'],
            ]);
            $proposalMapper->save($proposal);

            $recipients = $volunteerMapper->getAllForEmail();
            $client = new LambdaClient([
                'credentials' => [
                    'key' => getenv('ACCESS_KEY'),
                    'secret' => getenv('AWS_SECRET'),
                ]
            ]);

            $client->invoke([
                'FunctionName' => 'hma-notifications-send-mass-email',
                'InvocationType' => 'Event',
                'Payload' => json_encode([
                    'recipients' => $recipients,
                    'templateName' => 'volunteer_new_abstract',
                    'templateData' => [
                        'abstract' => [
                            'url' => $proposal->link,
                            'author' => $proposal->fullname
                        ]
                    ]
                ])
            ]);

        } catch (\Exception $e) {
            $error = (!empty($field_error)) ? $field_error : "uh oh, something went wrong";

            echo $twig->render('index.php', ['error' => $error]);
        }

        echo $twig->render('abstract_thankyou.php');
    } else {
        $error = $field_errors['error'];

        echo $twig->render('abstract_error.php', ['error' => $error]);
    }


});


$app->get('/error', function () {

});

$app->run();
