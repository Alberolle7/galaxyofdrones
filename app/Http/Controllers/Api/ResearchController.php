<?php

namespace Koodilab\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use Koodilab\Game\ResearchManager;
use Koodilab\Http\Controllers\Controller;
use Koodilab\Models\Unit;
use Koodilab\Transformers\ResourceAvailableTransformer;
use Koodilab\Transformers\UnitAvailableTransformer;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ResearchController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('verified');
        $this->middleware('player');
    }

    /**
     * Show the researches in json format.
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index(ResourceAvailableTransformer $resourceTransformer, UnitAvailableTransformer $unitTransformer)
    {
        /** @var \Koodilab\Models\User $user */
        $user = auth()->user();

        $resource = $user->findAvailableResource();

        return [
            'resource' => $resource
                ? $resourceTransformer->transform($resource)
                : null,
            'units' => $unitTransformer->transformCollection(
                $user->findAvailableUnits()
            ),
        ];
    }

    /**
     * Store a newly created research in storage.
     *
     * @throws \Exception|\Throwable
     *
     * @return mixed|\Illuminate\Http\Response
     */
    public function storeResource(ResearchManager $manager)
    {
        /** @var \Koodilab\Models\User $user */
        $user = auth()->user();

        $resource = $user->findAvailableResource();

        if (! $resource) {
            throw new BadRequestHttpException();
        }

        if ($resource->findResearchByUser($user)) {
            throw new BadRequestHttpException();
        }

        if (! $user->hasEnergy($resource->research_cost)) {
            throw new BadRequestHttpException();
        }

        DB::transaction(function () use ($resource, $manager) {
            $manager->create($resource);
        });
    }

    /**
     * Store a newly created research in storage.
     *
     * @throws \Exception|\Throwable
     *
     * @return mixed|\Illuminate\Http\Response
     */
    public function storeUnit(Unit $unit, ResearchManager $manager)
    {
        /** @var \Koodilab\Models\User $user */
        $user = auth()->user();

        $units = $user->findAvailableUnits();

        if (! $units->contains($unit)) {
            throw new BadRequestHttpException();
        }

        if ($unit->findResearchByUser($user)) {
            throw new BadRequestHttpException();
        }

        if (! $user->hasEnergy($unit->research_cost)) {
            throw new BadRequestHttpException();
        }

        DB::transaction(function () use ($unit, $manager) {
            $manager->create($unit);
        });
    }

    /**
     * Remove the research from storage.
     *
     * @throws \Exception|\Throwable
     *
     * @return mixed|\Illuminate\Http\Response
     */
    public function destroyResource(ResearchManager $manager)
    {
        /** @var \Koodilab\Models\User $user */
        $user = auth()->user();

        $resource = $user->findAvailableResource();

        if (! $resource) {
            throw new BadRequestHttpException();
        }

        $research = $resource->findResearchByUser($user);

        if (! $research) {
            throw new BadRequestHttpException();
        }

        DB::transaction(function () use ($research, $manager) {
            $manager->cancel($research);
        });
    }

    /**
     * Remove the research from storage.
     *
     * @throws \Exception|\Throwable
     *
     * @return mixed|\Illuminate\Http\Response
     */
    public function destroyUnit(Unit $unit, ResearchManager $manager)
    {
        $research = $unit->findResearchByUser(
            auth()->user()
        );

        if (! $research) {
            throw new BadRequestHttpException();
        }

        DB::transaction(function () use ($research, $manager) {
            $manager->cancel($research);
        });
    }
}
