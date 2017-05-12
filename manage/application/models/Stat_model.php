<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Advertisement_model
 *
 * Handles interations with the Advertisement Database
 * @author: Joseph Schultz - schultzjosephj@gmail.com
 * @version: 1.0.1
 * @modified: 1/9/2016
 */
class Stat_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct(true);
    }

    /**
     * Returns stats for a specific blog
     * @param bool|false $user_id
     * @param int $day_range
     */
    public function get($blog_id = false, $day_range = 1)
    {
        if (!$blog_id || !$day_range) {
            return false;
        }
        $stats = $this->db->select('log.*, blog.name, blog.category_id, DAYOFWEEK(FROM_UNIXTIME(log.created)) as day, HOUR(FROM_UNIXTIME(log.created)) as hour')->from('log')
            ->where(['blog_id' => $blog_id, 'log.created >=' => strtotime("now - $day_range days")])->get();
        return $stats && $stats->num_rows() > 0 ? $stats : false;
    }

    public function get_json($user_id = false, $day_range = 1)
    {
        $this->load->model('blog_model');
        if (!$user_id || !$day_range) {
            return false;
        }
        $delimiter = $day_range == 1 ? "hour" : "day";
        $out = [];
        $out['labels'] = $delimiter == "hour" ? $this->_generate_hour_names_array() : $this->_generate_day_names_array();
        $out['datasets'] = [];
        $stats = $this->get_all($user_id, $day_range);
        if ($stats) {
            $tmp = [];
            foreach ($stats->result() as $stat) {
                if (!$tmp[$stat->blog_id]) {
                    $tmp[$stat->blog_id] = [];
                }
                if (!$tmp[$stat->blog_id][$stat->day]) {
                    $tmp[$stat->blog_id][$stat->day] = [
                        "count" => 0,
                        "hours" => $this->_generate_hours_array(),
                    ];
                }
                $tmp[$stat->blog_id][$stat->day]["count"]++;
                $tmp[$stat->blog_id][$stat->day]["hours"][$stat->hour]++;
            }
            $i = 0;
            foreach ($tmp as $blog_id => $array) {
                $blog = $this->blog_model->get($blog_id);
                $d = $delimiter == "hour" ? [] : $this->_generate_day_array();
                foreach ($array as $day => $sub_array) {
                    if ($delimiter == "hour") {
                        $d = $sub_array['hours'];
                    } else {
                        $d[$day] = $sub_array["count"];
                    }
                }
                $out['datasets'][$i] = [
                    'label' => $blog->name,
                    'data' => array_values($d)
                ];
                $out['datasets'][$i] = array_merge($out['datasets'][$i], $this->_colors($i));
                $i++;
            }
            return json_encode($out);
        }
    }

    private function _generate_hour_names_array()
    {
        $out = [];
        for ($i = 0; $i < 24; $i++) {
            $out[$i] = "$i:00";
        }
        return $out;
    }

    private function _generate_day_names_array()
    {
        return ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    }

    /**
     * Returns stats for a all of a user's blogs
     * @param bool $user_id
     * @param bool $day_range
     * @return bool
     */
    public function get_all($user_id = false, $day_range = 1)
    {
        if (!$user_id || !$day_range) {
            return false;
        }
        $this->db->select('log.*, blog.name, blog.category_id, DAYOFWEEK(FROM_UNIXTIME(log.created)) as day, HOUR(FROM_UNIXTIME(log.created)) as hour')->from('log')
            ->join('blog', 'log.blog_id = blog.id', 'left');
        if ($this->user->role >= 2) {
            $this->db->where(['log.created >=' => strtotime("now - $day_range days")]);
        } else {
            $this->db->where(['blog.user_id' => $user_id, 'log.created >=' => strtotime("now - $day_range days")]);
        }
        $stats = $this->db->get();
        return $stats && $stats->num_rows() > 0 ? $stats : false;
    }

    private function _generate_hours_array()
    {
        $out = [];
        for ($i = 0; $i < 24; $i++) {
            $out[$i] = 0;
        }
        return $out;
    }

    private function _generate_day_array()
    {
        $out = [];
        for ($i = 1; $i <= 7; $i++) {
            $out[$i] = 0;
        }
        return $out;
    }

    private function _colors($number)
    {
        $colors = [[// blue
            'fillColor' => "rgba(151,187,205,0.2)",
            'strokeColor' => "rgba(151,187,205,1)",
            'pointColor' => "rgba(151,187,205,1)",
            'pointStrokeColor' => "#fff",
            'pointHighlightFill' => "#fff",
            'pointHighlightStroke' => "rgba(151,187,205,0.8)"
        ], [// light grey
            'fillColor' => "rgba(220,220,220,0.2)",
            'strokeColor' => "rgba(220,220,220,1)",
            'pointColor' => "rgba(220,220,220,1)",
            'pointStrokeColor' => "#fff",
            'pointHighlightFill' => "#fff",
            'pointHighlightStroke' => "rgba(220,220,220,0.8)"
        ], [ // red
            'fillColor' => "rgba(247,70,74,0.2)",
            'strokeColor' => "rgba(247,70,74,1)",
            'pointColor' => "rgba(247,70,74,1)",
            'pointStrokeColor' => "#fff",
            'pointHighlightFill' => "#fff",
            'pointHighlightStroke' => "rgba(247,70,74,0.8)"
        ], [ // green
            'fillColor' => "rgba(70,191,189,0.2)",
            'strokeColor' => "rgba(70,191,189,1)",
            'pointColor' => "rgba(70,191,189,1)",
            'pointStrokeColor' => "#fff",
            'pointHighlightFill' => "#fff",
            'pointHighlightStroke' => "rgba(70,191,189,0.8)"
        ], [ // 'yellow
            'fillColor' => "rgba(253,180,92,0.2)",
            'strokeColor' => "rgba(253,180,92,1)",
            'pointColor' => "rgba(253,180,92,1)",
            'pointStrokeColor' => "#fff",
            'pointHighlightFill' => "#fff",
            'pointHighlightStroke' => "rgba(253,180,92,0.8)"
        ], [ // grey
            'fillColor' => "rgba(148,159,177,0.2)",
            'strokeColor' => "rgba(148,159,177,1)",
            'pointColor' => "rgba(148,159,177,1)",
            'pointStrokeColor' => "#fff",
            'pointHighlightFill' => "#fff",
            'pointHighlightStroke' => "rgba(148,159,177,0.8)"
        ], [ // dark grey
            'fillColor' => "rgba(77,83,96,0.2)",
            'strokeColor' => "rgba(77,83,96,1)",
            'pointColor' => "rgba(77,83,96,1)",
            'pointStrokeColor' => "#fff",
            'pointHighlightFill' => "#fff",
            'pointHighlightStroke' => "rgba(77,83,96,1)"]
        ];
        $number = $number % count($colors);
        return $colors[$number];
    }

    public function get_follower_counts($limit = 8)
    {
        $out = [];
        $this->load->model('blog_model');
        $blogs = $this->blog_model->get_all();
        if ($blogs) {
            foreach ($blogs->result() as $blog) {
                $this->db->order_by('id', 'desc');
                $this->db->limit($limit);
                $results = $this->db->get_where('blog_followers', ['blog_id' => $blog->id]);
                if ($results && $results->num_rows()) {
                    $out[] = [
                        'blog' => $blog,
                        'followers' => $results->result()
                    ];
                }
            }
        }
        return $out;
    }

    public function get_follower_count($id = false)
    {
        $out = [];
        $this->load->model('blog_model');
        $blog = $this->blog_model->get($id);
        if ($blog) {
            $results = $this->db->get_where('blog_followers', ['blog_id' => $blog->id]);
            if ($results && $results->num_rows()) {
                $out[] = [
                    'blog' => $blog,
                    'followers' => $results->result()
                ];
            }
        }
        return $out;
    }
}