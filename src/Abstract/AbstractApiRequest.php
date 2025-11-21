<?php

namespace Cmrweb\AddressBundle\Abstract;

use Cmrweb\AddressBundle\Interface\ApiRequestInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractApiRequest implements ApiRequestInterface
{ 
    protected Serializer $serializer;

    public function __construct(
        protected string $url,
        private readonly HttpClientInterface $httpClient,
        protected readonly ParameterBagInterface $param
    ) 
    { 
        $propertyInfo = new PropertyInfoExtractor([], [new PhpDocExtractor(), new ReflectionExtractor()]);
        $normalizers = [new ObjectNormalizer(new ClassMetadataFactory(new AttributeLoader()), new CamelCaseToSnakeCaseNameConverter(), null, $propertyInfo), new ArrayDenormalizer()];

        $this->serializer = new Serializer($normalizers, [new JsonEncoder()]);
    }

    public function get(string $route, array $context): array
    {
        $request = implode('', [$this->url, $route, '?', http_build_query($context)]);
        $response = $this->httpClient->request('GET', $request);
        return $response->toArray();
    }

    public function jsonRequest(string $route, array $context, ?array $authBasic = null): ResponseInterface
    {
        $requestUrl = implode('', [$this->url, $route, '?', http_build_query($context, "", null, PHP_QUERY_RFC3986)]);
        $curlCLient = new CurlHttpClient();
        $response = $curlCLient->request('GET', $requestUrl, [
            'auth_basic' => $authBasic,  
            // 'query' => $context
        ]);   
        return $response;
    }
}
