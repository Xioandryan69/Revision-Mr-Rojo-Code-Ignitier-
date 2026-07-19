<?php

namespace App\Controllers;

use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Exceptions\PageNotFoundException;

class ExportController extends BaseController
{
    private BaseConnection $database;

    public function __construct()
    {
        $this->database = db_connect();
    }

    public function index()
    {
        return view('export/index', ['tables' => $this->tables()]);
    }

    public function download(string $table, string $format)
    {
        if (!in_array($format, ['csv', 'excel'], true)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $this->ensureTableExists($table);
        $columns = $this->database->getFieldNames($table);
        $rows = $this->database->table($table)->get()->getResultArray();

        return $format === 'csv'
            ? $this->csvResponse($table, $columns, $rows)
            : $this->excelResponse($table, $columns, $rows);
    }

    private function csvResponse(string $table, array $columns, array $rows)
    {
        $file = fopen('php://temp', 'r+');
        fwrite($file, "\xEF\xBB\xBF");
        fputcsv($file, $columns, ';');

        foreach ($rows as $row) {
            fputcsv($file, $this->valuesForRow($columns, $row), ';');
        }

        rewind($file);
        $content = stream_get_contents($file);
        fclose($file);

        return $this->response
            ->download($this->filename($table, 'csv'), $content)
            ->setContentType('text/csv; charset=UTF-8');
    }

    private function excelResponse(string $table, array $columns, array $rows)
    {
        $headerCells = '';
        foreach ($columns as $column) {
            $headerCells .= '<Cell ss:StyleID="header"><Data ss:Type="String">' . $this->escapeXml($column) . '</Data></Cell>';
        }

        $dataRows = '';
        foreach ($rows as $row) {
            $cells = '';
            foreach ($this->valuesForRow($columns, $row) as $value) {
                $cells .= '<Cell><Data ss:Type="String">' . $this->escapeXml($value) . '</Data></Cell>';
            }
            $dataRows .= '<Row>' . $cells . '</Row>';
        }

        $content = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" '
            . 'xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">'
            . '<Styles><Style ss:ID="header"><Font ss:Bold="1"/></Style></Styles>'
            . '<Worksheet ss:Name="' . $this->escapeXml($table) . '"><Table><Row>' . $headerCells . '</Row>'
            . $dataRows . '</Table></Worksheet></Workbook>';

        return $this->response
            ->download($this->filename($table, 'xls'), $content)
            ->setContentType('application/vnd.ms-excel; charset=UTF-8');
    }

    private function tables(): array
    {
        return array_values(array_filter(
            $this->database->listTables(),
            static fn (string $table): bool => !str_starts_with($table, 'sqlite_')
        ));
    }

    private function ensureTableExists(string $table): void
    {
        if (!in_array($table, $this->tables(), true)) {
            throw PageNotFoundException::forPageNotFound();
        }
    }

    private function valuesForRow(array $columns, array $row): array
    {
        return array_map(
            fn (string $column): string => $this->sanitizeExportValue($row[$column] ?? ''),
            $columns
        );
    }

    private function filename(string $table, string $extension): string
    {
        return $table . '_' . date('Y-m-d') . '.' . $extension;
    }

    private function sanitizeExportValue(mixed $value): string
    {
        $value = (string) $value;

        return preg_match('/^[=+@-]/', $value) ? "\t" . $value : $value;
    }

    private function escapeXml(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
}
