<!-- form start -->
<form id="main-form" method="POST">
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
                <div class="form-group">
                    <label>@lang('Description')</label>
                    <textarea 
                        name="description" 
                        class="form-control @if($errors->has('description')) is-invalid @endif"
                        placeholder="Enter Description"
                        >{!!old('text', $entity->text)!!}</textarea>
                    @include('admin._layout.partials.form_errors', ['fieldName' => 'description'])
                </div>
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
<script src="{{url('/themes/admin/plugins/ckeditor_4.15.0_full/ckeditor/ckeditor.js')}}"></script>
<script src="{{url('/themes/admin/plugins/ckeditor_4.15.0_full/ckeditor/adapters/jquery.js')}}"></script>
<script>
    $('#main-form [name="description"]').ckeditor({
        "height": "300px",
        "allowedContent": true,
    })
        console.log("$('#main-form')");
        console.log($('#main-form'));
        $('#main-form').validate({
            rules: {
                "header": {
                    "required": false,
                    "maxlength": 70
                },
                "description": {
                    "required": false
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