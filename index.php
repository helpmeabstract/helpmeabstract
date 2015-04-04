<?php
/**
 * Created by PhpStorm.
 * User: kayladaniels
 * Date: 3/24/15
 * Time: 9:46 PM
 */

use GuzzleHttp\Client;
use Spot\Config;
use Spot\Locator;

require_once(__DIR__ . '/vendor/autoload.php');
Dotenv::load(__DIR__);

session_start();

$app = new \Slim\Slim(array(
    'templates.path' => './views',
    'debug' => true
));

$loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
$twig = new Twig_Environment($loader);


$cfg = new Config();
// MySQL
$cfg->addConnection('mysql', 'mysql://'.$_ENV['DATABASE_USER'].':'.$_ENV['DATABASE_PASSWORD'].'@localhost/helpmeabstract');
$spot = new Locator($cfg);
$volunteerMapper = $spot->mapper('Kayladnls\Entity\Volunteer');

$proposalMapper = $spot->mapper('Kayladnls\Entity\Proposal');

$app->notFound(function () use ($app) {
    $app->redirect('/error');
});

$app->get('/', function () use ($twig, $volunteerMapper) {
    $volunteers = $volunteerMapper->getForHomePage();

    echo $twig->render('index.php', array('volunteers' => $volunteers));
});

$app->get('/volunteer', function () use ($twig)
{
    echo $twig->render('volunteer.php');
});

$app->post('/submitVolunteer', function () use ( $twig, $volunteerMapper)
{
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

                echo $twig->render('volunteer.php', array('error' => $error));
            }
        }
        else if (empty($field_errors))
        {
            echo $twig->render('volunteer.php', array('error' => "You're already signed up!"));
        }
    }

    else
    {
        $error = (!empty($field_error)) ? $field_error : "uh oh, something went wrong";

        echo $twig->render('volunteer.php', array('error' => $error));
    }

});


$app->post('/submitAbstract', function() use ( $twig, $proposalMapper, $volunteerMapper){

    $field_errors = $proposalMapper->verifyFields();

    if ( count($field_errors) == 0 )
    {
        try
        {
            $entity = $proposalMapper->build([
                'fullname'             => $_POST['name'],
                'email'            => $_POST['email'],
                'link'             => $_POST['link']
            ]);

            $proposalMapper->save($entity);

            $recipients = $volunteerMapper->getForMandrill();
            $body = $entity->getHTML();

            $mandrill = new Mandrill($_ENV['MANDRILL_KEY']);

            $message = array(
                'html' => $body,
                'subject' => 'Abstract Submitted For Review',
                'from_email' => 'abstract@helpmeabstract.com',
                'from_name' => 'Help Me Abstract',
                'to' => $recipients,
                'important' => false,
                'track_opens' => true,
                'track_clicks' => true,
            );
            $result = $mandrill->messages->send($message);
        }
        catch (\Exception $e)
        {

            echo "<pre>" . print_r($e->__toString(), true) . "</pre>";
            exit;
            $error = (!empty($field_error)) ? $field_error : "uh oh, something went wrong";

            echo $twig->render('index.php', array('error' => $error));
        }

        echo $twig->render('abstract_thankyou.php');
    }
    else
    {
        $error =  $field_errors['error'];

        echo $twig->render('abstract_error.php', array('error' => $error));
    }


});



$app->get('/error', function(){

});

$app->run();
