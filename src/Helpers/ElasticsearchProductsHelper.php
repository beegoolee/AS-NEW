<?php

namespace App\Helpers;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchProductsHelper
{
    private $entityManager;
    private $elasticClient;

    private const INDEX_NAME = "shop_products";

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->elasticClient = (ClientBuilder::create())->setHosts([$_ENV['ELASTICSEARCH_HOST']])->build();
        $this->entityManager = $entityManager;
    }

    public function searchProductByName(string $sSearchText)
    {
        if (!$this->elasticClient->ping()) {
            throw new \Exception("Elasticsearch claster is down");
        }

        $params = [
            'index' => self::INDEX_NAME,
            'body' =>
                [
                    'query' => [
                        'match' => [
                            'name' =>
                                [
                                    'query' => $sSearchText,
                                    'fuzziness' => 'AUTO'
                                ]
                        ]
                    ]
                ]
        ];

        $response = $this->elasticClient->search($params)->asArray();

        $arReturn = [];
        foreach ($response['hits']['hits'] as $hit) {
            $arReturn[] = $hit['_source'];
        }

        return $arReturn;
    }

    /**
     * Апсерт индекса в эластике с товарами (для поиска и фильтров)
     */
    public function updateProductsElastic()
    {
        if (!$this->elasticClient->ping()) {
            throw new \Exception("Elasticsearch claster is down");
        }

        $this->elasticClient->indices()->delete(['index' => self::INDEX_NAME]);
        // индекса нет - мы его создаём
        if (!$this->elasticClient->indices()->exists(['index' => self::INDEX_NAME])) {
            $this->elasticClient->indices()->create(
                [
                    'index' => self::INDEX_NAME,
                    'body' => [
                        'mappings' => [
                            'properties' => [
                                'name' => [
                                    'type' => 'text',
                                    'analyzer' => 'russian_analyzer',
                                ],
                                'url' => [
                                    'type' => 'keyword',
                                ],
                                'product_id' => [
                                    'type' => 'integer',
                                ]
                            ]
                        ],
                        'analysis' => [
                            'analyzer' => [
                                'russian_analyzer' => [
                                    'type' => 'custom',
                                    'tokenizer' => 'standard',
                                    'filter' => [
                                        'lowercase',
                                        'russian_stop',
                                        'russian_stemmer'
                                    ]
                                ]
                            ],
                        ]
                    ]
                ]
            );
        }

        $productsRepo = $this->entityManager->getRepository(Product::class);
        $arAllProducts = $productsRepo->findAll();
        foreach ($arAllProducts as $product) {
            $this->elasticClient->index(
                [
                    'index' => self::INDEX_NAME,
                    'id' => $product->getId(),
                    'body' => [
                        'name' => $product->getName(),
                        'product_id' => $product->getId(),
                        'url' => $product->getUrl(),
                    ]
                ]
            );
        }
    }
}