<?php

    session_start();

    function cleanInputs($input){
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    function validate($input, $flag){
        $status = true;
        switch ($flag) {
            case 1:
                # code...
                if (!empty($input)){
                    $status = false;
                }
                break;

            case 2;
                if (!filter_var($input, FILTER_VALIDATE_INT)){
                    $status = false;
                }
                break;
        }

        return $status;
    }


    function sanitize($input, $flag){
        switch ($flag) {
            case 1:
                return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
                break;
        }
    }

?>