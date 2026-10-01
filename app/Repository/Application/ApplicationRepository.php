<?php

namespace App\Repository\Application;

use App\Http\Requests\Application\ApplicationStoreRequest;
use App\Http\Requests\Application\ApplicationUpdateRequest;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ApplicationRepository implements ApplicationRepositoryInterface
{
    private const PER_PAGE = 10;

    public function getApplicationsPaginated(Request $request): LengthAwarePaginator
    {
        if (auth()->user()->isAdmin()) {
            return Application::Filters($request)
                ->with(['user', 'department'])
                ->latest('id')
                ->paginate(self::PER_PAGE)
                ->withQueryString();
        }
        return Application::Filters($request)
            ->with(['user', 'department'])
            ->where('user_id', auth()->id())
            ->latest('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();
    }

    public function store(ApplicationStoreRequest $applicationStoreRequest): ?Application
    {
        return Application::create($applicationStoreRequest->validated());
    }

    public function update(ApplicationUpdateRequest $applicationUpdateRequest, Application $application): ?Application
    {
        $application->update($applicationUpdateRequest->validated());

        return $application;
    }

    public function destroy(Application $application): ?bool
    {
        return $application->delete();
    }
}
