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

class DistrictHitList implements FromCollection, Responsable, WithMapping, WithHeadings, WithEvents, ShouldAutoSize
{
    use Exportable;
    
    /**
     * @var int
     */
    protected $totalRows;
    
    /**
     * The district we are pulling information for.
     *
     * @var string
     */
    protected $district;
    
    public function __construct($district, $filename = null)
    {
        $this->district = $district;
        
        if ( ! is_null($filename)) {
            $this->fileName = $filename;
        }
    }
    
    /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     */
    private $fileName = '2018-District-Walk-List.xlsx';
    
    public function collection()
    {
        $voters = Voter::where('pct', $this->district)
            ->hasVoted()
            ->whereIn('e_1', config('votelist.vote_types.republican'))
            ->defaultOrderBy();
        
        $this->totalRows = $voters->count() + 1;
        
        return $voters->get([
            'first_name', 'last_name', 'address', 'phone', 'pct_nbr', 'total_votes', 'republican_votes', 'democrat_votes',
            'e_1', 'e_3', 'e_4', 'e_6', 'e_7', 'e_9', 'e_11', 'e_13', 'e_15'
        ]);
    }
    
    public function map($voter): array
    {
        return [
            $voter->first_name,
            $voter->last_name,
            $voter->address,
            str_replace('931-', '', $voter->phone),
            $voter->pct_nbr,
            $voter->total_votes,
            round(($voter->republican_votes/$voter->total_votes) * 100 . '%'),
            $voter->republican_votes,
            $voter->democrat_votes,
            formatVotingCode($voter->e_1),
            formatVotingCode($voter->e_3),
            formatVotingCode($voter->e_4),
            formatVotingCode($voter->e_6),
            formatVotingCode($voter->e_7),
            formatVotingCode($voter->e_9),
            formatVotingCode($voter->e_11),
            formatVotingCode($voter->e_13),
            formatVotingCode($voter->e_15),
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
            'PHONE',
            'PCT',
            'T',
            '%',
            'R',
            'D',
            getElectionDate('e_1'),
            getElectionDate('e_3'),
            getElectionDate('e_4'),
            getElectionDate('e_6'),
            getElectionDate('e_7'),
            getElectionDate('e_9'),
            getElectionDate('e_11'),
            getElectionDate('e_13'),
            getElectionDate('e_15'),
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
                    ->setTitle("{$this->district} Walk List")
                    ->setSubject("Coffee County, TN District {$this->district} Walk List")
                    ->setCategory("Campaign Material");
            },
            
            AfterSheet::class => function (AfterSheet $event) {
                
                $event->sheet->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->setMargins('0.25', '0.25', '0.25', '0.25');
                $event->sheet->setRepeatRows(1, 1);
                $event->sheet->getPageSetup()->setFitToWidth(1);
                $event->sheet->getPageSetup()->setFitToHeight(0);
                $event->sheet->freezePane("A2");
                $event->sheet->setAllBorders("A1:R{$this->totalRows}");
                $event->sheet->setFirstRowBorders("A1:R1");
                $event->sheet->alignHorizontalCenter("D1:R" . $this->totalRows);
            },
        ];
    }
    
}
