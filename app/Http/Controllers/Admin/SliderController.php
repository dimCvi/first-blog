<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider as Entity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    protected $namespace = 'admin.sliders.';

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
                        'status' =>['nullable', 'boolean'],
                        'search' => ['nullable', 'array',],
                        'search.value' => ['nullable', 'string',],
                    ]);

                    if (! empty($searchFilter['search']['value'])) {
                        $s = ['LIKE', '%' . $searchFilter['search']['value'] . '%'];
                        $query
                            ->where(function ($q) use ($s) {
                                $q
                                    ->orWhere('header', ...$s)
                                    ->orWhere('status', ...$s);
                            });
                    }
                    
                    if (! empty($searchFilter['header'])) {
                        $query->where('header', 'LIKE', '%' . $searchFilter['header'] . '%');
                    }
                    if (! is_null($searchFilter['status'])) {
                        $query->where('status', $searchFilter['status']);
                    }
                })
                ->editColumn('created_at', function ($entity) {
                    return $entity->created_at->diffForHumans();
                })
                ->editColumn('photo', function ($entity) {
                    return view($this->namespace . 'partials.photo', ['entity' => $entity, 'namespace' => $this->namespace,]);
                })
                ->addColumn('actions', function ($entity) {
                    return view($this->namespace . 'partials.actions', ['entity' => $entity, 'namespace' => $this->namespace,]);
                })
                ->editColumn('status', function ($entity) {
                    return view($this->namespace . 'partials.status', ['entity' => $entity, 'namespace' => $this->namespace,]);
                })
                ->editColumn('url', function ($entity) {
                    return view($this->namespace . 'partials.url', ['entity' => $entity, 'namespace' => $this->namespace,]);
                })
                ->rawColumns(['status', 'actions', 'photo', 'url'] )
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
            'url' => ['nullable', 'url'],
            'photo' => ['nullable', 'file', 'image', 'max:65000'],
            
        ]);

        $entity = new Entity();

        $entity->status = 1;

        $entity->fill($formData);

        $entity->save();

        if ($request->hasFile('photo')) {
            $photoFile = $request->file('photo');

            $photoFileName = $entity->id . '_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                public_path('/storage/slider_photo/'),
                $photoFileName
            );

            $entity->photo = '/storage/slider_photo/' . $photoFileName;

            $entity->save();

            Image::make(public_path($entity->photo))->fit(300, 300)->save();
        }

        $entity->save();

        session()->flash('system_message', __('New slider added successfuly'));

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
            'header' => ['nullable', 'string'],
            'url' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
            'photo' => ['nullable', 'file', 'image', 'max:65000'],
        ]);

        $entity->fill($formData);

        if ($request->hasFile('photo')) {
            $entity->deletePhoto();

            $photoFile = $request->file('photo');

            $photoFileName = $entity->id . '_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                public_path('/storage/slider_photo/'),
                $photoFileName
            );

            $entity->photo = '/storage/slider_photo/' . $photoFileName;

            Image::make(public_path($entity->photo))->fit(300, 300)->save();
        }

        $entity->save($formData);

        session()->flash('system_message', __('Slider updated successfuly'));

        return redirect()->route($this->namespace . 'index');
    }

    public function delete(Entity $entity, Request $request)
    {
        $entity->delete();

        return response()->json([
            'system_message' => __('Slider has been deleted'),
        ]);
    }

    public function changestatus(Entity $entity)
    {
        $entity->update([
            'status' => ! $entity->status,
        ]);

        return response()->json([
            'system_message' => __('Status has been changed'),
        ]);
    }
}
