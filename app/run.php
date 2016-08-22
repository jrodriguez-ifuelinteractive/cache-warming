<?php
use MadeTech\CacheWarming\CacheWarmer;
use MadeTech\CacheWarming\Config\ArrayConfigProvider;
use MadeTech\CacheWarming\Gateway\FileGetContentsUrlRetriever;
use MadeTech\CacheWarming\GetUrlsFromSiteMap;
use MadeTech\CacheWarming\UseCase\WarmUpCacheForSitePresenter;
use MadeTech\CacheWarming\WarmCacheOfOneUrl;
use MadeTech\CacheWarming\WarmUpCacheForSiteMap;

require_once __DIR__ . '/../vendor/autoload.php';

class EchoingWarmUpCacheForSitePresenter implements WarmUpCacheForSitePresenter
{
    public function present($url)
    {
        echo "$url\n";
    }
}

$run = function () {
    $retriever = new FileGetContentsUrlRetriever;
    $cacheWarmer = new CacheWarmer(
        new WarmUpCacheForSiteMap(
            new GetUrlsFromSiteMap($retriever),
            new WarmCacheOfOneUrl($retriever)
        ),
        new ArrayConfigProvider(require __DIR__ . '/config.php'),
        $retriever
    );
    $cacheWarmer->warmCaches(new EchoingWarmUpCacheForSitePresenter);
};
$run();
