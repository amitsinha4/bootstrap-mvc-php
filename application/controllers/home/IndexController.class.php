<?php

class IndexController extends Controller
{

    public function mainAction()
    {
        $userModel = new UserModel("user");
        $users_col = $userModel->getUserCol();
        include CURR_VIEW_PATH . "main.php";
    }

    public function indexAction()
    {
        $userModel = new UserModel("user");
        $users = $userModel->getUsers();
        // Load View template
        include CURR_VIEW_PATH . "index.php";
    }

    public function menu()
    {
        include CURR_VIEW_PATH . "header.php";
    }

    public function footer()
    {
        include CURR_VIEW_PATH . "footer.php";
    }
}
?>