<section id="intro" class="container text-center">
    <div class="row">
        <div class="col-md-12">
            <div class="department_logo">
                <div class="thumbnail">
                    <a href="{{ Config::get('eppms.generar.app_url') }}/d/{{$department->url}}"><img src="{{ url($department->logo_path) }}" /></a>
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