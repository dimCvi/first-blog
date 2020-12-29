<div class="btn-group">
    <a href="{{route($namespace . 'edit', ['entity' => $entity->id])}}" class="btn btn-info">
        <i class="fas fa-edit"></i>
    </a>

    <a href="{{route('admin.comments.index', ['entity' => $entity->id])}}" class="btn btn-info">
        <i class="fa fa-comment"></i>
    </a>

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

    @if ($entity->featured)
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#featured-modal" data-action="change_featured"
            data-route="{{route($namespace . 'change_featured', ['entity' => $entity->id])}}" data-id="{{$entity->id}}"
            data-name="{{$entity->name}}">
            <i class="fa fa-eye-slash"></i>
        </button>
    @else
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#featured-modal" data-action="change_featured"
            data-route="{{route($namespace . 'change_featured', ['entity' => $entity->id])}}" data-id="{{$entity->id}}"
            data-name="{{$entity->name}}">
            <i class="fa fa-eye"></i>
        </button>
    @endif


</div>