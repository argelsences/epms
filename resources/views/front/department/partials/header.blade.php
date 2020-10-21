<section id="intro" class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="department_logo">
                <div class="thumbnail">
                    <img src="{{ url($department->logo_path) }}" />
                </div>
            </div>
            <h1>{{$department->name}}</h1>
            @if($department->about)
            <div class="description pl-5 pr-5">
                {!! $department->about !!}
            </div>
            @endif
        </div>
    </div>
</section>