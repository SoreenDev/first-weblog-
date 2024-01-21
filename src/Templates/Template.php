<?php
namespace app\Templates;

use app\Classes\Auth;
use app\Classes\Request;
use app\Classes\Validator;
use app\Models\Setting;

abstract Class Template{

    protected $Title;
    protected $Setting;
    protected $Request;
    protected $validator;

    public function __construct(){
        $Setting = new Setting();
        $this->Setting = $Setting->get_FirstData();
        $this->Request = new Request();
        $this->validator = new Validator($this->Request); 
    }

    abstract public function Render_page();


    protected function get_Head(){

        ?>
        <head>
            <meta charset="UTF-8">
            <meta name="description" content="<?= $this->Setting->get_description()?>" >
            <meta name="Keywords" content="<?= $this->Setting->get_keywords()?>" >
            <meta name="author" content="<?= $this->Setting->get_author()?>" >
            <title><?= $this->Title?></title>
            <link rel="stylesheet" href="<?=asset('css/style.css') ?>">
        </head>
        <?php
    
    }

    protected function get_header(){

        ?>
        <header>
            <h1><?= $this->Setting->get_title() ?></h1>
            <!-- <div id="logo">
                <img src="<?= asset($this->Setting->get_logo()) ?>" alt="<?= $this->Setting->get_title() ?>">
            </div> -->
        </header>
        <?php

    }
    protected function get_footer(){

        ?>
            <footer>
                <p><?= $this->Setting->get_footer() ?></p>
            </footer>
        <?php

    }

    protected function get_Sidebar($topPosts,$lastPosts){
        ?>
        <aside>
            <?php if(count($topPosts)) { ?>
                <div class="aside-box">
                    <h2>Top Posts</h2>
                    <ul>
                        <?php foreach($topPosts as $item) { ?>
                            <li>
                                <a href="<?= url("index.php",["action"=>"single","id" => $item->get_id()])?>">
                                    <?= $item->get_title() ?> <small>(<?= $item->get_view() ?>)</small>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
            
            <?php if(count($lastPosts)) { ?>
                <div class="aside-box">
                    <h2>Last Posts</h2>
                    <ul>
                        <?php foreach($lastPosts as $item) { ?>
                            <li>
                                <a href="<?= url("index.php",["action"=>"single","id" => $item->get_id()])?>">
                                    <?= $item->get_title() ?> <small>(<?= $item->get_date() ?>)</small>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </aside>
        <?php
    }

    protected function get_Navbar()
    {
        ?>
        <nav>
            <ul>
                <li><a href="<?= URL("index.php") ?>">Home</a></li>
                <li><a href="<?= URL("index.php",["action"=>"category","category"=>"sport"]) ?>">About us</a></li>
                <li><a href="<?= URL("index.php",["action"=>"category","category"=>"social"]) ?>">Blog</a></li>
                <li><a href="<?= URL("index.php",["action"=>"category","category"=>"political"]) ?>">Gallery</a></li>
                <li><a href="<?= URL("index.php",["action"=>"login"]) ?>">Login</a></li>

            </ul>
            <form action="<?= URL("index.php") ?>" method="GET">
                <input type="hidden" name="action" value="serch">
                <input type="text" name="word" placeholder=" Serch you word! " value="<?= $this->Request->has('word')? $this->Request->word:''; ?>">
                <input type="submit" value="Search">
            </form>
        </nav>
        <?php
    }

    protected function get_Admin_head(){

        ?>
            <head>
                <title><?= $this->Title ?></title>
                <link rel="stylesheet" href="<?= asset("css/style.css") ?>">
                <link rel="stylesheet" href=" <?= asset("css/panel.css") ?> ">
            </head>
        <?php

    }

    public function getAdminNavar(){

        $user = Auth::getLoggedinUser();

        ?>
            <nav>
                <ul>
                    <li><a href="<?= URL('index.php') ?>">Website</a></li>
                    <li><a href="<?= URL('panel.php',['action'=>'posts']) ?>">Posts</a></li>
                    <li><a href="<?= URL('panel.php',['action'=>'create']) ?>">Create post</a></li>
                    <li><a href="<?= URL('panel.php',['action'=>'logout']) ?>">Logout</a></li>
                </ul>
                <ul>
                    <li><?= $user->get_fullname() ?></li>
                </ul>
            </nav>
        <?php

    }
}