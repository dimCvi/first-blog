<div class="btn-group">
    <a href="{{route($namespace . 'edit', ['entity' => $entity->id])}}" class="btn btn-info">
        <i class="fas fa-edit"></i>
    </a>
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#delete-modal" 
        data-action="delete"
        data-route="{{route($namespace . 'delete', ['entity' => $entity->id])}}" 
        data-id="{{$entity->id}}"
        data-name="{{$entity->name}}"
    >
            <i class="fa fa-trash"></i>
    </button>

    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#status-modal" 
        data-action="changestatus"
        data-route="{{route($namespace . 'changestatus', ['entity' => $entity->id])}}" 
        data-id="{{$entity->id}}"
        data-name="{{$entity->name}}"
    >
        <i class="fa fa-exclamation"></i>
    </button>

</div>