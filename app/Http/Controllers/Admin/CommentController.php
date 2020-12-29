<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment as Entity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    protected $namespace = 'admin.comments.';

    public function index()
    {
        return view($this->namespace . 'index');
    }

    public function datatable()
    {
        return
            datatables(Entity::query())
                ->filter(function ($query) {
                    $searchFilter = request()->validate([
                        'email' => ['nullable', 'string', 'max:255'],
                    ]);

                    if (! empty($searchFilter['search']['value'])) {
                        $s = ['LIKE', '%' . $searchFilter['search']['value'] . '%'];
                        $query
                            ->where(function ($q) use ($s) {
                                $q
                                    ->orWhere('email', ...$s);
                            });
                    }
                    
                    if (! empty($searchFilter['email'])) {
                        $query->where('email', 'LIKE', '%' . $searchFilter['email'] . '%');
                    }
                })
                ->editColumn('created_at', function ($entity) {
                    return $entity->created_at->diffForHumans();
                })
                ->editColumn('comment', function ($entity) {
                    return $entity->comment;
                })
                ->addColumn('post', function ($entity) {
                    return view($this->namespace . 'partials.post', ['entity' => $entity]);
                })
                ->addColumn('actions', function ($entity) {
                    return view($this->namespace . 'partials.actions', ['entity' => $entity, 'namespace' => $this->namespace,]);
                })
                ->addColumn('status', function ($entity) {
                    return view($this->namespace . 'partials.status', ['entity' => $entity, 'namespace' => $this->namespace,]);
                })
                ->rawColumns(['actions', 'status'])
                ->make(true);
    }

    public function delete(Entity $entity, Request $request)
    {
        $entity->delete();

        return response()->json([
            'system_message' => __('Comment has been deleted'),
        ]);
    }

    public function changeStatus(Entity $entity, Request $request)
    {
        $entity->update(['status' => !$entity->status]);

        return response()->json([
            'system_message' => __('Comment status has changed'),
        ]);
    }
}
