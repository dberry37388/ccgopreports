<?php

namespace App\Exports;

use App\Voter;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class FirstTimeRepublicanVoterListExport implements FromCollection, Responsable, WithMapping, WithHeadings, WithEvents, ShouldAutoSize
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
    private $fileName = 'first_time_republican_voters.xlsx';
    
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $voter = Voter::where('total_votes', '=', 1)
            ->whereIn('e_1', ['YRY', 'NRY', 'YRN', 'NRN'])
            ->whereNull('e_3')
            ->whereNull('e_4')
            ->whereNull('e_6')
            ->whereNull('e_7')
            ->whereNull('e_9')
            ->whereNull('e_11')
            ->whereNull('e_13')
            ->whereNull('e_15')
            ->orderBy('pct', 'ASC')
            ->orderBy('street_address', 'asc')
            ->orderBy('house_number', 'asc');
        
        $this->totalRows = $voter->count() + 1;
        
        return $voter->get();
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
            $voter->address,
            $voter->pct_nbr,
            formatVotingCode($voter->e_1)
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
            'ADDRESS',
            'PCT',
            getElectionDate('e_1'),
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
                    ->setSubject("Full first-time voter list")
                    ->setDescription(
                        "List of voters who voted for the first time."
                    )
                    ->setCategory("Campaign Material - Lists");
            },
            
            AfterSheet::class => function (AfterSheet $event) {
                
                $event->sheet->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->setMargins('0.25', '0.25', '0.25', '0.25');
                $event->sheet->setRepeatRows(1, 1);
                $event->sheet->getPageSetup()->setFitToWidth(1);
                $event->sheet->getPageSetup()->setFitToHeight(0);
                $event->sheet->freezePane("A2");
                $event->sheet->setAllBorders("A1:E{$this->totalRows}");
                $event->sheet->setFirstRowBorders("A1:E1");
                $event->sheet->alignHorizontalCenter("E1:E" . $this->totalRows);
                $event->sheet->alignHorizontalCenter("D1:D" . $this->totalRows);
            },
        ];
    }
}
