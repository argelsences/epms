<section id="intro" class="container text-center" style="padding:20px;">
    <div class="row">
        <div class="col-md-12">
            <div class="department_logo">
                <div class="thumbnail">
                    <a href="{{ Config::get('eppms.generar.app_url') }}/d/{{$subscriber->department->url}}"><img src="{{ url($subscriber->department->logo_path) }}" /></a>
                </div>
            </div>
            <h1>{{$subscriber->department->name}}</h1>
        </div>
    </div>
</section>