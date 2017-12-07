<?php

namespace App\Validators;

use StdClass;

class ResultSetComparator
{
    /**
     * Compares two array result sets.
     *
     * @return bool|string TRUE if match, otherwise diff-annotated HTML table fragment
     */
    public function match(array $a, array $b)
    {
        $diff = false;

        $th = '';
        foreach ($a as $index => $row) {
            foreach ($row as $name => $column) {
                if ($this->hasColumn($name, $b[$index] ?? new StdClass)) {
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
                if ($this->hasData($name, $column, $b[$index] ?? new StdClass)) {
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

    protected function hasColumn(string $name, $data) : bool
    {
        $data = array_change_key_case(get_object_vars($data));

        return array_key_exists(strtolower($name), $data);
    }

    protected function hasData(string $name, $value, $data) : bool
    {
        $data = array_change_key_case(get_object_vars($data));

        return $value === $data[strtolower($name)] ?? null;
    }
}
