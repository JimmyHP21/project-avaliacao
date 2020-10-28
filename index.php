<?php
use \Slim\Slim;
use \Project\Page;
use \Project\Model\User;
use \Project\Model\Posts;
use \Project\Model\Comments;
use \Project\Model\Notification;
use \Project\Model\Transaction;

session_start();
require_once("vendor/autoload.php");
require_once("functions.php");

$app = new Slim();
$app -> config('debug', true);

// REDIRECT TO HOME
$app -> get('/', function() {
   header("Location: /home");
   exit;
});

// HOME
$app -> get('/home', function() {
    User::verifyLogin();
    $userName = User::getUserName();
    $page = new Page();
    $page -> setTpl('index', [
        'name' => $userName
    ]);
});

// TEMPLATE LOGIN
$app -> get('/login', function() {
    $page = new Page([
        "header" => false,
        "footer" => false
    ]);
	$page -> setTpl('login');
});

// METHOD OF LOGIN
$app -> post('/login', function () {
    User::login($_POST["login"], $_POST["password"]);
    header("Location: /home");
    exit;
});

// METHOD OF LOGOUT
$app -> get('/logout', function () {
    User::logout();
    header("Location: /login");
    exit;
});




// LIST USERS
$app -> get('/home/user/list', function () {
    $pageNumber = (isset($_GET["page"])) ? (int)$_GET["page"] : 1;

    User::verifyLogin();
    $users = User::listAll($pageNumber);

    $pages = [];
    for ($i = 1; $i <= $users['pages']; $i++) {
        array_push($pages, [
            'link' => '/home/user/list?page='.$i,
            'page' => $i
        ]);
    }

    $page = new Page();
    $page -> setTpl('user-list', array(
        "users" => $users['data'],
        "pages" => $pages
    ));
});

// TEMPLATE CREATE USER
$app -> get('/home/user/new', function () {
    User::verifyLogin();
    $page = new Page();
    $page -> setTpl('user-new');
});

// METHOD CREATE USER
$app -> post('/home/user/new', function () {
    User::verifyLogin();
    $user = new User();
    $_POST["signature"] = (isset($_POST["signature"])) ? 1 : 0;
    $user -> setData($_POST);

    $user -> save();

    header("Location: /home/user/list");
    exit;
});

// METHOD DELETE USER
$app -> get('/home/user/:iduser/delete', function ($iduser) {
    User::verifyLogin();
    $user = new User();
    $user -> get((int)$iduser);
    $user -> delete();

    header("Location: /home/user/list");
    exit;
});

// METHOD GET USER BY ID
$app -> get('/home/user/:iduser', function ($iduser) {
    User::verifyLogin();
    $user = new User();
    $user -> get((int)$iduser);
    $page = new Page();
    $page -> setTpl('user-update', array(
        "user" => $user -> getValues()
    ));
});

// METHOD UPDATE USER
$app -> post('/home/user/:iduser', function ($iduser) {
    User::verifyLogin();
    $user = new User();

    $_POST["signature"] = (isset($_POST["signature"])) ? 1 : 0;
    $user -> get((int)$iduser);
    $user -> setData($_POST);
    $user -> update();
    header("Location: /home/user/list");
    exit;
});




// LIST POSTS
$app -> get('/home/post/list', function () {
    $pageNumber = (isset($_GET["page"])) ? (int)$_GET["page"] : 1;

    User::verifyLogin();
    $posts = Posts::getPostsPage($pageNumber);

    $pages = [];
    for ($i = 1; $i <= $posts['pages']; $i++) {
        array_push($pages, [
           'link' => '/home/post/list?page='.$i,
            'page' => $i
        ]);
    }

    $page = new Page();
    $page -> setTpl('post-list', array(
        "posts" => $posts["data"],
        "pages" => $pages
    ));
});

// TEMPLATE NEW POST
$app -> get('/home/post/new', function() {
    User::verifyLogin();
    $page = new Page();
    $page -> setTpl('post-new');
});

//METHOD CREATE NEW POST
$app -> post('/home/post/new', function () {
    User::verifyLogin();
    $post = new Posts();
    $post -> setData($_POST);

    $post -> savePost();

    header("Location: /home/post/list");
    exit;
});

//METHOD DELETE POST
$app -> get('/home/post/:idpost/delete', function ($idpost) {
    User::verifyLogin();
    $post = new Posts();
    $post -> getPostById((int)$idpost);
    $post -> deletePost();

    header("Location: /home/post/list");
    exit;
});

//METHOD GET POST BY ID
$app -> get('/home/post/:idpost', function ($idpost) {
    User::verifyLogin();
    $post = new Posts();
    $post -> getPostById((int)$idpost);
    $page = new Page();
    $page -> setTpl('post-update', array(
        "post" => $post -> getValues()
    ));
});

// METHOD UPDATE POST
$app -> post('/home/post/:iduser', function ($idpost) {
    User::verifyLogin();
    $post = new Posts();
    $post -> getPostById((int)$idpost);
    $post -> setData($_POST);
    $post -> updatePost();

    header("Location: /home/post/list");
    exit;
});





// LIST COMMENTS
$app -> get('/home/post/:idpost/comment/list', function ($idpost) {
    $pageNumber = (isset($_GET["page"])) ? (int)$_GET["page"] : 1;

    User::verifyLogin();
    $comments = Comments::listAllCommentsByPost($idpost, $pageNumber);

    $pages = [];
    for ($i = 1; $i <= $comments['pages']; $i++) {
        array_push($pages, [
            'link' => '/home/post/'.$idpost.'/comment/list?page='.$i,
            'page' => $i
        ]);
    }

    $page = new Page();
    $page -> setTpl('comment-list', array(
        "comments" => $comments['data'],
        "pages" => $pages,
        "idpost" => $idpost
    ));
});

// TEMPLATE NEW COMMENT
$app -> get('/home/post/:idpost/comment/new', function ($idpost) {
    User::verifyLogin();
    $page = new Page();
    $page -> setTpl('comment-new', [
        'idpost' => $idpost
    ]);
});

// METHOD CREATE NEW COMMENT
$app -> post('/home/post/:idpost/comment/new', function ($idpost) {
    User::verifyLogin();
    $comment = new Comments();
    $_POST["destaquecomment"] = (isset($_POST["destaquecomment"])) ? 1 : 0;
    $_POST["isSpotlight"] = (isset($_POST["isSpotlight"])) ? 1 : 0;
    $comment -> setData($_POST);

    $comment -> saveComment($idpost);

    header("Location: /home/post/$idpost/comment/list");
    exit;
});

// METHOD DELETE COMMENT
$app -> get('/home/post/:idpost/comment/:idcomment/delete', function($idpost, $idcomment) {
    User::verifyLogin();
    $comment = new Comments();
    $comment -> getCommentById((int)$idcomment);
    $comment -> deleteComment($idpost);

    header("Location: /home/post/$idpost/comment/list");
    exit;
});

//METHOD GET COMMENT BY ID
$app -> get('/home/post/:idpost/comment/:idcomment', function ($idpost, $idcomment) {
    User::verifyLogin();
    $comment = new Comments();
    $comment -> getCommentById((int)$idcomment);
    $page = new Page();
    $page -> setTpl('comment-update', array(
        "comment" => $comment -> getValues(),
        "idpost" => $idpost
    ));
});

// METHOD UPDATE COMMENT
$app -> post('/home/post/:idpost/comment/:idcomment', function ($idpost, $idcomment) {
    User::verifyLogin();
    $comment = new Comments();
    $comment -> getCommentById((int)$idcomment);
    $comment -> setData($_POST);
    $comment -> updateComment($idpost);

    header("Location: /home/post/$idpost/comment/list");
    exit;
});






// LIST NOTIFICATIONS
$app -> get('/home/user/notification/list', function () {
    $pageNumber = (isset($_GET["page"])) ? (int)$_GET["page"] : 1;
    User::verifyLogin();
    $notifications = Notification::listAllNotification($pageNumber);

    $pages = [];
    for ($i = 1; $i <= $notifications['pages']; $i++) {
        array_push($pages, [
            'link' => '/home/user/notification/list?page='.$i,
            'page' => $i
        ]);
    }

    $page = new Page();
    $page -> setTpl('notification-list', array(
        "notifications" => $notifications["data"],
        "pages" => $pages
    ));
});

// METHOD DELETE NOTIFICATION
$app -> get('/home/user/notification/:idnotification/delete', function ($idnotification) {
    User::verifyLogin();
    $notification = new Notification();
    $notification -> deleteNotification($idnotification);

    header("Location: /home/user/notification/list");
    exit;
});





// LIST TRANSACTIONS
$app -> get('/home/user/transaction/list', function () {
    $pageNumber = (isset($_GET["page"])) ? (int)$_GET["page"] : 1;

    User::verifyLogin();
    $transaction = Transaction::listAllTransaction($pageNumber);

    $pages = [];
    for ($i = 1; $i <= $transaction['pages']; $i++) {
        array_push($pages, [
            'link' => '/home/user/transaction/list?page='.$i,
            'page' => $i
        ]);
    }

    $page = new Page();
    $page -> setTpl('transaction-list', array(
        "transactions" => $transaction['data'],
        "pages" => $pages
    ));
});

$app -> get('/home/user/transaction/list/:transaction/delete', function ($idtransaction) {
    User::verifyLogin();
    $transaction = new Transaction();
    $transaction -> deleteTransaction($idtransaction);

    header("Location: /home/user/transaction/list");
    exit;
});

$app->run();
