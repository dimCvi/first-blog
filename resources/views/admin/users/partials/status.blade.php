<span class="@if($entity->status) text-success @else text-danger @endif ">
    @if ($entity->status)
        @lang('enabled')
    @else
        @lang('disabled')
    @endif
</span>