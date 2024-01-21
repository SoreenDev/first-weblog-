<?php

namespace app\Templates;

use app\Classes\Session;
use app\Models\Post;

class EditPage extends Template 
{
    private $post ;
    private $Error =[] ;

    public function __construct()
    {
        parent :: __construct();
        if(!$this->Request->has('id'))
            redirect('panel.php',['action'=>'posts']);

        $id =$this->Request->id ; 
        $postModel = new Post();

        $this->post = $postModel->get_data_byID($id);

        $this->Title = $this->Setting->get_title() . 'Admin panel - Edit post : '.$this->post->get_title();
        if($this->Request->isPostMethod()){
            $data = $this->validator->validate([
                'title'=>['required','min:3','max:100'],
                'category'=>['required','in:sport,political,social'],
                'content'=>['required','min:3','max:5000'],
                'image'=>['nullable','file','type:jpg,png','size:2048']
            ]);

            if(! $data->has_Error()){
                $this->updataPost($postModel);
            }else{
                $this->Error = $data->get_Error();
            }
        }
    }

    public function updataPost($postModel)
    {
        $this->post->set_title($this->Request->title);
        $this->post->set_content($this->Request->content);
        $this->post->set_category($this->Request->category);
        if($this->Request->image->isFile()){

            deleteFile($this->post->get_image());
            $img =$this->Request->image->upload();
            $this->post->set_image($img);
        }
        $postModel->editData($this->post); 
        Session :: flush('message','post was update!');
        redirect('panel.php',['action'=>'posts']) ;
    }

    public function Render_page()
    {
        ?>
            <html>
                <?= $this->get_Admin_head() ?>
                <body>
                    <main>
                        
                        <?= $this->getAdminNavar() ?>

                        <section class="content">
                            <?php if(count($this->Error)){ ?>
                                    <div class="errors">
                                        <ul>
                                            <?php foreach($this->Error as $Error){?>
                                                <li><?= $Error?></li>
                                            <?php } ?>
                                        </ul> 
                                    </div>
                            <?php } ?>
                            <form method="POST" enctype="multipart/form-data">
                                <div>
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" value="<?= $this->post->get_title() ?>">
                                </div>
                                <div>
                                    <label for="category">Category</label>
                                    <select name="category" id="category">
                                        <option value="political" <?= ($this->post->get_category() == 'political')?'selected':'' ?>>Political</option>
                                        <option value="sport" <?= ($this->post->get_category() == 'sport')?'selected':'' ?>>Sport</option>
                                        <option value="social" <?= ($this->post->get_category() == 'social')?'selected':'' ?>>Social</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="content">Content</label>
                                    <textarea name="content" id="content" cols="30" rows="10" value=""><?= $this->post->get_content() ?></textarea>
                                </div>
                                <div>
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image">
                                    <img src="<?= asset($this->post->get_image()) ?>">  
                                </div>
                                <div>
                                    <input type="submit" value="Edit post">
                                </div>
                            </form>
                        </section>
                    </main>
                </body>
            </html>
        <?php
    }    
}