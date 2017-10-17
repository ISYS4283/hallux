<?php

namespace App\Validators;

class ResultSetComparator
{
    /**
     * Compares two array result sets.
     *
     * @return bool|string TRUE if match, otherwise diff-annotated HTML table fragment
     */
    public function match($a, $b)
    {
        $diff = false;

        $th = '';
        foreach ($a as $index => $row) {
            foreach ($row as $name => $column) {
                if (array_key_exists($name, $b[$index] ?? [])) {
                    $th .= "<th>$name</th>";
                } else {
                    $diff = true;
                    $th .= "<th class=\"danger\">$name</th>";
                }
            }
            break;
        }
        $thead = "<thead><tr>$th</tr></thead>";

        $td = '';
        foreach ($a as $index => $row) {
            foreach ($row as $name => $column) {
                if ($column === ($b[$index][$name] ?? null)) {
                    $td .= "<td>$column</td>";
                } else {
                    $diff = true;
                    $td .= "<td class=\"danger\">$column</td>";
                }
            }
        }
        $tbody = "<tbody>$td</tbody>";

        if ($diff) {
            return $thead.$tbody;
        }

        return true;
    }
}
