<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag as Entity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class TagController extends Controller
{
    protected $namespace = 'admin.tags.';

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
                        'name' => ['nullable', 'string', 'max:255'],
                    ]);

                    if (! empty($searchFilter['search']['value'])) {
                        $s = ['LIKE', '%' . $searchFilter['search']['value'] . '%'];
                        $query
                            ->where(function ($q) use ($s) {
                                $q
                                    ->orWhere('name', ...$s);
                            });
                    }
                    
                    if (! empty($searchFilter['name'])) {
                        $query->where('name', 'LIKE', '%' . $searchFilter['name'] . '%');
                    }
                })
                ->editColumn('created_at', function ($entity) {
                    return $entity->created_at->diffForHumans();
                })
                ->addColumn('actions', function ($entity) {
                    return view($this->namespace . 'partials.actions', ['entity' => $entity, 'namespace' => $this->namespace,]);
                })
                ->rawColumns(['actions'])
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
            'name' => ['required', 'string'],
        ]);

        $entity = new Entity();

        $entity->fill($formData);

        $entity->save();

        session()->flash('system_message', __('New tag added successfuly'));

        return redirect()->route($this->namespace . 'index');
    }
    
    public function edit(Entity $entity)
    {
        return view($this->namespace . 'edit', [
            'entity' => $entity,
            'namespace' => $this->namespace,
        ]);
    }

    public function update(Request $request, Entity $entity)
    {
        $formData = $request->validate([
            'name' => ['nullable', 'string'],
        ]);

        $entity->fill($formData);

        $entity->save($formData);

        session()->flash('system_message', __('Tag updated successfuly'));

        return redirect()->route($this->namespace . 'index');
    }

    public function delete(Entity $entity, Request $request)
    {
        $entity->delete();

        return response()->json([
            'system_message' => __('Tag has been deleted'),
        ]);
    }
}
