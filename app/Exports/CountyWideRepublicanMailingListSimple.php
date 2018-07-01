<?php

namespace App\Exports;

use App\Voter;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class CountyWideRepublicanMailingListSimple implements FromCollection, Responsable, WithMapping, WithHeadings, WithColumnFormatting, WithEvents, ShouldAutoSize
{
    use Exportable;
    
    /**
     * @var int
     */
    protected $totalRows;
    
    /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     */
    private $fileName = '2018-County-Wide-Republican-Mailing-List-Simple.xlsx';
    
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $voters = Voter::where(function ($query) {
            $query->whereIn('e_1', ['YRY', 'NRY', 'YRN', 'NRN'])
                ->whereNotNull('e_1');
        })
            ->where(function ($query) {
                $query->whereIn('e_3', ['YRY', 'NRY', 'YRN', 'NRN'])
                    ->whereNotNull('e_3');
            })
            ->where(function ($query) {
                $query->whereIn('e_4', ['YRY', 'NRY', 'YRN', 'NRN'])
                    ->whereNotNull('e_4');
            })
            ->where(function ($query) {
                $query->whereIn('e_6', ['YRY', 'NRY', 'YRN', 'NRN'])
                    ->whereNotNull('e_6');
            })
            ->orderBy('pct', 'asc')
            ->orderBy('street_address', 'asc')
            ->orderBy('house_number', 'asc');
    
       $this->totalRows = $voters->count() + 1;
        
        return $voters->get();
    }
    
    /**
     * Checks to see if we have a duplicate address
     *
     * @param $address
     * @param $addressList
     * @return bool
     */
    protected function isDuplicateAddress($address, $addressList)
    {
        if (in_array($address, $addressList)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * @param mixed $voter
     * @return array
     */
    public function map($voter): array
    {
        return [
            $voter->first_name,
            $voter->last_name,
            $voter->house_number,
            $voter->street_address,
            $voter->city,
            $voter->state,
            $voter->zip,
            $voter->phone,
            $voter->pct_nbr
        ];
    }
    
    /**
     * @return array
     */
    public function headings() : array
    {
        return [
            'FNAME',
            'LNAME',
            '#',
            'STREET',
            'CITY',
            'STATE',
            'ZIP',
            'PHONE',
            'PCT',
        ];
    }
    
    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
    }
    
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->getProperties()
                    ->setCreator("Daniel Berry")
                    ->setCompany('Coffee County GOP')
                    ->setManager('Daniel Berry')
                    ->setLastModifiedBy("Daniel Berry")
                    ->setTitle("Walk List")
                    ->setSubject("2018 County-Wide Hard Republican Address and Phine")
                    ->setDescription(
                        "This is a list of hard republicans, containing only address and phone numbers."
                    )
                    ->setKeywords("coffee county walk list 2018")
                    ->setCategory("Campaign Material");
            },
            
            AfterSheet::class => function (AfterSheet $event) {
                
                $event->sheet->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->setMargins('0.25', '0.25', '0.25', '0.25');
                $event->sheet->setRepeatRows(1, 1);
                $event->sheet->getPageSetup()->setFitToWidth(1);
                $event->sheet->getPageSetup()->setFitToHeight(0);
                $event->sheet->freezePane("A2");
                $event->sheet->setAllBorders("A1:I{$this->totalRows}");
                $event->sheet->setFirstRowBorders("A1:I1");
                $event->sheet->alignHorizontalCenter("H1:I" . $this->totalRows);
            },
        ];
    }
}
