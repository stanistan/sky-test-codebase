<?php

namespace Stan\Utils;

/**
 *  wraps it in try catches!
 *  @param  callable $fn
 */
function tr($fn)
{
    try {
        $fn();
    } catch (\ValidationException $e) {
        krumo($e->getErrors());
        print_pre($e->getTraceAsString());
    } catch (\AQLSelectException $e) {
        krumo($e);
        print_pre($e->getMessage());
        print_pre($e->getTraceAsString());
    } catch (\Exception $e) {
        print_pre($e->getMessage());
        print_pre($e->getTraceAsString());
    }
}

function elapsed($cl)
{
    $now = microtime(true);
    // print_pre('START: ' . $now);
    $a = $cl();
    $end = microtime(true);
    // print_pre('END: ' . $end);
    $el = $end - $now;
    print_pre('ELAPSED: ' . $el, '-----');
    return $a;
}

function allModelAQLArray()
{
    $aqls = array();
    global $codebase_path_arr, $sky_aql_model_path;

    // print_pre($codebase_path_arr, $sky_aql_model_path);


    foreach (array_reverse($codebase_path_arr) as $cp) {

        $path = $cp . $sky_aql_model_path;
        if (!is_dir($path)) {
            continue;
        }

        $dir = new \DirectoryIterator($path);
        foreach ($dir as $info) {

            if ($info->isDot() || !$info->isDir()) {
                continue;
            }

            $n = $info->getFilename();
            $model_path = $path . $n . '/' . $n . '.aql';
            // if ($n != 'ct_event') continue;
            if (file_exists($model_path)) {
                $aql = file_get_contents($model_path);
                $aqls[$n] = aql2array($aql);
            }

        }

    }

    return $aqls;
}

function allModelBelongsTo()
{
    $get_subs = function($arr) {
        return array_map(function($info) {
            return $info['objects'] ?: array();
        }, $arr);
    };

    $obs = function($arr) use($get_subs) {
        $i = $get_subs($arr);
        return array_reduce($i, 'array_merge', array());

    };


    return array_map($obs, allModelAQLArray());
}
