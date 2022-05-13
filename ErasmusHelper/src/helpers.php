<?php


/**
 * Retourne le nombre de jours entre deux dates
 *
 * @param $start DateTime
 * @param $end DateTime
 * @return int
 */
function count_days_between(mixed $start, mixed $end): int {
    if (is_string($start)) $start = DateTime::createFromFormat("Y-m-d", $start);
    if (is_string($end)) $end = DateTime::createFromFormat("Y-m-d", $end);
    return $start->diff($end)->days;
}
