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
            case '1':
                # code...
                if (!empty($input)){
                    $status = false;
                }
                break;
        }

        return $status;
    }

?>