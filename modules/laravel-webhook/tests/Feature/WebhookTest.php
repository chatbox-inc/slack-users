<?php

namespace Tests\Feature;

use Chatbox\LaravelWebhook\Events\EmitRequest;
use Chatbox\LaravelWebhook\Listeners\StoreRequest;
use Chatbox\LaravelWebhook\Services\WebhookService;
use Chatbox\LaravelWebhook\Values\WebhookRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Assert;

class WebhookTest extends TestCase
{
    public function provideRequestData()
    {
        $payload = [
            "hoge" => "piydddo",
            "22hoge" => "piyo",
        ];

        return array(
            'simple get request' => [
                "get",
                "webhook?".http_build_query($payload),
                $payload
            ],
            'simple post request' => [
                "post",
                "webhook",
                $payload
            ],
            'simple put request' => [
                "put",
                "webhook",
                $payload
            ],
        );
    }

    /**
     * @dataProvider provideRequestData
     */
    public function testGetRequest($method,$url,$payload)
    {
        Event::fake();

        $count = DB::table("webhook")->count();

        $response = $this->call($method,$url,$payload);
        $response->assertStatus(200);

        Assert::assertEquals($response->json("request.method"),strtoupper($method));

        Event::assertDispatched(
            EmitRequest::class,
            function (EmitRequest $event) use($method,$payload){
                Assert::assertEquals($event->request->method, strtoupper($method));
                Assert::assertEquals($event->request->payload, $payload);
                /** @var StoreRequest $listener */
                $listener = app(StoreRequest::class);
                $listener->handle($event);
                return true;
            }
        );
        Assert::assertEquals($count + 1, DB::table("webhook")->count());

        $service = new WebhookService();

        $hash = $response->json("request.hash");

        $req2 = $service->load($hash);

        Assert::assertInstanceOf(WebhookRequest::class,$req2);
        Assert::assertEquals(
            $req2->payload,
            $response->json("request.payload")
        );
        Assert::assertEquals(
            $req2->created_at->format(DATE_ATOM),
            $response->json("request.created_at")
        );

        $req3 = $service->dispatch($req2);
        Assert::assertNotEquals($req2->hash,$req3->hash);

        Event::assertDispatched(
            EmitRequest::class,
            function (EmitRequest $event) use($req3, $method,$payload){
                Assert::assertEquals($event->request->method, strtoupper($method));
                Assert::assertEquals($event->request->payload, $payload);
//                /** @var StoreRequest $listener */
//                $listener = app(StoreRequest::class);
//                $listener->handle($event);
                return true;
            }
        );


    }
}
