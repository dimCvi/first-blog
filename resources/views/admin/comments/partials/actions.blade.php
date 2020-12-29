<div class="btn-group">
    <button 
        type="button" 
        class="btn btn-info"
        data-route="{{route($namespace . 'change_status', ['entity' => $entity->id])}}" 
        data-toggle="modal" 
        data-target="#status-modal" 
        data-action="changestatus"
    >
        <i class="fas fa-eye"></i>
    </button>
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
</div>