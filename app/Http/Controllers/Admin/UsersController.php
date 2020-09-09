<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class UsersController extends Controller
{
    public function index() 
    {
        //$users = User::get();
            
        return view('admin.users.index', [
            //'users' => $users,
        ]);
    }

    public function datatable(Request $request)
    {
        $searchFilter = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'numeric', 'in:0,1']
        ]);
        
        $query = User::query();

        if(isset($searchFilter['name'])) {
            $query->where('users.name', 'LIKE', '%' . $searchFilter['name'] . '%');
        } 
        if(isset($searchFilter['email'])) {
            $query->where('users.email', 'LIKE', '%' . $searchFilter['email'] . '%');
        } 
        if(isset($searchFilter['phone'])) {
            $query->where('users.phone', '>=', $searchFilter['phone']);
        } 
        if(isset($searchFilter['status'])) {
            $query->where('users.status', '=', $searchFilter['status']);
        } 

        $dataTable = \DataTables::of($query);

        $dataTable->editColumn('email', function($users) {
            return '<a href="mailto:{{$users->email}}">' . e($users->email) . '</a>';
        })->editColumn('phone', function($users) {
            return '<a href="tel:{{$users->phone}}">' . e($users->phone) . '</a>';
        })->editColumn('photo', function($users) {
            return view('admin.users.partials.photo', ['user' => $users]);
        })->editColumn('status', function($users) {
            return view('admin.users.partials.status', ['user' => $users]);
        })->addColumn('actions', function($users) {
            return view('admin.users.partials.actions', ['user' => $users]);
        }); 

        $dataTable->rawColumns(['email', 'phone', 'photo', 'actions', 'status']);

        // $dataTable->filter(function ($query) use ($request){

        // }); 

        return $dataTable->make(true);
    }

    public function add()
    {
        return view('admin.users.add', [

        ]);
    }

    public function insert(Request $request) 
    {
        $formData = $request->validate([
            'email' => ['required', 'string', 'unique:users,email'],
            'name' => ['required', 'string', 'unique:users,name', 'max:255'],
            'surname' => ['required', 'string', 'unique:users,name', 'max:255'],
            'phone' => ['required', 'numeric', 'min:8'],
            'photo' => ['nullable', 'file', 'image', 'max:65000']
        ]);

        $newUser = new User();

        $newUser->password = bcrypt('cubes12345');

        $newUser->status = 1;

        $newUser->fill($formData);

        $newUser->save();

        if($request->hasFile('photo')) {
            $photoFile = $request->file('photo');

            $photoFileName = $newUser->id . '_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                public_path('/storage/user_photo/'),
                $photoFileName
            );

            $newUser->photo = '/storage/user_photo/' . $photoFileName; 

            $newUser->save();

            Image::make(public_path($newUser->photo))->fit(300, 300)->save();

        }

        $newUser->save();

        session()->flash('system_message', __('New user added successfuly'));

        return redirect()->route('admin.users.index');

    }
    
    public function edit(User $user)
    {
        if($user->id == auth()->user()->id) {
            session()->flash('warning_message', __('You can\'t edit your own profile like this'));

            return redirect()->route('admin.users.index');
        }

        return view('admin.users.edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        if($user->id == auth()->user()->id) {
            session()->flash('system_message', __('You can\'t edit your own profile like this'));

            return redirect()->route('admin.users.index');
        }
        
        $formData = $request->validate([
            'name' => ['nullable', 'string', 'max:70', Rule::unique('users')->ignore($user->id)],
            'email' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'surname' => ['nullable', 'string', 'max:70', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'min:8'],
            'photo' => ['nullable', 'file', 'image', 'max:65000']
        ]);

        $user->fill($formData);

        if ($request->hasFile('photo')) {
            $user->deletePhoto();

            $photoFile = $request->file('photo');

            $photoFileName = $user->id . '_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                public_path('/storage/user_photo/'),
                $photoFileName
            );

            $user->photo = '/storage/user_photo/' . $photoFileName;

            Image::make(public_path($user->photo))->fit(300, 300)->save();
        }

        $user->save ($formData);

        session()->flash('system_message', __('Account updated successfuly'));

        return redirect()->route('admin.users.index');
    }


    public function profile() 
    {
        return view('admin.users.profile');
    }

    public function updateProfile(Request $request)
    {

        $formData = $request->validate([
            'name' => ['nullable', 'string', 'max:70', Rule::unique('users')->ignore(auth()->user()->id)],
            'surname' => ['nullable', 'string', 'max:70', Rule::unique('users')->ignore(auth()->user()->id)],
            'phone' => ['nullable', 'string', 'min:8'],
            'photo' => ['nullable', 'file', 'image', 'max:65000']
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

        auth()->user()->save ($formData);


        session()->flash('system_message', __('Account updated successfuly'));

        return redirect()->route('admin.users.index');
    }


    public function changePasswordForm()
    {
        return view('admin.users.changepassword');
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'old_password'          => ['required', 'min:7',],
            'password'              => ['required', 'min:7', 'confirmed',],
            'password_confirmation' => ['required', 'min:7',],
        ]);

        if(!(\Hash::check($data['old_password'], auth()->user()->password))){

            session()->flash('warning_message', __('Your credentials do not match'));
            return back();
        }

        if (strcmp($data['old_password'], $data['password']) == 0) {
            

            session()->flash('warning_message', __('You can\'t have the same password as before'));
            return back();

        }

        if(($data['password']) == ""){
            session()->flash('warning_message', __('You can\'t leave the field password empty'));
            return back();
        }

        auth()->user()->password = bcrypt($data['password']);

        auth()->user()->save();

        session()->flash('system_message', __('Your password has been updated'));

        Auth::logout();

        return redirect()->route('login');

    }

    public function ban(User $users)
    {
        $users ->status = !($users->status);

        $users->save();

        return response()->json([
            'system_message' => __('User has been baned')
        ]);

    }
}
