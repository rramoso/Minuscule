<?php

/**
 * Created by PhpStorm.
 * User: schultzjosephj
 * Date: 12/11/16
 * Time: 11:06 PM
 */
class Migrations extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(false);
    }

    public function enable_all_primary()
    {
        exit(); // disable until needed
        $this->load->model('user_model');
        $this->load->model('blog_model');
        $users = $this->user_model->get_all();
        if ($users) {
            foreach($users->result() as $user) {
                $tumblr = new Tumblr\API\Client($this->auth['key'], $this->auth['secret'], $user->token, $user->secret);
                foreach ($tumblr->getUserInfo()->user->blogs as $blog) {
                    if ($blog->primary) {
                        $check = $this->blog_model->get(['name' => $blog->name]);
                        if (!$check) {
                            $this->blog_model->save($user->id, [
                                'name' => $blog->name,
                                'created' => time(),
                                'followers' => $blog->followers,
                                'updated' => time(),
                                'enable' => 'on',
                                'frequency' => 6
                            ]);
                        }
                    }
                }
            }
        }
    }
}