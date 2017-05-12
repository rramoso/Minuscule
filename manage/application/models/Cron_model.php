<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Cron_model
 *
 * Handles interations with the Cron Jobs
 * @property Blog_model $blog_model
 * @author: Joseph Schultz - schultzjosephj@gmail.com
 * @version: 1.0.0
 * @modified: 3/3/2016
 */
class Cron_model extends MY_Model
{
    private $interval = 10; //minutes;

    public function __construct()
    {
        parent::__construct(false);
        $this->load->model('blog_model');
    }

    /**
     * Get Full Schedule
     * @return array
     */
    function schedule()
    {
        $blogs = $this->blog_model->get_all(['enable_ads' => 1]);
        return $this->_generate_schedule($blogs);
    }

    /**
     * Get Schedule for the next hour
     * @return array|void
     */
    function get_up_next()
    {
        $schedule = $this->schedule();
        $hour = date('i') > 55 ? (int)date('H', strtotime('+1 hour')) : (int)date('H');
        $minute = round(date('i') / $this->interval) * $this->interval;
        return ['hour' => $hour, 'minute' => $minute, 'blogs' => $schedule[$hour][$minute]];
    }

    /**
     * Returns the next advertisement in the rotation to run.
     * @param $blog_id
     * @param $advertisements
     * @return bool
     */
    function get_next_advertisement($blog_id, $advertisements)
    {
        if ($advertisements) {
            $ids = [];
            foreach ($advertisements as $ad) {
                $ids[] = $ad->id;
            }
            $this->load->model('advertisement_model');
            $this->db->select('advertisement_reblog.*')->from('advertisement_reblog');
            $this->db->where('blog_id', $blog_id);
            $this->db->where_in('advertisement_id', $ids);
            $this->db->order_by('updated', 'desc');
            $r = $this->db->get();
            $r = $r->num_rows() ? $r : false;
            if ($r) {
                $order = [];
                foreach ($r->result() as $reblog) {
                    if (!in_array($reblog->advertisement_id, $order)) {
                        $order[] = $reblog->advertisement_id;
                    }
                }
                foreach ($ids as $id) {
                    if (!in_array($id, $order)) {
                        $order[] = $id;
                    }
                }
                return $this->advertisement_model->get($order[count($order) - 1]);
            } else {
                $active = $this->advertisement_model->get_active();
                return $active ? $active[0] : false;
            }
        }
    }

    /**
     * Generates an hour and minute schedule based on the interval
     * @param $blogs
     * @return array
     */
    public function _generate_schedule(&$blogs)
    {
        $out = [];
        $blog_ids = [];

        //Generate an array for [Hours][5 Minute Intervals]
        for ($i = 0; $i < 24; $i++) {
            $out[$i] = array();
            for ($j = 0; $j < 60; $j += $this->interval) {
                $out[$i][$j] = array();
            }
        }
        if ($blogs) {
            foreach ($blogs->result() as $blog) {
                $blog_ids[] = ['id' => $blog->id, 'frequency' => $blog->frequency];
            }
            $cursor = 0; //max = blog_id length
            $hour = 0; //max 24
            while (!empty($blog_ids)) {
                $this->_insert_in_schedule($out, $hour, $blog_ids[$cursor]['id']);
                $blog_ids[$cursor]['frequency']--;
                if ($blog_ids[$cursor]['frequency'] == 0) {
                    unset($blog_ids[$cursor]);
                    $blog_ids = array_values($blog_ids);
                }
                $hour = $hour + 1 > 24 ? 0 : $hour + 1;
                $cursor = $cursor + 1 > count($blog_ids) - 1 ? 0 : $cursor + 1;
            }
        }
        return $out;
    }

    /**
     * Inserts into the schedule to the lowest number of entries.
     * @param $schedule
     * @param $hour
     * @param $value
     */
    private function _insert_in_schedule(&$schedule, $hour, $value)
    {
        $lowest_index_count = 0;
        for ($i = 0; $i < count($schedule[$hour]) * $this->interval; $i += $this->interval) {
            if (empty($schedule[$hour][$i])) {
                array_push($schedule[$hour][$i], $value);
                return;
            } else {
                $lowest_index_count = count($schedule[$hour][$i]) < count($schedule[$hour][$lowest_index_count]) ? $i : $lowest_index_count;
            }
        }
        //Just insert at the lowest count index then..
        array_push($schedule[$hour][$lowest_index_count], $value);
        return;
    }

}