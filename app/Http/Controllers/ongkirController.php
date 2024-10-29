<?php

namespace App\Http\Controllers;

use App\Models\alamat;
use App\Models\chart;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ongkirController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function index()
    {
        return view('user.checkout.index');
    }

    public function checkOngkir(Request $request)
    {
        $request->validate([
            'origin' => 'required',
            'destination' => 'required',
            'weight' => 'required|numeric',
            'courier' => 'required',
        ]);

        try {
            $response = $this->client->request('POST', 'https://api.rajaongkir.com/starter/cost', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'key' => env('RAJA_ONGKIR_API_KEY'),
                ],
                'form_params' => [
                    'origin' => $request->origin,
                    'destination' => $request->destination,
                    'weight' => $request->weight,
                    'courier' => $request->courier,
                ],
            ]);
            $cost = json_decode($response->getBody(), true);
            return response()->json($cost);
        } catch (RequestException $e) {
            dd('gagal');
            return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }

    public function getOngkir()
    {
        $user = Auth::user();
        $data['barangs'] = chart::where('user_id', $user->id)->with('so')->get();
        $data['alamats'] = alamat::where('user_id', $user->id)->where('status', 'primary')->with('city')->first();
    
        $code = $data['alamats']->city->code;
        $qty = $data['barangs']->sum('qty');
    
        try {
            $response = $this->client->request('POST', 'https://api.rajaongkir.com/starter/cost', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'key' => env('RAJA_ONGKIR_API_KEY'),
                ],
                'form_params' => [
                    'origin' => 151,
                    'destination' => $code,
                    'weight' => 200 * $qty,
                    'courier' => 'jne',
                ],
            ]);
    
            $cost = json_decode($response->getBody(), true);
            $result = null;
    
            if (isset($cost['rajaongkir']['results'][0]['costs'])) {
                foreach ($cost['rajaongkir']['results'][0]['costs'] as $costDetail) {
                    if ($costDetail['service'] == 'REG') {
                        $result = [
                            'cost' => $costDetail['cost'][0]['value'],
                            'etd' => $costDetail['cost'][0]['etd']
                        ];
                        break;
                    }
                }
            }
    
            $data['ongkir'] = $result;
        } catch (RequestException $e) {
            $data['ongkir'] = ['error' => 'Something went wrong: ' . $e->getMessage()];
        }
    
        return view('user.checkout.checkout')->with($data);
    }
    
}
