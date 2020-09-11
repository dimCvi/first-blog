<span class="@if($entity->priority) text-success @else text-danger @endif ">
    @if ($entity->priority)
        @lang('important')
    @else
        @lang('unimportant')
    @endif
</span>