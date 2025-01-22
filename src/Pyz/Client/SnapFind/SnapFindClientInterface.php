<?php

declare(strict_types = 1);

namespace Pyz\Client\SnapFind;

use Generated\Shared\Transfer\SearchQueryByImageTransfer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface SnapFindClientInterface
{
    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @return SearchQueryByImageTransfer
     */
    public function getSearchQueryByImage(UploadedFile $image): SearchQueryByImageTransfer;
}
