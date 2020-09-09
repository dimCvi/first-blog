<div class="btn-group">
    @if ($user->id != auth()->user()->id)
    <a href="{{route('admin.users.edit', ['user' => $user->id])}}" class="btn btn-info">
        <i class="fas fa-edit"></i>
    </a>
    @endif

    @if ($user->status == 1)
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#disable-modal" data-action="ban"
        data-route="{{route('admin.users.ban', ['user' => $user->id])}}" data-id="{{$user->id}}"
        data-name="{{$user->name}}">
        <i class="fas fa-minus-circle"></i>
    </button>
    @endif
    @if ($user->status == 0)
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#disable-modal" data-action="ban"
        data-route="{{route('admin.users.ban', ['user' => $user->id])}}" data-id="{{$user->id}}"
        data-name="{{$user->name}}">
        <i class="fa fa-check"></i>
    </button>
    @endif
</div>