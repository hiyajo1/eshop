<?php

namespace Eshop\base;


abstract class Service
{
    protected static $sqlFunc = ['NOW()'];

    protected static function createFields($set, $table = false): string
    {
        $set['fields'] = (is_array($set['fields']) && !empty($set['fields'])) ? $set['fields'] : ['*'];
        $table = $table ? $table . '.' : '';
        $fields = '';
        foreach ($set['fields'] as $field) {
            $fields .= $table . $field . ',';
        }
        return $fields;
    }

    protected static function createOrder($set, $table = false): string
    {
        $table = $table ? $table . '.' : '';
        $order_by = '';
        if (isset($set['order']) && is_array($set['order']) && !empty($set['order'])) {
            $set['order_direction'] = (is_array($set['order_direction']) && !empty($set['order_direction'])) ? $set['order_direction'] : ['ASC'];

            $order_by = 'ORDER BY';

            $direct_count = 0;
            foreach ($set['order'] as $order) {
                if (isset($set['order_direction'][$direct_count])) {
                    $order_direction = strtoupper($set['order_direction'][$direct_count]);
                    $direct_count++;
                } else {
                    $order_direction = strtoupper($set(['order_direction'][$direct_count - 1]));
                }
                if (is_int($order)) {
                    $order_by .= ' ' . $order . ' ' . $order_direction . ',';
                } else {
                    $order_by .= ' ' . $table . $order . ' ' . $order_direction . ',';
                }
            }

            $order_by = rtrim($order_by, ',');
        }
        return $order_by;
    }

    protected static function createWhere($set, $table = false, $instruction = 'WHERE'): string
    {
        $table = $table ? $table . '.' : '';
        $where = '';
        if (isset($set['where']) && is_array($set['where']) && !empty($set['where'])) {
            $set['operand'] = (isset($set['operand']) && is_array($set['operand']) && !empty($set['operand'])) ? $set['operand'] : ['='];
            $set['condition'] = (isset($set['condition']) && is_array($set['condition']) && !empty($set['condition'])) ? $set['condition'] : ['AND'];
            $where = $instruction;
            $o_count = 0;
            $c_count = 0;
            foreach ($set['where'] as $key => $item) {
                $where .= ' ';
                if (isset($set['operand'][$o_count])) {
                    $operand = $set['operand'][$o_count];
                    $o_count++;
                } else {
                    $operand = $set['operand'][$o_count - 1];
                }
                if (isset($set['condition'][$c_count])) {
                    $condition = $set['condition'][$c_count];
                    $o_count++;
                } else {
                    $condition = $set['condition'][$c_count - 1];
                }
                if ($operand === 'IN' || $operand === 'NOT IN') {
                    if (is_string($item) && strpos($item, 'SELECT') === 0) {
                        $in_str = $item;
                    } else {
                        if (is_array($item)) {
                            $temp_item = $item;
                        } else {
                            $temp_item = explode(',', $item);
                        }
                        $in_str = '';
                        foreach ($temp_item as $v) {
                            $in_str .= "'" . addcslashes(trim($v), "'") . "',";
                        }
                    }
                    $where .= $table . $key . ' ' . $operand . ' (' . trim($in_str, ',') . ') ' . $condition;
                } elseif (strpos($operand, 'LIKE') !== false) {
                    $like_template = explode('%', $operand);
                    foreach ($like_template as $lt_key => $lt) {
                        if (!$lt) {
                            if (!$lt_key) {
                                $item = '%' . $item;
                            } else {
                                $item .= '%';
                            }
                        }
                    }
                    $where .= $table . $key . ' LIKE ' . "'" . addcslashes($item, "'") . "' $condition";
                } else {
                    if (strpos($item, 'SELECT') === 0) {
                        $where .= $table . $key . $operand . '(' . $item . ") $condition";
                    } else {
                        $where .= $table . $key . $operand . "'" . addcslashes($item, "'") . "' $condition";
                    }
                }

            }
            $where = substr($where, 0, strrpos($where, $condition));
        }
        return $where;
    }

    protected static function createJoin($set, $table, $new_where = false): array
    {

        $fields = '';
        $join = '';
        $where = '';
        $tables = '';

        if (isset($set['join'])) {
            $join_table = $table;

            foreach ($set['join'] as $key => $item) {
                if (is_int($key)) {
                    if (!$item['table']) {
                        continue;
                    }
                } else {
                    $key = $item['table'];
                }
                if ($join) {
                    $join .= ' ';
                }
                if ($item['on']) {
                    $join_fields = [];

                    switch (2) {
                        case isset($item['on']['fields']) && count($item['on']['fields']):
                            $join_fields = $item['on']['fields'];
                            break;
                        case count($item['on']):
                            $join_fields = $item['on'];
                            break;
                        default:
                            continue 2;
                    }
                    if (!$item['type']) {
                        $join .= 'LEFT JOIN ';
                    } else {
                        $join .= strtoupper(trim($item['type'])) . ' JOIN ';
                    }
                    $join .= $key . ' ON ';
                    $join = $join . $item['on']['table'] ?? $join . $join_table;

                    $join .= '.' . $join_fields[0] . '=' . $key . '.' . $join_fields[1];
                    $join_table = $key;
                    $tables .= ', ' . trim($join_table);
                    if ($new_where) {
                        if (isset($item['where'])) {
                            $new_where = false;
                        }
                        $group_condition = 'WHERE';
                    } else {
                        $group_condition = isset($item['group_condition']) ? strtoupper($item['group_condition']) : 'AND';
                    }
                    $fields .= self::createFields($item, $key);
                    $where .= self::createWhere($item, $key, $group_condition);
                }
            }
        }
        return [
            'fields' => $fields,
            'join' => $join,
            'where' => $where,
            'tables' => $tables
        ];
    }

    protected static function createInsert($fields, $except)
    {
        $insert_arr = [];
        if ($fields) {
            $insert_arr['fields'] = '';
            $insert_arr['values'] = '';
            foreach ($fields as $row => $value) {
                if ($except && in_array($row, $except)) continue;
                $insert_arr['fields'] .= $row . ',';
                if (in_array($value, self::$sqlFunc)) {
                    $insert_arr['values'] .= $value . ',';
                } else {
                    $insert_arr['values'] .= "'" . addcslashes($value, "'") . "',";
                }
            }
        }
        foreach ($insert_arr as $key => $arr) {
            $insert_arr[$key] = rtrim($arr, ',');
        }
        return $insert_arr;
    }

    protected static function createUpdate($fields, $except)
    {
        $update = '';
        if (isset($fields)) {
            foreach ($fields as $row => $value) {
                if ($except && in_array($row, $except)) continue;
                $update .= $row . '=';
                if (in_array($value, self::$sqlFunc)) {
                    $update .= $value . ',';
                } elseif ($value === NULL) {
                    $update .= "NULL" . ',';
                } else {
                    $update .= "'" . addcslashes($value, "'") . "',";
                }
            }
        }
        return rtrim($update, ',');
    }
}