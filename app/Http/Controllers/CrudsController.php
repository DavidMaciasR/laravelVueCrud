<?php

namespace App\Http\Controllers;

use App\Crud;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Faker\Generator;

class CrudsController extends Controller
{
    public function index()
    {
        return response(Ticket::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function create(Generator $faker, $lineNo)
    {

        $ticket= new Ticket();
        $ticket->lines= $this->createTicket($faker, $lineNo);
        $ticket->save();

        return response($ticket->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
//        $crud = Crud::findOrFail($id);
//        $crud->color = $request->color;
//        $crud->save();

        $ticket = Ticket::findOrFail($id);
        $this->lines= 'TEEEEEEEEEEEEEEST';

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Ticket::destroy($id);

        return response(null, Response::HTTP_OK);
    }

    /**
     * @param Generator $faker
     * @return string
     */
    public function createRandomTicketLine(Generator $faker): string
    {
        return $faker->numberBetween(0, 2) . ',' . $faker->numberBetween(0, 2) . ',' . $faker->numberBetween(0, 2);
    }

    /**
     * @param Generator $faker
     * @param $lineNo
     * @return string
     */
    public function createTicket(Generator $faker, $lineNo): string
    {
        $lines= '';
        for($i= 0; $i< $lineNo; $i++){
            $lines.= $this->createRandomTicketLine($faker);
            if($i!=($lineNo-1)){
                $lines.=';';
            }
        }
        return $lines;
    }



    public function amend(Generator $faker, Request $request, $id, $ticketLineNo)
    {
        $ticket = Ticket::findOrFail($id);

        $linesToAppend= $this->createTicket($faker, $ticketLineNo);
//        $linesToAppend= 'testlines';
//        $ticket->lines.= ';'.$linesToAppend;

        $ticket->lines.= ';'. $linesToAppend;
//        $request->ticketLineNo
//        $ticket->lines= json_encode($request);
        $ticket->save();
        return response($ticket->lines, Response::HTTP_OK);
    }
}
