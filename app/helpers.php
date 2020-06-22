<?php
if(! function_exists('activeSegment')){
    function activeSegment($nama,$segment=2,$class='active'){
        return request()->segment($segment) == $nama ? $class : '';
    }
}
