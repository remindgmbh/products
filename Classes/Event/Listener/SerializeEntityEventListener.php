<?php

declare(strict_types=1);

namespace Remind\Products\Event\Listener;

use Remind\Products\Domain\Model\Product;
use Remind\Extbase\Event\SerializeEntityEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Remind\Headless\Service\FilesService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

#[AsEventListener]
final readonly class SerializeEntityEventListener
{
    private FilesService $filesService;

    public function __construct()
    {
        $this->filesService = GeneralUtility::makeInstance(FilesService::class);
    }
    public function __invoke(SerializeEntityEvent $event): void
    {
        $abstractEntity = $event->getAbstractEntity();
        $settings =  $event->getSettings();
        $properties = explode(',', $this->camelize($settings['properties']));

        if ($abstractEntity instanceof Product) {
            /** @var \TYPO3\CMS\Core\TypoScript\FrontendTypoScript $frontendTyposcript */
            $frontendTyposcript = $event->getRequest()->getAttribute('frontend.typoscript');
            $constants = $frontendTyposcript->getFlatSettings();
            $normalizedParams = $event->getRequest()->getAttribute('normalizedParams');


            $json = $event->getJson();

            foreach ($properties as $property) {
                $value = $abstractEntity->_getProperty($property);

                if ($value instanceof FileReference) {
                    $value = $this->filesService->processImage($value->getOriginalResource(), []);
                } elseif ($value instanceof ObjectStorage) {
                    $storageItems = [];

                    foreach ($value as $item) {
                        $storageItems[] = [
                            'uid' => $item->getUid(),
                            'pid' => $item->getPid(),
                            'name' => $item->getName(),
                            'description' => $item->getDescription(),
                        ];

                    }

                    $value = $storageItems;
                }

                $json[$property] = $value;
            }

            $event->setJson($json);
        }
    }

    protected function camelize($input, $separator = '_')
    {
        return lcfirst(str_replace($separator, '', ucwords($input, $separator)));
    }
}
