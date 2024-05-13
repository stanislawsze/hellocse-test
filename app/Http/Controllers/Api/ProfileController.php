<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Administrator;
use App\Models\Comment;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    private $admin;
    public function __construct(Request $request)
    {
        $this->admin = Administrator::whereBearerToken($request->bearerToken())->first();
        if(!$this->admin)
            return response()->json(['message' => 'Not authorized'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(ProfileResource::collection(Profil::with('comments')->whereStatus('active')->get()), Response::HTTP_OK);
    }

    /**
     * @param CreateProfileRequest $request
     * @return JsonResponse
     */
    public function create(CreateProfileRequest $request): JsonResponse
    {
        $file = Storage::disk('public')->putFile('profile', $request->file('avatar'));
        $link = Storage::url($file);
        Profil::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'avatar' => $link,
            'administrator_id' => $this->admin->id,
        ]);
        return response()->json(['message' => 'Created'], Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function comment(int $id, Request $request): JsonResponse
    {
        $getComment = $this->admin->hasComment($id);
        if($getComment)
            return response()->json(['message' => 'Error while adding your comment, you already have posted a comment.'], Response::HTTP_FORBIDDEN);
        Comment::create([
            'content' => $request->comment,
            'profil_id' => $id,
            'administrator_id' => $this->admin->id,
        ]);
        return response()->json(['message' => 'Created'], Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @param UpdateProfileRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateProfileRequest $request): JsonResponse
    {
        $profile = Profil::find($id);
        if(!$profile)
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        $profile->firstname = $request->firstname ?? $profile->firstname;
        $profile->lastname = $request->lastname ?? $profile->lastname;
        $profile->save();

        return response()->json(['message' => 'Updated'], Response::HTTP_ACCEPTED);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $profile = Profil::find($id);
        if(!$profile)
            return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
        $profile->delete();
        return response()->json(['message' => 'Deleted'], Response::HTTP_NO_CONTENT);
    }
}
