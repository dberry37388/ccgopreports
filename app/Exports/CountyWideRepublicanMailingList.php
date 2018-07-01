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

class CountyWideRepublicanMailingList implements FromCollection, Responsable, WithMapping, WithHeadings, WithColumnFormatting, WithEvents, ShouldAutoSize
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
    private $fileName = '2018-County-Wide-Republican-Mailing-List.xlsx';
    
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $voters = Voter::orderBy('pct', 'asc')
            ->orderBy('street_address', 'asc')
            ->orderBy('house_number', 'asc');
    
        $voterCollection = [];
        $addresses = [];
        
       foreach ($voters->get() as $voter) {
           
           $electionYears = [
               'e_1',
               'e_3',
               'e_4',
               'e_6',
               'e_7',
               'e_9',
               'e_11',
               'e_13'
           ];
           
           $republicanVotes = 0;
           $democratVotes = 0;
           
           foreach ($electionYears as $electionYear) {
               if (in_array($voter->$electionYear, config('votelist.vote_types.republican'))) {
                   $republicanVotes++;
               } else {
                   $democratVotes++;
               }
           }
    
           $percentage = round(($republicanVotes/count($electionYears)) * 100 . '%');
           
           if ($republicanVotes >= 3 && $democratVotes < 3) {
               if (! $this->isDuplicateAddress($voter->address, $addresses)) {
                   array_push($addresses, $voter->address);
                   $voter->name = "{$voter->first_name}";
                   
                   $voter->percentage = $percentage;
        
                   $voterCollection[$voter->address] = $voter;
               } else {
                   $existingRecord = $voterCollection[$voter->address];
        
                   if ($existingRecord['last_name'] == $voter->last_name) {
                       $voterCollection[$voter->address]['name'] .= " AND {$voter->first_name}";
                       $voterCollection[$voter->address]['updated'] = 'Combined single last name';
                   } else {
                       
                       if ( ! str_contains($voterCollection[$voter->address]['name'], 'AND')) {
                           $voterCollection[$voter->address]['name'] .= ' ' . $voterCollection[$voter->address]['last_name'] . " AND {$voter->first_name} {$voter->last_name}";
                       } else {
                           $voterCollection[$voter->address]['name'] .= " AND {$voter->first_name} {$voter->last_name}";
                       }
                       
                       $voterCollection[$voter->address]['updated'] = 'Combined multiple last names';
                   }
                   
                   $voterCollection[$voter->address]['percentage'] = $percentage;
               }
           }
       }
       
       $voterCollection = collect($voterCollection);
    
       $this->totalRows = $voterCollection->count() + 1;
        
        return collect($voterCollection);
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
            $voter->name,
            $voter->last_name,
            $voter->house_number,
            $voter->street_address,
            $voter->city,
            $voter->state,
            $voter->zip,
            $voter->pct_nbr,
            $voter->total_votes,
            $voter->percentage,
            $voter->republican_votes,
            $voter->democrat_votes,
            getVoteCode($voter->e_1),
            getVoteCode($voter->e_3),
            getVoteCode($voter->e_4),
            getVoteCode($voter->e_6),
            getVoteCode($voter->e_7),
            getVoteCode($voter->e_9),
            getVoteCode($voter->e_11),
            getVoteCode($voter->e_13),
            $voter->updated,
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
            'UPDATED'
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
                    ->setSubject("2018 County-Wide Republican Hit List")
                    ->setDescription(
                        "This is a list of voters who voted Republican in the 5/18 elections, are not first time voters and have never voted Democrat."
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
                $event->sheet->setAllBorders("A1:U{$this->totalRows}");
                $event->sheet->setFirstRowBorders("A1:U1");
                $event->sheet->alignHorizontalCenter("H1:U" . $this->totalRows);
            },
        ];
    }
}
