<?php

declare(strict_types=1);

namespace Remind\Products\Tests\Unit\Event\Listener;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\ServerRequestInterface;
use Remind\Extbase\Event\Enum\SerializeEntityEventType;
use Remind\Extbase\Event\SerializeEntityEvent;
use Remind\Headless\Service\FilesService;
use Remind\Products\Domain\Model\Product;
use Remind\Products\Event\Listener\SerializeEntityEventListener;
use stdClass;
use TYPO3\CMS\Core\Resource\FileReference as CoreFileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(SerializeEntityEventListener::class)]
class SerializeEntityEventListenerTest extends UnitTestCase
{
    #[Test]
    public function invokeIgnoresNonProductEntities(): void
    {
        $filesService = $this->createMock(FilesService::class);
        $filesService
            ->expects(self::never())
            ->method('processImage');
        GeneralUtility::addInstance(FilesService::class, $filesService);

        $entity = new class () extends AbstractEntity {
        };

        $event = $this->createEvent($entity, ['properties' => 'name']);
        $initialJson = $event->getJson();

        (new SerializeEntityEventListener())($event);

        self::assertSame($initialJson, $event->getJson());
    }

    #[Test]
    public function invokeMapsSnakeCasePropertyToCamelCasePropertyName(): void
    {
        $filesService = $this->createMock(FilesService::class);
        GeneralUtility::addInstance(FilesService::class, $filesService);

        $product = (new Product())
            ->setArticleNumber('SKU-1001');

        $event = $this->createEvent($product, ['properties' => 'article_number']);

        (new SerializeEntityEventListener())($event);

        $json = $event->getJson();
        self::assertSame('SKU-1001', $json['articleNumber']);
        self::assertArrayNotHasKey('article_number', $json);
    }

    #[Test]
    public function invokeSerializesFileReferenceUsingFilesService(): void
    {
        $originalResource = $this->createMock(CoreFileReference::class);

        $fileReference = $this->createMock(FileReference::class);
        $fileReference
            ->expects(self::once())
            ->method('getOriginalResource')
            ->willReturn($originalResource);

        $filesService = $this->createMock(FilesService::class);
        $filesService
            ->expects(self::once())
            ->method('processImage')
            ->with($originalResource, [])
            ->willReturn(['url' => '/img/product.jpg']);
        GeneralUtility::addInstance(FilesService::class, $filesService);

        $product = (new class () extends Product {
            protected ?FileReference $mainImage = null;

            public function setMainImage(FileReference $mainImage): self
            {
                $this->mainImage = $mainImage;

                return $this;
            }
        })->setMainImage($fileReference);

        $event = $this->createEvent($product, ['properties' => 'main_image']);

        (new SerializeEntityEventListener())($event);

        self::assertSame(['url' => '/img/product.jpg'], $event->getJson()['mainImage']);
    }

    #[Test]
    public function invokeSerializesObjectStorageIntoArrayShape(): void
    {
        $filesService = $this->createMock(FilesService::class);
        $filesService
            ->expects(self::never())
            ->method('processImage');
        GeneralUtility::addInstance(FilesService::class, $filesService);

        $relatedProductA = (new Product())
            ->setName('Alpha')
            ->setDescription('First');
        $relatedProductA->_setProperty('pid', 21);
        $relatedProductA->_setProperty('uid', 11);

        $relatedProductB = (new Product())
            ->setName('Beta')
            ->setDescription('Second');
        $relatedProductB->_setProperty('pid', 22);
        $relatedProductB->_setProperty('uid', 12);

        $images = new ObjectStorage();
        $images->attach($relatedProductA);
        $images->attach($relatedProductB);

        $product = (new Product())->setImages($images);

        $event = $this->createEvent($product, ['properties' => 'images']);

        (new SerializeEntityEventListener())($event);

        self::assertSame([
            [
                'description' => 'First',
                'name' => 'Alpha',
                'pid' => 21,
                'uid' => 11,
            ],
            [
                'description' => 'Second',
                'name' => 'Beta',
                'pid' => 22,
                'uid' => 12,
            ],
        ], $event->getJson()['images']);
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
        parent::tearDown();
    }

    /**
     * @param array<string, mixed> $settings
     */
    private function createEvent(AbstractEntity $entity, array $settings): SerializeEntityEvent
    {
        $frontendTyposcript = new class () {
            /**
             * @return array<string, string>
             */
            public function getFlatSettings(): array
            {
                return [];
            }
        };

        $request = $this->createMock(ServerRequestInterface::class);
        $request
            ->method('getAttribute')
            ->willReturnMap([
                ['frontend.typoscript', $frontendTyposcript],
                ['normalizedParams', new stdClass()],
            ]);

        $uriBuilder = $this->createMock(UriBuilder::class);

        return new SerializeEntityEvent(
            'Products',
            SerializeEntityEventType::Detail,
            $request,
            $entity,
            $uriBuilder,
            $settings,
        );
    }
}
