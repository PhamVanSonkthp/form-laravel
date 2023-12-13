<?php

namespace Database\Seeders;

use App\Models\Airline;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Database\Seeder;

class CreateUserByFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        set_time_limit(36000);

        $path = storage_path() . '/app/airlines.csv';

        $reader = ReaderEntityFactory::createReaderFromFile($path);

        $reader->open($path);

        foreach ($reader->getSheetIterator() as $sheet) {

            foreach ($sheet->getRowIterator() as $index => $row) {
                // do stuff with the row

                if ($index > 2){
                    $cells = $row->getCells();

                    Airline::updateOrCreate([
                        'name' => $cells[1]->getValue(),
                        'alias' => $cells[2]->getValue(),
                        'iata' => $cells[3]->getValue(),
                        'icao' => $cells[4]->getValue(),
                        'callsign' => $cells[5]->getValue(),
                        'country' => $cells[6]->getValue(),
                        'active' => $cells[7]->getValue(),
                    ]);
                }


            }
        }
    }
}
