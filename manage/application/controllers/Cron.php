<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Cron
 * @property Advertisement_model $advertisement_model;
 * @property Cron_model $cron_model;
 * @property Blog_model $blog_model;
 */
class Cron extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(false);
        $this->load->model('advertisement_model');
        $this->load->model('blog_model');
        $this->load->model('cron_model');
    }

    public function run()
    {
        $schedule = $this->cron_model->get_up_next();
        $advertisements = $this->advertisement_model->get_active();
        if ($schedule['blogs'] && $advertisements) {
            foreach ($schedule['blogs'] as $blog) {
                if ($blog) {
                    $blog = $this->blog_model->get($blog);
                    $reblogs = $this->blog_model->get_reblogs($blog->id);
                    $next = $this->cron_model->get_next_advertisement($blog->id, $advertisements);
                    if ($reblogs) {
                        foreach ($reblogs->result() as $reblog) {
                            $this->blog_model->unreblog_all($blog->id, $reblog->advertisement_id);
                        }
                        if ($next) {
                            $this->blog_model->reblog($blog->id, $next->id);
                        }
                    } else {
                        if ($next) {
                            $this->blog_model->reblog($blog->id, $next->id);
                        }
                    }

                }
            }
        }
        echo json_encode($schedule);
    }

    public function update_followers()
    {
        $blogs = $this->blog_model->get_all();
        if ($blogs) {
            foreach ($blogs->result() as $blog) {
                try {
                    $user = $this->blog_model->get_blog_user($blog->id);
                    $tumblr = new Tumblr\API\Client($this->auth['key'], $this->auth['secret'], $user->token, $user->secret);
                    $this->blog_model->update_followers($blog->id, $tumblr->getBlogInfo($blog->name)->blog->followers);
                } catch (Exception $e) {
                    continue;
                }
            }
        }
    }
}