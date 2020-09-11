<span class="@if($entity->featured) text-success @else text-danger @endif ">
    @if ($entity->featured)
        @lang('important')
    @else
        @lang('unimportant')
    @endif
</span>