<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category as Entity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class CategoriesController extends Controller
{
    protected $namespace = 'admin.categories.';

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
                        'header' => ['nullable', 'string', 'max:255'],
                        'priority' =>['nullable', 'boolean'],
                    ]);

                    if (! empty($searchFilter['search']['value'])) {
                        $s = ['LIKE', '%' . $searchFilter['search']['value'] . '%'];
                        $query
                            ->where(function ($q) use ($s) {
                                $q
                                    ->orWhere('header', ...$s)
                                    ->orWhere('priority', ...$s);
                            });
                    }
                    
                    if (! empty($searchFilter['header'])) {
                        $query->where('header', 'LIKE', '%' . $searchFilter['header'] . '%');
                    }
                    if (! is_null($searchFilter['priority'])) {
                        $query->where('priority', $searchFilter['priority']);
                    }
                })
                ->editColumn('created_at', function ($entity) {
                    return $entity->created_at->diffForHumans();
                })
                ->addColumn('actions', function ($entity) {
                    return view($this->namespace . 'partials.actions', ['entity' => $entity, 'namespace' => $this->namespace,]);
                })
                ->editColumn('priority', function ($entity) {
                    return view($this->namespace . 'partials.priority', ['entity' => $entity, 'namespace' => $this->namespace,]);
                })
                ->rawColumns(['priority', 'actions'] )
                ->make(true);
    }

    public function add()
    {
        return view($this->namespace . 'add', [
            'entity' => new Entity(),
            'namespace' => $this->namespace,
        ]);
    }

    public function insert(Request $request)
    {
        $formData = $request->validate([
            'header' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        $entity = new Entity();

        $entity->priority = 1;

        $entity->fill($formData);

        $entity->save();

        session()->flash('system_message', __('New category added successfuly'));

        return redirect()->route($this->namespace . 'index');
    }
    
    public function edit(Entity $entity)
    {
        // if ($entity->id == auth()->user()->id) {
        //     session()->flash('warning_message', __('You can\'t edit your own profile like this'));

        //     return redirect()->route($this->namespace . 'index');
        // }

        return view($this->namespace . 'edit', [
            'entity' => $entity,
            'namespace' => $this->namespace,
        ]);
    }

    public function update(Request $request, Entity $entity)
    {
        if ($entity->id == auth()->user()->id) {
            session()->flash('system_message', __('You can\'t edit your own profile like this'));

            return redirect()->route($this->namespace . 'index');
        }
        
        $formData = $request->validate([
            'name' => ['nullable', 'string', 'max:70', Rule::unique('users')->ignore($entity->id)],
            'email' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($entity->id)],
            'surname' => ['nullable', 'string', 'max:70', Rule::unique('users')->ignore($entity->id)],
            'phone' => ['nullable', 'string', 'min:8'],
            'photo' => ['nullable', 'file', 'image', 'max:65000'],
        ]);

        $entity->fill($formData);

        if ($request->hasFile('photo')) {
            $entity->deletePhoto();

            $photoFile = $request->file('photo');

            $photoFileName = $entity->id . '_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                public_path('/storage/category_photo/'),
                $photoFileName
            );

            $entity->photo = '/storage/category_photo/' . $photoFileName;

            Image::make(public_path($entity->photo))->fit(300, 300)->save();
        }

        $entity->save($formData);

        session()->flash('system_message', __('Account updated successfuly'));

        return redirect()->route($this->namespace . 'index');
    }

    public function delete(Entity $entity, Request $request)
    {
        $entity->delete();

        return response()->json([
            'system_message' => __('Categorys has been deleted'),
        ]);
    }

    public function changepriority(Entity $entity)
    {
        $entity->update([
            'priority' => ! $entity->priority,
        ]);

        return response()->json([
            'system_message' => __('Priority has been changed'),
        ]);
    }
}
