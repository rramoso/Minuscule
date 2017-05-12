<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Minuscule
 * @property Advertisement_model $advertisement_model
 * @property Blog_model $blog_model
 */
class Minuscule extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(false);
        $this->load->library('api_loader');
        $this->load->model('api_model');
    }

    function index()
    {
    }

    /**
     * Track an image load!
     * @param bool $uid
     * @param bool $advertisement_id
     * @return bool
     */
    function beacon($uid = false, $advertisement_id = false)
    {
        if (!$uid || !$advertisement_id) {
            return false;
        }

        $this->load->model('advertisement_model');
        $this->load->model('blog_model');
        $blog = $this->blog_model->get(['uid' => $uid]);
        $advertisement = $this->advertisement_model->get($advertisement_id);

        $request = json_encode([
            'referrer' => $_SERVER['HTTP_REFERER'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'remote_addr' => $_SERVER['REMOTE_ADDR'],
            'uri' => $_SERVER['REQUEST_URI']
        ]);

        $this->api_model->log([
            'blog_id' => $blog->id,
            'advertisement_id' => $advertisement->id,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'request' => $request,
            'created' => time()
        ]);

        header("Content-Type: image/jpeg");
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0"); // Proxies.
        $im = @imagecreate(1, 1) or die("Cannot Initialize new GD image stream");
        imagejpeg($im);
        imagedestroy($im);
    }

    function redirect($advertisement_id = false)
    {
        $this->load->model('advertisement_model');
        $this->load->model('blog_model');
        $advertisement = $this->advertisement_model->get($advertisement_id);

        $request = json_encode([
            'referrer' => $_SERVER['HTTP_REFERER'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'remote_addr' => $_SERVER['REMOTE_ADDR'],
            'uri' => $_SERVER['REQUEST_URI']
        ]);

        $this->api_model->link([
            'advertisement_id' => $advertisement->id,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'request' => $request,
            'created' => time()
        ]);
        header('Location:' . urldecode($this->input->get('url')));
    }

    /**
     * Reblogs an advertisement to a blog manually.
     * @param bool $key
     * @param $ad_id
     * @param $blog_name
     * @return bool
     */
    function reblog($key = false, $ad_id, $blog_name)
    {
        if ($key != "PirateChairBags") {
            return false;
        }
        $this->load->model('advertisement_model');
        $this->load->model('blog_model');
        $ad = $this->advertisement_model->get($ad_id);
        $blog = $this->blog_model->get(['name' => $blog_name]);
        $reblogs = $this->blog_model->get_reblogs($blog->id);
        if ($ad) {
            if ($reblogs) {
                foreach ($reblogs->result() as $reblog) {
                    $this->blog_model->unreblog_all($blog->id, $reblog->advertisement_id);
                }
                $this->blog_model->reblog($blog->id, $ad_id);
            } else {
                $this->blog_model->reblog($blog->id, $ad_id);
            }
        } else {
            echo "Advertisement doesn't exist.";
        }
    }
}