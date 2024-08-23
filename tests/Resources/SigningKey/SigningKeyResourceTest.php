<?php

declare(strict_types=1);

use Http\Mock\Client as MockClient;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\SigningKey\Key;
use Szhorvath\CloudflareStream\DataObjects\SigningKey\KeyCollection;
use Szhorvath\CloudflareStream\Resources\SigningKey\SigningKeyResource;
use Szhorvath\CloudflareStream\StreamSdk;

it('should return the video resource', function () {
    $sdk = new StreamSdk('api-key');

    $response = $sdk->signingKey();

    expect($response)->toBeInstanceOf(SigningKeyResource::class);
});

it('should create signing key', function () {
    $client = new MockClient;
    $client->addResponse(response(
        name: 'key/create',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $response = $sdk->signingKey()->create(
        accountId: '0a6c8c72a460f78152e767e10842dcb2'
    );

    expect($response)
        ->toBeInstanceOf(ApiResponse::class)
        ->success->toBeTrue()
        ->result->toBeInstanceOf(Key::class)
        ->result->id->toBe('a789764c40565eacf08198a4041ed5bb')
        ->result->pem->toBe('LS0tLS1CRUdJTiBSU0EgUFJJVkFURSBLRVktLS0tLQpNSUlFb3dJQkFBS0NBUUVBcWhwYi9IV0ZwckZnYWRlYlZxa3MyVnpyYWd6aW56Y1F6RFdyV294bytZSkJDNTBtCnZ4L0tneWgwTFVRbGdRZjNreUZQR2h6TFVGSmhPZlJpRm9seHdFL2VON0RYVXM3K1lzUCtlQ2V2THhXTktyT1gKM0hhWExSL2xqaHk5UFovSkE2MVlwSWJoa2J6aTZMQXFkQ2pNdjZaY2Q5WjEvZDFqQ2lDY0w1UEdhbDFNTjZBVgpVT3ZCaGJ2WUk1V2tTQytYRDRPTEU1aGd2UTg3NWd2ekZiMTJzdVpOcy9nQ2ZuWktOY2lTaVd1S0xjbFA0cTVtCk5qbUJ1Z3pidmxSYWxzaW50Y1Y3aTE5SFhIaUtKZmVid2tLa2ozUGtWTlljVVRmbjZkQXVJMkZFTE1EaVZjRTIKNUlVdnpVV0IrdDYydFBhYlpkOWRIZ0tVVWdRNnF4MnlZbTB0U3dJREFRQUJBb0lCQUNvSzFjMXlKcFJxcHMvQwpNR3ljNTY3Wm5uM1pyWEY0cExnMFU2UFByR3B1M1RESHFMbjRXNDlMUWx1bHlqYzRCdUxnaXJLRGgyVFUxNThCClhmVUFCNU5tcWgvTm40cWlDcEhTcTJSN09udENzbDlwZ0JGSFpsb0sxaXZud29ZbXBnSTRwLzRTTUZKYkF5SkwKMkZKWmV6R3JKcE9mK0EzRTJDTzZwNS9Dd0htdEtXcTUxTXIwaStrSWVvdVdtWmFMb0JaK1JabWJndzBRUCtUTgptSEpDRjRHYVV6UzdCZml6TzFieGlFdHVYem9xNEt2L1dpbDhwYlhtSTl0RlZWTzRCQWN6RjM0MU9VNE9md28rCjdGS1RQL20wL0R2OWlzQlRUbXh5WlRWOTE3Rzk5K0tWQ2lMU3g1Rys4V0VKQ3RCTVVBMWJEUmVUTE5NeWFiSTcKWmR4WnQ5RUNnWUVBOENrY2l4Y2RSVTRjK0FEaVVIclZnWFA0bDV2eitaUDFoU05wam8rOGZqdDRodE1Xd2JGNQpRbFJ3K0NQZ0ZHeEtpYWZmOVcrWllFS1I0SzZHWHRQeGhFZi9LbVZYVUJjVjFiL0l2LzcyUHpLblE4N1FnaTIwCjdHbUZjZlFFQWd1SkRwelVTaXFYNk1Kc2lXZnc1MjNQeWNnY1dXLy8xZmF6c3ZwdFJUejlWTzhDZ1lFQXRWSmoKei9GR1ZRK0F1alF4bGdsRFdQN3FVRDIvczkyNWN5bjR3b2ZNQjR4N28rOFpxZStrNzdKYmtQWkZaNFg1WHl2Swp0VXBqMVhCVzB2V2RHMUphMno4aVNhc1h6MFAvZDVxSElnbUtQdWs0NDJSMDhzV2g2bWVYclN3djBWTUo5Ky81Ck5ZNGlWN0VpTU42Z0hoYlY1UWVCN0xqSS9PZWJUV3pHclhGT0JXVUNnWUFDQWhYL0E3NTI2ZVJNSHBYRjNvRVMKaUFtNEd0RzdjSVZKQzdiQ1BtbHhGTVk1T21LaVUvMlRsR2t0YWY5aHJGWWpPSWdpNFVBREVndHVPWWRlRzUrVgpYNVMrb2dKTTVTU0ZtUWp3c2cwVkVqTmIyY3JjaTgxTGZNWms0WWwzQ3VtbWVhRTh6WVpmcCtDSWRab0tGVno3CmJ2VHR1b1lGSC83NHJDZGx3TkROZVFLQmdBSG5TNFR6VTNteEgvalVjM0RQeUJVM0Y5NmZ4MU5zRUhaVkNuZUEKVlhQKzFZMXpCU0h6a2hleUY2UDk4ZHlVVzNuVVM5eDdXM0R5TFBjcC9PdzhnUmVzSWdBRCs4d0JPcjFXc2ZSNQpoU29ENk1UNldQL3pjeSt5eHJUYXNlWFFxVm9nK3N6RklUY3FkT0Z1ZE4vYi9ZTGFBVk1xM1hGS1BTY2k3VE1FCjdYekJBb0dCQUovVWR3dHBiSkI1SFdUdTBTNVNTbzVSdm9rY3VKUVhTenRmN1dzSndzU3VSdUZTeFd1V084Tm4KSk1wYlJXRnY4cXg1dVUzTVlpTGxkdEd4V09FdDlPNE5YS0xFcjJUT2E1emRxeksyd3NCRi83c0lYZ2ZYUC9ySwpTeWhXUkp6L0pmWDgrM2Q0d1dlVktqbVFCcS9OOXEreWtUYmxQWDVaR0YzQ29LbmpqOEsyCi0tLS0tRU5EIFJTQSBQUklWQVRFIEtFWS0tLS0tCg==')
        ->result->jwk->toBe('eyJ1c2UiOiJzaWciLCJrdHkiOiJSU0EiLCJraWQiOiJhNzg5NzY0YzQwNTY1ZWFjZjA4MTk4YTQwNDFlZDViYiIsImFsZyI6IlJTMjU2IiwibiI6InFocGJfSFdGcHJGZ2FkZWJWcWtzMlZ6cmFnemluemNRekRXcldveG8tWUpCQzUwbXZ4X0tneWgwTFVRbGdRZjNreUZQR2h6TFVGSmhPZlJpRm9seHdFX2VON0RYVXM3LVlzUC1lQ2V2THhXTktyT1gzSGFYTFJfbGpoeTlQWl9KQTYxWXBJYmhrYnppNkxBcWRDak12NlpjZDlaMV9kMWpDaUNjTDVQR2FsMU1ONkFWVU92QmhidllJNVdrU0MtWEQ0T0xFNWhndlE4NzVndnpGYjEyc3VaTnNfZ0NmblpLTmNpU2lXdUtMY2xQNHE1bU5qbUJ1Z3pidmxSYWxzaW50Y1Y3aTE5SFhIaUtKZmVid2tLa2ozUGtWTlljVVRmbjZkQXVJMkZFTE1EaVZjRTI1SVV2elVXQi10NjJ0UGFiWmQ5ZEhnS1VVZ1E2cXgyeVltMHRTdyIsImUiOiJBUUFCIiwiZCI6IktnclZ6WEltbEdxbXo4SXdiSnpucnRtZWZkbXRjWGlrdURSVG84LXNhbTdkTU1lb3VmaGJqMHRDVzZYS056Z0c0dUNLc29PSFpOVFhud0ZkOVFBSGsyYXFIODJmaXFJS2tkS3JaSHM2ZTBLeVgybUFFVWRtV2dyV0stZkNoaWFtQWppbl9oSXdVbHNESWt2WVVsbDdNYXNtazVfNERjVFlJN3FubjhMQWVhMHBhcm5VeXZTTDZRaDZpNWFabG91Z0ZuNUZtWnVERFJBXzVNMllja0lYZ1pwVE5Mc0YtTE03VnZHSVMyNWZPaXJncV85YUtYeWx0ZVlqMjBWVlU3Z0VCek1YZmpVNVRnNV9DajdzVXBNXy1iVDhPXzJLd0ZOT2JISmxOWDNYc2IzMzRwVUtJdExIa2I3eFlRa0swRXhRRFZzTkY1TXMwekpwc2p0bDNGbTMwUSIsInAiOiI4Q2tjaXhjZFJVNGMtQURpVUhyVmdYUDRsNXZ6LVpQMWhTTnBqby04Zmp0NGh0TVd3YkY1UWxSdy1DUGdGR3hLaWFmZjlXLVpZRUtSNEs2R1h0UHhoRWZfS21WWFVCY1YxYl9Jdl83MlB6S25RODdRZ2kyMDdHbUZjZlFFQWd1SkRwelVTaXFYNk1Kc2lXZnc1MjNQeWNnY1dXX18xZmF6c3ZwdFJUejlWTzgiLCJxIjoidFZKanpfRkdWUS1BdWpReGxnbERXUDdxVUQyX3M5MjVjeW40d29mTUI0eDdvLThacWUtazc3SmJrUFpGWjRYNVh5dkt0VXBqMVhCVzB2V2RHMUphMno4aVNhc1h6MFBfZDVxSElnbUtQdWs0NDJSMDhzV2g2bWVYclN3djBWTUo5LV81Tlk0aVY3RWlNTjZnSGhiVjVRZUI3TGpJX09lYlRXekdyWEZPQldVIiwiZHAiOiJBZ0lWX3dPLWR1bmtUQjZWeGQ2QkVvZ0p1QnJSdTNDRlNRdTJ3ajVwY1JUR09UcGlvbFA5azVScExXbl9ZYXhXSXppSUl1RkFBeElMYmptSFhodWZsVi1VdnFJQ1RPVWtoWmtJOExJTkZSSXpXOW5LM0l2TlMzekdaT0dKZHdycHBubWhQTTJHWDZmZ2lIV2FDaFZjLTI3MDdicUdCUl8tLUt3blpjRFF6WGsiLCJkcSI6IkFlZExoUE5UZWJFZi1OUnpjTV9JRlRjWDNwX0hVMndRZGxVS2Q0QlZjXzdWalhNRklmT1NGN0lYb18zeDNKUmJlZFJMM0h0YmNQSXM5eW44N0R5QkY2d2lBQVA3ekFFNnZWYXg5SG1GS2dQb3hQcFlfX056TDdMR3ROcXg1ZENwV2lENnpNVWhOeXAwNFc1MDM5djlndG9CVXlyZGNVbzlKeUx0TXdUdGZNRSIsInFpIjoibjlSM0MybHNrSGtkWk83UkxsSktqbEctaVJ5NGxCZExPMV90YXduQ3hLNUc0VkxGYTVZN3cyY2t5bHRGWVdfeXJIbTVUY3hpSXVWMjBiRlk0UzMwN2cxY29zU3ZaTTVybk4yck1yYkN3RVhfdXdoZUI5Y18tc3BMS0ZaRW5QOGw5Zno3ZDNqQlo1VXFPWkFHcjgzMnI3S1JOdVU5ZmxrWVhjS2dxZU9Qd3JZIn0=')
        ->result->created->format('Y-m-d H:i:s')->toBe('2024-08-22 15:06:42');
});

it('should list all signing keys', function () {
    $client = new MockClient;
    $client->addResponse(response(
        name: 'key/list',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $response = $sdk->signingKey()->list(
        accountId: '0a6c8c72a460f78152e767e10842dcb2'
    );

    expect($response)
        ->toBeInstanceOf(ApiResponse::class)
        ->success->toBeTrue()
        ->result->toBeInstanceOf(KeyCollection::class)
        ->result->toHaveCount(2)
        ->result->sequence(
            fn ($key) => $key
                ->id->toBe('a789764c40565eacf08198a4041ed5bb')
                ->key_id->toBe('a789764c40565eacf08198a4041ed5bb')
                ->created->format('Y-m-d H:i:s')->toBe('2024-08-22 15:06:42'),
            fn ($key) => $key
                ->id->toBe('b3cdd05463d911d988a9663095f0ccc9')
                ->key_id->toBe('b3cdd05463d911d988a9663095f0ccc9')
                ->created->format('Y-m-d H:i:s')->toBe('2024-08-22 15:06:23')
        );

});

it('should delete signing key', function () {
    $client = new MockClient;
    $client->addResponse(response(
        name: 'key/delete',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $response = $sdk->signingKey()->delete(
        accountId: '0a6c8c72a460f78152e767e10842dcb2',
        keyId: 'a789764c40565eacf08198a4041ed5bb'
    );

    expect($response)
        ->toBeInstanceOf(ApiResponse::class)
        ->success->toBeTrue()
        ->result->toBeNull();
});
