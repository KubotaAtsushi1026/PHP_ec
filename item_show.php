 <?php
    // ログインフィルターの読み込み
    require_once 'login_filter.php';
    // (C)
    require_once 'models/User.php';
    require_once 'models/Item.php';

    session_start();
    $errors = $_SESSION['errors'];
    $_SESSION['errors'] = null;

    $id = $_GET['id'];
    $item = Item::find($id);


    include_once 'views/item_show_view.php';