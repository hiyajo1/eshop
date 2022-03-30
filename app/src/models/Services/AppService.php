<?php

namespace Up\models\Services;

use Eshop\base\Service;
use Eshop\Db;
use PDO;

class AppService extends Service
{

    /**
     * @param $table
     * @param array $set
     * 'fields' => ['id', 'name'],
     * 'where' => ['id' => 1, 'name' => 'IVAN'],
     * 'operand' => ['IN', 'NOT IN', '%LIKE%', '=', '<>'],
     * 'condition' => ['AND', 'OR'],
     * 'order' => ['id', 'name'],
     * 'order_direction' => ['ASC', 'DESC'],
     * 'limit' => '1',
     * 'join' => [
     *      'join_table1' => [
     *              'table' => 'join_table1',
     *              'fields' => ['id as j_id', 'name as j_name'],
     *              'type' => 'left',
     *              'where' => ['name' => 'Sasha']
     *              'operand' => ['='],
     *              'condition' => ['OR'],
     *              'on' => ['id', 'parent_id'],
     *              'group_condition' => 'AND'
     *              ]
     *      ],
     *      'join_table2' => [
     *              'table' => 'join_table2',
     *              'fields' => ['id as j2_id', 'name as j2_name'],
     *              'type' => 'left',
     *              'where' => ['name' => 'Sasha']
     *              'operand' => ['<>'],
     *              'condition' => ['AND'],
     *              'on' => [
     *                  'tableMAIN' => 'join_table1',
     *                  'fields' => ['id', 'parent_id']
     *              ],
     *              'group_condition' => 'AND'
     *      ]
     * ]
     */
    public static function get($table, array $set): string
    {
        $fields = self::createFields($set, $table);
        $order = self::createOrder($set, $table);
        $where = self::createWhere($set, $table);
        if (!$where) {
            $new_where = true;
        } else {
            $new_where = false;
        }
        $join_arr = self::createJoin($set, $table, $new_where);


        $fields .= $join_arr['fields'];
        $join = $join_arr['join'];
        $where .= $join_arr['where'];


        $fields = rtrim($fields, ',');


        $limit = isset($set['limit']) ? ' LIMIT ' . $set['limit'] : '';

        return sprintf("SELECT %s FROM %s %s %s %s %s", $fields, $table, $join, $where, $order, $limit);
    }

    /**
     * @param $table - таблица для вставки данных
     * @param array $set - массив параметров:
     * fields => [поле => значение]; - если не указан, то обрабатывается $_POST[поле => значение]
     * разрешена передача NOW() в качестве MySql функции обычной строкой
     * except => ['исключение 1', 'исключение 2'] - исключает данные элементы массива из добавленных в запрос
     * @return mixed
     */


    public static function add($table, array $set = []): string

    {
        $set['fields'] = (isset($set['fields']) && is_array($set['fields']) && !empty($set['fields'])) ? $set['fields'] : $_POST;
        $set['except'] = (isset($set['except']) && is_array($set['except']) && !empty($set['except'])) ? $set['except'] : false;

        if (!isset($set['fields'])) {
            return false;
        }
        $insert_arr = self::createInsert($set['fields'], $set['except']);

        return "INSERT INTO $table ({$insert_arr['fields']}) VALUES ({$insert_arr['values']})";

    }

    /**
     * @param $table - таблица для вставки данных
     * @param array $set - массив параметров:
     * fields => [поле => значение]; - если не указан, то обрабатывается $_POST[поле => значение]
     * разрешена передача NOW() в качестве MySql функции обычной строкой
     * except => ['исключение 1', 'исключение 2'] - исключает данные элементы массива из добавленных в запрос
     * where => ['id' => 1, 'name' => 'IVAN']
     * operand => ['IN', 'NOT IN', '%LIKE%', '=', '<>']
     * condition => ['AND', 'OR']
     * @return mixed
     */

    public static function edit($table, array $set = []):string
    {
        $set['fields'] = (isset($set['fields']) && is_array($set['fields']) && !empty($set['fields'])) ? $set['fields'] : $_POST;
        $set['except'] = (isset($set['except']) && is_array($set['except']) && !empty($set['except'])) ? $set['except'] : false;

        if (!$set['fields']) {
            return false;
        }
        $where = '';
        if (!isset($set['all_rows'])) {
            if (isset($set['where'])) {
                $where = self::createWhere($set);
            } else {
                $columns = self::showColumns($table);
                if (!isset($columns)) {
                    return false;
                }
                if (isset($columns['id_row']) && isset($set['fields'][$columns['id_row']])) {
                    $where = 'WHERE ' . $columns['id_row'] . '=' . $set['fields'][$columns['id_row']];
                    unset($set['fields'][$columns['id_row']]);
                }
            }
        }

        $update = self::createUpdate($set['fields'], $set['except']);

        return "UPDATE $table SET $update $where";
    }

    public static function delete($table, $set): string
    {
        $table = trim($table);
        $where = self::createWhere($set, $table);
        $columns = self::showColumns($table);
        if (!isset($columns)) {
            return false;
        }
        if (isset($set['fields']) && is_array($set['fields']) && !empty($set['fields'])) {
            if ($columns['id_row']) {
                $key = array_search($columns['id_row'], $set['fields']);
                if ($key !== false) {
                    unset($set['fields'][$key]);
                }
            }
            $fields = [];
            foreach ($set['fields'] as $field) {
                $fields[$field] = $columns['field']['Default'];
            }
            $update = self::createUpdate($fields, false);

            $query = "UPDATE $table SET $update $where";
        } else {
            $join_arr = self::createJoin($set, $table);
            $join = $join_arr['join'];
            $join_tables = $join_arr['tables'];

            $query = 'DELETE ' . $table . $join_tables . ' FROM ' . $table . ' ' . $join . ' ' . $where;
        }

        return $query;
    }

    public static function showColumns($table): array
    {
        $query = "SHOW COLUMNS FROM $table";
        $queryResult = Db::getOrConnectPDO()->query($query)->fetchAll(PDO::FETCH_ASSOC);
        $columns = [];
        if (isset($queryResult)) {
            foreach ($queryResult as $row) {
                $columns[$row['Field']] = $row;
                if ($row['Key'] === 'PRI') {
                    $columns['id_row'] = $row['Field'];
                }
            }
        }
        return $columns;
    }

    public static function getAssoc($table): array
    {
        $table = trim($table);
        $query = sprintf("SELECT * FROM %s", $table);
        return Db::getOrConnectPDO()->query($query)->fetchAll(PDO::FETCH_UNIQUE);
    }
}