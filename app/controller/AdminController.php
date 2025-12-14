<?php

class AdminController
{
    public function index()
    {
        SessionUtils::requireAdmin();

        $view = 'admin/index.html';
        include_once VIEW_PATH . 'main.php';
    }
}