<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StoreBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Http\Resources\Dashboard\AdminData\Blogs\BlogsResource;
use App\Models\Blog;
use App\Repositories\Interfaces\BlogRepositoryInterface;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    use ApiTrait;

    protected const RESOURCE = BlogsResource::class;

    /**
     * SOLID -> Dependency Inversion Principle. (DIP) (BlogRepositoryInterface)
     * High-Level Modules should not depend on low-level modules .
     **/
    public function __construct(protected BlogRepositoryInterface $blogRepository)
    {
        foreach (Blog::getPermissions() as $permission => $methods) {
            $middleware = new Middleware("permission:$permission");
            $middleware->only($methods);
        }
    }

    /**
     * @return JsonResponse
     * List blogs with pagination and trashed count.
     */
    public function index()
    {
        $blogs = $this->blogRepository->index(config('app.paginate'));
        $trashedCount = $this->blogRepository->getTrashedCount();
        return $this->returnData((self::RESOURCE)::collection($blogs)->additional(['trashed_count' => $trashedCount])->response()->getData(), lang('api::blog.blogs'));
    }

    /**
     * @param StoreBlogRequest $request
     * @return JsonResponse
     * Store a new blog with translations and image.
     */
    public function store(StoreBlogRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $data['translations'] ?? [];
            unset($data['translations'], $data['image']);
            // Create blog using the repository
            $blog = $this->blogRepository->create($data);
            // Add translations
//            $blog->translations()->createMany($translations);
            $this->blogRepository->addTranslations($blog->id, $translations);
            // Add image
            addImage($request, $blog, 'image');
            // Add translations using the repository

            DB::commit();
            return $this->returnData(new (self::RESOURCE)($blog), lang('api::blog.blog_created_successfully'));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }


    /**
     * @param string $uuid
     * @return JsonResponse
     * Show blog details.
     */
    public function show(string $uuid)
    {
        $blog = $this->blogRepository->show($uuid);
        return $this->returnData(new (self::RESOURCE)($blog), lang('api::blog.blog_show_successfully'));
    }

    /**
     * @param string $uuid
     * @param Request $request
     * @return JsonResponse
     * Change blog status (active/inactive).
     */
    public function changeStatus(string $uuid, Request $request)
    {
        $blog = $this->blogRepository->changeStatus($uuid, $request->is_active);
        return $this->returnData(new (self::RESOURCE)($blog), lang('api::general.change_status_successfully'));
    }

    /**
     * @param UpdateBlogRequest $request
     * @param string $uuid
     * @return JsonResponse
     * Update blog details, including translations and image.
     */
    public function update(UpdateBlogRequest $request, string $uuid)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $data['translations'] ?? [];
            unset($data['translations'], $data['image']);

            // Update blog using the repository
            $blog = $this->blogRepository->update($uuid, $data);

            // Update translations
//            $blog->translations()->upsert($translations, ['locale']);
            $this->blogRepository->updateTranslations($blog->id, $translations);

            // Update image
            updateImage($request, $blog, 'image');

            DB::commit();
            return $this->returnData(new (self::RESOURCE)($blog), lang('api::blog.blog_updated_successfully'));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }


    /**
     * @param string $uuid
     * @return JsonResponse
     * Soft delete a blog.
     */
    public function destroy(string $uuid)
    {
        $this->blogRepository->destroy($uuid);
        return $this->successMessage(lang('api::blog.blog_archived_successfully'));
    }

    /**
     * @return JsonResponse
     * List archived (soft deleted) blogs.
     */
    public function archive()
    {
        $archivedBlogs = $this->blogRepository->getArchived(config('app.paginate'));
        return $this->returnData((self::RESOURCE)::collection($archivedBlogs), lang('api::blog.archived_blogs'));
    }


    /**
     * @param string $uuid
     * @return JsonResponse
     * Restore a soft deleted blog.
     */
    public function restore(string $uuid)
    {
        $blog = $this->blogRepository->restore($uuid);
        return $this->returnData(new (self::RESOURCE)($blog), lang('api::blog.blog_restored_successfully'));
    }

    /**
     * @param string $uuid
     * @return JsonResponse
     * Permanently delete a soft deleted blog.
     */
    public function forceDelete(string $uuid)
    {
        try {
            DB::beginTransaction();
            $blog = $this->blogRepository->forceDelete($uuid);
            deleteMedia($blog, 'image');
            DB::commit();
            return $this->successMessage(lang('api::blog.blog_deleted_successfully'));
        } catch (ModelNotFoundException) {
            DB::rollBack();
            return $this->NotFound();
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }

}
