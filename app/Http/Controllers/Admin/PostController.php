<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post as Entity;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    protected $namespace = 'admin.posts.';

    public function index()
    {
        return view($this->namespace . 'index');
    }

    public function datatable(Request $request)
    {
        return
            datatables(Entity::query())
                ->filter(function ($query) {
                    $searchFilter = request()->validate([
                        'title' => ['nullable', 'string', 'max:255'],
                        'text' => ['nullable', 'string'],
                        'author' => ['nullable', 'string', 'max:255'],
                        'status' => ['nullable', 'boolean'],
                        'featured' => ['nullable', 'boolean'],
                        'search' => ['nullable', 'array',],
                        'search.value' => ['nullable', 'string',],
                    ]);

                    if (! empty($searchFilter['search']['value'])) {
                        $s = ['LIKE', '%' . $searchFilter['search']['value'] . '%'];
                        $query
                            ->where(function ($q) use ($s) {
                                $q
                                    ->orWhere('title', ...$s)
                                    ->orWhere('text', ...$s)
                                    ->orWhere('status', ...$s)
                                    ->orWhere('featured', ...$s)
                                ;
                            })
                            ->orWhereHas('author', function($q) use($s) {
                                $q->where(function($qe) use($s) {
                                    $qe
                                        ->orWhere('name', ...$s)
                                        ->orWhere('surname', ...$s)
                                    ;   
                                });
                            });
                    }
                    
                    if (! empty($searchFilter['title'])) {
                        $query->where('title', 'LIKE', '%' . $searchFilter['title'] . '%');
                    }

                    if (! empty($searchFilter['text'])) {
                        $query->where('text', 'LIKE', '%' . $searchFilter['text'] . '%');
                    }

                    if (! empty($searchFilter['author'])) {
                        $query->whereHas('author', function($q) use($searchFilter) {
                            $q->where(function($qe) use($searchFilter) {
                                $qe
                                    ->orWhere('name', 'LIKE', '%' . $searchFilter['text'] . '%')
                                    ->orWhere('surname', 'LIKE', '%' . $searchFilter['text'] . '%')
                                ;   
                            });
                        });
                    }

                    if (! is_null($searchFilter['status'])) {
                        $query->where('status', $searchFilter['status']);
                    }
                    if (! is_null($searchFilter['featured'])) {
                        $query->where('featured', $searchFilter['featured']);
                    }
                })
                ->editColumn('author', function ($entity) {
                    $r = route('admin.users.edit', ['entity' => $entity->user_id,]);
                    return '<a href="' . $r . '">' . $entity->author->fullName . '</a>';
                })
                ->editColumn('views', function ($entity) {
                    return $entity->views ?? 0;
                })
                ->editColumn('photo', function ($entity) {
                    return view($this->namespace . 'partials.photo', ['entity' => $entity, 'namespace' => $this->namespace,]);
                })
                ->editColumn('status', function ($entity) {
                    return view($this->namespace . 'partials.status', ['entity' => $entity, 'namespace' => $this->namespace,]);
                })
                ->editColumn('featured', function ($entity) {
                    return view($this->namespace . 'partials.featured', ['entity' => $entity, 'namespace' => $this->namespace,]);
                })
                ->editColumn('created_at', function ($entity) {
                    return $entity->created_at->diffForHumans();
                })
                ->addColumn('actions', function ($entity) {
                    return view($this->namespace . 'partials.actions', ['entity' => $entity, 'namespace' => $this->namespace,]);
                })
                ->editColumn('comments', function($entity){
                    return view($this->namespace . 'partials.numberofcomments', ['entity' => $entity, 'namespace' => $this->namespace,]);
                }) 
                ->rawColumns(['author', 'featured', 'photo', 'actions', 'status', 'comments'])
                ->make(true);
    }

    public function add()
    {
        return view($this->namespace . 'add', [
            'categories' => Category::get(),
            'tags' => Tag::get(),
            'entity' => new Entity(),
            'namespace' => $this->namespace,
        ]);
    }

    public function insert(Request $request)
    {

        $formData = $request->validate([
            'title' => ['required', 'string'],
            'text' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'file', 'image', 'max:65000'],
            'category' => ['nullable', 'integer', 'exists:categories,id'],
            'tags' => ['nullable', 'array', 'exists:tags,id'],
        ]);

        $formData['user_id'] = auth()->user()->id; 

        $entity = new Entity();

        $entity->status = 1;

        $entity->fill($formData);

        $entity->save();

        if ($request->hasFile('photo')) {
            $photoFile = $request->file('photo');

            $photoFileName = $entity->id . '_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                public_path('/storage/post_photo/'),
                $photoFileName
            );

            $entity->photo = '/storage/post_photo/' . $photoFileName;

            $entity->save();

            Image::make(public_path($entity->photo))->fit(300, 300)->save();
        }

        $entity->categories()->attach($formData['category']);

        $entity->tags()->sync($formData['tags']);

        $entity->save();

        session()->flash('system_message', __('New post added successfuly'));

        return redirect()->route($this->namespace . 'index');
    }
    
    public function edit(Entity $entity)
    {
        return view($this->namespace . 'edit', [
            'categories' => Category::get(),
            'tags' => Tag::get(),
            'entity' => $entity,
            'namespace' => $this->namespace,
        ]);
    }

    public function update(Request $request, Entity $entity)
    {
        $formData = $request->validate([
            'title' => ['nullable', 'string', 'max:70'],
            'text' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'file', 'image', 'max:65000'],
            'category' => ['nullable', 'integer', 'exists:categories,id'],
            'tags' => ['nullable', 'array', 'exists:tags,id'],
        ]);

        $formData['user_id'] = auth()->user()->id; 

        $entity->fill($formData);

        $entity->categories()->detach();

        $entity->categories()->attach($formData['category']);

        $entity->tags()->sync($formData['tags']);

        if ($request->hasFile('photo')) {
            $entity->deletePhoto();

            $photoFile = $request->file('photo');

            $photoFileName = $entity->id . '_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                public_path('/storage/post_photo/'),
                $photoFileName
            );

            $entity->photo = '/storage/post_photo/' . $photoFileName;

            Image::make(public_path($entity->photo))->fit(300, 300)->save();
        }

        $entity->save();

        session()->flash('system_message', __('Account updated successfuly'));

        return redirect()->route($this->namespace . 'index');
    }

    public function ban(Entity $entity)
    {
        $entity->update([
            'status' => ! $entity->status,
        ]);

        return response()->json([
            'system_message' => __('Post has been baned'),
        ]);
    }

    public function changeFeatured(Entity $entity)
    {
        $entity->update([
            'featured' => ! $entity->featured,
        ]);

        return response()->json([
            'system_message' => __('Posts featured column was changed'),
        ]);
    }
}
