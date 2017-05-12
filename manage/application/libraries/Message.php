<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Message
 *
 * Simple Library for communicating messages from the backend back to the frontend.
 *
 * @author: Joseph Schultz - schultzjosephj@gmail.com
 * @version: 1.0.0
 * @modified: 11/7/2015
 */
class Message
{
    /**
     * @param string|bool $text
     * @param string $type
     * @param string|bool $redirect
     * @return bool
     */
    function send($text = false, $type = 'alert', $redirect = false)
    {
        $CI =& get_instance();
        if (!$text) {
            return false;
        }
        if ($redirect) {
            $CI->session->set_flashdata('message', array('text' => $text, 'type' => $type));
            redirect($redirect);
        }
        echo json_encode(array('text' => $text, 'type' => $type, 'redirect' => $redirect));
        return true;
    }
}