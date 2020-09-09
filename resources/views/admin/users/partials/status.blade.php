<span class="@if($user->status == 1) text-success @else text-danger @endif ">
    @if ($user->status == 1)
    enabled
    @else
    disabled
    @endif
</span>