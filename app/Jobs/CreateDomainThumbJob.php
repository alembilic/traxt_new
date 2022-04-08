<?php

namespace App\Jobs;

use App\Core\EntityManagerFresher;
use App\Entities\Domain;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Queue\InteractsWithQueue;

class CreateDomainThumbJob extends BaseJob implements ShouldBeUniqueUntilProcessing
{
    use EntityManagerFresher;
    use InteractsWithQueue;

    /**
     * Queue to handle this job.
     *
     * @var string
     */
    public $queue = 'default';

    private int $domainId;

    /**
     * TerminateSubscriptionJob constructor.
     *
     * @param Domain $domain Domain
     */
    public function __construct(Domain $domain)
    {
        $this->domainId = $domain->getId();
    }

    /**
     * @throws BindingResolutionException
     */
    public function handle(): void
    {
        $entityManager = $this->getEntityManager();
        $domain = $entityManager->find(Domain::class, $this->domainId);

        $url = 'http://PhantomJScloud.com/api/browser/v2/ak-jwt2k-fp6at-ehhwx-htpwg-19v4t/';
        $payload = json_encode([
            'url' => $domain->getDomainUrl(),
            'renderType' => 'jpeg',
            'renderSettings' => [
                'viewport' => [
                    'width' => 800,
                    'height' => 600,
                ],
                'clipRectangle' => [
                    'width' => 800,
                    'height' => 600
                ],
                'zoomFactor' => 0.90,
            ],
            'requestSettings' => ['doneWhen' => [['event' => "domReady"]]],
        ]);
        $options = [
            'http' => [
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => $payload,
            ],
        ];
        $context = stream_context_create($options);
        $imageData = file_get_contents($url, false, $context);
        $fileName = DIRECTORY_SEPARATOR . 'domains-images' . DIRECTORY_SEPARATOR . $domain->getId() . '.jpeg';
        file_put_contents(public_path() . $fileName, $imageData);

        $domain->setThumbUrl($fileName);

        $entityManager->persist($domain);
        $entityManager->flush();
    }
}
