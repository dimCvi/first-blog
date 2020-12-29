@push('head_links')
     <!-- Select2 -->
    <link rel="stylesheet" href="{{url('/themes/admin/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{url('/themes/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush

<!-- form start -->
<form id="main-form" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>@lang('Title')</label>
                    <input 
                        type="text" 
                        name="title" 
                        class="form-control @if($errors->has('title')) is-invalid @endif"
                        placeholder="Enter title" 
                        value="{{old('title', $entity->title)}}"
                    >
                    @include('admin._layout.partials.form_errors', ['fieldName' => 'title'])
                </div>
                <div class="form-group">
                    <label>@lang('Post Category')</label>
                    <select id="select2bs4" class="form-control" name="category">
                        <option value="">-- Choose Category --</option>
                        @foreach ($categories as $category)
                            <option 
                                @if (optional($entity->categories->first())->id == $category->id)
                                    selected
                                @endif
                                value="{{$category->id}}"
                            >
                                {{$category->header}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>@lang('Post Tags')</label>
                    <select 
                        id="multipleselect2" 
                        class="form-control"
                        multiple 
                        name="tags[]"
                    >
                        <option value="">-- Choose Tags --</option>
                        @foreach ($tags as $tag)
                            <option 
                                @if (
                                    is_array(old('tags', $entity->tags->pluck('id')->toArray())) 
                                    && in_array($tag->id, old('tags', $entity->tags->pluck('id')->toArray()))
                                    )
                                        selected
                                @endif
                                value="{{$tag->id}}"
                            >
                                {{$tag->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>@lang('Text')</label>
                    <textarea 
                        name="text" 
                        class="form-control @if($errors->has('text')) is-invalid @endif"
                        placeholder="Enter Description"
                        >{!!old('text', $entity->text)!!}</textarea>
                    @include('admin._layout.partials.form_errors', ['fieldName' => 'text'])
                </div>
                <div class="form-group">
                    <label>@lang('Choose New Photo')</label>
                    <input 
                        name="photo" 
                        type="file" 
                        class="form-control"
                    >
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
                                <img src="{{ $entity->photo . '?t=' . time() }}" alt="Nema" class="img-fluid">
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
<!-- CKeditor4 -->
<script src="{{url('/themes/admin/plugins/ckeditor_4.15.0_full/ckeditor/ckeditor.js')}}"></script>
<script src="{{url('/themes/admin/plugins/ckeditor_4.15.0_full/ckeditor/adapters/jquery.js')}}"></script>
<!-- Select2 -->
<script src="{{url('/themes/admin/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
    $('#main-form [name="text"]').ckeditor({
        "height": "300px",
        "allowedContent": true,
    });

    $('#select2bs4').select2({
      theme: 'bootstrap4'
    });
   
    $('#multipleselect2').select2({
      theme: 'bootstrap4'
    });
        $('#main-form').validate({
            rules: {
                "title": {
                    "required": false,
                    "maxlength": 70
                },
                "text": {
                    "required": false
                },
                "surname": {
                    "required": false,
                    "maxlength": 70
                },
                "photo": {
                    "required": false,
                    "maxlength": 65000
                },
                "category": {
                    "required": false,
                },
                "tags": {
                    "required": false,
                }
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