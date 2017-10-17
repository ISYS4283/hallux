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
                    $th .= sprintf('<th>%s</th>', e($name));
                } else {
                    $diff = true;
                    $th .= sprintf('<th class="danger">%s</th>', e($name));
                }
            }
            break;
        }
        $thead = "<thead><tr>$th</tr></thead>";

        $tr = '';
        foreach ($a as $index => $row) {
            $td = '';
            foreach ($row as $name => $column) {
                if ($column === ($b[$index]->$name ?? $b[$index][$name] ?? null)) {
                    $td .= sprintf('<td>%s</td>', e($column));
                } else {
                    $diff = true;
                    $td .= sprintf('<td class="danger">%s</td>', e($column));
                }
            }
            $tr .= sprintf('<tr>%s</tr>', $td);
        }
        $tbody = "<tbody>$tr</tbody>";

        if ($diff) {
            return $thead.$tbody;
        }

        return true;
    }
}
