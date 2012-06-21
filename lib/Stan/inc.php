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
    } catch (\Exception $e) {
        print_pre($e->getMessage());
        print_pre($e->getTraceAsString());
    }
}

