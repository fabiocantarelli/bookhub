<?php

declare(strict_types=1);

namespace App\Utils;

final class FileUtils
{
    public static function fileNameWithDateTime(string $fileName, string $extension): string
    {
        $dateTimeNow = new \DateTime();
        $dateTimeNowFormated = $dateTimeNow->format('d_m_Y_H_i_s');
        return sprintf('%s_%s.%s', $fileName, $dateTimeNowFormated, $extension);
    }

    public static function fileNamePdfWithDateTime(string $fileName, bool $isContentDisposition = false): string
    {
        $pdfFileName = self::fileNameWithDateTime($fileName, 'pdf');

        if ($isContentDisposition) {
            return sprintf('inline; filename="%s"', $pdfFileName);
        }

        return $pdfFileName;
    }
}
