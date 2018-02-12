<?php

namespace App\Service;

use Http\Client\Exception;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\MessageFactory;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DigitalOcean
{
    /** @var HttpClient */
    private $client;

    /** @var MessageFactory */
    private $messageFactory;

    /**
     * DigitalOcean constructor.
     */
    public function __construct(HttpClient $client, MessageFactory $messageFactory)
    {
        $this->client = $client ?: HttpClientDiscovery::find();
        $this->messageFactory = $messageFactory ?: MessageFactoryDiscovery::find();
    }

    public function updateSubDomain($subDomain, $domain, $data)
    {
        $recordId = $this->getSubDomainRecordId($subDomain, $domain);

        $body = json_encode([
            'name' => $subDomain,
            'data' => $data,
        ]);

        $uri = "https://api.digitalocean.com/v2/domains/{$domain}/records/{$recordId}";
        $request = $this->messageFactory->createRequest('PUT', $uri, [], $body);
        $response = $this->client->sendRequest($request);

        $json = json_decode($response->getBody()->__toString());

        return $json;
    }

    private function getSubDomainRecordId($subDomain, $domain)
    {
        $uri = "https://api.digitalocean.com/v2/domains/{$domain}/records";
        $request = $this->messageFactory->createRequest('GET', $uri);
        try {
            $response = $this->client->sendRequest($request);
        } catch (\Exception $e) {
            throw new NotFoundHttpException('Sub-domain not found!');
        } catch (Exception $e) {
            throw new NotFoundHttpException('Sub-domain not found!');
        }
        if ($response->getStatusCode() !== 200) {
            throw new NotFoundHttpException('Sub-domain not found!');
        }
        $data = json_decode($response->getBody()->__toString());

        foreach ($data->domain_records as $record) {
            if ($record->name === $subDomain) {
                return $record->id;
            }
        }

        throw new NotFoundHttpException('Sub-domain not found!');
    }
}
