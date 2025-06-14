<?php

namespace App\Utils;

use Symfony\Component\Asset\Packages;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class AssetsUtils
{
    private Packages $assets;
    private string $projectDir;

    public function __construct(Packages $assets, ParameterBagInterface $params)
    {
        $this->assets = $assets;
        $this->projectDir = rtrim($params->get('kernel.project_dir'), '/');
    }

    public function getAssetDataUri(string $assetPath, string $mimeType = 'image/png'): string
    {
        $webPath = $this->assets->getUrl($assetPath);
        $absolutePath = $this->projectDir . '/public' . $webPath;

        if (!file_exists($absolutePath) || !is_readable($absolutePath)) {
            throw new \RuntimeException(sprintf('Asset não encontrado ou não legível em "%s".', $absolutePath));
        }

        $fileContents = file_get_contents($absolutePath);
        $base64       = base64_encode($fileContents);

        return sprintf('data:%s;base64,%s', $mimeType, $base64);
    }
}
