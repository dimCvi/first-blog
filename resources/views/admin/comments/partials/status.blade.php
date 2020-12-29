<span class="@if($entity->status) text-success @else text-danger @endif ">
    @if ($entity->status)
        @lang('approved')
    @else
        @lang('not approved')
    @endif
</span>