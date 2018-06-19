<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Writer;
use PhpOffice\PhpSpreadsheet\Worksheet\PageMargins;

class ExcelMacrosServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Writer::macro('setCreator', function (Writer $writer, string $creator) {
            $writer->getProperties()->setCreator($creator);
        });
    
        Writer::macro('setTitle', function (Writer $writer, string $title) {
            $writer->getProperties()->setTitle($title);
        });
    
        Writer::macro('setCompany', function (Writer $writer, string $company) {
            $writer->getProperties()->setCompany($company);
        });
    
        Sheet::macro('setOrientation', function (Sheet $sheet, $orientation) {
            return $sheet->getPageSetup()->setOrientation($orientation);
        });
    
        Sheet::macro('setMargins', function (Sheet $sheet, $top, $bottom, $left, $right) {
    
            $margins = (new PageMargins())
                ->setTop($top)
                ->setBottom($bottom)
                ->setLeft($left)
                ->setRight($right);
            
            return $sheet->setPageMargins($margins);
        });
    
        Sheet::macro('setRepeatRows', function (Sheet $sheet, $start, $end) {
            return $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd($start, $end);
        });
        
        Sheet::macro('setAllBorders', function(Sheet $sheet, $range) {
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ];
    
            return $sheet->getStyle($range)->applyFromArray($styleArray);
        });
    
        Sheet::macro('setFirstRowBorders', function(Sheet $sheet, $range) {
            $styleArray = [
                'font' => [
                    'bold' => true,
                ],
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ];
        
            return $sheet->getStyle($range)->applyFromArray($styleArray);
        });
    
        Sheet::macro('alignHorizontalCenter', function(Sheet $sheet, $range) {
            return $sheet->getStyle($range)
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        });
    }
}
