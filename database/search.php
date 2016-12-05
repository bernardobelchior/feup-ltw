<?php

/** Normalizes the query by trimming whitespaces, making everything lower case and
 * substituting newlines, tabs and multiple spaces by a single space.
 * @param $query string Input query
 * @return string
 */
function normalizeQuery($query) {
    // Remove whitespace at the beginning and end of the query.
    $normalizedQuery = trim($query);

    // Substitutes multiple spaces, tabs and newlines for a unique space.
    $normalizedQuery = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $normalizedQuery);

    // Make the query lower cased, as the search functions need a lower case query.
    return strtolower($normalizedQuery);
}
