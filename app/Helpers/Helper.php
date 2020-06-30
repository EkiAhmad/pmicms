<?php

namespace App\Helpers;

class Helper
{
    public static function success_alert($message)
    {
        $string = '';
        if (is_array($message)) {
            $string = '<ul>';
            foreach ($message as $key => $value) {
                $string .= '<li>' . ucfirst($value) . '</li>';
            }
            $string .= '</li>';
        } else {
            $string = ucfirst($message);
        }
        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success !</strong> 
                    ' . $string . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        return $alert;
    }

    public static function parsing_alert($message)
    {
        $string = '';
        if (is_array($message)) {
            foreach ($message as $key => $value) {
                $string .= ucfirst($value) . '<br>';
            }
        } else {
            $string = ucfirst($message);
        }
        return $string;
    }

    public static function warning_alert($message)
    {
        $string = '';
        if (is_array($message)) {

            foreach ($message as $key => $value) {
                $string .= '<li>' . ucfirst($value) . '</li>';
            }
            $string .= '</li>';
        } else {
            $string = ucfirst($message);
        }
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Warning !</strong> ' . $string . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        return $alert;
    }

    public static function failed_alert($message)
    {
        $string = '';
        if (is_array($message)) {
            $string = '<ul>';
            foreach ($message as $key => $value) {
                $string .= '<li>' . ucfirst($value) . '</li>';
            }
            $string .= '</li>';
        } else {
            $string = ucfirst($message);
        }
        $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Failed !</strong> ' . $string . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        return $alert;
    }

    public static function short_text($phrase, $max_words)
    {
        $phrase_array = explode(' ', $phrase);
        if (count($phrase_array) > $max_words && $max_words > 0)
            $phrase = implode(' ', array_slice($phrase_array, 0, $max_words)) . '...';
        return $phrase;
    }
}
