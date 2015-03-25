<?php
/**
 * Created by PhpStorm.
 * User: kayladaniels
 * Date: 3/24/15
 * Time: 9:46 PM
 */

use GuzzleHttp\Client;

require_once(__DIR__ . '/vendor/autoload.php');
Dotenv::load(__DIR__);

session_start();

$app = new \Slim\Slim(array(
    'templates.path' => './views',
    'debug' => true
));

$loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
$twig = new Twig_Environment($loader);

$app->notFound(function () use ($app) {
    $app->redirect('/error');
});

$app->get('/', function () use ($twig) {
    echo $twig->render('index.php');
});

$app->get('/volunteer', function () use ($twig)
{
    echo $twig->render('volunteer.php');
});

$app->post('/submit', function(){

});


$app->get('/register', function() use ($twig)
{
    $client_id = $_ENV['GH_CLIENT_ID'];

    if(isset($_GET['code']))
    {
        $code = $_GET['code'];
        $client = new Client();
        $r = $client->post('https://github.com/login/oauth/access_token',
            [
                'body' => [
                    'client_id' => $client_id,
                    'client_secret' => $_ENV['GH_CLIENT_SECRET'],
                    'code' => $code
                ],
                "headers" => [
                    "Accept" => "application/json"]
            ])->json();

        $access_token = $r['access_token'];
        $user_data = $client->get("https://api.github.com/user?access_token=".$access_token)->json();
        $email = isset($user_data['email']) ? $user_data['email'] : '';
        $name = isset($user_data['name']) ? $user_data['name'] : '';
        $avatar = isset($user_data['avatar_url']) ? $user_data['avatar_url'] : '';
        $gh_id = isset($user_data['id']) ? $user_data['id'] : '';
        $gh_url = isset($user_data['url']) ? $user_data['url'] : '';
        $gh_username = isset($user_data['url']) ? $user_data['url'] : '';
        $conn = new PDO('mysql:dbname=helpmeabstract;host=localhost', $_ENV['DATABASE_USER'], $_ENV['DATABASE_PASSWORD']);
        $query = 'SELECT * FROM users where github_id = "'.$gh_id.'"';
        $find = $conn->prepare($query);
        $find->execute();
        if ($find->rowCount() > 0)
        {
            $_SESSION['name'] = $name;
            $_SESSION['image']   = $avatar;
            header("Location: /");
            exit;
        }
        echo $twig->render('/volunteers/signup-form.php', ['email' => $email, 'name' => $name, 'avatar' => $avatar, 'gh_id' => $gh_id, 'gh_url' => $gh_url, 'gh_un' => $gh_username]);
    }
    else
    {
        $url = "https://github.com/login/oauth/authorize?client_id=$client_id&redirect_uri=".$_ENV['GH_REDIRECT_URI'];
        header("Location: $url");
        exit;
    }
});

$app->post('/completeSignup', function () use ($twig){
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $avatar = isset($_POST['avatar']) ? $_POST['avatar'] : '';
    $gh_id = isset($_POST['gh_id']) ? $_POST['gh_id'] : '';
    $gh_url = isset($_POST['gh_url']) ? $_POST['gh_url'] : '';
    $gh_un = isset($_POST['gh_un']) ? $_POST['gh_un'] : '';
    if ($email == '')
    {
        echo $twig->render('/volunteers/signup-form.php', ['email' => $email, 'name' => $name, 'avatar' => $avatar, 'gh_id' => $gh_id, 'gh_url' => $gh_url, 'gh_un' => $gh_un, 'error' => true]);
    }
    else
    {
        $conn = new PDO('mysql:dbname=helpmeabstract;host=localhost', $_ENV['DATABASE_USER'], $_ENV['DATABASE_PASSWORD']);
        $query = 'SELECT * FROM volunteers where email = "'.$email.'"';
        $find = $conn->prepare($query);
        $find->execute();
        if ($find->rowCount() == 0)
        {
            // query
            $sql = "INSERT INTO volunteers (github_username, email, fullname, github_id, profile_image, profile_url)
                VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                $gh_un,
                $email,
                $name,
                $gh_id,
                $avatar,
                $gh_url
            ]);
        }
        $_SESSION['name'] = $name;
        $_SESSION['image']   = $avatar;
        header("Location: /dashboard");
        exit;
    }
});

$app->get('/login', function() use ($twig)
{
});

$app->get('/dashboard', function() use ($twig)
{
    echo $twig->render('/volunteers/dashboard.php');

});

$app->get('/abstract/$id', function()
{

});

$app->post('/abstract/$id/comment', function(){

});

$app->get('/error', function(){

});

$app->run();