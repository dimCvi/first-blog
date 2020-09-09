<?php

namespace App\Http\Controllers\Admin;

use App\User as Entity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class UsersController extends Controller
{
    protected $namespace = 'admin.users.';

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
                        'email' => ['nullable', 'string'],
                        'phone' => ['nullable', 'string', 'max:255'],
                        'status' => ['nullable', 'boolean'],
                        'search' => ['nullable', 'array',],
                        'search.value' => ['nullable', 'string',],
                    ]);

                    if (! empty($searchFilter['search']['value'])) {
                        $s = ['LIKE', '%' . $searchFilter['search']['value'] . '%'];
                        $query
                            ->where(function ($q) use ($s) {
                                $q
                                    ->orWhere('name', ...$s)
                                    ->orWhere('surname', ...$s)
                                    ->orWhere('email', ...$s)
                                    ->orWhere('phone', ...$s);
                            });
                    }
                    
                    if (! empty($searchFilter['name'])) {
                        $query->where('name', 'LIKE', '%' . $searchFilter['name'] . '%');
                    }

                    if (! empty($searchFilter['email'])) {
                        $query->where('email', 'LIKE', '%' . $searchFilter['email'] . '%');
                    }

                    if (! empty($searchFilter['phone'])) {
                        $query->where('phone', '>=', $searchFilter['phone']);
                    }

                    if (! is_null($searchFilter['status'])) {
                        $query->where('status', $searchFilter['status']);
                    }
                })
                ->editColumn('email', function ($entity) {
                    return '<a href="mailto:{{$entity->email}}">' . e($entity->email) . '</a>';
                })
                ->editColumn('phone', function ($entity) {
                    return '<a href="tel:{{$entity->phone}}">' . e($entity->phone) . '</a>';
                })
                ->editColumn('photo', function ($entity) {
                    return view($this->namespace . 'partials.photo', ['entity' => $entity, 'namespace' => $this->namespace,]);
                })
                ->editColumn('status', function ($entity) {
                    return view($this->namespace . 'partials.status', ['entity' => $entity, 'namespace' => $this->namespace,]);
                })
                ->addColumn('actions', function ($entity) {
                    return view($this->namespace . 'partials.actions', ['entity' => $entity, 'namespace' => $this->namespace,]);
                })
                ->rawColumns(['email', 'phone', 'photo', 'actions', 'status'])
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
            'email' => ['required', 'string', 'unique:users,email'],
            'name' => ['required', 'string', 'unique:users,name', 'max:255'],
            'surname' => ['required', 'string', 'unique:users,name', 'max:255'],
            'phone' => ['required', 'numeric', 'min:8'],
            'photo' => ['nullable', 'file', 'image', 'max:65000'],
        ]);

        $entity = new Entity();

        $entity->password = bcrypt('cubes12345');

        $entity->status = 1;

        $entity->fill($formData);

        $entity->save();

        if ($request->hasFile('photo')) {
            $photoFile = $request->file('photo');

            $photoFileName = $entity->id . '_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                public_path('/storage/user_photo/'),
                $photoFileName
            );

            $entity->photo = '/storage/user_photo/' . $photoFileName;

            $entity->save();

            Image::make(public_path($entity->photo))->fit(300, 300)->save();
        }

        $entity->save();

        session()->flash('system_message', __('New user added successfuly'));

        return redirect()->route($this->namespace . 'index');
    }
    
    public function edit(Entity $entity)
    {
        if ($entity->id == auth()->user()->id) {
            session()->flash('warning_message', __('You can\'t edit your own profile like this'));

            return redirect()->route($this->namespace . 'index');
        }

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
                public_path('/storage/user_photo/'),
                $photoFileName
            );

            $entity->photo = '/storage/user_photo/' . $photoFileName;

            Image::make(public_path($entity->photo))->fit(300, 300)->save();
        }

        $entity->save($formData);

        session()->flash('system_message', __('Account updated successfuly'));

        return redirect()->route($this->namespace . 'index');
    }

    public function profile()
    {
        return view($this->namespace . 'profile');
    }

    public function updateProfile(Request $request)
    {
        $formData = $request->validate([
            'name' => ['nullable', 'string', 'max:70', Rule::unique('users')->ignore(auth()->user()->id)],
            'surname' => ['nullable', 'string', 'max:70', Rule::unique('users')->ignore(auth()->user()->id)],
            'phone' => ['nullable', 'string', 'min:8'],
            'photo' => ['nullable', 'file', 'image', 'max:65000'],
        ]);

        auth()->user()->fill($formData);

        if ($request->hasFile('photo')) {
            auth()->user()->deletePhoto();

            $photoFile = $request->file('photo');

            $photoFileName = auth()->user()->id . '_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                public_path('/storage/user_photo/'),
                $photoFileName
            );

            auth()->user()->photo = '/storage/user_photo/' . $photoFileName;

            Image::make(public_path(auth()->user()->photo))->fit(300, 300)->save();
        }

        auth()->user()->save($formData);

        session()->flash('system_message', __('Account updated successfuly'));

        return redirect()->route($this->namespace . 'index');
    }


    public function changePasswordForm()
    {
        return view($this->namespace . 'changepassword');
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'old_password' => ['required', 'min:7',],
            'password' => ['required', 'min:7', 'confirmed',],
            'password_confirmation' => ['required', 'min:7',],
        ]);

        if (! (\Hash::check($data['old_password'], auth()->user()->password))) {
            session()->flash('warning_message', __('Your credentials do not match'));
            return back();
        }

        if (strcmp($data['old_password'], $data['password']) == 0) {
            session()->flash('warning_message', __('You can\'t have the same password as before'));
            return back();
        }

        if (($data['password']) == '') {
            session()->flash('warning_message', __('You can\'t leave the field password empty'));
            return back();
        }

        auth()->user()->password = bcrypt($data['password']);

        auth()->user()->save();

        session()->flash('system_message', __('Your password has been updated'));

        Auth::logout();

        return redirect()->route('login');
    }

    public function ban(Entity $entity)
    {
        $entity->update([
            'status' => ! $entity->status,
        ]);

        return response()->json([
            'system_message' => __('User has been baned'),
        ]);
    }
}
