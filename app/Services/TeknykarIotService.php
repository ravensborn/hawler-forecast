<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TeknykarIotService
{
    private const BASE_URL = 'https://iot.teknykar.com/api/v2';

    private const MAX_ENDPOINT_IDS_PER_REQUEST = 5;

    /**
     * Fetch the latest data for up to 5 endpoint IDs.
     *
     * @param  array<int>  $endpointIds
     * @return array<int, array{EndpointID: int, Description: string, SequenceNumber: int, Timestamp_UTC: string, Value: float}>
     */
    public function fetchEndpointData(array $endpointIds): array
    {
        $endpointIds = array_slice($endpointIds, 0, self::MAX_ENDPOINT_IDS_PER_REQUEST);

        $response = Http::get(self::BASE_URL.'/endpointData/multiple', [
            'accessToken' => config('teknykar-iot.accessToken'),
            'endpointIds' => implode(',', $endpointIds),
        ]);

        if ($response->failed()) {
            return [];
        }

        return $response->json() ?? [];
    }
}
