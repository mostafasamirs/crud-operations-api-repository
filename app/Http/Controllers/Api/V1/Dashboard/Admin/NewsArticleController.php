<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsArticle\StoreNewsArticleRequest;
use App\Http\Requests\NewsArticle\UpdateNewsArticleRequest;
use App\Http\Resources\Dashboard\AdminData\News\NewsResource;
use App\Models\NewsArticle;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class NewsArticleController extends Controller
{
    use ApiTrait;

    protected const RESOURCE = NewsResource::class;

    /**
     * SOLID -> Dependency Inversion Principle. (DIP) (NewsRepositoryInterface)
     * High-Level Modules should not depend on low-level modules .
     **/
    public function __construct(protected NewsRepositoryInterface $newsRepository)
    {
        foreach (NewsArticle::getPermissions() as $permission => $methods) {
            $middleware = new Middleware("permission:$permission");
            $middleware->only($methods);
        }
    }

    /**
     * @return JsonResponse
     * Retrieve a paginated list of news articles, including a count of archived articles.
     */
    public function index()
    {
        $news = $this->newsRepository->index(config('app.paginate'));
        $trashedCount = $this->newsRepository->getTrashedCount();
        return $this->returnData((self::RESOURCE)::collection($news)->additional(['trashed_count' => $trashedCount])->response()->getData(), lang('api::news.news'));
    }

    /**
     * @param StoreNewsArticleRequest $request
     * @return JsonResponse
     * Store a new news article with translations and an image.
     */
    public function store(StoreNewsArticleRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $data['translations'] ?? [];
            unset($data['translations'], $data['image']);
            $news = $this->newsRepository->create($data);
            // Add translations
//            $news->translations()->createMany($translations);
            $this->newsRepository->addTranslations($news, $translations);
            addImage($request, $news, 'image');
            DB::commit();
            return $this->returnData(new (self::RESOURCE)($news), lang('api::news.news_created_successfully'));
        } catch (Exception $exception) {
            return $this->errorMessage($exception->getMessage());
        }
    }


    /**
     * @param string $uuid
     * @return JsonResponse
     * Display a specific news article.
     */
    public function show(string $uuid)
    {
        $blog = $this->newsRepository->show($uuid);
        return $this->returnData(new (self::RESOURCE)($blog), lang('api::news.news_show_successfully'));
    }

    /**
     * @param string $uuid
     * @param Request $request
     * @return JsonResponse
     * Change the status (active/inactive) of a news article.
     */
    public function changeStatus(string $uuid, Request $request)
    {
        $news = $this->newsRepository->changeStatus($uuid, $request->is_active);
        return $this->returnData(new (self::RESOURCE)($news), lang('api::general.change_status_successfully'));
    }

    /**
     * @param UpdateNewsArticleRequest $request
     * @param $uuid
     * @return JsonResponse
     * Update an existing news article with translations and an image.
     */
    public function update(UpdateNewsArticleRequest $request, $uuid)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $data['translations'] ?? [];
            unset($data['translations'], $data['image']);

            $news = $this->newsRepository->update($uuid, $data);
            $this->newsRepository->updateTranslations($news, $translations);
            updateImage($request, $news, 'image');
            DB::commit();
            return $this->returnData(new (self::RESOURCE)($news), lang('api::news.news_updated_successfully'));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }


    /**
     * @param string $uuid
     * * @return JsonResponse
     * Soft delete (archive) a news article.
     */
    public function destroy(string $uuid)
    {
        $this->newsRepository->destroy($uuid);
        return $this->successMessage(lang('api::news.news_archived_successfully'));
    }


    /**
     * @return JsonResponse
     * Retrieve a paginated list of archived (soft-deleted) news articles.
     */
    public function archive()
    {
        $archivedNews = $this->newsRepository->getArchived(config('app.paginate'));
        return $this->returnData((self::RESOURCE)::collection($archivedNews), lang('api::news.archived_articles'));
    }


    /**
     * @param $uuid
     * @return JsonResponse
     * Restore a previously archived news article.
     */
    public function restore($uuid)
    {
        $restoreNews = $this->newsRepository->restore($uuid);
        return $this->returnData(new (self::RESOURCE)($restoreNews), lang('api::news.news_restored_successfully'));
    }

    /**
     * @param $uuid
     * @return JsonResponse
     * Permanently delete a previously archived news article.
     */
    public function forceDelete($uuid)
    {
        try {
            DB::beginTransaction();
            $forceDeleteArticle = $this->newsRepository->forceDelete($uuid);
            deleteMedia($forceDeleteArticle, 'image');
            $forceDeleteArticle->forceDelete();
            DB::commit();
            return $this->successMessage(lang('api::news.news_deleted_successfully'));
        } catch (ModelNotFoundException) {
            DB::rollBack();
            return $this->NotFound();
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }

}
