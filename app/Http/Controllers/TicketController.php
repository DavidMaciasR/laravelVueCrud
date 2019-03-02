<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TicketController extends Controller
{

    private $checkResult= ['zeroPointLines'=> [],
        'onePointLines'=> [],
        'fivePointLines'=> [],
        'tenPointLines'=> [],
        'totalValue'=> 0
        ];

    public function check(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $this->checkResult['totalValue'] = $this->calculateTicketValue($ticket);

        return response($this->checkResult, Response::HTTP_OK);
    }

    /**
     * @param $ticket
     * @return int
     */
    public function calculateTicketValue($ticket): int
    {
        $totalValue = 0;

        $lines = explode(';', $ticket['lines']);
        for ($j = 0; $j < sizeof($lines); $j++) {
            $numbers = array_map('intval', explode(',', $lines[$j]));
            $value = $this->calculateLineValue($numbers, $j);
            $totalValue += $value;
        }
        return $totalValue;
    }

    /**
     * @param $numbers
     * @return int
     */
    public function calculateLineValue($numbers, $index): int
    {
        $value = 0;
        if (($numbers[0] + $numbers[1] + $numbers[2]) == 2) {
            $this->checkResult['tenPointLines'][]= $index+1;
            $value = 10;
        } else if (($numbers[0] == $numbers[1]) && ($numbers[1] == $numbers[2])) {
            $this->checkResult['fivePointLines'][]= $index+1;
            $value = 5;
        } else if (($numbers[0] != $numbers[1]) && ($numbers[1] == $numbers[2])) {
            $this->checkResult['onePointLines'][]= $index+1;
            $value = 1;
        }else{
            $this->checkResult['zeroPointLines'][]= $index+1;

        }

        return $value;
    }
}
