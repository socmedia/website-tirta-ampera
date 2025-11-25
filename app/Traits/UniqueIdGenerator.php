<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UniqueIdGenerator
{
    /**
     * Generate a unique ID that does not exist in a specific resource.
     *
     * @param  string $type The type of ID to generate ('string' or 'number').
     * @param  int $length The length of the generated ID.
     * @param  int $maxLength The maximum length for the random string.
     * @param  string $column The column name to check for existing IDs.
     * @return string The generated unique ID.
     */
    public static function generateId($type = 'string', $length = 8, $maxLength = 32, $column = 'id')
    {
        switch ($type) {
            case 'string':
                $id = substr(Str::random($maxLength), rand(0, $maxLength - $length), $length);
                break;
            case 'number':
                $id = mt_rand(str_pad(1, $length, 0), str_pad(9, $length, 9));
                break;
            default:
                $id = substr(Str::random($maxLength), rand(0, $maxLength - $length), $length);
                break;
        }

        // Recursively call the function if the ID already exists
        if (self::idExists($id, $column)) {
            return self::generateId($type, $length, $maxLength, $column);
        }

        return $id;
    }

    /**
     * Generate a unique invoice code that does not exist in a specific resource.
     *
     * @param  array $config Configuration options for generating the invoice code.
     *                       Expected keys: 'prefix', 'dateFormat', 'suffixLength', 'column'.
     * @return string The generated unique invoice code.
     */
    public static function generateInvoiceCode(array $config)
    {
        $config = [
            'prefix' => $config['prefix'] ?? 'ORD',
            'dateFormat' => $config['dateFormat'] ?? 'ymd',
            'suffixLength' => $config['suffixLength'] ?? 4,
            'column' => $config['column'] ?? 'order_code',
        ];

        $date = now()->format($config['dateFormat']);
        $search = $config['prefix'] . $date;
        $lastInvoice = self::latestInModel($search, $config['column']);

        if (!$lastInvoice) {
            return $config['prefix'] . $date . str_pad(1, $config['suffixLength'], '0', STR_PAD_LEFT);
        }

        $suffix = substr($lastInvoice->order_code, -$config['suffixLength']);
        $lastIncrement = str_pad($suffix + 1, $config['suffixLength'], '0', STR_PAD_LEFT);
        $invoiceCode = $config['prefix'] . $date . $lastIncrement;

        // Check if the generated invoice code already exists
        if (self::idExists($invoiceCode, $config['column'])) {
            return self::generateInvoiceCode($config);
        }

        return $invoiceCode;
    }

    /**
     * Check if a given ID exists in the specified resource.
     *
     * @param  string $id The ID to check.
     * @param  string $column The column name to check for the ID.
     * @return bool True if the ID exists, false otherwise.
     */
    public static function idExists(string $id, string $column = 'id')
    {
        return self::where($column, $id)->exists();
    }

    /**
     * Retrieve the latest record that matches a specific search criteria.
     *
     * @param  string $search The search criteria.
     * @param  string $column The column name to search in.
     * @return Model|null The latest matching model or null if none found.
     */
    public static function latestInModel(string $search, string $column = 'id')
    {
        return self::withoutGlobalScopes()->where($column, 'LIKE', '%' . $search . '%')->latest()->first();
    }
}
