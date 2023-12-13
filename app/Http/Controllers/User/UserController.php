<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Airline;
use App\Models\User;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function view;

class UserController extends Controller
{
    public function index(Request $request){

        set_time_limit(36000);

        $path = storage_path() . '/app/users.xlsx';

        $reader = ReaderEntityFactory::createReaderFromFile($path);

        $reader->open($path);

        foreach ($reader->getSheetIterator() as $sheet) {

            foreach ($sheet->getRowIterator() as $index => $row) {
                // do stuff with the row

                if ($index > 2){
                    $cells = $row->getCells();

                    if (empty($cells[2]->getValue())) continue;

                    User::firstOrCreate([
                        'phone' => $cells[2]->getValue(),
                    ],[
                        'name' => $cells[1]->getValue(),
                        'phone' => $cells[2]->getValue(),
                        'email' => 'admin',
                        'password' => Hash::make("123456"),
                        'is_admin'=> 0,
                        'role_id'=> 0,
                        'business_name'=> $cells[3]->getValue(),
                        'business_address'=> $cells[4]->getValue(),
                        'business_field_of_activity'=> $cells[5]->getValue(),
                        'business_position'=> $cells[6]->getValue(),
                        'zalo'=> $cells[8]->getValue(),
                    ]);


                }


            }
        }

//        return view('user.home.index');
    }

}
