<?php

namespace App\Http\Controllers;

use App\Contracts\HasOrganisation;
use App\Contracts\IDataTransferObject;
use App\Contracts\IFilteringRepository;
use App\Dto\CursorDto;
use App\Entities\Organisation;
use App\Entities\User;
use App\Enums\OrganisationStaffStatuses;
use App\Http\Controllers\Helpers\OrganisationRetrieverHelper;
use App\Http\Requests\CursorRequest;
use Auth;
use Doctrine\Common\Collections\Selectable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ObjectRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use League\Fractal\Pagination\Cursor;
use League\Fractal\TransformerAbstract;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use function response;

/**
 * Base controller for all api controllers in application.
 *
 * @property-read User|null $user Authenticated user
 */
abstract class BaseApiController extends Controller
{
    use AuthorizesRequests;

    /**
     * Entity manager instance.
     *
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * Transformer to use by default.
     *
     * @var TransformerAbstract
     */
    protected $transformer;

    /**
     * Default response root resource name.
     *
     * @var string
     */
    protected $responseResourceKey = 'data';

    /**
     * Base controller for all api controllers in application.
     *
     * @param EntityManagerInterface $entityManager Entity manager instance
     * @param TransformerAbstract|null $transformer Transformer to use by default
     */
    public function __construct(EntityManagerInterface $entityManager, ?TransformerAbstract $transformer = null)
    {
        $this->entityManager = $entityManager;
        $this->transformer = $transformer;
    }

    /**
     * Return repository from entity manager.
     *
     * @param string $className Class to get repository
     *
     * @return ObjectRepository|Selectable
     */
    protected function getRepository(string $className): ObjectRepository
    {
        return $this->entityManager->getRepository($className);
    }

    /**
     * Returns models collection as api response.
     *
     * @param iterable $list Models list to convert into api response
     * @param TransformerAbstract|null $transformer Transformer to make collection
     * @param array|null $meta Meta to add in response
     *
     * @return JsonResponse
     */
    public function collection(
        iterable $list,
        ?TransformerAbstract $transformer = null,
        ?array $meta = null,
        array $additionalIncludes = []
    ): JsonResponse {
        $resource = fractal($list, $transformer ?? $this->transformer)->withResourceName($this->responseResourceKey);

        if ($meta) {
            $resource->addMeta($meta);
        }

        if (count($additionalIncludes)) {
            $resource->parseIncludes($additionalIncludes);
        }

        return response()->json($resource->toArray());
    }

    /**
     * Returns transformed item as api response.
     *
     * @param object $item Item to transform
     * @param TransformerAbstract|null $transformer Transformer
     * @param array|null $meta Meta to add
     * @param array $additionalIncludes additional includes
     *
     * @return JsonResponse
     */
    protected function item(
        object $item,
        ?TransformerAbstract $transformer = null,
        ?array $meta = null,
        array $additionalIncludes = []
    ): JsonResponse {
        $resource = fractal()->item($item, $transformer ?? $this->transformer);

        if ($meta) {
            $resource->addMeta($meta);
        }

        if (count($additionalIncludes)) {
            $resource->parseIncludes($additionalIncludes);
        }

        return new JsonResponse($resource->toArray());
    }

    /**
     * Get the authenticated user.
     *
     * @return User|null
     */
    protected function user(): ?User
    {
        return Auth::user();
    }

    /**
     * Magically handle calls to certain properties.
     *
     * @param string $key Key
     *
     * @return mixed
     *
     * @throws RuntimeException
     */
    public function __get(string $key)
    {
        if ($key === 'user') {
            return $this->user();
        }

        throw new RuntimeException('Undefined property ' . get_class($this) . '::' . $key);
    }
}
