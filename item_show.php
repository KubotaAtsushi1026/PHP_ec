 <?php
    // (C)
    // ログインフィルターの読み込み
    require_once 'login_filter.php';
    require_once 'models/Item.php';

    $errors = $_SESSION['errors'];
    $_SESSION['errors'] = null;

    $id = $_GET['id'];
    $item = Item::find($id);

    include_once 'views/item_show_view.php';