<div class="btn-group">
    @if ($entity->id != auth()->user()->id)
        <a href="{{route($namespace . 'edit', ['entity' => $entity->id])}}" class="btn btn-info">
            <i class="fas fa-edit"></i>
        </a>
    @endif

    @if ($entity->status)
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#disable-modal" data-action="ban"
            data-route="{{route($namespace . 'ban', ['entity' => $entity->id])}}" data-id="{{$entity->id}}"
            data-name="{{$entity->name}}">
            <i class="fas fa-minus-circle"></i>
        </button>
    @else
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#disable-modal" data-action="ban"
            data-route="{{route($namespace . 'ban', ['entity' => $entity->id])}}" data-id="{{$entity->id}}"
            data-name="{{$entity->name}}">
            <i class="fa fa-check"></i>
        </button>
    @endif
</div>