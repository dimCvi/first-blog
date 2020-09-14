<!-- form start -->
<form id="main-form" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>@lang('Header')</label>
                    <input 
                        type="text" 
                        name="header" 
                        class="form-control @if($errors->has('header')) is-invalid @endif"
                        placeholder="Enter header" 
                        value="{{old('header', $entity->header)}}"
                    >
                    @include('admin._layout.partials.form_errors', ['fieldName' => 'header'])
                </div>
            </div>
            <div class="form-group">
                <label>@lang('URL')</label>
                <input 
                    type="text" 
                    name="url"
                    class="form-control @if($errors->has('url')) is-invalid @endif" 
                    placeholder="Enter url"
                    value="{{old('url', $entity->url)}}"
                >
                @include('admin._layout.partials.form_errors', ['fieldName' => 'url'])
            </div>
            <div class="form-group">
                <label>@lang('Choose New Photo')</label>
                <input 
                    name="photo"
                    type="file" 
                    class="form-control"
                >
            </div>
            @if (!empty($entity->photo))
            <div class="offset-md-3 col-md-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('Photo')</label>

                            <div class="text-right">
                                <button type="button" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-remove"></i>
                                    @lang('Delete Photo')
                                </button>
                            </div>
                            <div class="text-center">
                                <img src="{{ $entity->photo . '?t=' . time() }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">@lang('Save')</button>
        <a href="{{route($namespace . 'index')}}" class="btn btn-outline-secondary">@lang('Cancel')</a>
    </div>
</form>

@push('footer_javascript')
<script>
        $('#main-form').validate({
            rules: {
                "header": {
                    "required": false,
                    "maxlength": 70
                },
                "url": {
                    "required": false,
                    "url": true
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
</script>
@endpush