@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit Social Media Item</h1>

    <form action="{{ url('admin/social-media/update/'.$social_media->id) }}" method="post">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Edit Social Media Item</h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin.social_media.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> View All</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">URL *</label>
                            <input type="text" name="social_url" class="form-control" value="{{ $social_media->social_url }}" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="">Existing Icon</label>
                            <div class="col-sm-5">
                                <div class="pt_10">
                                    <i class="{{ $social_media->social_icon }}" id="social-icon-value" style="font-size: 32px;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Icon (Font Awesome 5 Codes) *</label>
                            <select name="social_icon" id="social-icon" class="form-control">
                                <option value="">Select a social icon</option>
                                <option value="fab fa-facebook" @if($social_media->social_icon == 'fab fa-facebook') selected @endif>Facebook (fab fa-facebook)</option>
                                <option value="fab fa-twitter" @if($social_media->social_icon == 'fab fa-twitter') selected @endif>Twitter (fab fa-twitter)</option>
                                <option value="fab fa-instagram" @if($social_media->social_icon == 'fab fa-instagram') selected @endif>Instagram (fab fa-instagram)</option>
                                <option value="fab fa-linkedin" @if($social_media->social_icon == 'fab fa-linkedin') selected @endif>LinkedIn (fab fa-linkedin)</option>
                                <option value="fab fa-reddit" @if($social_media->social_icon == 'fab fa-reddit') selected @endif>Reddit (fab fa-reddit)</option>
                                <option value="fab fa-behance" @if($social_media->social_icon == 'fab fa-behance') selected @endif>Behance (fab fa-behance)</option>
                                <option value="fab fa-dribbble" @if($social_media->social_icon == 'fab fa-dribbble') selected @endif>Dribble (fab fa-dribbble)</option>
                                <option value="fab fa-vk" @if($social_media->social_icon == 'fab fa-vk') selected @endif>VK (fab fa-vk)</option>
                                <option value="fab fa-youtube" @if($social_media->social_icon == 'fab fa-youtube') selected @endif>Yoututbe (fab fa-youtube)</option>
                            </select>

                            {{-- <label for="">Icon (Font Awesome 5 Codes) *</label>
                            <input type="text" name="social_icon" class="form-control" value="{{ $social_media->social_icon }}">
                            <div class="text-danger">Example: "fab fa-facebook-f"</div> --}}
                        </div>
                        <div class="form-group">
                            <label for="">Order</label>
                            <input type="text" name="social_order" class="form-control" value="{{ $social_media->social_order }}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </div>
    </form>
    <script>
        const socialIconSelect = document.getElementById('social-icon');
        const socialIcon = document.getElementById('social-icon-value');

        socialIconSelect.addEventListener('change', () => {
            socialIcon.className = socialIconSelect.value;
        });
    </script>

@endsection
