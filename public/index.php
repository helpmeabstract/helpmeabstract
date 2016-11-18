<?php

use Http\Adapter\Guzzle6\Client;
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
Dotenv::load(__DIR__.'/../');

session_start();

$app = new \Slim\Slim([
    'templates.path' => '../views',
    'debug'          => false
]);

$loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
$twig = new Twig_Environment($loader);


$cfg = new Config();
// MySQL
$cfg->addConnection('mysql', 'mysql://' . $_ENV['DATABASE_USER'] . ':' . $_ENV['DATABASE_PASSWORD'] . '@localhost/helpmeabstract');
$spot = new Locator($cfg);

/** @var Kayladnls\Entity\Mapper\Volunteer $volunteerMapper */
$volunteerMapper = $spot->mapper('Kayladnls\Entity\Volunteer');

/** @var Kayladnls\Entity\Mapper\Proposal $proposalMapper */
$proposalMapper = $spot->mapper('Kayladnls\Entity\Proposal');

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
                    'fullname'         => $_POST['name'],
                    'twitter_username' => $_POST['twitter'],
                    'github_username'  => $_POST['github'],
                    'email'            => $_POST['email'],
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
                'fullname'  => $_POST['name'],
                'email'     => $_POST['email'],
                'link'      => $_POST['link'],
                'max_chars' => $_POST['max_chars'],
            ]);
            $proposalMapper->save($proposal);

            $recipients = $volunteerMapper->getAsCSV();
            $body = $proposal->getHTML();

            $client = new Client();
            $mailgun = new \Mailgun\Mailgun($_ENV['MAILGUN_KEY'], $client);

            $message = [
                'html'    => $body,
                'subject' => 'Abstract Submitted For Review by ' . $proposal->fullname,
                'from'    => 'Help Me Abstract <abstract@helpmeabstract.com>',
                'to'      => "abstract@helpmeabstract.com",
                'bcc' => $recipients
            ];

            $result = $mailgun->sendMessage("helpmeabstract.com", $message);

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
